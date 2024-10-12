@php
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

    $api_token = Cookie::get('api_auth_token');
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
				<div class="row">
					<div class="col-xl-9 col-lg-8">
						@auth
							<div class="section3125">
								<h4 class="item_title">Recommended Courses</h4>
								<a href="" class="see150">See all</a>
								<div class="la5lo1">
									<div class="owl-carousel featured_courses owl-theme">
										@foreach ($featureCourses as $course)
											<div class="item">
												<div class="fcrse_1 mb-20">
													<a href="{{route('course_detail', ['id' => $course->id])}}" class="fcrse_img">
														<img src="{{asset('storage/'.$course->cover_url)}}" alt="">
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
																<span onclick="copyCourseUrl('{{route('course_detail', ['id' => $course->id])}}','{{$course->id}}')"><i class='uil uil-share-alt'></i>Share</span>
																<span onclick="addToCart('{{$course->id}}')"><i class="uil uil-shopping-cart-alt"></i>Add to cart</span>
																<form id="cart_form_{{$course->id}}" action="{{route('cart')}}" method="POST">
																	<input type="hidden" value="{{$course->id}}" name="course_id">
																	@csrf
																</form>
																<span><i class='uil uil-ban'></i>Not Interested</span>
																<span><i class="uil uil-windsock"></i>Report</span>
															</div>																										
														</div>
														<div class="vdtodt">
															<span class="vdt14">{{formatCounting($course->preview_count,'view')}}</span>
															<span class="vdt14">{{$course->created_at->diffForHumans()}}</span>
														</div>
														<a href="{{route('course_detail', ['id' => $course->id])}}" class="crse14s"> {{$course->title}} </a>
														<a href="{{route('courses')}}?category_id={{$course->category_id}}" class="crse-cate">
															{{$course->category->title}} <i class="uil uil-arrow-right"></i> {{$course->sub_category->title}} <i class="uil uil-arrow-right"></i>  {{$course->topic->title}}
														</a>
														<div class="auth1lnkprce">
															<p class="cr1fot">By <a href="{{route('instructor_detail',['id'=>$course->instructor->id])}}">{{$course->instructor->user->name}}</a></p>
															<div class="prce142">{{$course->fee}} <span>MMK</span></div>
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
						@endauth
						<div class="section3125">
							<h4 class="item_title">Featured Courses</h4>
							<a href="" class="see150">See all</a>
							<div class="la5lo1">
								<div class="owl-carousel featured_courses owl-theme">
									@foreach ($featureCourses as $course)
										<div class="item">
											<div class="fcrse_1 mb-20">
												<a href="{{route('course_detail', ['id' => $course->id])}}" class="fcrse_img">
													<img src="{{asset('storage/'.$course->cover_url)}}" alt="">
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
															<span onclick="copyCourseUrl('{{route('course_detail', ['id' => $course->id])}}','{{$course->id}}')"><i class='uil uil-share-alt'></i>Share</span>
															<span onclick="addToCart('{{$course->id}}')"><i class="uil uil-shopping-cart-alt"></i>Add to cart</span>
															<form id="cart_form_{{$course->id}}" action="{{route('cart')}}" method="POST">
																<input type="hidden" value="{{$course->id}}" name="course_id">
																@csrf
															</form>
															<span><i class="uil uil-windsock"></i>Report</span>
														</div>																										
													</div>
													<div class="vdtodt">
														<span class="vdt14">{{formatCounting($course->preview_count,'view')}}</span>
														<span class="vdt14">{{$course->created_at->diffForHumans()}}</span>
													</div>
													<a href="{{route('course_detail', ['id' => $course->id])}}" class="crse14s"> {{$course->title}} </a>
													<a href="{{route('courses')}}?category_id={{$course->category_id}}" class="crse-cate">
														{{$course->category->title}} <i class="uil uil-arrow-right"></i> {{$course->sub_category->title}} <i class="uil uil-arrow-right"></i>  {{$course->topic->title}}
													</a>
													<div class="auth1lnkprce">
														<p class="cr1fot">By <a href="{{route('instructor_detail',['id'=>$course->instructor->id])}}">{{$course->instructor->user->name}}</a></p>
														<div class="prce142">{{$course->fee}} <span>MMK</span></div>
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
												<a href="{{route('course_detail', ['id' => $course->id])}}" class="fcrse_img">
													<img src="{{asset('storage/'.$course->cover_url)}}" alt="">
													<div class="course-overlay">
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
															<span onclick="copyCourseUrl('{{route('course_detail', ['id' => $course->id])}}','{{$course->id}}')"><i class='uil uil-share-alt'></i>Share</span>
															<span onclick="addToCart('{{$course->id}}')"><i class="uil uil-shopping-cart-alt"></i>Add to cart</span>
															<form id="cart_form_{{$course->id}}" action="{{route('cart')}}" method="POST">
																<input type="hidden" value="{{$course->id}}" name="course_id">
																@csrf
															</form>
															<span><i class="uil uil-windsock"></i>Report</span>
														</div>																											
													</div>
													<div class="vdtodt">
														<span class="vdt14">{{formatCounting($course->preview_count,'view')}}</span>
														<span class="vdt14">{{$course->created_at->diffForHumans()}}</span>
													</div>
													<a href="{{route('course_detail', ['id' => $course->id])}}" class="crse14s"> {{$course->title}} </a>
													<a href="{{route('courses')}}?category_id={{$course->category_id}}" class="crse-cate">
														{{$course->category->title}} <i class="uil uil-arrow-right"></i> {{$course->sub_category->title}} <i class="uil uil-arrow-right"></i>  {{$course->topic->title}}
													</a>
													<div class="auth1lnkprce">
														<p class="cr1fot">By <a href="{{route('instructor_detail',['id'=>$course->instructor->id])}}">{{$course->instructor->user->name}}</a></p>
														<div class="prce142">{{$course->fee}} <span>MMK</span></div>
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
						@guest
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
						@endguest
						<div class="section3125 mt-50">
							<h4 class="item_title">Popular Instructors</h4>
							<a href="{{route('instructors')}}" class="see150">See all</a>
							<div class="la5lo1">
								<div class="owl-carousel top_instrutors owl-theme">
									@foreach ($popularInstructors as $instructor)
										<div class="item">
											<div class="fcrse_1 mb-20">
												<div class="tutor_img">
													<a href="{{route('instructor_detail',['id'=>$instructor->id])}}"><img src="{{asset('storage/'.$instructor->user->image_url)}}" alt=""></a>												
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
														@foreach ($instructor->user->social_contacts as $contact)
															<li><a href="{{$contact->link}}" style="margin-top:-10px;"> <?= $contact->social_media->web_icon ?> </a></li>
														@endforeach
														
													<div class="tut1250">
														<span class="vdt15">{{formatCounting($instructor->student_enroll,' Student')}}</span>
														<span class="vdt15">
															@php
																$courseCount = $instructor->total_course;
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
									<a href="{{route('instructor_detail',['id'=>1])}}" class="prfle12link">Go To Profile</a>
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
									@foreach ($top_categories as $category)
										<li><a href="{{route('courses')}}?category_id={{$category->id}}" class="ct_item"><?= $category->web_icon ?> {{$category->title}}</a></li>
									@endforeach
								  
								</ul>
							</div>
							<div class="strttech120">
								<h4>Become an Instructor</h4>
								<p>Top instructors from around the world teach millions of students on Cursus. We provide the tools and skills to teach what you love.</p>
								<button class="Get_btn" onclick="window.location.href = '{{route('teach-on')}}';">Start Teaching</button>
							</div>
						</div>
					</div>
				
					<div class="col-xl-12 col-lg-12">
						<div class="section3125 mt-30">
							<h4 class="item_title">What Our Student Have Today</h4>
							<div class="la5lo1">
								<div class="owl-carousel Student_says owl-theme">
									@foreach ($reviews as $review)
										<div class="item">
											<div class="fcrse_4 mb-20">
												<div class="say_content" style="margin-bottom: 10px;">
													<p>"{{$review->body}}"</p>
												</div>
												<div class="st_group">
													<div class="stud_img" >
														<img src="images/left-imgs/img-4.jpg" alt="" style="width:35px;height:35px;">												
													</div>
													<h4>{{$review->user->name}}</h4>
												</div>	
												
												<div class="st_group review_course">
													<a href="{{route('course_detail', ['id' => $review->course->id])}}" style="display: flex;width:100%;">
														<div class="stud_img">
															<i class="uil uil-play-circle" style="font-size:20px;"></i>									
														</div>
														<h5 style="margin:0px;"> {{$review->course->title}} </h5>
													</a>
													
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
		
	<script>

		console.log(navigator.userAgent);

		const apiToken = "{{$api_token}}";

		function addToCart(courseId){
			document.getElementById('cart_form_'+courseId).submit();
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
	  
	</script>

@endsection
