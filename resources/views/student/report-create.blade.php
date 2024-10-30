@php
    if(isset($_COOKIE['api_auth_token'])){
		$api_token = $_COOKIE['api_auth_token'];
	}else{
		$api_token = "";
	}
    $user = Auth::user();

    if (!function_exists('calculateHour')) {
        function calculateHour($min){
            $hr = $min/60;
            $hr = floor($hr);
            return $hr;
        }
    }
    if (!function_exists('formatCounting')) {
        function formatCounting($count,$unit){


            if($count<=1){
                return $count.' '.$unit;
            }else if($count>1 && $count<1000){
                return $count.' '.$unit.'s';
            }else if($count>=1000 && $count<1000000){
                return floor($count/1000).'k'.' '.$unit.'s';
            }else{
                return floor($count/1000000).'M'.' '.$unit.'s';;
            }
        }
    }
@endphp

@extends('student.components.master')

@section('content')
	@auth
	<div class="wrapper">
	@else
	<div style="padding-top:60px;">
	@endauth
		<div class="sa4d25">
		    <div class="container-fluid">		
                @if (session('msg'))
                    <div class="alert alert-success">
                        {{ session('msg') }}
                    </div>
                @endif	
				<div class="row">
					<div class="col-lg-12">
						<h2 class="st_title"><i class='uil uil-windsock'></i> Report Now</h2>

                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                @if ($course)
                                    <div class="fcrse_1">
                                        <a href="{{route('course_detail', ['id' => $course->id])}}" class="hf_img">
                                            <img src="{{asset('storage/'.$course->cover_url)}}" alt="">
                                            <div class="course-overlay">
                                                <span class="play_btn1"><i class="uil uil-play"></i></span>
                                            </div>
                                        </a>
                                        <div class="hs_content">
                                            <div class="vdtodt">
                                                <span class="vdt14">{{formatCounting($course->preview_count,'view')}}</span>
                                                <span class="vdt14">{{$course->created_at->diffForHumans()}}</span>
                                            </div>
                                            <a href="{{route('course_detail', ['id' => $course->id])}}" class="crse14s title900">{{$course->title}}</a>
                                            <a href="{{route('courses')}}?category_id={{$course->category_id}}" class="crse-cate">
                                                {{$course->category->title}} <i class="uil uil-arrow-right"></i> {{$course->sub_category->title}} <i class="uil uil-arrow-right"></i>  {{$course->topic->title}}
                                            </a>
                                            <div class="auth1lnkprce">
                                                <p class="cr1fot">By <a href="{{route('instructor_detail',['id'=>$course->instructor->id])}}">{{$course->instructor->user->name}}</a></p>
                                            </div>
                                        </div>
                                    </div>
                                @endif 	

                                @if ($instructor)
                                   <div class="fcrse_1" style="padding:10px;">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="review_usr_dt" style="width:100%;">
                                                    <img src="{{asset('storage/'.$instructor->user->image_url)}}" alt="">
                                                    <div class="rv1458">
                                                        <h4 class="tutor_name1">{{$instructor->user->name}}</h4>
                                                        <div class="time_145">
                                                            <span>
                                                                @foreach ($instructor->categories as $index=> $category)
                                                                        @if ($index>0)
                                                                            ,
                                                                        @endif
                                                                    {{$category->title}} 
                                                                @endforeach
                                                                and Instructor
                                                            </span>	
                                                        </div> 

                                                        <ul class="tutor_social_links">
                                                            @foreach ($instructor->user->social_contacts as $contact)
                                                                <li>
                                                                    <a href="{{$contact->link}}">
                                                                        <?= $contact->social_media->web_icon ?>
                                                                    </a>
                                                                    
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($reported_user)
                                    <div class="fcrse_1" style="padding:10px;">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="review_usr_dt" style="width:100%;">
                                                    <img src="{{asset('storage/'.$reported_user->image_url)}}" alt="">
                                                    <div class="rv1458">
                                                        <h4 class="tutor_name1">{{$reported_user->name}}</h4>
                                                        <div class="time_145">
                                                            
                                                        </div> 

                                                        <ul class="tutor_social_links">
                                                            @foreach ($reported_user->social_contacts as $contact)
                                                                <li>
                                                                    <a href="{{$contact->link}}">
                                                                        <?= $contact->social_media->web_icon ?>
                                                                    </a>
                                                                    
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($review)
                                    <div class="fcrse_1 review_item">
                                        <div class="review_usr_dt">
                                            <a href = "{{asset('')}}users/{{$review->user->id}}" >
                                                <img src="{{asset('storage/'.$review->user->image_url)}}" alt="">
                                            </a>
                                            <div class="rv1458">
                                                <a href = "{{asset('')}}users/{{$review->user->id}}" >
                                                    <h4 class="tutor_name1">{{$review->user->name}}</h4>
                                                </a>
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
                                        <p class="rvds10">{{$review->body? $review->body: ""}}</p>
                                    </div> 
                                @endif
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="fcrse_1">
                                    <p>
                                        The reported content is reviewed by EasyStudy staff to determine whether it 
                                        violates Terms of Service or Community Guidelines.
                                    </p>
                                    <form action="{{route('reports.store')}}" method="POST">
                                        @csrf
                                        <div class="radio--group-inline-container"> 
                                            <h5>Issue Type</h5>
                                            <p style="color:red">{{$errors->first('report_type_id')?"Please select an issue.":""}}</p>
                                            @foreach ($report_types as $type)
                                                <div class="radio-item" style="margin-top:5px;s">
                                                    <input id="radio-{{$type->id}}" name="report_type_id" value="{{$type->id}}" type="radio">
                                                    <label for="radio-{{$type->id}}" class="radio-label">{{$type->type}}</label>
                                                </div><br>
                                            @endforeach
                                            <h5>Detail (Optional)</h5>
                                            <div class="ui search focus">																
                                                <div class="ui form swdh30">
                                                    <div class="field">
                                                        <textarea rows="6" name="description" id="input_description" placeholder="Describe your issue in detail"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="content_id" value="{{$content_id}}" >
                                            <input type="hidden" name="content_type_id" value="{{$content_type_id}}">

                                            <button id="btn_save" class="save_btn">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
					</div>						
				</div>
			</div>
		</div>

@endsection
