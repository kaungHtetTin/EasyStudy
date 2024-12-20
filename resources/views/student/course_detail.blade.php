@php
if (!function_exists('calculateHour')) {
	function calculateHour($min){
		$hr = $min/60;
		$hr = floor($hr);
		return $hr;
	}
}
if (!function_exists('formatCounting')) {
	function formatCounting($count){
		if($count<1000){
			return $count;
		}else if($count>=1000 && $count<1000000){
			return floor($count/1000);
		}else{
			return floor($count/1000000);
		}
	}
}

if (!function_exists('convertMinutes')) {
    function convertMinutes($minutes) {
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        $seconds = ($minutes - floor($minutes)) * 60;
        return sprintf("%02d:%02d:%02d", $hours, $remainingMinutes, $seconds);
    }
}

if (!function_exists('calculatePercent')) {
    function calculatePercent($star_count,$total_star){
        if($total_star==0) return 0;
        return floor(($star_count/$total_star)*100);
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
 

    $total_review_count = 0;
    $total_one_star = 0;
    $total_two_star = 0;
    $total_three_star = 0;
    $total_four_star = 0;
    $total_five_star = 0; 

    foreach ($review_stars as $review_star) {
       switch ($review_star->star) {
            case 1:
                $total_one_star = $review_star->star_count;
                break;

            case 2:
                $total_two_star = $review_star->star_count;
                break;
            
            case 3:
                $total_three_star = $review_star->star_count;
                break;

            case 4:
                $total_four_star = $review_star->star_count;
                break;

            case 5:
                $total_five_star = $review_star->star_count;
                break;
        }

        $total_review_count += $review_star->star_count;
    }


    $one_star_percent = calculatePercent($total_one_star,$total_review_count);
    $two_star_percent = calculatePercent($total_two_star,$total_review_count);
    $three_star_percent = calculatePercent($total_three_star,$total_review_count);
    $four_star_percent = calculatePercent($total_four_star,$total_review_count);
    $five_star_percent = calculatePercent($total_five_star,$total_review_count);

    $api_token = Cookie::get('api_auth_token');

    $show_check_out_modal = $errors->first('screenshot')!="" || $errors->first('payment')!="";

    $like = false; $dislike = false;
    if($reaction){
        if($reaction->react==1) $like = true;
        if($reaction->react==2) $dislike = true;
    }

    $payment_methods = $course->instructor->payment_methods;

    $user = Auth::user();
    if($user) $my_course = $user->id==$course->instructor->user_id;
    else $my_course = false;

@endphp


@extends('student.components.master')
    @section('content')
    <style>
        .my_star{
            cursor: pointer;
        }

        .payment_method{
            padding:5px;
            border-radius: 7px;
        }

        .payment_method:hover{
            color :#475692;
            background:#efeeff;
            border-radius: 7px;
            padding:5px;
            cursor: pointer;
        }

        ._htg451 ul{
			list-style-type: disc;
			margin-inline-start: 20px;
		}

    </style>
    <!-- Video Model Start -->
	<div class="modal vd_mdl fade" id="videoModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<button onclick="closeVideo()" type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<div class="modal-body">
                     {{-- <iframe src="https://drive.google.com/file/d/1FUI2Z-gXQQVodPan_s3AW2cDEDN3OQk2/preview" width="640" height="480" allow="autoplay"></iframe> --}}
					{{-- <iframe  src="http://localhost/video-server/easy_korean_honest_review%20(720p).mp4" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> --}}
                    <video id="myVideo" style="width:100%" controls controlsList="nodownload">
                        <source id="videoSrc" src="" type="video/mp4">
                    </video>
				</div>
			</div>
		</div>
	</div>
	<!-- Video Model End -->

    {{-- Paynow modal Start --}}
    <div style="" class="modal vd_mdl fade" id="payModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
                @if (count($payment_methods)>0)
                    <div class="modal-body">
                        <div style="text-align: right">
                            <button class="btn_payment_cancel" style="width:35px;height:35px;float:right;margin-top:0" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div> 

                        <div class="membership_chk_bg rght1528">
                            <div class="coupon_code">
                                <h4>How to apply?</4>
                                <p>
                                    Select the payment methods. <br>
                                    Transfer the required amount ({{$course->fee}} MMK). <br>
                                    Send the payment screenshot with transaction ID. <br>
                                    <br><br>
                                </p>
                            </div>

                            <div class="checkout_title">
                                <h4>Payment Methods</h4>
                                <img src="{{asset('images/line.svg')}}" alt="">
                            </div>
                            <div class="order_dt_section">

                                @foreach ($payment_methods as $method)
                                    <div class="fcrse_1 payment_method" style="margin:3px;">
                                        <div class="" style="display: flex;padding:5px;">
                                            <img style="width:30px;height:30px;margin-right:20px;background:#475692;border-radius:3px;" src="{{asset($method->payment_method_type->icon_url)}}" alt="">
                                            <div >
                                                <strong>{{$method->payment_method_type->type}}</strong>
                                                <div>{{$method->method}}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                
                                <div class="order_title">
                                    <h2>Amount</h2>
                                    <div class="order_price5">{{$course->fee}} MMK</div>
                                </div>

                                <div class="coupon_code">
                                    <h4> </4>
                                    <p>
                                        
                                        <br>
                                    </p>
                                </div>
                                <div style="text-align: center;">
                                    <img id="img_screenshot" style="width: 180px;height:320px;display:none" src="" alt="">
                                    <br><br>
                                    
                                    <span id="screenshot_picker" style="border: 1px solid #475692;border-radius:7px;color:#475692;padding:10px;cursor:pointer">
                                        Upload Screenshot
                                    </span><br><br>
                                    Select a payment screenshot
                                    <p style="text-align:left;font-size:12px;color:red;margin-top:10px;"> {{$errors->first('screenshot')}} </p>	
                                </div>
                                <form id="checkoutform" action="{{route('course.checkout',['id'=>$course->id])}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="screenshot" id="input_screenshot" style="display:none" accept="image/*">
                                    <input id="payment_method" type="hidden" name="payment" value="" />
                                    <p style="text-align:left;font-size:12px;color:red;margin-top:10px;"> {{$errors->first('payment')}} </p>	
                                </form>
                                <a onclick="checkoutNow()" style="cursor: pointer" class="chck-btn22">Checkout Now</a>
                            </div>
                        </div>
                    </div>
                    <script>

                        const show_check_out_modal ='{{$show_check_out_modal}}';
                        const payment_methods = @json($payment_methods);

                        $(document).ready(()=>{

                            if(show_check_out_modal=="1"){
                                $('#btn_pay_now').click();
                            }

                            $('.payment_method').each((j,method)=>{
                                $(method).click(()=>{
                                    const payment_method_id = payment_methods[j].id;
                                    $('#payment_method').val(payment_method_id);

                                    $('.payment_method').each((i,m)=>{
                                        $(m).css({"border":""});
                                    })

                                    $(method).css({"border":"2px solid #475692"});
                                    
                                })
                            })

                            $('#screenshot_picker').click(()=>{
                                $('#input_screenshot').click();
                                $('#img_screenshot').attr('src', '');
                                $('#img_screenshot').hide();
                            });

                            $('#input_screenshot').change(()=>{

                                var files=$('#input_screenshot').prop('files');
                                var file=files[0];
                                var reader = new FileReader();

                                reader.onload = function (e) {
                                    imageSrc=e.target.result;
                                
                                    $('#img_screenshot').attr('src', imageSrc);
                                    $('#img_screenshot').show();
                                };

                                reader.readAsDataURL(file);
                                    
                            });
                        })

                        function checkoutNow(){
                            $('#checkoutform').submit();
                        }
                    </script>
                @else
                    <div class="modal-body">
                        <div style="text-align: right">
                            <button class="btn_payment_cancel" style="width:35px;height:35px;float:right;margin-top:0" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div style="padding:20px;text-align:center">
                            <br><br>
                            <i style="font-size: 40px;" class="uil uil-card-atm"></i> <br><br>

                            No payment method is defined by the instructor for this course. <br>
                            You cannot purchase the course. <br>
                            Thank you.
                            <br><br> 
                            <button class="subscribe-btn" style="width:100px;margin:auto;magin-top:20px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                Close
                            </button>
                        </div>

                    </div>
                @endif
                

				
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
                                    <a onclick="playPreview('{{$course->id}}')" href="#" class="fcrse_img" data-toggle="modal" data-target="#videoModal">
                                        <img src="{{asset('storage/'.$course->cover_url)}}" alt="">
                                        <div class="course-overlay">
                                            <div class="badge_seller">Bestseller</div>
                                            <span class="play_btn1"><i class="uil uil-play"></i></span>
                                            <span class="_215b02">Preview this course</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="_215b10">
                                    <a href="{{route('reports.create')."?id=$course->id&type=1"}}" class="_215b12">										
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
                                    ({{$course->rating_count}} ratings )
                                </div>

                                <div class="row">
                                    <div class="col-6 _215b08">
                                        <div class="_215b05" style="display: flex">		
                                            <span><i class='uil uil-play-circle'></i></span>
                                            <div>
                                                {{calculateHour($course->duration)}} hours on-demand video
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 _215b08">
                                        <div class="_215b05" style="display: flex">										
                                            <span><i class='uil uil-file-alt'></i></span>
                                            <div>{{$assignment_count}} Assignments</div>
                                        </div>
                                    </div>
                                    <div class="col-6 _215b08">
                                        <div class="_215b05" style="display: flex">										
                                            <span><i class='uil uil-document'></i></span>
                                            <div>{{$article_count}} articles</div>
                                        </div>
                                    </div>
                                    <div class="col-6 _215b08">
                                        <div class="_215b05" style="display: flex">										
                                            <span><i class='uil uil-cloud-download'></i></span>
                                            <div>{{$downloadable_count}} downloable resourses</div>
                                        </div>
                                    </div>
                                    <div class="col-6 _215b08">
                                        <div class="_215b05" style="display: flex">										
                                            <span><i class='uil uil-graduation-hat'></i></span>
                                            <div>{{$course->enroll_count}} students enrolled</div>
                                        </div>
                                    </div>
                                    <div class="col-6 _215b08">
                                        <div class="_215b05" style="display: flex">										
                                            <span><i class='uil uil-clock-seven'></i></span>
                                            <div>Full life-time access</div>
                                        </div>
                                    </div>
                                    @if ($course->certificate)
                                        <div class="col-6 _215b08">
                                            <div class="_215b05" style="display: flex">										
                                                <span><i class='uil uil-trophy'></i></span>
                                                <div>Certification of completion</div>
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
                                @if (!$my_course)
                                    <ul class="_215b31">										
                                        <li>
                                            <form action="{{route('cart')}}" method="POST">
                                                <input type="hidden" value="{{$course->id}}" name="course_id">
                                                @csrf
                                                <button type="submit" class="btn_adcart">Add to Cart</button>
                                            </form>
                                        </li>
                                        
                                        <li>
                                            <button id="btn_pay_now" class="btn_buy" data-toggle="modal" data-target="#payModal">
                                                Buy Now
                                            </button>
                                        </li>
                                        
                                    </ul>
                                @endif
                                <div class="_215b05">										
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
                                    <a href="{{route('instructor_detail',['id'=>$course->instructor->id])}}"><img src="{{asset('storage/'.$course->instructor->user->image_url)}}" alt=""></a>												
                                </div>
                                <div class="user_cntnt">
                                    <a href="{{route('instructor_detail',['id'=>$course->instructor->id])}}" class="_df7852">{{$course->instructor->user->name}}</a>
                                    <form action="{{route('instructor.subscribe',['id'=>$course->instructor->id])}}" method="POST">
                                        @csrf
                                        @if ($subscribed)
                                            <button type="submit" class="subscribe-btn" style="border-radius:15px;background:#efeeff;color:#475692"><i class='uil uil-bell'></i>Subscribed</button>
                                        @else
                                            <button type="submit" class="subscribe-btn">Subscribe</button>
                                        @endif
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="user_dt_right">
                            <ul>
                                <li>
                                    <a class="lkcm152">
                                        <span><i class="uil uil-eye"></i></span>
                                        <span>{{$course->preview_count}}</span>
                                    </a>
                                </li>
                                <li>
                                    @auth
                                        <a onclick="react({{$user->id}},1)" class="lkcm152"  style="cursor: pointer">
                                            <span id="like_icon" style="background:#475692;border-radius:50px;display: {{$like?'block':'none'}}">
                                                <i class="uil uil-thumbs-up" style="color:white"></i>
                                            </span>

                                            <span id="non_like_icon" style="border-radius:50px;display: {{$like?'none':'block'}}">
                                                <i class="uil uil-thumbs-up"></i>
                                            </span>
                                            <span id="tv_like_count">{{$course->like_count}}</span>
                                        </a>
                                    @else
                                        <a href="{{route('login')}}" class="lkcm152">
                                            
                                            <i class="uil uil-thumbs-up"></i>
                                            <span>{{$course->like_count}}</span>
                                        </a>
                                    @endauth
                                    
                                </li>
                                <li>
                                    
                                    @auth
                                        <a onclick="react({{$user->id}},2)"  class="lkcm152" style="cursor: pointer">
                                            <span id="dislike_icon" style="background:#ff0909;border-radius:50px;display: {{$dislike?'block':'none'}}">
                                                <i class="uil uil-thumbs-down" style="color:white"></i>
                                            </span>
                                            <span id="non_dislike_icon" style="border-radius:50px;display: {{$dislike?'none':'block'}}">
                                                <i class="uil uil-thumbs-down"></i>
                                            </span>

                                            <span id="tv_dislike_count">{{$course->dislike_count}}</span>
                                        </a>
                                    @else
                                        <a href="{{route('login')}}" class="lkcm152">
                                            <i class="uil uil-thumbs-down"></i>
                                            <span>{{$course->dislike_count}}</span>
                                        </a>
                                    @endauth
                                    
                                </li>
                                <li>
                                    <a onclick="copyCourseUrl('{{route('course_detail', ['id' => $course->id])}}','{{$course->id}}')" style="cursor: pointer" class="lkcm152">
                                        <span style="border-radius: 50px;"><i class="uil uil-share-alt"></i></span>
                                        <span>{{$course->share_count}}</span>
                                    </a>
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
                                    {!!$course->description!!}					
                                </div>							
                            </div>
                            <div class="tab-pane fade" id="nav-courses" role="tabpanel">
                                <div class="crse_content">
                                    <h3>Course content</h3>
                                    <div class="_112456">
                                        <ul class="accordion-expand-holder">
                                            <li><span class="accordion-expand-all _d1452">Expand all</span></li>
                                            <li><span class="_fgr123"> {{$course->total_lecture}} Lectures</span></li>
                                            <li><span class="_fgr123">{{convertMinutes($course->duration)}}</span></li>
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
                                                    <span class="num-items-in-section">{{$module->lessons->count()}} lectures</span>
                                                    <span class="section-header-length">{{convertMinutes($module->lessons()->sum('duration'))}}</span>
                                                </div>
                                            </a>
                                            <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
                                                
                                                @foreach ($module->lessons as $lesson)
                                                    @php 
                                                        // only for development process
                                                        $lesson->course_id = $course->id;
                                                        $lesson->save();
                                                    @endphp
                                                    @if ($lesson->lesson_type_id==1 && $lesson->free_preview == 1)
                                                    <div class="lecture-container" style="cursor: pointer" onclick="playLesson('{{$lesson->download_url}}')" data-toggle="modal" data-target="#videoModal">
                                                    @else
                                                    <div class="lecture-container">
                                                    @endif
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
                                                                @if ($lesson->free_preview == 1)
                                                                    <span class="content-summary">Free Preview</span>
                                                                @endif
                                                                <span class="content-summary">{{convertMinutes($lesson->duration)}}</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                @endforeach
                                            </div>
                                        </div>
                                     @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-reviews" role="tabpanel">
                                <div class="student_reviews">
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <div class="reviews_left">
                                                <h3>Student Feedback</h3>
                                                <div class="total_rating">
                                                    <div class="_rate001">{{$course->rating}}</div>		
                                                          			
                                                    <div class="rating-box">
                                                        @php
                                                            $star = $course->rating;
                                                         
                                                        @endphp		
                                                        @for ($i = 0; $i < 5; $i++)
                                                            @if (($i+1)<=$star)
                                                                <span class="rating-star full-star"></span>
                                                            @else
                                                                @if (($i+0.5)==$star)
                                                                    <span class="rating-star half-star"></span>
                                                                @else
                                                                    <span class="rating-star empty-star"></span>
                                                                @endif
                                                                
                                                            @endif
                                                        @endfor		  
                                                    </div>

                                                    <div class="_rate002">Course Rating</div>	
                                                </div>
                                                <div class="_rate003">
                                                    <div class="_rate004">
                                                        <div class="progress progress1">
                                                            <div style="width:{{$five_star_percent}}%" class="progress-bar" role="progressbar" aria-valuenow="{{$five_star_percent}}" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        <div class="rating-box">
                                                            <span class="rating-star full-star"></span>
                                                            <span class="rating-star full-star"></span>
                                                            <span class="rating-star full-star"></span>
                                                            <span class="rating-star full-star"></span>
                                                            <span class="rating-star full-star"></span>
                                                        </div>
                                                        <div class="_rate002">{{$five_star_percent}}%</div>
                                                    </div>
                                                    <div class="_rate004">
                                                        <div class="progress progress1">
                                                            <div style="width:{{$four_star_percent}}%" class="progress-bar" role="progressbar" aria-valuenow="{{$four_star_percent}}" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        <div class="rating-box">
                                                            <span class="rating-star full-star"></span>
                                                            <span class="rating-star full-star"></span>
                                                            <span class="rating-star full-star"></span>
                                                            <span class="rating-star full-star"></span>
                                                            <span class="rating-star empty-star"></span>
                                                        </div>
                                                        <div class="_rate002">{{$four_star_percent}}%</div>
                                                    </div>
                                                    <div class="_rate004">
                                                        <div class="progress progress1">
                                                            <div style="width:{{$three_star_percent}}%" class="progress-bar" role="progressbar" aria-valuenow="{{$three_star_percent}}" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        <div class="rating-box">
                                                            <span class="rating-star full-star"></span>
                                                            <span class="rating-star full-star"></span>
                                                            <span class="rating-star full-star"></span>
                                                            <span class="rating-star empty-star"></span>
                                                            <span class="rating-star empty-star"></span>
                                                        </div>
                                                        <div class="_rate002">{{$three_star_percent}}%</div>
                                                    </div>
                                                    <div class="_rate004">
                                                        <div class="progress progress1">
                                                            <div style="width:{{$two_star_percent}}%" class="progress-bar" role="progressbar" aria-valuenow="{{$two_star_percent}}" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        <div class="rating-box">
                                                            <span class="rating-star full-star"></span>
                                                            <span class="rating-star full-star"></span>
                                                            <span class="rating-star empty-star"></span>
                                                            <span class="rating-star empty-star"></span>
                                                            <span class="rating-star empty-star"></span>
                                                        </div>
                                                        <div class="_rate002">{{$two_star_percent}}%</div>
                                                    </div>
                                                    <div class="_rate004">
                                                        <div class="progress progress1">
                                                            <div style="width:{{$one_star_percent}}%" class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        <div class="rating-box">
                                                            <span class="rating-star full-star"></span>
                                                            <span class="rating-star empty-star"></span>
                                                            <span class="rating-star empty-star"></span>
                                                            <span class="rating-star empty-star"></span>
                                                            <span class="rating-star empty-star"></span>
                                                        </div>
                                                        <div class="_rate002">{{$one_star_percent}}%</div>
                                                    </div>
                                                </div>
                                            </div>	
                                          
                                            @if ($myReview)
                                                <div class="reviews_left">
                                                    <h3>My Review</h3>
                                                            
                                                    <div class="rating-box">
                                                        @for ($i = 0; $i < 5; $i++)
                                                            @if (($i+1)<=$myReview->star)
                                                                <span class="rating-star full-star"></span>
                                                            @else
                                                                <span class="rating-star empty-star"></span>
                                                            @endif
                                                        @endfor		  
                                                    </div>
                                                        <p class="rvds10">{{$myReview->body}}</p>
                                                        <ul class="_215b31">										
                                                        <li style="float:right">
                                                            <form action="{{ route('reviews.destroy', $myReview->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden" value="{{$course->id}}" name="course_id">
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                            </form>
                                                        
                                                        </li>
                                                        <li>
                                                            <button id="btn_review_update" class="btn btn-secondary" style="background: #475692">
                                                                Update
                                                            </button>
                                                        </li>
                                                    </ul>
                                                    
                                                </div>	
                                            @endif
                                            <div id="add_review_container" class="reviews_left" style="display:{{$myReview?'none':'block'}}">
                                                @if (session('review_added'))
                                                    <div class="bg bg-success mb-10" style="color:white;border-radius:3px;padding:5px;">
                                                    {{session('review_added')}}
                                                    </div>
                                                @endif
                                                
                                                <h3>Add Review</h3>
                                                        
                                                <div id="rating-box" class="rating-box">
                                                    <span class="rating-star empty-star my_star" data-value="1"></span>
                                                    <span class="rating-star empty-star my_star" data-value="2"></span>
                                                    <span class="rating-star empty-star my_star" data-value="3"></span>
                                                    <span class="rating-star empty-star my_star" data-value="4"></span>
                                                    <span class="rating-star empty-star my_star" data-value="5"></span>
                                                </div>
                                                <form action="{{$myReview?route('reviews.update'):route('reviews.create')}}" method="POST">
                                                    @csrf
                                                    
                                                    <input type="hidden" value="0" name="hidden">
                                                    <input id="input_star_count" type="hidden" name="star">
                                                    <p style="text-align:left;font-size:12px;color:red;margin-top:10px;"> {{$errors->first('star')}} </p>	
                                                    <div class="ui search focus lbel25 mt-10">	
                                                        <label>Review*</label>
                                                        <div class="ui form swdh30">
                                                            <div class="field">
                                                                <textarea rows="2" name="review" id="" placeholder="Your review here..."></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @auth
                                                        <input type="hidden" value="{{ Auth::user()->id}}" name="user_id">
                                                    @endauth
                                                    @if ($myReview)
                                                         <input type="hidden" value="{{$myReview->id}}" name="id">
                                                    @endif
                                                    
                                                    <input type="hidden" value="{{$course->id}}" name="course_id">
                                                    <button type="submit" class="login-btn">Add review</button>
                                                </form>
                                            </div>	
                                            										
                                        </div>
                                        <div class="col-lg-7">
                                            <div class="review_right">
                                                <div class="review_right_heading">
                                                    <h3>Reviews</h3>
                                                    {{-- <div class="review_search">
                                                        <input class="rv_srch" type="text" placeholder="Search reviews...">
                                                        <button class="rvsrch_btn"><i class='uil uil-search'></i></button>
                                                    </div> --}}
                                                </div>
                                            </div>
                                            <div class="review_all120">
                                               
                                                <div id="review_container">

                                                </div>

                                                <div class="row" id="shimmer">				
                                                    <div class="col-md-12">
                                                        <br><br><br>
                                                        <div class="main-loader mt-50">													
                                                            <div class="spinner">
                                                                <div class="bounce1"></div>
                                                                <div class="bounce2"></div>
                                                                <div class="bounce3"></div>
                                                            </div>																										
                                                        </div>
                                                        <br><br><br>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <br><br><br>
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
    </div>

    <script>
        
        const user = @json($user);
        let like = "{{$like}}";
        let dislike = "{{$dislike}}";
        const course_id = "{{$course->id}}"
        let like_count = parseInt("{{$course->like_count}}");
        let dislike_count = parseInt("{{$course->dislike_count}}");
        
        var nightMode = localStorage.getItem('gmtNightMode');
        
        
        let is_review_fetching = false;
        let is_review_tab = false;
        let reviewArr = [];

        let fetch_review_url = `{{asset('')}}api/courses/${course_id}/reviews`

        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.my_star');
            const starInput = document.getElementById('input_star_count');
            
            starInput.value=0;
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = this.getAttribute('data-value');
                    starInput.value = rating;
                    
                    // Reset all stars
                    stars.forEach(s => s.classList.remove('full-star'));
                    stars.forEach(s => s.classList.add('empty-star'));
                    
                    // Highlight the selected number of stars
                    for (let i = 0; i < rating; i++) {
                        stars[i].classList.remove('empty-star');
                        stars[i].classList.add('full-star');
                    }
                });
            });

            $('#btn_review_update').click(()=>{
                $('#add_review_container').show();
                
            });

            $('.nav-item').on('click', function() {
                 
                var elementId = $(this).attr('id');
                 
                if(elementId=="nav-reviews-tab"){
                    is_review_tab = true;
                    if(!is_review_fetching && is_review_tab){
                        fetchReviews();
                    }
                }else{
                    is_review_tab = false;
                }
            });

            $(window).scroll(()=>{
                if($(window).scrollTop() + $(window).height() > $(document).height() - 500) {
                    if(!is_review_fetching && is_review_tab){
                        fetchReviews();
                    }
                }
            });

        });

        function fetchLesson(){
            $.ajax({
				url: '{{asset("")}}api/courses/'+course_id+'/lessons', // Replace with your API endpoint
				type: 'GET', // or 'GET' depending on your request
				headers: {
					'Authorization': 'Bearer '+apiToken // Example for Authorization header
				},
				success: function(response) {
                    lessonReady = true;
                    lessons = response.lessons;
                    modules = response.modules;
				},
				error: function(xhr, status, error) {
					console.error('Error:', status, error);
				}
			});
        }

        function playLesson(link){
            $('#videoSrc').attr('src',link);
            $('#myVideo').get(0).load();
            $('#myVideo').get(0).play();
        }

        function fetchReviews(id){
            is_review_fetching = true;
            $('#shimmer').show();
            if(fetch_review_url==null){
                $('#shimmer').hide();
                return;
            }

            $.ajax({
				url: fetch_review_url, // Replace with your API endpoint
				type: 'GET', // or 'GET' depending on your request
				headers: {
					'Authorization': 'Bearer '+apiToken // Example for Authorization header
				},
                data:{
                   'user_id':user? user.id : 0,
                },
				success: function(res) {
                     console.log(res);
                    is_review_fetching=false;
                    if(res){
                        fetch_review_url = res.next_page_url;
                        let reviews = res.data;
                        setReviews(reviews);
                       
                    }
				},
				error: function(xhr, status, error) {
					console.error('Error:', status, error);
				}
			});
        }

        function setReviews(reviews){
                $('#shimmer').hide();
				reviews.map((review,index)=>{
					reviewArr.push(review);	
					$('#review_container').append(reviewComponent(review));
				})
        }

        function reviewComponent(review){

            let star ="";
            for(var i =0;i<5;i++){
                if((i+1)<=review.star){
                    star +=`<span class="rating-star full-star"></span>`;
                }else{
                    star += `<span class="rating-star empty-star"></span>`;
                }
            }

            let review_body = "";
            if(review.body){
                review_body = `<p class="rvds10">${review.body}</p>`;
            }

            let yes = "";
            if(review.liked==1)yes ="checked";
            let no = "";
            if(review.disliked) no = "checked";
            return `
                <div class="review_item">
                    <div class="review_usr_dt">
                        <a href = "{{asset('')}}users/${review.user.id}" >
                            <img src="{{asset('')}}storage/${review.user.image_url}" alt="">
                        </a>
                        <div class="rv1458">
                            <h4 class="tutor_name1">${review.user.name}</h4>
                            <span class="time_145">${formatDateTime(new Date(review.created_at))}</span>
                        </div>
                    </div>
                    <div class="rating-box mt-20">
                        ${star}
                    </div>
                    ${review_body}
                    <div class="rpt100">
                        <span>Was this review helpful?</span>
                        <form>
                            <div class="radio--group-inline-container">
                                <div class="radio-item">
                                    <input onclick="reactReview(${review.id},1)" id="radio-yes-${review.id}" name="radio" type="radio" ${yes}>
                                    <label for="radio-yes-${review.id}" class="radio-label">Yes</label>
                                </div>
                                <div class="radio-item">
                                    <input onclick="reactReview(${review.id},2)" id="radio-no-${review.id}" name="radio" type="radio" ${no}>
                                    <label  for="radio-no-${review.id}" class="radio-label">No</label>
                                </div>
                            </div>
                        </form>
                        <a href="{{route('reports.create')}}?id=${review.id}&type=2" class="report145">Report</a>
                    </div>
                </div> 
            `;
        }

        function reactReview(id, react_type){
            if(!user){
                window.location.href ="{{asset("")}}login";
                return;
            }
            $.ajax({
				url: '{{asset("")}}api/reviews/react/'+id, // Replace with your API endpoint
				type: 'POST', // or 'GET' depending on your request
				headers: {
					'Authorization': 'Bearer '+apiToken // Example for Authorization header
				},
				success: function(response) {
					console.log('Success:', response);
				},
				error: function(xhr, status, error) {
					console.error('Error:', status, error);
				},
                data:{
                    'user_id':user.id,
                    'react':react_type,
                }
			});
        }
        
        function formatDateTime(cmtTime){
			var currentTime = Date.now();
			var min=60;
			var h=min*60;
			var day=h*24;

			var diff =currentTime-cmtTime
			diff=diff/1000;
			
			if(diff<day*3){
				if(diff<min){
					return "a few second ago";
				}else if(diff>=min&&diff<h){
					return Math.floor(diff/min)+'min ago';
				}else if(diff>=h&&diff<day){
					return Math.floor(diff/h)+'h ago';
				}else{
					return Math.floor(diff/day)+'d ago';
				}
			}else{
				var date = new Date(Number(cmtTime));
				return date.toLocaleDateString("en-GB");
			}
		}

        function playPreview(id){
            $.ajax({
				url: '{{asset("")}}api/courses/pre-view/'+id, // Replace with your API endpoint
				type: 'POST', // or 'GET' depending on your request
				headers: {
					'Authorization': 'Bearer '+apiToken // Example for Authorization header
				},
				success: function(response) {
					console.log('Success:', response);
				},
				error: function(xhr, status, error) {
					console.error('Error:', status, error);
				}
			});

            $('#videoSrc').attr('src','http://localhost/video-server/easy_korean_honest_review%20(720p).mp4');
            $('#myVideo').get(0).load();
            $('#myVideo').get(0).play();


        }

        function react(user_id, react_type){
            if(react_type==1){
                // like the course
                if(like==1){
                    //remove like
                    $('#like_icon').hide();
                    $('#non_like_icon').show();
                    like=0;
                    like_count--;

                }else{
                    // remove dislike and other react
                    if(dislike==1){
                        dislike=0;
                        $('#dislike_icon').hide();
                        $('#non_dislike_icon').show();
                        dislike_count--;
                    }

                    //like the course
                    $('#like_icon').show();
                    $('#non_like_icon').hide();
                    like=1;
                    like_count++;
                }

            }else{
                // dislike the course
                if(dislike==1){
                    // remove dislike react
                    $('#dislike_icon').hide();
                    $('#non_dislike_icon').show();
                    dislike=0;
                    dislike_count--;
                }else{
                    // remove like and other react
                    if(like==1){
                        $('#like_icon').hide();
                        $('#non_like_icon').show();
                        like=0;
                        like_count--;
                    }
                    

                    //dislike the course
                    $('#dislike_icon').show();
                    $('#non_dislike_icon').hide();
                    dislike = 1;
                    dislike_count++;
                }
            }

            $('#tv_like_count').html(like_count);
            $('#tv_dislike_count').html(dislike_count);

            $.ajax({
				url: '{{asset("")}}api/courses/react/'+course_id, // Replace with your API endpoint
				type: 'POST', // or 'GET' depending on your request
				headers: {
					'Authorization': 'Bearer '+apiToken // Example for Authorization header
				},
				success: function(response) {
					console.log('Success:', response);
				},
				error: function(xhr, status, error) {
					console.error('Error:', status, error);
				},
                data:{
                    'user_id':user.id,
                    'react':react_type,
                }
			});
        }

        function closeVideo(){
            $('#myVideo').get(0).pause();
        }

        function copyCourseUrl(url,id){
			
			// Create a temporary input element to hold the URL
			const tempInput = document.createElement('input');
			tempInput.value =url;
			document.body.appendChild(tempInput);

			// Select the input element's value
			tempInput.select();
			tempInput.setSelectionRange(0, 99999); // For mobile devices

			// Copy the text inside the input element
			document.execCommand('copy');

			// Remove the temporary input element
			document.body.removeChild(tempInput);

			// Optionally, alert the user that the URL has been copied

			alert('URL copied to clipboard: ' +url);

			$.ajax({
				url: '{{asset("")}}api/courses/share/'+id, // Replace with your API endpoint
				type: 'POST', // or 'GET' depending on your request
				headers: {
					'Authorization': 'Bearer '+apiToken // Example for Authorization header
				},
				success: function(response) {
					console.log('Success:', response);
				},
				error: function(xhr, status, error) {
					console.error('Error:', status, error);
				}
			});
		}
   
    </script>

    @endsection