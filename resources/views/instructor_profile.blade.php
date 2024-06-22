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


@extends('layouts.master')
@section('content')

@auth
<div class="wrapper _bg4586">
@else
<div style="padding-top:60px;">
@endauth
		<div class="_216b01">
			<div class="container">			
				<div class="row justify-content-md-center">
					<div class="col-md-10">
						<div class="section3125 rpt145">							
							<div class="row">						
								<div class="col-lg-7">
									<a href="#" class="_216b22">										
										<span><i class="uil uil-windsock"></i></span>Report Profile
									</a>
									<div class="dp_dt150">						
										<div class="img148">
											<img src="images/left-imgs/img-1.jpg" alt="">										
										</div>
										<div class="prfledt1">
											<h2>{{$instructor->user->name}}</h2>
											<span>
												@foreach ($instructor->categories as $index=> $category)
														@if ($index>0)
															&amp;
														@endif
													{{$category->title}} 
												@endforeach
											</span>
										</div>										
									</div>
									<ul class="_ttl120">
										<li>
											<div class="_ttl121">
												<div class="_ttl122">Enroll Students</div>
												<div class="_ttl123">612K</div>
											</div>
										</li>
										<li>
											<div class="_ttl121">
												<div class="_ttl122">Courses</div>
												<div class="_ttl123">{{$instructor->courses->count()}}</div>
											</div>
										</li>
										<li>
											<div class="_ttl121">
												<div class="_ttl122">Reviews</div>
												<div class="_ttl123">115K</div>
											</div>
										</li>
										<li>
											<div class="_ttl121">
												<div class="_ttl122">Subscribers</div>
												<div class="_ttl123">452K</div>
											</div>
										</li>
									</ul>
								</div>
								<div class="col-lg-5">
									<a href="#" class="_216b12">										
										<span><i class="uil uil-windsock"></i></span>Report Profile
									</a>
									<div class="rgt-145">
										<ul class="tutor_social_links">
											<li><a href="#" class="fb"><i class="fab fa-facebook-f"></i></a></li>
											<li><a href="#" class="tw"><i class="fab fa-twitter"></i></a></li>
											<li><a href="#" class="ln"><i class="fab fa-linkedin-in"></i></a></li>
											<li><a href="#" class="yu"><i class="fab fa-youtube"></i></a></li>
										</ul>
									</div>
									<ul class="_bty149">
										<li><button class="subscribe-btn btn500">Subscribe</button></li>								
										<li><button class="msg125 btn500">Message</button></li>								
									</ul>
									
								</div>													
							</div>							
						</div>							
					</div>															
				</div>
			</div>
		</div>
		<div class="_215b15">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">						
						<div class="course_tabs">
							<nav>
								<div class="nav nav-tabs tab_crse" id="nav-tab" role="tablist">
									<a class="nav-item nav-link active" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-selected="true">About</a>
									<a class="nav-item nav-link" id="nav-courses-tab" data-toggle="tab" href="#nav-courses" role="tab" aria-selected="false">Courses</a>
									<a class="nav-item nav-link" id="nav-reviews-tab" data-toggle="tab" href="#nav-reviews" role="tab" aria-selected="false">Discussion</a>
								</div>
							</nav>						
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="_215b17">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="course_tab_content">
							<div class="tab-content" id="nav-tabContent">
								<div class="tab-pane fade show active" id="nav-about" role="tabpanel">
									<div class="_htg451">
										<div class="_htg452">
											<h3>About Me</h3>
											<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum scelerisque nibh sed ligula blandit, quis faucibus lorem pellentesque. Suspendisse pulvinar dictum pellentesque. Vestibulum at sagittis lectus, sit amet aliquam turpis. In quis elit tempus, semper justo vitae, lacinia massa. Etiam sagittis quam quis fermentum lacinia. Curabitur blandit sapien et risus congue viverra. Mauris auctor risus sit amet cursus sollicitudin. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla feugiat sodales massa, in viverra dolor condimentum ut. In imperdiet, justo nec volutpat blandit, tellus justo tempor quam, sed pretium nibh nunc nec mauris. Mauris vel malesuada magna. Quisque iaculis molestie purus, non luctus mauris porta id. Maecenas imperdiet tincidunt mauris vestibulum vulputate. Aenean sollicitudin pretium nibh, et sagittis risus tincidunt ac. Phasellus scelerisque rhoncus massa, ac euismod massa pharetra non. Phasellus dignissim, urna in iaculis varius, turpis libero mollis velit, sit amet euismod arcu mi ac nibh. Praesent tincidunt eros at ligula pellentesque elementum. Fusce condimentum enim a tellus egestas, sit amet rutrum elit gravida. Pellentesque in porta sapien. Fusce tristique maximus ipsum et mollis. Sed at massa ac est dapibus vulputate at eu nibh.</p>
										</div>																	
									</div>							
								</div>
								<div class="tab-pane fade" id="nav-courses" role="tabpanel">
									<div class="crse_content">
										<h3>My courses ({{$instructor->courses->count()}})</h3>
										<div class="_14d25">
											<div class="row">
												@foreach ($instructor->courses as $course)
													<div class="col-lg-4 col-md-4">
														<div class="fcrse_1 mb-30">
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
								</div>
								<div class="tab-pane fade" id="nav-reviews" role="tabpanel">
									<div class="student_reviews">
										<div class="row">
											<div class="col-lg-12">
												<div class="review_right">
													<div class="review_right_heading">
														<h3>Discussions</h3>
													</div>
												</div>
												<div class="cmmnt_1526">
													<div class="cmnt_group">
														<div class="img160">
															<img src="images/left-imgs/img-1.jpg" alt="">										
														</div>
														<textarea class="_cmnt001" placeholder="Add a public comment"></textarea>
													</div>
													<button class="cmnt-btn" type="submit">Comment</button>
												</div>
												<div class="review_all120">
													<div class="review_item">
														<div class="review_usr_dt">
															<img src="images/left-imgs/img-1.jpg" alt="">
															<div class="rv1458">
																<h4 class="tutor_name1">John Doe</h4>
																<span class="time_145">2 hour ago</span>
															</div>
															<div class="eps_dots more_dropdown">
																<a href="#"><i class="uil uil-ellipsis-v"></i></a>
																<div class="dropdown-content">
																	<span><i class='uil uil-comment-alt-edit'></i>Edit</span>
																	<span><i class='uil uil-trash-alt'></i>Delete</span>
																</div>																											
															</div>
														</div>
														<p class="rvds10">Nam gravida elit a velit rutrum, eget dapibus ex elementum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Fusce lacinia, nunc sit amet tincidunt venenatis.</p>
														<div class="rpt101">
															<a href="#" class="report155"><i class='uil uil-thumbs-up'></i> 10</a>
															<a href="#" class="report155"><i class='uil uil-thumbs-down'></i> 1</a>
															<a href="#" class="report155"><i class='uil uil-heart'></i></a>
															<a href="#" class="report155 ml-3">Reply</a>
														</div>
													</div>
													<div class="review_reply">
														<div class="review_item">
															<div class="review_usr_dt">
																<img src="images/left-imgs/img-3.jpg" alt="">
																<div class="rv1458">
																	<h4 class="tutor_name1">Rock Doe</h4>
																	<span class="time_145">1 hour ago</span>
																</div>
																<div class="eps_dots more_dropdown">
																	<a href="#"><i class="uil uil-ellipsis-v"></i></a>
																	<div class="dropdown-content">
																		<span><i class='uil uil-trash-alt'></i>Delete</span>
																	</div>																											
																</div>
															</div>
															<p class="rvds10">Fusce lacinia, nunc sit amet tincidunt venenatis.</p>
															<div class="rpt101">
																<a href="#" class="report155"><i class='uil uil-thumbs-up'></i> 4</a>
																<a href="#" class="report155"><i class='uil uil-thumbs-down'></i> 2</a>
																<a href="#" class="report155"><i class='uil uil-heart'></i></a>
																<a href="#" class="report155 ml-3">Reply</a>
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
		</div>
	</div>

	<script>
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
		