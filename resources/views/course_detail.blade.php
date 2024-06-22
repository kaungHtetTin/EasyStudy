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

    $reviews = $course->reviews;

    $total_star_count = $reviews->count();
    $total_one_star = 0;
    $total_two_star = 0;
    $total_three_star = 0;
    $total_four_star = 0;
    $total_five_star = 0;

    foreach ($reviews as $key => $review) {
        switch ($review->star) {
            case 1:
                $total_one_star++;
                break;

            case 2:
                $total_two_star++;
                break;
            
            case 3:
                $total_three_star++;
                break;

            case 4:
                $total_four_star++;
                break;

            case 5:
                $total_five_star++;
                break;
        }
    }

    $one_star_percent = calculatePercent($total_one_star,$total_star_count);
    $two_star_percent = calculatePercent($total_two_star,$total_star_count);
    $three_star_percent = calculatePercent($total_three_star,$total_star_count);
    $four_star_percent = calculatePercent($total_four_star,$total_star_count);
    $five_star_percent = calculatePercent($total_five_star,$total_star_count);

    $api_token = Cookie::get('api_auth_token');

    $show_check_out_modal = $errors->first('screenshot')!="" || $errors->first('payment')!="";

    $payment_methods =Array(
        [
            'id'=>1,
            'icon'=>'images/payment-wave-pay.jpg',
            'type'=>'Wave Pay',
            'method'=>'09682537158',
        ],
        [
            'id'=>2,
            'icon'=>'images/payment-kbz-pay.jpg',
            'type'=>'KBZ Pay',
            'method'=>'09682537158',
        ],
        [
            'id'=>3,
            'icon'=>'images/payment-aya-pay.png',
            'type'=>'AYA Pay',
            'method'=>'09682537158',
        ],
        [
            'id'=>4,
            'icon'=>'images/payment-cb-pay.png',
            'type'=>'CB Pay',
            'method'=>'09682537158',
        ],
    );


    $like = false; $dislike = false;
    if($reaction){
        if($reaction->react==1) $like = true;
        if($reaction->react==2) $dislike = true;
    }

    $user = Auth::user();

@endphp


@extends('layouts.master')
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
            border: 1px solid #475692;
            color :#475692;
            background:#efeeff;
            border-radius: 7px;
            padding:5px;
            cursor: pointer;
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
				<div class="modal-body">
                    <div style="text-align: right">
                        <button class="btn_payment_cancel" style="width:35px;height:35px;float:right;margin-top:0" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div id="loading" style="display: none">
                        <div class="col-md-12">
                            <br><br><br><br><br>
                            <div class="main-loader mt-50" style="margin-bottom:150px;">													
                                <div class="spinner">
                                    <div class="bounce1"></div>
                                    <div class="bounce2"></div>
                                    <div class="bounce3"></div>
                                </div>																										
                            </div>
                        </div>
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

                            @foreach ($payment_methods as $payment)
                                <div class="order_title payment_method" style="display: flex;">
                                    <img style="width:30px;height:30px;margin-right:20px;background:#475692;border-radius:3px;" src="{{asset($payment['icon'])}}" alt="">
                                    <h6>{{$payment['type']}}</h6>
                                    <div class="order_price">{{$payment['method']}}</div>
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
                            $(m).css({"background":""});
                        })

                        $(method).css({"background":"#A5FE82"});
                        
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
	</div>

    {{-- Paynow modal End --}}

@auth
<div class="wrapper _bg4586">
@else
<div style="padding-top:60px;">
@endauth

    @if ($access)
        @if ($access->verified==0)
            <div style="background: yellow;display:flex;text-align:center;padding:5px;">
                <div style="width:12px;height:12px;background:red;border-radius:50px;margin-left:15px;"></div>
                <div style="margin-left:15px;font-family: 'Roboto', sans-serif;font-size:12px;">Your payment is checking by ... </div>
            </div>
         @endif
    @endif

    <div class="_215b01">
        <div class="container-fluid">			
            <div class="row">
                <div class="col-lg-12">
                    <div class="section3125">			
                        <div class="row justify-content-center">						
                            <div class="col-xl-4 col-lg-5 col-md-6">						
                                <div class="preview_video">						
                                    <a onclick="playPreview('{{$course->id}}')" href="#" class="fcrse_img" data-toggle="modal" data-target="#videoModal">
                                        <img src="{{asset('images/courses/img-2.jpg')}}" alt="">
                                        <div class="course-overlay">
                                            <div class="badge_seller">Bestseller</div>
                                            <span class="play_btn1"><i class="uil uil-play"></i></span>
                                            <span class="_215b02">Preview this course</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="_215b10">
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
                                @if (!$access)
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
                                    <a href="{{route('instructor_detail',['id'=>$course->instructor->id])}}"><img src="{{asset('images/left-imgs/img-1.jpg')}}" alt=""></a>												
                                </div>
                                <div class="user_cntnt">
                                    <a href="{{route('instructor_detail',['id'=>$course->instructor->id])}}" class="_df7852">{{$course->instructor->user->name}}</a>
                                    <form action="{{route('instructor.subscribe',['id'=>$course->instructor->id])}}" method="POST">
                                        @csrf
                                        @auth
                                            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                        @endauth
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
                                                                <span class="content-summary">{{convertMinutes($lesson->duration)}}</span>
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
                                                @foreach ($reviews as $review)
                                                    <div class="review_item">
                                                        <div class="review_usr_dt">
                                                            <img src="images/left-imgs/img-1.jpg" alt="">
                                                            <div class="rv1458">
                                                                <h4 class="tutor_name1">{{$review->user->name}}</h4>
                                                                <span class="time_145">{{$review->created_at->diffForHumans()}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="rating-box mt-20">
                                                            @for ($i = 0; $i < 5; $i++)
                                                            @if (($i+1)<=$review->star)
                                                                <span class="rating-star full-star"></span>
                                                            @else
                                                                <span class="rating-star empty-star"></span>
                                                            @endif
                                                        @endfor		
                                                        </div>
                                                        <p class="rvds10">{{$review->body}}</p>
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
                                                @endforeach
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

    <script>
        const apiToken = "{{$api_token}}";
        let like = "{{$like}}";
        let dislike = "{{$dislike}}";
        let course = @json($course);
        let like_count = parseInt(course.like_count);
        let dislike_count = parseInt(course.dislike_count);
        console.log(course);

        function playPreview(id){
            $.ajax({
				url: 'http://localhost:8000/api/courses/pre-view/'+id, // Replace with your API endpoint
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
				url: 'http://localhost:8000/api/courses/react/'+course.id, // Replace with your API endpoint
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
                    'user_id':user_id,
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
				url: 'http://localhost:8000/api/courses/share/'+id, // Replace with your API endpoint
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

        });
    </script>

    @endsection
		
		