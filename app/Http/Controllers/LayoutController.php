<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Category;
use App\Models\Review;
use App\Models\SocialMedia;

class LayoutController extends Controller
{
    public function index(){
        //extract recommended course

        $newestCourses = Course::with('instructor.user')->with('category')->with('sub_category')->with('topic')->where('disable',0)->limit(10)->orderBy('id','desc')->get();
        $featureCourses = Course::with('instructor.user')->with('category')->with('sub_category')->with('topic')->where('disable',0)->limit(10)->orderBy('id','asc')->get();
        $popularInstructors = Instructor::with('user:id,name,email,phone,address')
        ->with('user.social_contacts')
        ->with('categories')
        ->where('user_id','>',1)
        ->orderBy('student_enroll','desc')
        ->limit(10)->get();

        $reviews = Review::limit(10)->get();
        
        $top_categories = Category::orderBY('course_count','DESC')->limit(6)->get();

        return view('student.index',[
            'page_title'=>'Home',
            'newestCourses'=>$newestCourses,
            'featureCourses'=>$featureCourses,
            'popularInstructors'=>$popularInstructors,
            'reviews'=>$reviews,
            'top_categories'=>$top_categories,
        ]);
    }

    public function explore(){
        return view('student.explore',[
            'page_title'=>'Explore',
        ]);
    }

    public function aboutPage(){
        return view('pages.about',[
            'page_title'=>'About'
        ]);
    }

    public function pressPage(){
        return view ('pages.press',[
            'page_title'=>'Press'
        ]);
    }

    public function contactPage(){
        return view('pages.contact',[
            'page_title'=>'Contact',
        ]);
    }

    public function getAppPage(){
        return view('pages.get-app',[
            'page_title'=>'Get Mobile App',
        ]);
    }

    public function helpPage(){
        return view('pages.help',[
            'page_title'=>'Help',
        ]);
    }

    public function privacyPolicyPage(){
        return view('pages.privacy-policy',[
            'page_title'=>'Privacy Policy',
        ]);
    }

    public function siteMapPage(){
        return view('pages.sitemap',[
            'page_title'=>'Sitemap',
        ]);
    }

    public function teachOnPage(){
        return view('pages.teach-on',[
            'page_title'=>'Teach On',
        ]);
    }

    public function termPage(){
        return view('pages.terms',[
            'page_title'=>'Terms',
        ]);
    }

    public function subscription(){
        $social_media = SocialMedia::all();
        return view('student.subscriptions',[
            'page_title'=>'Subscriptions',
            'social_media'=>$social_media,
        ]);
    }
}
