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

@extends('layouts.master')

@section('content')
	<div class="wrapper">
		<div class="sa4d25">
			<div class="container-fluid">			
				<div class="row">
					<div class="col-lg-3 col-md-4 ">
						<div class="section3125 hstry142">
							<div class="grp_titles pt-0">
								<div class="ht_title">Saved Courses</div>
								<a href="#" class="ht_clr">Remove All</a>
							</div>
							<div class="tb_145">
								<div class="wtch125">
									<span class="vdt14">4 Courses</span>
								</div>
								<a href="#" class="rmv-btn"><i class='uil uil-trash-alt'></i>Remove Saved Courses</a>
							</div>						
						</div>							
					</div>					
					<div class="col-md-9">
						<div class="_14d25 mb-20">						
							<div class="row">

								<div class="col-md-12">
									<h4 class="mhs_title">Saved Courses</h4>

                                    @foreach ($myCourses as $myCourse)
                                        @php
                                            $course = $myCourse->course;
                                        @endphp
                                        <div class="fcrse_1">
                                            <a href="course_detail_view.html" class="hf_img">
                                                <img src="images/courses/img-1.jpg" alt="">
                                                <div class="course-overlay">
                                                    <div class="badge_seller">Bestseller</div>
                                                    <div class="crse_reviews">
                                                        <i class="uil uil-star"></i>{{$course->rating}}
                                                    </div>
                                                    <span class="play_btn1"><i class="uil uil-play"></i></span>
                                                    <div class="crse_timer">
                                                        25 hours
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="hs_content">
                                                <div class="vdtodt">
                                                    <span class="vdt14">109k views</span>
                                                    <span class="vdt14">{{$course->created_at->diffForHumans()}}</span>
                                                </div>
                                                <a href="course_detail_view.html" class="crse14s title900">{{$course->title}}</a>
                                                <a href="#" class="crse-cate">
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
				</div>
			</div>
		</div>
@endsection
