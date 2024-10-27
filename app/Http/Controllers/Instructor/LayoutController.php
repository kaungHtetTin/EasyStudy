<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Instructor;
use App\Models\SubCategory;
use App\Models\Topic;
use App\Models\Level;
use App\Models\PaymentMethod;
use App\Models\Course;
use App\Models\PaymentHistory;
use App\Models\SocialMedia;
use App\Models\Visit;
use App\Models\Subscriber;
use App\Models\Setting;
use App\Models\User;


class LayoutController extends Controller
{
    public function index(){

        $user = Auth::user();
        $instructor = Instructor::where('user_id',$user->id)->first();
  
        $year = date('Y');
        $month = date('m');

        $payment_methods = PaymentMethod::where('instructor_id',$instructor->id)->get(); 
        $courses = Course::where('instructor_id',$instructor->id);
        $total_course = $courses->count();
        $total_student = $courses->sum('enroll_count');
        $total_sale = PaymentHistory::where('instructor_id',$instructor->id)->sum('amount');
        $new_sales = PaymentHistory::where('instructor_id',$instructor->id)
        ->where(DB::raw("YEAR(created_at)"),$year)
        ->where(DB::raw("MONTH(created_at)"),$month);

        $new_course = Course::where('instructor_id',$instructor->id)
        ->where(DB::raw("YEAR(created_at)"),$year)
        ->where(DB::raw("MONTH(created_at)"),$month)->count();

        $new_subscriber = Subscriber::where('instructor_id',$instructor->id)
        ->where(DB::raw("YEAR(created_at)"),$year)
        ->where(DB::raw("MONTH(created_at)"),$month)->count();

        
    
        return view('instructor.dashboard',[
            'page_title'=>'Dashboard',
            'payment_methods'=>$payment_methods,
            'instructor'=>$instructor,
            'total_course'=>$total_course,
            'total_student'=>$total_student,
            'total_sale'=>$total_sale,
            'new_sale'=>$new_sales->sum('amount'),
            'new_enroll'=>$new_sales->count(),
            'new_course'=>$new_course,
            'new_subscriber'=>$new_subscriber, 
        ]);
       
    }

    public function profileEdit(){
        $user = Auth::user();
        $instructor = Instructor::where('user_id',$user->id)->first();
        $social_media = SocialMedia::get();
    
        return view('instructor.instructor-profile-edit',[
            'page_title'=>"Profile Edit",
            'instructor'=>$instructor,
            'social_media'=>$social_media,
        ]);
    }

    public function error(){
        return view('instructor.error',[
            'page_title'=>"Error",
        ]);
    }

    public function analyics(Request $req){
        $user = Auth::user();
        $instructor = Instructor::where('user_id',$user->id)->first();
  
        if(isset($req->year)) $year = $req->year;
        else $year = date('Y');

        if(isset($req->month)) $month = $req->month;
        else $month = date('m');

        $day = date('d');
        $today['day_of_month'] = $day;
        $today['day_of_week'] = date('D');

        // subscriber in year
        $subscribers = Subscriber::selectRaw(DB::raw("count(*) as subscriber, MONTH(created_at) as month"))
        ->where('instructor_id',$instructor->id)
        ->where(DB::raw("YEAR(created_at)"),$year)
        ->groupBy("month")
        ->get();


        // weekly visitor
        $visitors = Visit::selectRaw(DB::raw("count(*) as visitor,  Day(visits.created_at) as day"))
        ->join('courses','courses.id','=','course_id')
        ->where('courses.instructor_id',$instructor->id)
        ->where(DB::raw("YEAR(visits.created_at)"),$year)
        ->where(DB::raw("MONTH(visits.created_at)"),$month)
        ->where(DB::raw("DAY(visits.created_at)"),'>=',$day-14)
        ->groupBy("day")
        ->get();

        // sales of year
        $saleOfYears = DB::table('payment_histories')
        ->selectRaw(DB::raw("sum(amount) as amount, MONTH(created_at) as month"))
        ->where(DB::raw("YEAR(created_at)"),$year)
        ->where('instructor_id',$instructor->id)
        ->groupBy("month")
        ->get();

        // sales of month
        $saleofMonth = DB::table('payment_histories')
        ->selectRaw(DB::raw("sum(amount) as amount, Day(created_at) as day"))
        ->where(DB::raw("YEAR(created_at)"),$year)
        ->where(DB::raw("MONTH(created_at)"),$month)
        ->where('instructor_id',$instructor->id)
        ->groupBy("day")
        ->get();
 
        $lastPeriod = $this->getLastMonth($year,$month);

        // sale of last month
        $saleofPreviousMonth = DB::table('payment_histories')
        ->selectRaw(DB::raw("sum(amount) as amount, Day(created_at) as day"))
        ->where(DB::raw("YEAR(created_at)"),$lastPeriod['year'])
        ->where(DB::raw("MONTH(created_at)"),$lastPeriod['month'])
        ->where('instructor_id',$instructor->id)
        ->groupBy("day")
        ->get();

        // sale of course in year
        $salesOfCourse = PaymentHistory::selectRaw(DB::raw("sum(amount) as amount, course_id"))
        ->with('course:id,title')
        ->where(DB::raw("YEAR(created_at)"),$year)
        ->where('instructor_id',$instructor->id)
        ->groupBy("course_id")
        ->get();

        // sale of course in last year
        $salesOfCourseLastYear = PaymentHistory::selectRaw(DB::raw("sum(amount) as amount, course_id"))
        ->with('course:id,title')
        ->where(DB::raw("YEAR(created_at)"),$year-1)
        ->where('instructor_id',$instructor->id)
        ->groupBy("course_id")
        ->get();

        // sale of course in month
        $salesOfCourseInMonth = PaymentHistory::selectRaw(DB::raw("sum(amount) as amount, course_id"))
        ->with('course:id,title')
        ->where(DB::raw("YEAR(created_at)"),$year)
        ->where(DB::raw("MONTH(created_at)"),$month)
        ->where('instructor_id',$instructor->id)
        ->groupBy("course_id")
        ->get();

        // sale of course in last month
        $salesOfCourseLastMonth = PaymentHistory::selectRaw(DB::raw("sum(amount) as amount, course_id"))
        ->with('course:id,title')
        ->where(DB::raw("YEAR(created_at)"),$lastPeriod['year'])
        ->where(DB::raw("MONTH(created_at)"),$lastPeriod['month'])
        ->where('instructor_id',$instructor->id)
        ->groupBy("course_id")
        ->get();

        $courses = Course::selectRaw("id, title")->where('instructor_id',$instructor->id)->get();
   
        return view('instructor.analyics',[
            'page_title'=>'Analyics',
            'today'=>$today,
            'subscribers'=>$subscribers,
            'visitors'=>$visitors,
            'saleOfYears'=>$saleOfYears,
            'saleofPreviousMonth'=>$saleofPreviousMonth,
            'saleofMonth'=>$saleofMonth,
            'salesOfCourse'=>$salesOfCourse,
            'salesOfCourseLastYear'=>$salesOfCourseLastYear,
            'salesOfCourseInMonth'=>$salesOfCourseInMonth,
            'salesOfCourseLastMonth'=>$salesOfCourseLastMonth,
            'courses'=>$courses,
            'request'=>[
                'year'=>$year,
                'month'=>$month
            ],
        ]);
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
 
    public function earning(){
        $user = Auth::user();
        $instructor = Instructor::where('user_id',$user->id)->first();
        $year = date('Y');
        $month = date('m');

        $this_month_earnings = PaymentHistory::selectRaw(DB::raw("sum(amount) as amount, course_id"))
        ->where(DB::raw("YEAR(created_at)"),$year)
        ->where(DB::raw("MONTH(created_at)"),$month)
        ->where('instructor_id',$instructor->id)
        ->groupBy("course_id")
        ->get();

        $this_year_earnings = PaymentHistory::selectRaw(DB::raw("sum(amount) as amount, course_id"))
        ->where(DB::raw("YEAR(created_at)"),$year)
        ->where('instructor_id',$instructor->id)
        ->groupBy("course_id")
        ->get();

        $all_time_earnings = PaymentHistory::selectRaw(DB::raw("sum(amount) as amount, course_id, count(*) as sale"))
        ->where(DB::raw("YEAR(created_at)"),$year)
        ->where('instructor_id',$instructor->id)
        ->groupBy("course_id")
        ->get();


        return view('instructor.earning',[
            'page_title'=>'Earning',
            'this_month_earnings'=>$this_month_earnings,
            'this_year_earnings'=>$this_year_earnings,
            'all_time_earnings'=>$all_time_earnings,
        ]);
    }
    
}
