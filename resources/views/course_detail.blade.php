@php
	function calculateHour($min){
		$hr = $min/60;
		$hr = floor($hr);
		return $hr;
	}

	function formatCounting($count){
		if($count<1000){
			return $count;
		}else if($count>=1000 && $count<1000000){
			return floor($count/1000);
		}else{
			return floor($count/1000000);
		}
	}

    $downloadable_count = 0;
    $article_count = 0;
    $assignment_count = 0;
    foreach ($course->lessons as $key => $lesson) {
       
        # code...
        if($lesson->downloadable==1){
            $downloadable_count++;
        }
        if($lesson->lesson_type_id==2){
            $article_count++;

        }
        if($lesson->lesson_type_id==3){
            $assignment_count++;
        }
    }

@endphp

@extends('layouts.master')
    @section('content')
    
    <!-- Video Model Start -->
	<div class="modal vd_mdl fade" id="videoModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<div class="modal-body">
					<iframe  src="https://www.youtube.com/embed/Ohe_JzKksvA" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
				
			</div>
		</div>
	</div>
	<!-- Video Model End -->

    {{-- Paynow modal Start --}}
    <div class="modal vd_mdl fade" id="payModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<div class="modal-body">
					This is paynow modal
				</div>
				
			</div>
		</div>
	</div>

    {{-- Paynow modal End --}}

@auth
<div class="wrapper _bg4586">
@else
<div style="padding-top:60px;">
@endauth
    <div class="_215b01">
        <div class="container-fluid">			
            <div class="row">
                <div class="col-lg-12">
                    <div class="section3125">							
                        <div class="row justify-content-center">						
                            <div class="col-xl-4 col-lg-5 col-md-6">						
                                <div class="preview_video">						
                                    <a href="#" class="fcrse_img" data-toggle="modal" data-target="#videoModal">
                                        <img src="{{asset('images/courses/img-2.jpg')}}" alt="">
                                        <div class="course-overlay">
                                            <div class="badge_seller">Bestseller</div>
                                            <span class="play_btn1"><i class="uil uil-play"></i></span>
                                            <span class="_215b02">Preview this course</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="_215b10">										
                                    <a href="#" class="_215b11">										
                                        <span><i class="uil uil-heart"></i></span>Save
                                    </a>
                                    <a href="#" class="_215b12">										
                                        <span><i class="uil uil-windsock"></i></span>Report abuse
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-8 col-lg-7 col-md-6">
                                <div class="_215b03">
                                    <h2>{{$course->title}}</h2>
                                    <span class="_215b04">{{$course->category->title}} <i class="uil uil-arrow-right"></i> {{$course->sub_category->title}} <i class="uil uil-arrow-right"></i>  {{$course->topic->title}}</span>
                                </div>
                                <div class="_215b05">
                                    <div class="crse_reviews mr-2">
                                        <i class="uil uil-star"></i>{{$course->rating}}
                                    </div>
                                    ({{$course->total_rating}} ratings)
                                </div>

                                <div class="row">
                                    <div class="col-6 _215b08">
                                        <div class="_215b05">										
                                            <span><i class='uil uil-play-circle'></i></span>
                                            {{calculateHour($course->duration)}} hours on-demand video
                                        </div>
                                    </div>
                                    <div class="col-6 _215b08">
                                        <div class="_215b05">										
                                            <span><i class='uil uil-file-alt'></i></span>
                                            {{$assignment_count}} Assignments
                                        </div>
                                    </div>
                                    <div class="col-6 _215b08">
                                        <div class="_215b05">										
                                            <span><i class='uil uil-document'></i></span>
                                            {{$article_count}} articles
                                        </div>
                                    </div>
                                    <div class="col-6 _215b08">
                                        <div class="_215b05">										
                                            <span><i class='uil uil-cloud-download'></i></span>
                                            {{$downloadable_count}} downloable resourses
                                        </div>
                                    </div>
                                    <div class="col-6 _215b08">
                                        <div class="_215b05">										
                                            <span><i class='uil uil-graduation-hat'></i></span>
                                            {{$course->users->count()}} students enrolled
                                        </div>
                                    </div>
                                    <div class="col-6 _215b08">
                                        <div class="_215b05">										
                                            <span><i class='uil uil-clock-seven'></i></span>
                                            Full life-time access
                                        </div>
                                    </div>
                                    @if ($course->certificate)
                                        <div class="col-6 _215b08">
                                            <div class="_215b05">										
                                                <span><i class='uil uil-trophy'></i></span>
                                                Certification of completion
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                
                               
                                <div class="_215b06">										
                                    <div class="_215b07">										
                                        <span><i class='uil uil-comment'></i></span>
                                        English
                                    </div>
                                </div>
                                <div class="_215b05">										
                                    Last updated {{$course->updated_at->diffForHumans()}}
                                </div>
                                <ul class="_215b31">										
                                    <li>
                                        <form action="{{route('cart')}}" method="POST">
                                            <input type="hidden" value="{{$course->id}}" name="course_id">
                                            @csrf
                                            <button type="submit" class="btn_adcart">Add to Cart</button>
                                        </form>
                                       
                                    </li>
                                    <li>
                                        <button class="btn_buy" data-toggle="modal" data-target="#payModal">
                                            Buy Now
                                        </button>
                                    </li>
                                </ul>
                                <div class="_215fgt1">										
                                    30-Day Money-Back Guarantee
                                </div>
                            </div>							
                        </div>							
                    </div>							
                </div>															
            </div>
        </div>
    </div>
    <div class="_215b15 _byt1458">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="user_dt5">
                        <div class="user_dt_left">
                            <div class="live_user_dt">
                                <div class="user_img5">
                                    <a href="#"><img src="{{asset('images/left-imgs/img-1.jpg')}}" alt=""></a>												
                                </div>
                                <div class="user_cntnt">
                                    <a href="{{route('instructor_detail',['id'=>$course->instructor->id])}}" class="_df7852">{{$course->instructor->user->name}}</a>
                                    <button class="subscribe-btn">Subscribe</button>
                                </div>
                            </div>
                        </div>
                        <div class="user_dt_right">
                            <ul>
                                <li>
                                    <a href="#" class="lkcm152"><i class="uil uil-eye"></i><span>1452</span></a>
                                </li>
                                <li>
                                    <a href="#" class="lkcm152"><i class="uil uil-thumbs-up"></i><span>100</span></a>
                                </li>
                                <li>
                                    <a href="#" class="lkcm152"><i class="uil uil-thumbs-down"></i><span>20</span></a>
                                </li>
                                <li>
                                    <a href="#" class="lkcm152"><i class="uil uil-share-alt"></i><span>9</span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="course_tabs">
                        <nav>
                            <div class="nav nav-tabs tab_crse justify-content-center" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-selected="true">About</a>
                                <a class="nav-item nav-link" id="nav-courses-tab" data-toggle="tab" href="#nav-courses" role="tab" aria-selected="false">Courses Content</a>
                                <a class="nav-item nav-link" id="nav-reviews-tab" data-toggle="tab" href="#nav-reviews" role="tab" aria-selected="false">Reviews</a>
                            </div>
                        </nav>						
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="_215b17">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="course_tab_content">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-about" role="tabpanel">
                                <div class="_htg451">
                                    <div class="_htg452">
                                        <h3>Requirements</h3>
                                        <ul>
                                            <li><span class="_5f7g11">Have a computer with Internet</span></li>
                                            <li><span class="_5f7g11">Be ready to learn an insane amount of awesome stuff</span></li>
                                            <li><span class="_5f7g11">Prepare to build real web apps!</span></li>
                                        </ul>
                                    </div>
                                    <div class="_htg452 mt-35">
                                        <h3>Description</h3>
                                        <span class="_abc123">Just updated to include Bootstrap 4.1.3!</span>
                                        <p>Hi! Welcome to the Web Developer Bootcamp, the <strong>only course you need to learn web development</strong>. There are a lot of options for online developer training, but this course is without a doubt the most comprehensive and effective on the market.  Here's why:</p>
                                        <ul class="_abc124">
                                            <li><span class="_5f7g11">This is the only online course taught by a professional bootcamp instructor.</span></li>
                                            <li><span class="_5f7g11">94% of my in-person bootcamp students go on to get full-time developer jobs. Most of them are complete beginners when I start working with them.</span></li>
                                            <li><span class="_5f7g11">The previous 2 bootcamp programs that I taught cost $14,000 and $21,000.  This course is just as comprehensive but with brand new content for a fraction of the price.</span></li>
                                            <li><span class="_5f7g11">Everything I cover is up-to-date and relevant to today's developer industry. No PHP or other dated technologies. This course does not cut any corners.</span></li>
                                            <li><span class="_5f7g11">This is the only complete beginner full-stack developer course that covers NodeJS.</span></li>
                                            <li><span class="_5f7g11">We build 13+ projects, including a gigantic production application called YelpCamp. No other course walks you through the creation of such a substantial application.</span></li>
                                            <li><span class="_5f7g11">The course is constantly updated with new content, projects, and modules.  Think of it as a subscription to a never-ending supply of developer training.</span></li>
                                        </ul>
                                        <p>When you're learning to program you often have to sacrifice learning the exciting and current technologies in favor of the "beginner friendly" classes.  With this course, you get the best of both worlds.  This is a course designed for the complete beginner, yet it covers some of the most exciting and relevant topics in the industry.</p>
                                        <p>Throughout the course we cover tons of tools and technologies including:</p>
                                        <ul class="_abc124">												
                                            <li><span class="_5f7g11"><strong>HTML5</strong></span></li>
                                            <li><span class="_5f7g11"><strong>CSS3</strong></span></li>
                                            <li><span class="_5f7g11"><strong>JavaScript</strong></span></li>
                                            <li><span class="_5f7g11"><strong>Bootstrap 4</strong></span></li>
                                            <li><span class="_5f7g11"><strong>SemanticUI</strong></span></li>
                                            <li><span class="_5f7g11"><strong>DOM Manipulation</strong></span></li>
                                            <li><span class="_5f7g11"><strong>jQuery</strong></span></li>
                                            <li><span class="_5f7g11"><strong>Unix(Command Line) Commands</strong></span></li>
                                            <li><span class="_5f7g11"><strong>NodeJS</strong></span></li>
                                            <li><span class="_5f7g11"><strong>NPM</strong></span></li>
                                            <li><span class="_5f7g11"><strong>ExpressJS</strong></span></li>
                                            <li><span class="_5f7g11"><strong>REST</strong></span></li>
                                            <li><span class="_5f7g11"><strong>MongoDB</strong></span></li>
                                            <li><span class="_5f7g11"><strong>Database Associations</strong></span></li>
                                            <li><span class="_5f7g11"><strong>Authentication</strong></span></li>
                                            <li><span class="_5f7g11"><strong>PassportJS</strong></span></li>
                                            <li><span class="_5f7g11"><strong>Authorization</strong></span></li>
                                        </ul>
                                        
                                            <p>This course is also unique in the way that it is structured and presented. Many online courses are just a long series of "watch as I code" videos.  This course is different. I've incorporated everything I learned in my years of teaching to make this course not only more effective but more engaging. The course includes:</p>
                                            <ul class="_abc124">												
                                                <li><span class="_5f7g11">Lectures</span></li>
                                                <li><span class="_5f7g11">Code-Alongs</span></li>
                                                <li><span class="_5f7g11">Projects</span></li>
                                                <li><span class="_5f7g11">Exercises</span></li>
                                                <li><span class="_5f7g11">Research Assignments</span></li>
                                                <li><span class="_5f7g11">Slides</span></li>
                                                <li><span class="_5f7g11">Downloads</span></li>
                                                <li><span class="_5f7g11">Readings</span></li>
                                            </ul>
                                            <p>If you have any questions, please don't hesitate to contact me.  I got into this industry because I love working with people and helping students learn.  Sign up today and see how fun, exciting, and rewarding web development can be!</p>
                                    </div>
                                    <div class="_htg452 mt-35">
                                        <h3>Who this course is for :</h3>
                                        <ul class="_abc124">												
                                            <li><span class="_5f7g11">This course is for anyone who wants to learn about web development, regardless of previous experience</span></li>
                                            <li><span class="_5f7g11">It's perfect for complete beginners with zero experience</span></li>
                                            <li><span class="_5f7g11">It's also great for anyone who does have some experience in a few of the technologies(like HTML and CSS) but not all</span></li>
                                            <li><span class="_5f7g11">If you want to take ONE COURSE to learn everything you need to know about web development, take this course</span></li>
                                        </ul>
                                    </div>	
                                    <div class="_htgdrt mt-35">
                                        <h3>What you'll learn</h3>
                                        <div class="_scd123">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <ul class="_htg452 _abcd145">												
                                                        <li><div class="_5f7g15"><i class="fas fa-check-circle"></i><span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span></div></li>
                                                        <li><div class="_5f7g15"><i class="fas fa-check-circle"></i><span>Donec ultricies elit porttitor, ultrices enim a, commodo dolor.</span></div></li>
                                                        <li><div class="_5f7g15"><i class="fas fa-check-circle"></i><span>Nunc dapibus ligula sed justo porta, id volutpat odio iaculis.</span></div></li>
                                                        <li><div class="_5f7g15"><i class="fas fa-check-circle"></i><span>Maecenas pharetra mi quis nisl mollis, molestie imperdiet lorem molestie.</span></div></li>
                                                        <li><div class="_5f7g15"><i class="fas fa-check-circle"></i><span>Maecenas ultricies felis in pulvinar blandit.</span></div></li>
                                                        <li><div class="_5f7g15"><i class="fas fa-check-circle"></i><span>Praesent ac libero consequat, efficitur tortor et, interdum sem.</span></div></li>
                                                        <li><div class="_5f7g15"><i class="fas fa-check-circle"></i><span>Nullam non lacus nibh. Etiam et fringilla neque, ut vulputate sapien. Sed vitae tortor gravida, interdum felis at, pulvinar enim. Integer tempor urna leo.</span></div></li>
                                                        <li><div class="_5f7g15"><i class="fas fa-check-circle"></i><span>Phasellus ultrices tellus sed volutpat vestibulum. Curabitur aliquet dictum leo non congue.</span></div></li>
                                                        <li><div class="_5f7g15"><i class="fas fa-check-circle"></i><span>In hac habitasse platea dictumst. Aenean vel fermentum neque.</span></div></li>
                                                        <li><div class="_5f7g15"><i class="fas fa-check-circle"></i><span>Suspendisse semper feugiat urna dictum interdum.</span></div></li>
                                                    </ul>
                                                </div>
                                                <div class="col-lg-6">
                                                    <ul class="_htg452 _abcd145">
                                                        <li><div class="_5f7g15"><i class="fas fa-check-circle"></i><span>Nullam non lacus nibh. Etiam et fringilla neque, ut vulputate sapien. Sed vitae tortor gravida, interdum felis at, pulvinar enim. Integer tempor urna leo.</span></div></li>
                                                        <li><div class="_5f7g15"><i class="fas fa-check-circle"></i><span>Phasellus ultrices tellus sed volutpat vestibulum. Curabitur aliquet dictum leo non congue.</span></div></li>
                                                        <li><div class="_5f7g15"><i class="fas fa-check-circle"></i><span>In hac habitasse platea dictumst. Aenean vel fermentum neque.</span></div></li>
                                                        <li><div class="_5f7g15"><i class="fas fa-check-circle"></i><span>Suspendisse semper feugiat urna dictum interdum.</span></div></li>
                                                        <li><div class="_5f7g15"><i class="fas fa-check-circle"></i><span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span></div></li>
                                                        <li><div class="_5f7g15"><i class="fas fa-check-circle"></i><span>Donec ultricies elit porttitor, ultrices enim a, commodo dolor.</span></div></li>
                                                        <li><div class="_5f7g15"><i class="fas fa-check-circle"></i><span>Nunc dapibus ligula sed justo porta, id volutpat odio iaculis.</span></div></li>
                                                        <li><div class="_5f7g15"><i class="fas fa-check-circle"></i><span>Maecenas pharetra mi quis nisl mollis, molestie imperdiet lorem molestie.</span></div></li>
                                                        <li><div class="_5f7g15"><i class="fas fa-check-circle"></i><span>Maecenas ultricies felis in pulvinar blandit.</span></div></li>
                                                        <li><div class="_5f7g15"><i class="fas fa-check-circle"></i><span>Praesent ac libero consequat, efficitur tortor et, interdum sem.</span></div></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>							
                                </div>							
                            </div>
                            <div class="tab-pane fade" id="nav-courses" role="tabpanel">
                                <div class="crse_content">
                                    <h3>Course content</h3>
                                    <div class="_112456">
                                        <ul class="accordion-expand-holder">
                                            <li><span class="accordion-expand-all _d1452">Expand all</span></li>
                                            <li><span class="_fgr123"> 402 lectures</span></li>
                                            <li><span class="_fgr123">47:06:29</span></li>
                                        </ul>
                                    </div>

                                    @foreach ($course->modules as $module)
                                        <div id="accordion" class="ui-accordion ui-widget ui-helper-reset">
                                            <a href="javascript:void(0)" class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all">												
                                                <div class="section-header-left">
                                                    <span class="section-title-wrapper">
                                                        <i class='uil uil-presentation-play crse_icon'></i>
                                                        <span class="section-title-text">{{$module->title}}</span>
                                                    </span>
                                                </div>
                                                <div class="section-header-right">
                                                    <span class="num-items-in-section">8 lectures</span>
                                                    <span class="section-header-length">22:08</span>
                                                </div>
                                            </a>
                                            <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
                                                
                                                @foreach ($module->lessons as $lesson)
                                                    
                                                    <div class="lecture-container">
                                                        <div class="left-content">
                                                            @if ($lesson->lesson_type_id==1)
                                                                <i class='uil uil-play-circle icon_142'></i> 
                                                            @else
                                                                 <i class='uil uil-file icon_142'></i>
                                                            @endif
                                                           
                                                            <div class="top">
                                                                <div class="title">{{$lesson->title}}</div>
                                                            </div>
                                                        </div>
                                                        <div class="details">
                                                             @if ($lesson->lesson_type_id==1)
                                                                <span class="content-summary">00:12</span>
                                                            @endif
                                                           
                                                        </div>
                                                    </div>

                                                @endforeach
                                            </div>
                                        </div>
                                     @endforeach
                                    <a class="btn1458" href="#">20 More Sections</a>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-reviews" role="tabpanel">
                                <div class="student_reviews">
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <div class="reviews_left">
                                                <h3>Student Feedback</h3>
                                                <div class="total_rating">
                                                    <div class="_rate001">4.6</div>														
                                                    <div class="rating-box">
                                                        <span class="rating-star full-star"></span>
                                                        <span class="rating-star full-star"></span>
                                                        <span class="rating-star full-star"></span>
                                                        <span class="rating-star full-star"></span>
                                                        <span class="rating-star half-star"></span>
                                                    </div>
                                                    <div class="_rate002">Course Rating</div>	
                                                </div>
                                                <div class="_rate003">
                                                    <div class="_rate004">
                                                        <div class="progress progress1">
                                                            <div class="progress-bar w-70" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        <div class="rating-box">
                                                            <span class="rating-star full-star"></span>
                                                            <span class="rating-star full-star"></span>
                                                            <span class="rating-star full-star"></span>
                                                            <span class="rating-star full-star"></span>
                                                            <span class="rating-star full-star"></span>
                                                        </div>
                                                        <div class="_rate002">70%</div>
                                                    </div>
                                                    <div class="_rate004">
                                                        <div class="progress progress1">
                                                            <div class="progress-bar w-30" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        <div class="rating-box">
                                                            <span class="rating-star full-star"></span>
                                                            <span class="rating-star full-star"></span>
                                                            <span class="rating-star full-star"></span>
                                                            <span class="rating-star full-star"></span>
                                                            <span class="rating-star empty-star"></span>
                                                        </div>
                                                        <div class="_rate002">40%</div>
                                                    </div>
                                                    <div class="_rate004">
                                                        <div class="progress progress1">
                                                            <div class="progress-bar w-5" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        <div class="rating-box">
                                                            <span class="rating-star full-star"></span>
                                                            <span class="rating-star full-star"></span>
                                                            <span class="rating-star full-star"></span>
                                                            <span class="rating-star empty-star"></span>
                                                            <span class="rating-star empty-star"></span>
                                                        </div>
                                                        <div class="_rate002">5%</div>
                                                    </div>
                                                    <div class="_rate004">
                                                        <div class="progress progress1">
                                                            <div class="progress-bar w-2" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        <div class="rating-box">
                                                            <span class="rating-star full-star"></span>
                                                            <span class="rating-star full-star"></span>
                                                            <span class="rating-star empty-star"></span>
                                                            <span class="rating-star empty-star"></span>
                                                            <span class="rating-star empty-star"></span>
                                                        </div>
                                                        <div class="_rate002">1%</div>
                                                    </div>
                                                    <div class="_rate004">
                                                        <div class="progress progress1">
                                                            <div class="progress-bar w-1" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        <div class="rating-box">
                                                            <span class="rating-star full-star"></span>
                                                            <span class="rating-star empty-star"></span>
                                                            <span class="rating-star empty-star"></span>
                                                            <span class="rating-star empty-star"></span>
                                                            <span class="rating-star empty-star"></span>
                                                        </div>
                                                        <div class="_rate002">1%</div>
                                                    </div>
                                                </div>
                                            </div>												
                                        </div>
                                        <div class="col-lg-7">
                                            <div class="review_right">
                                                <div class="review_right_heading">
                                                    <h3>Reviews</h3>
                                                    <div class="review_search">
                                                        <input class="rv_srch" type="text" placeholder="Search reviews...">
                                                        <button class="rvsrch_btn"><i class='uil uil-search'></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="review_all120">
                                                <div class="review_item">
                                                    <div class="review_usr_dt">
                                                        <img src="images/left-imgs/img-1.jpg" alt="">
                                                        <div class="rv1458">
                                                            <h4 class="tutor_name1">John Doe</h4>
                                                            <span class="time_145">2 hour ago</span>
                                                        </div>
                                                    </div>
                                                    <div class="rating-box mt-20">
                                                        <span class="rating-star full-star"></span>
                                                        <span class="rating-star full-star"></span>
                                                        <span class="rating-star full-star"></span>
                                                        <span class="rating-star full-star"></span>
                                                        <span class="rating-star half-star"></span>
                                                    </div>
                                                    <p class="rvds10">Nam gravida elit a velit rutrum, eget dapibus ex elementum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Fusce lacinia, nunc sit amet tincidunt venenatis.</p>
                                                    <div class="rpt100">
                                                        <span>Was this review helpful?</span>
                                                        <div class="radio--group-inline-container">
                                                            <div class="radio-item">
                                                                <input id="radio-1" name="radio" type="radio">
                                                                <label for="radio-1" class="radio-label">Yes</label>
                                                            </div>
                                                            <div class="radio-item">
                                                                <input id="radio-2" name="radio" type="radio">
                                                                <label  for="radio-2" class="radio-label">No</label>
                                                            </div>
                                                        </div>
                                                        <a href="#" class="report145">Report</a>
                                                    </div>
                                                </div>
                                                <div class="review_item">
                                                    <div class="review_usr_dt">
                                                        <img src="images/left-imgs/img-2.jpg" alt="">
                                                        <div class="rv1458">
                                                            <h4 class="tutor_name1">Jassica William</h4>
                                                            <span class="time_145">12 hour ago</span>
                                                        </div>
                                                    </div>
                                                    <div class="rating-box mt-20">
                                                        <span class="rating-star full-star"></span>
                                                        <span class="rating-star full-star"></span>
                                                        <span class="rating-star full-star"></span>
                                                        <span class="rating-star full-star"></span>
                                                        <span class="rating-star empty-star"></span>
                                                    </div>
                                                    <p class="rvds10">Nam gravida elit a velit rutrum, eget dapibus ex elementum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Fusce lacinia, nunc sit amet tincidunt venenatis.</p>
                                                    <div class="rpt100">
                                                        <span>Was this review helpful?</span>
                                                        <div class="radio--group-inline-container">
                                                            <div class="radio-item">
                                                                <input id="radio-3" name="radio1" type="radio">
                                                                <label for="radio-3" class="radio-label">Yes</label>
                                                            </div>
                                                            <div class="radio-item">
                                                                <input id="radio-4" name="radio1" type="radio">
                                                                <label  for="radio-4" class="radio-label">No</label>
                                                            </div>
                                                        </div>
                                                        <a href="#" class="report145">Report</a>
                                                    </div>
                                                </div>
                                                <div class="review_item">
                                                    <div class="review_usr_dt">
                                                        <img src="images/left-imgs/img-3.jpg" alt="">
                                                        <div class="rv1458">
                                                            <h4 class="tutor_name1">Albert Dua</h4>
                                                            <span class="time_145">5 days ago</span>
                                                        </div>
                                                    </div>
                                                    <div class="rating-box mt-20">
                                                        <span class="rating-star full-star"></span>
                                                        <span class="rating-star full-star"></span>
                                                        <span class="rating-star full-star"></span>
                                                        <span class="rating-star half-star"></span>
                                                        <span class="rating-star empty-star"></span>
                                                    </div>
                                                    <p class="rvds10">Nam gravida elit a velit rutrum, eget dapibus ex elementum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Fusce lacinia, nunc sit amet tincidunt venenatis.</p>
                                                    <div class="rpt100">
                                                        <span>Was this review helpful?</span>
                                                        <div class="radio--group-inline-container">
                                                            <div class="radio-item">
                                                                <input id="radio-5" name="radio2" type="radio">
                                                                <label for="radio-5" class="radio-label">Yes</label>
                                                            </div>
                                                            <div class="radio-item">
                                                                <input id="radio-6" name="radio2" type="radio">
                                                                <label  for="radio-6" class="radio-label">No</label>
                                                            </div>
                                                        </div>
                                                        <a href="#" class="report145">Report</a>
                                                    </div>
                                                </div>
                                                <div class="review_item">
                                                    <div class="review_usr_dt">
                                                        <img src="images/left-imgs/img-4.jpg" alt="">
                                                        <div class="rv1458">
                                                            <h4 class="tutor_name1">Zoena Singh</h4>
                                                            <span class="time_145">15 days ago</span>
                                                        </div>
                                                    </div>
                                                    <div class="rating-box mt-20">
                                                        <span class="rating-star full-star"></span>
                                                        <span class="rating-star full-star"></span>
                                                        <span class="rating-star full-star"></span>
                                                        <span class="rating-star full-star"></span>
                                                        <span class="rating-star full-star"></span>
                                                    </div>
                                                    <p class="rvds10">Nam gravida elit a velit rutrum, eget dapibus ex elementum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Fusce lacinia, nunc sit amet tincidunt venenatis.</p>
                                                    <div class="rpt100">
                                                        <span>Was this review helpful?</span>
                                                        <div class="radio--group-inline-container">
                                                            <div class="radio-item">
                                                                <input id="radio-7" name="radio3" type="radio">
                                                                <label for="radio-7" class="radio-label">Yes</label>
                                                            </div>
                                                            <div class="radio-item">
                                                                <input id="radio-8" name="radio3" type="radio">
                                                                <label  for="radio-8" class="radio-label">No</label>
                                                            </div>
                                                        </div>
                                                        <a href="#" class="report145">Report</a>
                                                    </div>
                                                </div>
                                                <div class="review_item">
                                                    <div class="review_usr_dt">
                                                        <img src="images/left-imgs/img-5.jpg" alt="">
                                                        <div class="rv1458">
                                                            <h4 class="tutor_name1">Joy Dua</h4>
                                                            <span class="time_145">20 days ago</span>
                                                        </div>
                                                    </div>
                                                    <div class="rating-box mt-20">
                                                        <span class="rating-star full-star"></span>
                                                        <span class="rating-star full-star"></span>
                                                        <span class="rating-star full-star"></span>
                                                        <span class="rating-star empty-star"></span>
                                                        <span class="rating-star empty-star"></span>
                                                    </div>
                                                    <p class="rvds10">Nam gravida elit a velit rutrum, eget dapibus ex elementum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Fusce lacinia, nunc sit amet tincidunt venenatis.</p>
                                                    <div class="rpt100">
                                                        <span>Was this review helpful?</span>
                                                        <div class="radio--group-inline-container">
                                                            <div class="radio-item">
                                                                <input id="radio-9" name="radio4" type="radio">
                                                                <label for="radio-9" class="radio-label">Yes</label>
                                                            </div>
                                                            <div class="radio-item">
                                                                <input id="radio-10" name="radio4" type="radio">
                                                                <label  for="radio-10" class="radio-label">No</label>
                                                            </div>
                                                        </div>
                                                        <a href="#" class="report145">Report</a>
                                                    </div>
                                                </div>
                                                <div class="review_item">
                                                    <a href="#" class="more_reviews">See More Reviews</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
		
		