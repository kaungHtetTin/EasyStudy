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

	@auth
	<div class="wrapper">
	@else
	<div style="padding-top:60px;">
	@endauth
		<div class="sa4d25">
			<div class="container-fluid">			
				<div class="row">
					<div class="col-xl-9 col-lg-8">
						<div class="section3125">
							<h4 class="item_title">Featured Courses</h4>
							<a href="" class="see150">See all</a>
							<div class="la5lo1">
								<div class="owl-carousel featured_courses owl-theme">
									@foreach ($featureCourses as $course)
										<div class="item">
											<div class="fcrse_1 mb-20">
												<a href="{{route('course_detail', ['id' => $course->id])}}" class="fcrse_img">
													<img src="{{asset('images/courses/img-1.jpg')}}" alt="">
													<div class="course-overlay">
														<div class="badge_seller">Bestseller</div>
														<div class="crse_reviews">
															<i class='uil uil-star'></i>{{$course->rating}}
														</div>
														<span class="play_btn1"><i class="uil uil-play"></i></span>
														<div class="crse_timer">
															{{calculateHour($course->duration)}} hours
														</div>
													</div>
												</a>
												<div class="fcrse_content">
													<div class="eps_dots more_dropdown">
														<a href="#"><i class='uil uil-ellipsis-v'></i></a>
														<div class="dropdown-content">
															<span><i class='uil uil-share-alt'></i>Share</span>
															<span><i class="uil uil-heart"></i>Save</span>
															<span><i class='uil uil-ban'></i>Not Interested</span>
															<span><i class="uil uil-windsock"></i>Report</span>
														</div>																										
													</div>
													<div class="vdtodt">
														<span class="vdt14">109k views</span>
														<span class="vdt14">{{$course->created_at->diffForHumans()}}</span>
													</div>
													<a href="{{route('course_detail', ['id' => $course->id])}}" class="crse14s"> {{$course->title}} </a>
													<a href="#" class="crse-cate">
														{{$course->category->title}} <i class="uil uil-arrow-right"></i> {{$course->sub_category->title}} <i class="uil uil-arrow-right"></i>  {{$course->topic->title}}
													</a>
													<div class="auth1lnkprce">
														<p class="cr1fot">By <a href="{{route('instructor_detail',['id'=>$course->instructor->id])}}">{{$course->instructor->user->name}}</a></p>
														<div class="prce142">{{$course->fee}} MMK</div>
														<form action="{{route('cart')}}" method="POST">
															<input type="hidden" value="{{$course->id}}" name="course_id">
															@csrf
															<button type="submit" class="shrt-cart-btn" title="Add to cart"><i class="uil uil-shopping-cart-alt"></i></button>
														</form>
													</div>
												</div>
											</div>
										</div>
									@endforeach
								</div>
							</div>
						</div>
						<div class="section3125 mt-30">
							<h4 class="item_title">Newest Courses</h4>
							<a href="#" class="see150">See all</a>

							<div class="la5lo1">
								<div class="owl-carousel featured_courses owl-theme">
									@foreach ($newestCourses as $course)
										<div class="item">
											<div class="fcrse_1 mb-20">
												<a href="course_detail_view.html" class="fcrse_img">
													<img src="images/courses/img-14.jpg" alt="">
													<div class="course-overlay">
														<span class="play_btn1"><i class="uil uil-play"></i></span>
														<div class="crse_timer">
															{{calculateHour($course->duration)}} hours
														</div>
													</div>
												</a>
												<div class="fcrse_content">
													<div class="eps_dots more_dropdown">
														<a href="#"><i class='uil uil-ellipsis-v'></i></a>
														<div class="dropdown-content">
															<span><i class='uil uil-share-alt'></i>Share</span>
															<span><i class="uil uil-heart"></i>Save</span>
															<span><i class='uil uil-ban'></i>Not Interested</span>
															<span><i class="uil uil-windsock"></i>Report</span>
														</div>																											
													</div>
													<div class="vdtodt">
														<span class="vdt14">15 views</span>
														<span class="vdt14">{{$course->created_at->diffForHumans()}}</span>
													</div>
													<a href="{{route('course_detail', ['id' => $course->id])}}" class="crse14s"> {{$course->title}} </a>
													<a href="#" class="crse-cate">
														{{$course->category->title}} <i class="uil uil-arrow-right"></i> {{$course->sub_category->title}} <i class="uil uil-arrow-right"></i>  {{$course->topic->title}}
													</a>
													<div class="auth1lnkprce">
														<p class="cr1fot">By <a href="{{route('instructor_detail',['id'=>$course->instructor->id])}}">{{$course->instructor->user->name}}</a></p>
														<div class="prce142">{{$course->fee}} MMK</div>
														<form action="{{route('cart')}}" method="POST">
															<input type="hidden" value="{{$course->id}}" name="course_id">
															@csrf
															<button type="submit" class="shrt-cart-btn" title="Add to cart"><i class="uil uil-shopping-cart-alt"></i></button>
														</form>
													</div>
												</div>
											</div>
										</div>
									@endforeach
								</div>
							</div>

						</div>
						<div class="section3126">
							<div class="row">
								<div class="col-xl-6 col-lg-12 col-md-6">
									<div class="value_props">
										<div class="value_icon">
											<i class='uil uil-history'></i>
										</div>
										<div class="value_content">
											<h4>Go at your own pace</h4>
											<p>Enjoy lifetime access to courses on Edututs+'s website</p>
										</div>
									</div>
								</div>
								<div class="col-xl-6 col-lg-12 col-md-6">
									<div class="value_props">
										<div class="value_icon">
											<i class='uil uil-user-check'></i>
										</div>
										<div class="value_content">
											<h4>Learn from industry experts</h4>
											<p>Select from top instructors around the world</p>
										</div>
									</div>
								</div>
								<div class="col-xl-6 col-lg-12 col-md-6">
									<div class="value_props">
										<div class="value_icon">
											<i class='uil uil-play-circle'></i>
										</div>
										<div class="value_content">
											<h4>Find video courses on almost any topic</h4>
											<p>Build your library for your career and personal growth</p>
										</div>
									</div>
								</div>
								<div class="col-xl-6 col-lg-12 col-md-6">
									<div class="value_props">
										<div class="value_icon">
											<i class='uil uil-presentation-play'></i>
										</div>
										<div class="value_content">
											<h4>100,000 online courses</h4>
											<p>Explore a variety of fresh topics</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="section3125 mt-50">
							<h4 class="item_title">Popular Instructors</h4>
							<a href="{{route('instructors')}}" class="see150">See all</a>
							<div class="la5lo1">
								<div class="owl-carousel top_instrutors owl-theme">
									@foreach ($popularInstructors as $instructor)
										<div class="item">
											<div class="fcrse_1 mb-20">
												<div class="tutor_img">
													<a href="{{route('instructor_detail',['id'=>$instructor->id])}}"><img src="images/left-imgs/img-1.jpg" alt=""></a>												
												</div>
												<div class="tutor_content_dt">
													<div class="tutor150">
														<a href="{{route('instructor_detail',['id'=>$instructor->id])}}" class="tutor_name">{{$instructor->user->name}}</a>
														<div class="mef78" title="Verify">
															<i class="uil uil-check-circle"></i>
														</div>
													</div>
													<div class="tutor_cate">
														@foreach ($instructor->categories as $index=> $category)
															 @if ($index>0)
																 &amp;
															 @endif
															{{$category->title}} 
														@endforeach
													</div>
													<ul class="tutor_social_links">
														<li><a href="#" class="fb"><i class="fab fa-facebook-f"></i></a></li>
														<li><a href="#" class="tw"><i class="fab fa-twitter"></i></a></li>
														<li><a href="#" class="ln"><i class="fab fa-linkedin-in"></i></a></li>
														<li><a href="#" class="yu"><i class="fab fa-youtube"></i></a></li>
													</ul>
													<div class="tut1250">
														<span class="vdt15">100K Students</span>
														<span class="vdt15">
															@php
																$courseCount = $instructor->courses->count();
																if ($courseCount>1) {
																	echo $courseCount." Courses";
																}else{
																	echo $courseCount." Course";
																}
															@endphp
														</span>
													</div>
												</div>
											</div>
										</div>
									@endforeach

								</div>
							</div>
						</div>	
					</div>
					
					<div class="col-xl-3 col-lg-4">
						<div class="right_side">
							@auth
							<div class="fcrse_2 mb-30">
								<div class="tutor_img">
									<a href="{{route('instructor_detail',['id'=>1])}}"><img src="images/left-imgs/img-10.jpg" alt=""></a>												
								</div>
								<div class="tutor_content_dt">
									<div class="tutor150">
										<a href="{{route('instructor_detail',['id'=>1])}}" class="tutor_name">Joginder Singh</a>
										<div class="mef78" title="Verify">
											<i class="uil uil-check-circle"></i>
										</div>
									</div>
									<div class="tutor_cate">Web Developer, Designer, and Teacher</div>
									<ul class="tutor_social_links">
										<li><a href="#" class="fb"><i class="fab fa-facebook-f"></i></a></li>
										<li><a href="#" class="tw"><i class="fab fa-twitter"></i></a></li>
										<li><a href="#" class="ln"><i class="fab fa-linkedin-in"></i></a></li>
										<li><a href="#" class="yu"><i class="fab fa-youtube"></i></a></li>
									</ul>
									<div class="tut1250">
										<span class="vdt15">615K Students</span>
										<span class="vdt15">12 Courses</span>
									</div>
									<a href="my_instructor_profile_view.html" class="prfle12link">Go To Profile</a>
								</div> 
							</div>
							
							<div class="fcrse_3">
								<div class="cater_ttle">
									<h4>Live Streaming</h4>
								</div>
								<div class="live_text">
									<div class="live_icon"><i class="uil uil-kayak"></i></div>
									<div class="live-content">
										<p>Set up your channel and stream live to your students</p>
										<button class="live_link" onclick="window.location.href = 'add_streaming.html';">Get Started</button>
										<span class="livinfo">Info : This feature only for 'Instructors'.</span>
									</div>
								</div>
							</div>

							<div class="get1452">
								<h4>Get personalized recommendations</h4>
								<p>Answer a few questions for your top picks</p>
								<button class="Get_btn" onclick="window.location.href = '#';">Get Started</button>
							</div>
							@endauth
							<div class="fcrse_3">
								<div class="cater_ttle">
									<h4>Top Categories</h4>
								</div>
								<ul class="allcate15">
									@foreach ($categories as $category)
										<li><a href="{{route('courses')}}?category_id={{$category->id}}" class="ct_item"><i class='uil uil-arrow'></i>{{$category->title}}</a></li>
									@endforeach
									
									<li><a href="#" class="ct_item"><i class='uil uil-graph-bar'></i>Business</a></li>
									<li><a href="#" class="ct_item"><i class='uil uil-monitor'></i>IT and Software</a></li>
									<li><a href="#" class="ct_item"><i class='uil uil-ruler'></i>Design</a></li>
									<li><a href="#" class="ct_item"><i class='uil uil-chart-line'></i>Marketing</a></li>
									<li><a href="#" class="ct_item"><i class='uil uil-book-open'></i>Personal Development</a></li>
									<li><a href="#" class="ct_item"><i class='uil uil-camera'></i>Photography</a></li>
									<li><a href="#" class="ct_item"><i class='uil uil-music'></i>Music</a></li>
								</ul>
							</div>
							<div class="strttech120">
								<h4>Become an Instructor</h4>
								<p>Top instructors from around the world teach millions of students on Cursus. We provide the tools and skills to teach what you love.</p>
								<button class="Get_btn" onclick="window.location.href = '#';">Start Teaching</button>
							</div>
						</div>
					</div>
				
					<div class="col-xl-12 col-lg-12">
						<div class="section3125 mt-30">
							<h4 class="item_title">What Our Student Have Today</h4>
							<div class="la5lo1">
								<div class="owl-carousel Student_says owl-theme">
									<div class="item">
										<div class="fcrse_4 mb-20">
											<div class="say_content">
												<p>"Donec ac ex eu arcu euismod feugiat. In venenatis bibendum nisi, in placerat eros ultricies vitae. Praesent pellentesque blandit scelerisque. Suspendisse potenti."</p>
											</div>
											<div class="st_group">
												<div class="stud_img">
													<img src="images/left-imgs/img-4.jpg" alt="">												
												</div>
												<h4>Jassica William</h4>
											</div>											
										</div>
									</div>
									<div class="item">
										<div class="fcrse_4 mb-20">
											<div class="say_content">
												<p>"Cras id enim lectus. Fusce at arcu tincidunt, iaculis libero quis, vulputate mauris. Morbi facilisis vitae ligula id aliquam. Nunc consectetur malesuada bibendum."</p>
											</div>
											<div class="st_group">
												<div class="stud_img">
													<img src="images/left-imgs/img-1.jpg" alt="">												
												</div>
												<h4>Rock Smith</h4>
											</div>											
										</div>
									</div>
									<div class="item">
										<div class="fcrse_4 mb-20">
											<div class="say_content">
												<p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos eros ac, sagittis orci."</p>
											</div>
											<div class="st_group">
												<div class="stud_img">
													<img src="images/left-imgs/img-7.jpg" alt="">												
												</div>
												<h4>Luoci Marchant</h4>
											</div>											
										</div>
									</div>
									<div class="item">
										<div class="fcrse_4 mb-20">
											<div class="say_content">
												<p>"Nulla bibendum lectus pharetra, tempus eros ac, sagittis orci. Suspendisse posuere dolor neque, at finibus mauris lobortis in.  Pellentesque vitae laoreet tortor."</p>
											</div>
											<div class="st_group">
												<div class="stud_img">
													<img src="images/left-imgs/img-6.jpg" alt="">												
												</div>
												<h4>Poonam Sharma</h4>
											</div>											
										</div>
									</div>
									<div class="item">
										<div class="fcrse_4 mb-20">
											<div class="say_content">
												<p>"Curabitur placerat justo ac mauris condimentum ultricies. In magna tellus, eleifend et volutpat id, sagittis vitae est.  Pellentesque vitae laoreet tortor."</p>
											</div>
											<div class="st_group">
												<div class="stud_img">
													<img src="images/left-imgs/img-3.jpg" alt="">												
												</div>
												<h4>Davinder Singh</h4>
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
