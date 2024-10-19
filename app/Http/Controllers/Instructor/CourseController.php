<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Reaction;
use App\Models\Review;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Instructor;
use App\Models\PaymentHistory;
use App\Models\SavedCourse;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Topic;
use App\Models\Level;
use App\Models\Language;
use App\Models\User;
use App\Models\LearningHistory;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $instructor = Instructor::where('user_id',$user->id)->first();
        $courses = Course::with('category')->where('instructor_id',$instructor->id)->get();
    
        return view('instructor.courses',[
            'courses'=>$courses,
            'page_title'=>'Courses'
        ]);
    }

    public function create(){
        $topics = Topic::all();
        $sub_categories = SubCategory::all();
        $categories = Category::all();
        $levels = Level::all();
        $languages = Language::all();
        return view('instructor.course-create',[
            'topics'=>$topics,
            'sub_categories'=>$sub_categories,
            'categories'=>$categories,
            'levels'=>$levels,
            'languages'=>$languages,
            'page_title'=>'Create Course',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request;
        $validatedData = $request->validate([
            'title'=>'required',
            'short'=>'required',
            'description'=>'required',
            'language'=>'required',
            'level_id'=>'required|numeric',
            'category_id'=>'required|numeric',
            'sub_category_id'=>'required|numeric',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id){

        $course = Course::find($id);
        if(!$course) return redirect(route('instructor.error'));
        if(Gate::denies('my-course',$course)){
            return back()->with('error','Unauthorize');
        }

        $categories = Category::all();
        $topics = Topic::all();
        $sub_categories = SubCategory::all();
        $levels = Level::all();
        $languages = Language::all();
        $user = Auth::user();

        return view('instructor.course-edit',[
            'user'=>$user,
            'topics'=>$topics,
            'sub_categories'=>$sub_categories,
            'categories'=>$categories,
            'levels'=>$levels,
            'languages'=>$languages,
            'course'=>$course,
            'page_title'=>'Edit Course',
        ]);


    }


    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $id;   
    }

    public function overview(Request $req, $id){
        $user = Auth::user();
        $course = Course::find($id);
 
        if(isset($req->year)) $year = $req->year;
        else $year = date('Y');

        if(isset($req->month)) $month = $req->month;
        else $month = date('m');

        $saleOfYears = DB::table('payment_histories')
                        ->selectRaw(DB::raw("sum(amount) as amount, MONTH(created_at) as month"))
                        ->where(DB::raw("YEAR(created_at)"),$year)
                        ->where('course_id',$course->id)
                        ->groupBy("month")
                        ->get();

        $saleofMonth = DB::table('payment_histories')
                        ->selectRaw(DB::raw("sum(amount) as amount, Day(created_at) as day"))
                        ->where(DB::raw("YEAR(created_at)"),$year)
                        ->where(DB::raw("MONTH(created_at)"),$month)
                        ->where('course_id',$course->id)
                        ->groupBy("day")
                        ->get();

        $lastPeriod = $this->getLastMonth($year,$month);

        $saleofPreviousMonth = DB::table('payment_histories')
                        ->selectRaw(DB::raw("sum(amount) as amount, Day(created_at) as day"))
                        ->where(DB::raw("YEAR(created_at)"),$lastPeriod['year'])
                        ->where(DB::raw("MONTH(created_at)"),$lastPeriod['month'])
                        ->where('course_id',$course->id)
                        ->groupBy("day")
                        ->get();
   
        if($course){
            if($course->instructor->user->id ==$user->id ){
                return view('instructor.course-overview',[
                    'page_title'=>'Course Overview',
                    'course'=>$course,
                    'request'=>[
                        'year'=>$year,
                        'month'=>$month
                    ],
                    'saleOfYears'=>$saleOfYears,
                    'saleofPreviousMonth'=>$saleofPreviousMonth,
                    'saleofMonth'=>$saleofMonth,

                ]);
            }else{
                return redirect(route('instructor.error'));
            }
        }else{
            return redirect(route('instructor.error'));
        }
    }

    public function studentEnroll($id){
        $user = Auth::user();
        $course = Course::find($id);
 
        if($course){
            if($course->instructor->user->id ==$user->id ){
                return view('instructor.course-students',[
                    'page_title'=>'Students Enrolled',
                    'course'=>$course,

                ]);
            }else{
                return redirect(route('instructor.error'));
            }
        }else{
            return redirect(route('instructor.error'));
        }
    }

    public function studentDetail($id,$sid){
        $user = Auth::user();
        $course = Course::find($id);
        $student = User::find($sid);
 
        if(!$course){
            return redirect(route('instructor.error'));
        }

        if($course->instructor->user->id !=$user->id ){
            return redirect(route('instructor.error'));
        }

        $saveCourse = SavedCourse::where('course_id',$id)->where('user_id',$sid)->first();
        if(!$saveCourse){
           return redirect(route('instructor.error'));
        }

        $other_courses = SavedCourse::selectRaw('courses.id, courses.title')
        ->where('user_id',$sid)
        ->where('courses.instructor_id',$course->instructor->id)
        ->where('saved_courses.course_id','!=',$course->id)
        ->join('courses','courses.id','=','saved_courses.course_id')
        ->get();

        return view('instructor.course-students-detail',[
            'page_title'=>'Student\'s Detail',
            'course'=>$course,
            'student'=>$student,
            'joined'=>$saveCourse->created_at,
            'other_courses'=>$other_courses,

        ]);
    }

    public function approveStudent($id, $student_id){
        $paymentHistory = PaymentHistory::where('user_id',$student_id)->where('course_id',$id)->first();
        if($paymentHistory==null){
            return redirect(route('instructor.error'));
        }
        return redirect(route('instructor.statements.view',$paymentHistory->id));
    }

    function getLastMonth($year, $month){

        $month--;
        if($month==0){
            $month=12;
            $year--;
        }

        $result['year']=$year;
        $result['month']=$month;

        return $result;
    }

    public function editCoverPhoto($id){
        $course = Course::find($id);
        if(!$course) return redirect(route('instructor.error'));
        if(Gate::denies('my-course',$course)){
            return back()->with('error','Unauthorize');
        }

        return view('Instructor.course-edit-cover-photo',[
            'page_title'=>'Edit Course',
            'course'=>$course,
        ]);
    }
}
