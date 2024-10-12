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
     
        if($hours>0){
            return sprintf("%02d:%02d", $remainingMinutes, $seconds);
        }else{
            return sprintf("%02d:%02d:%02d", $hours, $remainingMinutes, $seconds);
        }
        
    }
}

if (!function_exists('calculateModuleDuration')) {
    function calculateModuleDuration($minutes) {
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        $seconds = ($minutes - floor($minutes)) * 60;
        return "$hours hr $remainingMinutes min";
    }
}

if (!function_exists('calculatePercent')) {
    function calculatePercent($star_count,$total_star){
        if($total_star==0) return 0;
        return floor(($star_count/$total_star)*100);
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

    $like = false; $dislike = false;
    if($reaction){
        if($reaction->react==1) $like = true;
        if($reaction->react==2) $dislike = true;
    }

    $api_token = Cookie::get('api_auth_token');
    $user = Auth::user();
    $instructor = $course->instructor->user;
@endphp

<!DOCTYPE html>
<html lang="en">
    <head>
    @include('student.components.head')
     <style>
            .fixedLessonContainer
            {
                
                height: 100%;
                position: relative;
            }
            .scrollLessonContent
            {
                height: 100%;
                width:100%;
                overflow:auto;
              
            }
            .fixContainer{
                position: fixed;
                bottom: 0;
                right: 0;
            }

            input{
                
                border-width:0 0 1px 0;
                border-style:sold;
                background: #00000000;
                flex:1;
                margin-right:100px;
                margin-left:20px;
            }
            
            .shimmer {
                color: grey;
                display:inline-block;
                -webkit-mask:linear-gradient(-60deg,#000 30%,#0005,#000 70%) right/300% 100%;
                background-repeat: no-repeat;
                animation: shimmer 2.5s infinite;
                font-size: 50px;
                
            }
            .cmt-reply{
                display:flex;
                position:relative; 
                margin-left:40px;
            }

            @keyframes shimmer {
                100% {-webkit-mask-position:left}
            }

            .user_dt_right ul li {
                width: 23.3%;
            }

            .num-items-in-section{
                font-size:14px;
            }

            .download-lecture{
                padding:3px;
                color:#505763;
            }

            .download-lecture:hover{
                background:#eee;
                border-radius: 10px;
                color:#333
            }

            .my_star{
                cursor: pointer;
            }

            .rating-star1 {
                font-size: 1rem;
                width: 1rem;
                height: 1rem;
                position: relative;
                display: inline-block;
            }

            .ask_question{
                cursor: pointer;
                flex:1;
            }
 
            .rv_srch1 {
                height: 30px;
                font-size: 12px;
                font-weight: 400;
                font-family: 'Roboto', sans-serif;
                color: #333;
                padding-left: 15px;
                padding-right: 40px;
                border: 1px solid #efefef;
                border-radius: 3px;
            }

            .rvsrch_btn1 {
               
                border-radius: 3px;
                border: 0;
                height: 26px;
                width: 26px;
                background: #475692;
                color: #fff;
                font-size: 14px;
            }

            .question_related{
                padding:10px;
                border: 1px solid #dedfe0;
                border-radius:3px;
                margin-top:7px;
                margin-left:30px;
                cursor: pointer;
            }

            .question_related:hover{
                background: #475692;
                color:white;
            }

            #toolbar {
                margin-bottom: 10px;
                display: flex;
                gap: 10px;
            }


            #toolbar button:hover {
                color: #475692;
            }

            #toolbar button.active {
                color: #475692;
            }


            pre code {
                background-color: #ecffeb;
                color: #3a3a3a;
                font-family: 'Courier New', Courier, monospace;
                padding: 3px;
                border-radius: 2px;
                display: block;
                font-size: 12px;
                white-space: pre-wrap;
            }

            .field div ul{
                list-style-type: disc;
                margin-inline-start: 20px;
            }

            .description ul{
                list-style-type: disc;
                margin-inline-start: 20px;
            }

            .content_body{
                overflow: auto;
            }

            .content_body ul{
                list-style-type: disc;
                margin-inline-start: 20px;
                width: 100%;
             
            }

            .content_body div{
                width: max-content;
            }

            .night-mode #question_title{
                color:white;
            }

            .night-mode #question_title:focus{
                color:#333;
            }

            .radio-item input[type="radio"]:checked + .radio-label:before {
                background-color: #475692;
                box-shadow: inset 0 0 0 2px #f4f4f4;
            }
            .custom-radio input:checked~.checkmark {
                background-color: #48f321;
                border-color: #2196F3;
            }

            
             
        </style>
    </head>

<body onresize="">
    <!-- Reply Dialog Section Start -->
	<div class="modal fade" id="reply_dialog" tabindex="-1" aria-labelledby="lectureModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="lectureModalLabel">Reply</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="new-section-block">
						<div id="reply_editor_container"></div>
						<span id="editor_input_error" style="color: red; padding:5px;display:none">*Please enter what on your mind.</span>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="main-btn cancel" data-dismiss="modal">Close</button>
					<button id="btn_reply_dialog_add" type="button" class="main-btn" data-dismiss="modal">Post</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Reply Dialog Section End -->

    <!-- Delete Dialog Section Start -->
	<div class="modal fade" id="delete_dialog" tabindex="-1" aria-labelledby="lectureModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="lectureModalLabel">Delete</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="alert alert-warning">
						Do you reall want to delete
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="main-btn cancel" data-dismiss="modal">Close</button>
					<button id="btn_delete_dialog_add" onclick="deleteQA()" type="button" class="main-btn" data-dismiss="modal">Delete</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Delete Dialog Section End -->

    <div class="fixedLessonContainer">
        <div class="row" style="padding-right:0px;">
            <div class="col-lg-8 col-md-6" style="padding-right:0px;" id="player-section">
                <div style="padding:10px;background:#333;color:white">
                    <a href="" target="_blank" rel="noopener noreferrer" style="color:white;">
                        <i class='uil uil-arrow-left'></i>
                        <span>{{$course->title}}</span>
                    </a> 
                    
                </div>
                <div id="video_player">
                    <video id="myVideo" style="width:100%" controls controlsList="nodownload">
                        <source id="videoSrc" src="" type="video/mp4">
                    </video>
                </div>
                <div style="float:right;padding:3px;">
                    <span class="download-lecture" onclick="downloadVideo()" style="cursor: pointer"><b><i class='uil uil-download-alt'></i> Download lecture</b></span>
                </div>

                <div class="course_tabs">
                    <nav>
                        <div class="nav nav-tabs tab_crse justify-content-center" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link" id="nav-content-tab" data-toggle="tab" href="#nav-content" role="tab" aria-selected="true">Course Content</a>
                            <a class="nav-item nav-link active" id="nav-overview-tab" data-toggle="tab" href="#nav-overview" role="tab" aria-selected="true">Overview</a>
                            <a class="nav-item nav-link" id="nav-q-and-a-tab" data-toggle="tab" href="#nav-q-and-a" role="tab" aria-selected="false">Q&A</a>
                            <a class="nav-item nav-link" id="nav-reviews-tab" data-toggle="tab" href="#nav-reviews" role="tab" aria-selected="false">Reviews</a>
                            <a class="nav-item nav-link" id="nav-anouncements-tab" data-toggle="tab" href="#nav-anouncements" role="tab" aria-selected="false">Anouncements</a>
                        </div>
                    </nav>						
                </div>

                <div class="_215b17">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="course_tab_content">
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade" id="nav-content" role="tabpanel">
                                            <div class="crse_content" style="margin-top:15px;">
                                                <div class="_112456">
                                                    <ul class="accordion-expand-holder">
                                                        <li><span class="accordion-expand-all _d1452">Expand all</span></li>
                                                        <li><span class="_fgr123"> {{$course->total_lecture}} Lectures</span></li>
                                                        <li><span class="_fgr123">{{calculateModuleDuration($course->duration)}}</span></li>
                                                    </ul>
                                                </div>

                                                @foreach ($course->modules as $module)
                                                    @php
                                                        $module_index = $loop->index;
                                                    @endphp
                                                    <div id="accordion" class="ui-accordion ui-widget ui-helper-reset">
                                                        <a href="javascript:void(0)" class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" style="margin-top:0px;padding-right:10px;">												
                                                            <div class="section-header-left" style="flex-basis: 100%">
                                                                <span class="section-title-wrapper">
                                                                    <span class="section-title-text">{{$module->title}}</span>
                                                                </span>
                                                                <div style="margin-left:8px;color:#505763;margin-top:3px;font-size:12px;"> {{$module->lessons->count()}} lectures . {{calculateModuleDuration($module->lessons->sum('duration'))}} </div>
                                                            </div>
                                                            <div class="section-header-right" style="flex-basis: 5%">
                                                                <i class='uil uil-angle-down crse_icon'></i>
                                                            </div>
                                                        </a>
                                                        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
                                                            
                                                            @foreach ($module->mLessons($user->id) as $lesson)
                                                                @php
                                                                    $lesson_index = $loop->index;
                                                                @endphp
                                                                <div class="lecture-container lecture-list-1" onclick="playLesson({{$module_index}},{{$lesson_index}})" style="padding-right:15px;cursor: pointer;">
                                                                    <div class="left-content">
                                                                        @if ($lesson->lesson_type_id==1)
                                                                            <i class='uil uil-play-circle icon_142'></i> 
                                                                        @else
                                                                                <i class='uil uil-file icon_142'></i>
                                                                        @endif
                                                                        
                                                                        <div class="top">
                                                                            <div class="title">{{$lesson->title}} 
                                                                               @if ($lesson->learned==1)
                                                                                    <i class='uil uil-check-circle'></i> 
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="details">
                                                                            @if ($lesson->lesson_type_id==1)
                                                                                <span class="content-summary" style="font-size:12px;">{{convertMinutes($lesson->duration)}}</span>
                                                                            @else
                                                                                <i class='uil uil-download-alt'></i>
                                                                            @endif
                                                                        
                                                                    </div>
                                                                </div>

                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show active" id="nav-overview" role="tabpanel">
                                            <div>
                                                @if ($access)
                                                    @if ($access->verified==0)
                                                        <div style="background: yellow;display:flex;text-align:center;padding:5px;">
                                                            <div style="width:12px;height:12px;background:red;border-radius:50px;margin-left:15px;"></div>
                                                            <div style="margin-left:15px;font-family: 'Roboto', sans-serif;font-size:12px;">Your payment is being identified.</div>
                                                        </div>
                                                    @endif
                                                @endif
                                                 
                                                <h2>{{$course->title}}</h2>
                                           
                                                <div style="display: flex">
                                                    <div class="user_img5">
                                                        <a href="{{route('instructor_detail',['id'=>$course->instructor->id])}}"><img src="{{asset('storage/'.$course->instructor->user->image_url)}}" alt=""></a>												
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
                                                <br>
                                             
                                                <div style="display:flex">
                                                    <div style="width:100px;">
                                                        <b style="font-size:16px;">{{$course->rating}}</b>  <span class="rating-star full-star"></span> <br>
                                                        <span style="font-size:12px;">Rating</span>
                                                    </div>
                                                    <div style="width:100px;">
                                                        <b style="font-size:16px;">{{$course->enroll_count}} </b><br>
                                                        <span style="font-size:12px;">Students</span>
                                                    </div>
                                                    <div style="width:100px;">
                                                        <b style="font-size:16px;">{{calculateModuleDuration($course->duration)}}</b> <br>
                                                        <span style="font-size:12px;">Total</span>
                                                    </div>
                                                </div>
                                                <br>
                                                <i class='uil uil-clock-two'></i> Last updated {{$course->updated_at->diffForHumans()}}
                                            </div>
                                            <hr>
                                            <div class="description">
                                                {!!$course->description!!}		
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="nav-q-and-a" role="tabpanel">
                                            <br>
                                            <div class="row" style="margin-right:5px;" id="search_input">
                                                <div class="col-lg-4 col-md-6 col-4">
                                                     <h5 id="btn_ask" style="cursor: pointer;margin-bottom:30px;">Ask a question</h5>
                                                </div>
                                                <div class="col-lg-8 col-md-6 col-8">
                                                    <input style="margin-right:0;margin-left:0;" class="rv_srch" type="text" placeholder="Search questions...">
                                                    <button class="rvsrch_btn"><i class='uil uil-search'></i></button>
                                                
                                                </div>
                                            </div>

                                            <div id="ask_input" style="display: none">
                                                <h5 id="btn_back_ask" style="cursor: pointer;margin-bottom:30px;"><i class='uil uil-arrow-left'></i> Back</h5>
                                                    <div class="course__form" style="padding:30px;">
                                                        <div class="general_info10">
                                                            <div class="row">
                                                                <div class="col-lg-12 col-md-12">
                                                                    @if ($question_types)
                                                                        <h6>My question related to </h6>
                                                                        <div class="rpt100">
                                                                            <div class="radio--group-inline-container">
                                                                                @foreach ($question_types as $type)
                                                                                    <div class="radio-item">
                                                                                        <input class="question_type_input" id="{{$type->id}}" name="question_type" type="radio" value="{{$type->id}}" style="margin-right:20px;">
                                                                                        <label for="{{$type->id}}" class="radio-label"> <b>{{$type->title}}</b></label>
                                                                                    </div> <br>
                                                                                
                                                                                @endforeach
                                                                                <p id="question_type_error" style="color:red;font-size:12px; display:none">Please select a question related</p>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="col-lg-12 col-md-12">															
                                                                    <div class="ui search focus lbel25 mt-30">	
                                                                        <label><h4>Title or summary</h4></label>
                                                                        <div class="ui form swdh30">
                                                                            <div class="field">
                                                                                <textarea rows="3" name="question_title" id="question_title" placeholder="Item description here..."></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="help-block" id="question_title_count">220 words</div>
                                                                        <p id="question_title_error" style="color:red;font-size:12px; display:none">Please enter the question title or summary.</p>
                                                                    </div>								
                                                                </div>
                                                                <div class="col-lg-12 col-md-12">
                                                                    <div class="course_des_textarea mt-30 lbel25">
                                                                        <label for="question_details"><h4>Detail (Optional)</h4></label>
                                                                        <div id="question_editor_container">
                                                                            {{-- <input id="dialog_input_file" type="file" accept="image/*" style="display: none">
                                                                            <div class="course_des_bg">
                                                                                <div id="toolbar">
                                                                                    <button data-command="bold" id="boldBtn"><i class="fas fa-bold"></i></button>
                                                                                    <button data-command="italic" id="italicBtn"><i class="fas fa-italic"></i></button>
                                                                                    <button data-command="insertUnorderedList" id="listBtn"><i class="fas fa-list-ul"></i></button>
                                                                                    <button id="codeBtn"><i class="fas fa-code"></i></button>
                                                                                    <button id="imageBtn"><i class="fas fa-image"></i></button>
                                                                                </div>
                                                                                <div class="ui form swdh30">
                                                                                    <div class="field">
                                                                                        <div id="editor" contenteditable="true"></div>
                                                                                    </div>
                                                                                </div>
                                                                            </div> --}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        {{-- <input type="hidden" name="question_detail" id="editorContent"> --}}
                                                    <form action="{{route('question.create')}}" id="question_form" method="POST">
                                                        @csrf
                                                        <input type="hidden" id="question_type_input" name="question_type">
                                                        <input type="hidden" id="question_title_input" name="question_title">
                                                        <input type="hidden" id="question_detail_input" name="question_detail">
                                                        <input type="hidden" id="course_id" name="course_id" value="{{$course->id}}">
                                                        <input type="hidden" id="user_id" name="user_id" value="{{$user->id}}">
                                                    </form>
                                                    <button id="btn_question_publish" style="width:100%;marign-top:20px;" class="steps_btn">Publish</button>
                                                </div>
                                                
                                            </div>

                                            <div id="question_container">
                                                
                                            </div>

                                            <div id="answer_container" style="display:none">
                                                <h5 id="btn_back_answer" style="cursor: pointer;margin-bottom:30px;"><i class='uil uil-arrow-left'></i> Back</h5>
                                                <div>
                                                    <div class="review_item">
                                                        <div class="review_usr_dt" id="question_layout">
                                                            
                                                        </div> 
                                                        <div style="padding-left:50px;" id="answers_layout">

                                                        </div>  
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="question_loading">
                                                <br><br><br>
                                                <div class="main-loader mt-50 mb-50">													
                                                    <div class="spinner">
                                                        <div class="bounce1"></div>
                                                        <div class="bounce2"></div>
                                                        <div class="bounce3"></div>
                                                    </div>																										
                                                </div>
                                                <br><br><br>
                                                <br><br><br>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="nav-reviews" role="tabpanel">
                                            <div class="student_reviews" style="">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="reviews_left">
                                                            <h3>Student Feedback</h3>
                                                            <div class="row _rate003">
                                                                <div class="col-lg-2 col-md-4 col-sm-6"  style="">
                                                                    <h1 style="font-size:70px;color:#333;font-weight:bold;margin-bottom:-15px;">
                                                                        {{$course->rating}}
                                                                        <span id="course_rating_text1" style="font-size: 16px;">Course Rating</span>
                                                                    </h1>
                                                                   
                                                                    <div id="course_rating_text2">
                                                                        <div style="font-weight:bold;"> Course Rating </div>
                                                                        @php
                                                                            $star = $course->rating;
                                                                        @endphp		
                                                                        <div style="color:#dedfe0">
                                                                            @for ($i = 0; $i < 5; $i++)
                                                                                @if (($i+1)<=$star)
                                                                                    <span class="rating-star1 full-star"></span>
                                                                                @else
                                                                                    @if (($i+0.5)==$star)
                                                                                        <span class="rating-star1 half-star"></span>
                                                                                    @else
                                                                                        <span class="rating-star1 empty-star"></span>
                                                                                    @endif
                                                                                    
                                                                                @endif
                                                                            @endfor	
                                                                        </div>   
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-10 col-md-8 col-sm-6">
                                                                    <div class="_rate004">
                                                                        <div class="progress progress1" style="flex-basis: 80%">
                                                                            <div style="width:{{$five_star_percent}}%" class="progress-bar" role="progressbar" aria-valuenow="{{$five_star_percent}}" aria-valuemin="0" aria-valuemax="100"></div>
                                                                        </div>
                                                                        <div class="rating-box" style="flex-basis: 20%">
                                                                            <span class="rating-star full-star"></span>
                                                                            <span class="rating-star full-star"></span>
                                                                            <span class="rating-star full-star"></span>
                                                                            <span class="rating-star full-star"></span>
                                                                            <span class="rating-star full-star"></span>
                                                                        </div>
                                                                        <div class="_rate002">{{$five_star_percent}}%</div>
                                                                    </div>
                                                                    <div class="_rate004">
                                                                        <div class="progress progress1" style="flex-basis: 80%">
                                                                            <div style="width:{{$four_star_percent}}%" class="progress-bar" role="progressbar" aria-valuenow="{{$four_star_percent}}" aria-valuemin="0" aria-valuemax="100"></div>
                                                                        </div>
                                                                        <div class="rating-box" style="flex-basis: 20%">
                                                                            <span class="rating-star full-star"></span>
                                                                            <span class="rating-star full-star"></span>
                                                                            <span class="rating-star full-star"></span>
                                                                            <span class="rating-star full-star"></span>
                                                                            <span class="rating-star empty-star"></span>
                                                                        </div>
                                                                        <div class="_rate002">{{$four_star_percent}}%</div>
                                                                    </div>
                                                                    <div class="_rate004">
                                                                        <div class="progress progress1" style="flex-basis: 80%">
                                                                            <div style="width:{{$three_star_percent}}%" class="progress-bar" role="progressbar" aria-valuenow="{{$three_star_percent}}" aria-valuemin="0" aria-valuemax="100"></div>
                                                                        </div>
                                                                        <div class="rating-box" style="flex-basis: 20%">
                                                                            <span class="rating-star full-star"></span>
                                                                            <span class="rating-star full-star"></span>
                                                                            <span class="rating-star full-star"></span>
                                                                            <span class="rating-star empty-star"></span>
                                                                            <span class="rating-star empty-star"></span>
                                                                        </div>
                                                                        <div class="_rate002">{{$three_star_percent}}%</div>
                                                                    </div>
                                                                    <div class="_rate004">
                                                                        <div class="progress progress1" style="flex-basis: 80%">
                                                                            <div style="width:{{$two_star_percent}}%" class="progress-bar" role="progressbar" aria-valuenow="{{$two_star_percent}}" aria-valuemin="0" aria-valuemax="100"></div>
                                                                        </div>
                                                                        <div class="rating-box" style="flex-basis: 20%">
                                                                            <span class="rating-star full-star"></span>
                                                                            <span class="rating-star full-star"></span>
                                                                            <span class="rating-star empty-star"></span>
                                                                            <span class="rating-star empty-star"></span>
                                                                            <span class="rating-star empty-star"></span>
                                                                        </div>
                                                                        <div class="_rate002">{{$two_star_percent}}%</div>
                                                                    </div>
                                                                    <div class="_rate004">
                                                                        <div class="progress progress1" style="flex-basis: 80%">
                                                                            <div style="width:{{$one_star_percent}}%" class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                                        </div>
                                                                        <div class="rating-box" style="flex-basis: 20%">
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
                                                    <div class="col-lg-12">
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
                                        <div class="tab-pane fade" id="nav-anouncements" role="tabpanel">
                                            <div id="anouncement_container">

											</div>
                                            <br><br>
                                            <div id="announcement_loading" class="main-loader mt-50 mb-50">													
                                                <div class="spinner">
                                                    <div class="bounce1"></div>
                                                    <div class="bounce2"></div>
                                                    <div class="bounce3"></div>
                                                </div>																										
                                            </div>
                                            <br><br><br>
                                            <br><br><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="footer1">
                    @include('student.components.footer');
                </div>

            </div>

            <div class="col-lg-4 col-md-6 scrollLessonContent fixContainer" id="lesson-section" style="padding-left:10px; padding-right:10px;">

                <div class="crse_content" style="margin-top:15px;">
                    <div class="_112456">
                        <ul class="accordion-expand-holder">
                            <li><span class="accordion-expand-all _d1452">Expand all</span></li>
                            <li><span class="_fgr123"> {{$course->total_lecture}} Lectures</span></li>
                            <li><span class="_fgr123">{{calculateModuleDuration($course->duration)}}</span></li>
                        </ul>
                    </div>

                    @foreach ($course->modules as $module)

                        @php
                            $module_index = $loop->index;
                        @endphp

                        <div id="accordion" class="ui-accordion ui-widget ui-helper-reset" style="margin-top:0px;">
                            <a href="javascript:void(0)" class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" style="margin-top:0px;padding-right:10px;">												
                                <div class="section-header-left" style="flex-basis: 100%">
                                    <span class="section-title-wrapper">
                                        <span class="section-title-text">{{$module->title}}</span>
                                    </span>
                                    <div style="margin-left:8px;color:#505763;margin-top:3px;font-size:12px;"> {{$module->lessons->count()}} lectures . {{calculateModuleDuration($module->lessons()->sum('duration'))}} </div>
                                </div>
                                <div class="section-header-right" style="flex-basis: 5%">
                                    <i class='uil uil-angle-down crse_icon'></i>
                                </div>
                            </a>
                            <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="margin-top:0px;">
                                
                                @foreach ($module->mLessons($user->id) as $lesson)

                                    @php
                                        $lesson_index = $loop->index;
                                    @endphp

                                    <div class="lecture-container lecture-list-1" onclick="playLesson({{$module_index}},{{$lesson_index}})" style="padding-right:15px;cursor: pointer;">
                                        <div class="left-content">
                                            @if ($lesson->lesson_type_id==1)
                                                <i class='uil uil-play-circle icon_142'></i> 
                                            @else
                                                    <i class='uil uil-file icon_142'></i>
                                            @endif
                                            
                                            <div class="top">
                                                <div class="title">{{$lesson->title}} 
                                                     @if ($lesson->learned==1)
                                                        <i style="color:#475692" class='uil uil-check-circle'></i>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="details">
                                            @if ($lesson->lesson_type_id==1)
                                                <span class="content-summary" style="font-size:12px;">{{convertMinutes($lesson->duration)}}</span>
                                            @else
                                                <span > <i class='uil uil-download-alt'></i> </span>
                                            @endif
                                        </div>
                                    </div>

                                @endforeach
                            </div>
                        </div>
                        @endforeach
                     
                </div>
                
            </div>
        </div>
    </div>
	<!-- Body End -->

    <script>

        const apiToken = "{{$api_token}}";
        const course = @json($course);
        const user = @json($user);
        const access = @json($access);
        const question_types = @json($question_types);
        const instructor = @json($instructor); // user model
        const imageShimmer = "{{asset('images/courses/img-1.jpg')}}";
        let lessons, modules;
        let currentLesson = null;
        let reply_question_id = 0;

        console.log('api token',apiToken);
        
        modules = course.modules;

        let is_review_fetching = false;
        let is_review_tab = false;
        let reviewArr = [];

        let is_question_fetching = false;
        let is_question_tab = false;
        let question_mode = true;
        let questionArr = [];

        let is_anouncement_fetching = false;
        let is_announcement_tab = false;
		let anouncementArr = [];
			

        let fetch_review_url = `/api/courses/${course.id}/reviews`
        let fetch_question_url = `/api/courses/${course.id}/questions`;
        let fetch_answer_url = `/api/courses/${course.id}/questions/`; // dynamically concatenate 
        let fetch_anouncement_url = `/api/courses/${course.id}/announcements`;

        let is_answer_is_fetching = false;
        let answer_mode = false;

        let selectedQuestionTypeId = null;

        $(document).ready(()=>{
            adjustLayout();
         
            $('#nav-overview-tab').click(()=>{
              
            });
            
            $('#nav-q-and-a-tab').click(()=>{
               
            });

            $('#nav-reviews-tab').click(()=>{
               
            })

            $('#nav-anouncements-tab').click(()=>{
                
            });


            $('.lecture-list-1').each((i,item)=>{
               
                $(item).click(()=>{

                    $('.lecture-list-1').each((j,lessonItem)=>{
                        $(lessonItem).css({"background":""});
                    });
                    $('.lecture-list-2').eq(i).css({"background":"#efeeff"});
                    $(item).css({"background":"#efeeff"});
                });
            });

            $('.lecture-list-2').each((i,item)=>{
                $(item).click(()=>{
                    $('.lecture-list-2').each((j,lessonItem)=>{
                        $(lessonItem).css({"background":""});
                    });
                     $('.lecture-list-1').eq(i).css({"background":"#efeeff"});
                    $(item).css({"background":"#efeeff"});
                });
            })

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

                if(elementId=="nav-q-and-a-tab"){
                    is_question_tab = true;
                    question_mode = true;
			        answer_mode = false;
                    if(!is_question_fetching && is_question_tab){
                        fetchQuestion();
                    }
                }else{
                    is_question_tab = false;
                    answer_mode = false;
                }

                if(elementId=="nav-anouncements-tab"){
                    is_announcement_tab = true;
                    if(!is_anouncement_fetching){
                        fetchAnnouncements();
                    }
                }else{
                    is_announcement_tab = false;
                }

            });

            $('#btn_ask').click(()=>{
                $('#search_input').hide();
                $('#ask_input').show();
                $('#question_container').hide();
                $('#reply_editor_container').html("");
                new MyTextEditor("question_editor_container");
            })

            $('#btn_back_ask').click(()=>{
                $('#search_input').show();
                $('#ask_input').hide();
                $('#question_container').show();
            })

            $('#btn_back_answer').click(()=>{
                $('#question_container').show();
                $('#answer_container').hide();
                $('#question_loading').hide();
                $('#search_input').show();

                question_mode = true;
				answer_mode = false;
            })

            $(window).scroll(()=>{
                if($(window).scrollTop() + $(window).height() > $(document).height() - 500) {
                    if(!is_review_fetching && is_review_tab){
                        fetchReviews();
                    }

                    if(!is_question_fetching && is_question_tab && question_mode){
                        fetchQuestion();
                    }

                    if(!is_answer_is_fetching && answer_mode){
                        fetchAnswer();
                    }

                    if(!is_anouncement_fetching && is_announcement_tab){
                        fetchAnnouncements();
                    }

                }
            });

            $('.question_related').each((index,e)=>{
                $(e).click(()=>{
                    $('.question_related').each((j,element)=>{
                        $(element).css({"background":""});
                        $(element).css({"color":""});
                    })
                    
                    $(e).css({"background":"#475692"});
                    $(e).css({"color":"#fff"});

                });
            });
           

            $('.question_type_input').on('change', function() {
                selectedQuestionTypeId = $(this).val();
            });

            $('#btn_question_publish').click(()=>{
                
               publishQuestion();
            });

            $('#question_title').on('keyup',()=>{
                var text = $('#question_title').val();
                const letterLimit = 220;

                var letterCount = text.length;
                if(letterCount>letterLimit){
                    $('#question_title').val(text.substring(0, $('#question_title').val().length - 1));
                }else{
                    letterCount = letterLimit - letterCount;
                    if(letterCount>1){
                        $('#question_title_count').html(letterCount+' words');
                    }else{
                        $('#question_title_count').html(letterCount+' word');
                    }
                }

                
            });

            $('#btn_reply_dialog_add').click(()=>{
                reply();
            })

        });

        function fetchAnnouncements(){
            is_anouncement_fetching = true;
            $('#announcement_loading').show();
            if(fetch_anouncement_url==null){
                $('#announcement_loading').hide();
                return;
            }

            $.get(fetch_anouncement_url,function(res,status){
                is_anouncement_fetching=false;
                if(res){
                    fetch_anouncement_url = res.next_page_url;
                    let anouncements = res.data;
                    setAnouncement(anouncements);
                    console.log(anouncements);
                }
                
            })
        }

        function setAnouncement(anouncements){
                $('#announcement_loading').hide();
                anouncements.map((anouncement,index)=>{
                    anouncementArr.push(anouncement);	
                    $('#anouncement_container').append(anouncementComponent(anouncement));
                })
        }

        function anouncementComponent(anouncement){
            let photo_attachment = "";
            if(anouncement.image_url!=""){
                photo_attachment = `<img style="width:200px;margin-top:10px;border-radius:3px;" src="http://localhost:8000/storage/${anouncement.image_url}" alt="">`;
            }
            let resource_file = "";
            if(anouncement.resource_url!=""){
                resource_file = `
                    <a href="http://localhost:8000/storage/${anouncement.resource_url}"> <div class="resource" id="resource_attachment">Resource <i class="uil uil-download-alt"></i></div> </a>
                `;
            }
            return `
                <div class="reviews_left">
                    <div style="display: flex;">
                        <div>
                            <img src="http://localhost:8000/storage/${instructor.image_url}" alt="" style="width: 30px;height:30px; border-radius:50px;">
                        </div>
                        <div style="margin-left: 15px;flex:1;margin-right:15px;">
                            <span style="font-weight:bold;margin-bottom:5px;">{{$course->title}}</span> <br>
                            <span class="time_145">Announced by ${instructor.name} . ${formatDateTime(new Date(anouncement.created_at))}</span>

                            <br>
                            <div>
                                ${anouncement.body}	<br>
                                ${photo_attachment}
                                ${resource_file}
                            </div>
                        </div>
                    </div>					
                </div>
            `
        }

        function publishQuestion(){
            let validated = true;
            $('#question_type_error').hide();
            $('#question_title_error').hide();
            if(selectedQuestionTypeId!=null){
                $('#question_type_input').val(selectedQuestionTypeId);
            }else{
                $('#question_type_error').show();
                validated=false;

            }

            let question_title = $('#question_title').val();

            if(question_title==""){
                $('#question_title_error').show();
                validated=false;
            }

            

            $('#question_title_input').val(question_title);
            $('#question_detail_input').val($('#editor').html());

            if(validated)  $('#question_form').submit();
        }

        function fetchQuestion(){
            is_question_fetching = true;
            $('#question_loading').show();
            if(fetch_question_url==null){
                $('#question_loading').hide();
                return;
            }

            $.get(fetch_question_url,function(res,status){
                is_question_fetching=false;
                $('#question_loading').hide();
                if(res){
                    fetch_question_url = res.next_page_url;
                    let questions = res.data;
                    setQuestions(questions);
                     
                }
                
            })
        }

        function setQuestions(questions){
            questions.map((question,index)=>{
                $('#question_container').append(questionComponent(question));
                questionArr.push(question);
            })
        }

        function questionComponent(question){
            let delBtn = question.user_id == user.id ? `<span class="btn_span" style="float:right;" onclick="defineDeleteQA(${question.id},true)"  data-toggle="modal" data-target="#delete_dialog">Delete<i class='uil uil-trash'></i> </span>`:'';
            return `
                <div class="review_item" id="question_component_${question.id}">
                    <div class="review_usr_dt">
                        <img src="http://localhost:8000/storage/${question.user.image_url}" alt="">
                        <div class="rv1458" style="width:100%">
                            <h5 class="">${question.title}</h5>
                            <span style="display: inline" class="time_145">By ${question.user.name}</span> . <span style="display: inline"  class="time_145">${formatDateTime(new Date(question.created_at))}</span>
                            <span class="btn_span" style="float:right" onclick="seeAnswer(${question.id})"> See answers <i class='uil uil-comments-alt'></i> ${question.answer_count} </span>
                            ${delBtn}
                        </div>
                    </div>   
                </div>
            `;
        }

        function seeAnswer(question_id){
            const question = questionArr.find(q=>q.id ===question_id );
            question_mode = false;
			answer_mode = true;
            $('#answers_layout').html("");
            $('#question_layout').html(`
                <img src="" alt="">
                <div class="rv1458" style="width:100%">
                    <div>
                        <h5 class="">${question.title}</h5>
                        <div class="content_body">${question.body}</div>
                        <br>
                    </div>
                    
                    <span style="display: inline" class="time_145">By ${question.user.name}</span> . <span style="display: inline"  class="time_145">${formatDateTime(new Date(question.created_at))}</span>
                    <span style="float:right;">Total <i class='uil uil-comments-alt'></i> ${question.answer_count} </span>
                </div>
            `);


            $('#question_container').hide();
            $('#answer_container').show();
            $('#search_input').hide();
            $('#question_loading').show();

            fetch_answer_url= `/api/courses/${course.id}/questions/${question.id}/answers`;
            fetchAnswer();

        }

        function fetchAnswer(question_id){
            is_answer_is_fetching = true;
            $('#question_loading').show();
            if(fetch_answer_url==null){
                $('#question_loading').hide();
                return;
            }

            $.get(fetch_answer_url,function(res,status){
                is_answer_is_fetching=false;
                $('#question_loading').hide();
                if(res){
                    fetch_answer_url = res.next_page_url;
                    let answers = res.data;
					setAnswer(answers);
                     
                }
                
            })
        }

        function setAnswer(answers){
			answers.map((answer,index)=>{
                $('#answers_layout').append(answerComponent(answer));
               // questionArr.push(question);
            })
		}

		function answerComponent(answer){
            let delBtn = answer.user_id == user.id ? ` . <span class="btn_span" onclick="defineDeleteQA(${answer.id},false)"  data-toggle="modal" data-target="#delete_dialog">Delete<i class='uil uil-trash'></i> </span>`:'';
			return `
				<div class="review_item" id="answer_component_${answer.id}">
					<div class="review_usr_dt">
						<img src="http://localhost:8000/storage/${answer.user.image_url}" alt="" style="width:30px; height:30px;">
						<div class="rv1458"  style="width:100%">
							<div>
								<div class="content_body">${answer.body}</div>
							</div>
                            <br>
							<span style="display: inline" class="time_145">By ${answer.user.name}</span> . <span style="display: inline"  class="time_145">${formatDateTime(new Date(answer.created_at))}</span>
							. <span class="btn_span" onclick="defineReply(${answer.question_id})" data-toggle="modal" data-target="#reply_dialog" >Answer<i class='uil uil-comments-alt'></i>  </span>
                            ${delBtn}
						</div>
					</div>
				</div>

			`;

		}

        function defineReply(question_id){
            $('#question_editor_container').html("");
            new MyTextEditor("reply_editor_container");
			$('#editor').html("");
			reply_question_id = question_id;
		}

        function reply(){
			const body = $('#editor').html();
			if(body==""){
				$('#editor_input_error').show();
				return;
			}

			let formData = {};
			formData.body = body;
			formData.user_id = user.id;
			formData.question_id = reply_question_id;
			 
			console.log(formData);
			$.ajax({
				url: `http://localhost:8000/api/answers`,
				type: 'POST',
				data: formData,
				headers: {
					'Authorization': 'Bearer ' + apiToken,
					'Accept': 'application/json'
				},
				success: function(response) {
                    let answer = response;
                    answer.user = user;
                    $('#answers_layout').append(answerComponent(answer));
				 
				},
				error: function(xhr, status, error) {
					console.log('Error:', xhr.status, error);
					 
				}
			});

		}

        function adjustLayout(){
            var w = window.innerWidth;
            var player_section=document.getElementById('player-section');
            var w_player_section=player_section.offsetWidth;
            //console.log('windown',w,'lesson section',w_lesson_section);

            if(w<=w_player_section+250){
                $('#lesson-section').hide();
                $('#nav-content-tab').show();
                $('#nav-content-tab').click();
                $('#course_rating_text1').show();
                $('#course_rating_text2').hide();
            }else{
                $('#lesson-section').show();
                $('#nav-content-tab').hide();
                $('#nav-overview-tab').click();
                $('#course_rating_text1').hide();
                $('#course_rating_text2').show();
                
            }
        }

        function playLesson(module_index, lesson_index){
           
            let lesson = modules[module_index].lessons[lesson_index];
            currentLesson = lesson;

            if(lesson.lesson_type_id==1){
                $('#videoSrc').attr('src',lesson.link);
                const $video = $('#myVideo');
                $video[0].load();
                $video[0].play();

                let videoDuration = 0 ;
                let updatedLearningRecord = false;
                $video.on('loadedmetadata', function() {
                    videoDuration = $video[0].duration.toFixed(2);
                    
                });

                $video.on('timeupdate', function() {
                    if(videoDuration>0){
                        const videoProgress = $video[0].currentTime.toFixed(2);
                        if(videoProgress>videoDuration-10){
                            if(!updatedLearningRecord){
                                updateLearnHistory(lesson);
                                updatedLearningRecord=true;
                            }
                        }
                    }
                });
                    
            }else{
                $('#myVideo').get(0).pause();
                downloadContent();
                updateLearnHistory(lesson);
            }
        }

        function downloadVideo(){
            console.log(currentLesson);
            if(currentLesson.downloadable==1){
                if(access.verified==1){
                    downloadContent();
                }else{
                    alert('The lecture cannot be downloaded on payment identification progress. You need to contact to your instructor.')
                }
            }else{
                alert('Your intructor does not allow to download the lecture. You need to contact to your instructor to get the lecture!')
            }
        }

        function downloadContent(){

            console.log(currentLesson.link);
            const link = $('<a></a>').attr('href', currentLesson.link).attr('download', '');
            $('body').append(link);
            link[0].click();
            link.remove();
        }

        function fetchLesson(){
            $.ajax({
				url: 'http://localhost:8000/api/courses/'+course.id+'/lessons', // Replace with your API endpoint
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

        
        function fetchReviews(){
            is_review_fetching = true;
            $('#shimmer').show();
            if(fetch_review_url==null){
                $('#shimmer').hide();
                return;
            }

            $.get(fetch_review_url,function(res,status){
                is_review_fetching=false;
                if(res){
                    fetch_review_url = res.next_page_url;
                    let reviews = res.data;
                    setReviews(reviews);
                    console.log(reviews);
                }
                
            })
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

            return `
                <div class="review_item">
                    <div class="review_usr_dt">
                        <img src="http://localhost:8000/storage/${review.user.image_url}" alt="">
                        <div class="rv1458">
                            <h4 class="tutor_name1">${review.user.name}</h4>
                            <span class="time_145">${formatDateTime(new Date(review.created_at))}</span>
                        </div>
                    </div>
                    <div class="rating-box mt-20">
                        ${star}
                    </div>
                    <p class="rvds10">${review.body}</p>
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
            `;
        }

        function updateLearnHistory(lesson){
            $.ajax({
				url: 'http://localhost:8000/api/learning-histories', // Replace with your API endpoint
				type: 'POST', // or 'GET' depending on your request
				headers: {
					'Authorization': 'Bearer '+apiToken // Example for Authorization header
				},
                data:{
                    'lesson_id':lesson.id,
                },
				success: function(response) {
                    console.log('learning history res ',response);
				},
				error: function(xhr, status, error) {
					console.error('Error:', status, error);
				}
			});
        }

        var deleteQAContentId = 0;
        var isQuestionDelete;

        function defineDeleteQA(id, isQuestion){
            deleteQAContentId = id;
            isQuestionDelete = isQuestion;
            console.log(typeof(isQuestion));
        }

        function deleteQA(){
            let api_url;
            if(isQuestionDelete){
                api_url = `/api/questions/${deleteQAContentId}`;
                $('#question_component_'+deleteQAContentId).html("");
            }else{
                api_url = `/api/answers/${deleteQAContentId}`;
                $('#answer_component_'+deleteQAContentId).html("");
            }
            
             $.ajax({
				url: api_url, // Replace with your API endpoint
				type: 'DELETE', // or 'GET' depending on your request
				headers: {
					'Authorization': 'Bearer '+apiToken // Example for Authorization header
				},
                
				success: function(response) {
                    console.log(response);
				},
				error: function(xhr, status, error) {
					console.error('Error:', status, error);
				}
			});
        }

    </script>

    <script src="{{asset('js/vertical-responsive-menu.min.js')}}"></script>
	<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('vendor/OwlCarousel/owl.carousel.js')}}"></script>
	<script src="{{asset('vendor/semantic/semantic.min.js')}}"></script>
	<script src="{{asset('js/custom.js')}}"></script>
	<script src="{{asset('js/night-mode.js')}}"></script>
    <script src="{{asset('js/editor_component.js')}}"></script>
    <script src="{{asset('js/util.js')}}"></script>

</body>
</html>