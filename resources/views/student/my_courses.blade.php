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


@endphp

@extends('student.components.master')

@section('content')
	<div class="wrapper">
		<div class="sa4d25">
			<div class="container-fluid">			
				<div class="row">
					<div class="col-md-8">
						<div class="_14d25 mb-20">						
							<div class="row">

								<div class="col-md-12">
									<h4 class="mhs_title">My Courses</h4>

                                    @foreach ($myCourses as $myCourse)
                                        @php
                                            $course = $myCourse->course;
                                        @endphp
                                        <div class="fcrse_1">
                                            <a href="{{route('course_detail', ['id' => $course->id])}}" class="hf_img">
                                                <img src="images/courses/img-1.jpg" alt="">
                                                <div class="course-overlay">
                                                    <div class="badge_seller">Bestseller</div>
                                                    <div class="crse_reviews">
                                                        <i class="uil uil-star"></i>{{$course->rating}}
                                                    </div>
                                                    <span class="play_btn1"><i class="uil uil-play"></i></span>
                                                    <div class="crse_timer">
                                                        {{calculateHour($course->duration)}} Hours
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="hs_content">
												
                                                <div class="vdtodt">
													<div style="background:rgb(239, 239, 0);border-radius:50px;width:20px;height:20px;position: absolute;right:15px;top:15px;"></div>
                                                    <span class="vdt14">109k views</span>
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
                                    @endforeach
								</div>									
							</div>																		
						</div>								
					</div>	

					<div class="col-lg-4 col-md-4 ">
						<div class="hide_on_small_screen section3125 hstry142">
							<div class="grp_titles pt-0">
								<div class="ht_title">Heading</div>
							</div>
							<div class="tb_145">
								<div class="wtch125">
									<span class="vdt14">
										@php
											$course_count = $myCourses->count();
										@endphp
										@if ($course_count>1)
											{{$course_count}} Courses
										@else
											{{$course_count}} Course
										@endif
									</span>
									<br>
									ထည့်ချင်တာ ထည့်လို့ရတယ် <br>
									small screen မှာ ဖျောက်မယ်
								</div>
								 
							</div>						
						</div>							
					</div>					
								
				</div>
			</div>
		</div>
@endsection
