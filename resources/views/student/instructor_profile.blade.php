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

if (!function_exists('formatCount')) {
	function formatCount($count){

		if($count<=1){
			return $count;
		}else if($count>1 && $count<1000){
			return $count;
		}else if($count>=1000 && $count<1000000){
			return floor($count/1000).'k';
		}else{
			return floor($count/1000000).'M';
		}
	}
}

    $api_token = Cookie::get('api_auth_token');

	
	$student_enrolled =0;
	$review_count = 0;
	if(isset($instructor->courses)){
		$courses = $instructor->courses;
		foreach ($courses as $key => $course) {
		# code...
			$student_enrolled+=$course->enroll_count;
			$review_count +=$course->rating_count;
		}
	}

	$user = Auth::user();

@endphp


@extends('student.components.master')
@section('content')
	<style>
		._htg452 ul{
			list-style-type: disc;
			margin-inline-start: 20px;
		}

		 .my-table td{
            padding:5px;
        }

	</style>
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
									@auth
										@if ($user->id == $instructor->user->id)
											<a href="{{route('instructor.profile.edit')}}" class="_216b22">										
												<span><i class="uil uil-edit"></i></span>Edit Profile
											</a>
										@else
											<a href="#" class="_216b22">										
												<span><i class="uil uil-windsock"></i></span>Report Profile
											</a>
										@endif
									@endauth
									<div class="dp_dt150">						
										<div class="img148">
											<img src="{{asset('storage/'.$instructor->user->image_url)}}" alt="">										
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

								</div>
								<div class="col-lg-5">
									@auth
										@if ($user->id == $instructor->user->id)
											<a href="{{route('instructor.profile.edit')}}" class="_216b12">										
												<span><i class="uil uil-edit"></i></span>Edit Profile
											</a>
										@else
											<a href="#" class="_216b12">										
												<span><i class="uil uil-windsock"></i></span>Report Profile
											</a>
										@endif
									@endauth
									
									<div class="rgt-145">
										<ul class="tutor_social_links">
											@foreach ($instructor->user->social_contacts as $contact)
												<li><a href="{{$contact->link}}"> <?= $contact->social_media->web_icon ?> </a> </li>
											@endforeach
										</ul>
									</div>
									@auth
										@if ($user->id != $instructor->user->id)
											<ul class="_bty149">
												<li>
													<form action="{{route('instructor.subscribe',['id'=>$instructor->id])}}" method="POST">
													@csrf
														@if ($subscribed)
															<button type="submit" class="subscribe-btn btn500" style="border-radius:15px;background:#efeeff;color:#475692">
																<span><i class='uil uil-bell'></i> Subscribed</span>
															</button>
														@else
															<button type="submit" class="subscribe-btn btn500">Subscribe</button>
														@endif
													</form>
													
												</li>								
												<li>
													@if ($subscribed)
														<button class="msg125 btn500" style="border-radius:15px;background:#333">Message</button>
													@else
														<button class="msg125 btn500">Message</button>
													@endif
												</li>								
											</ul>
										@endif
									@else
										<ul class="_bty149">
											<li>
												<form action="{{route('instructor.subscribe',['id'=>$instructor->id])}}" method="POST">
												@csrf
													@if ($subscribed)
														<button type="submit" class="subscribe-btn btn500" style="border-radius:15px;background:#efeeff;color:#475692">
															<span><i class='uil uil-bell'></i> Subscribed</span>
														</button>
													@else
														<button type="submit" class="subscribe-btn btn500">Subscribe</button>
													@endif
												</form>
												
											</li>								
											<li>
												@if ($subscribed)
													<button class="msg125 btn500" style="border-radius:15px;background:#333">Message</button>
												@else
													<button class="msg125 btn500">Message</button>
												@endif
											</li>								
										</ul>
									@endauth
								</div>	


                                <div class="col-lg-6 col-md-6">
                                    <table class="my-table" style="margin-top:20px;color:white">

										<tr>
                                            <td> <i class="uil uil-envelope"></i></i> Email</td>
                                            <td>{{$instructor->user->email}}</td>
                                        </tr>
                                        <tr>
                                            <td> <i class="uil uil-phone-alt"></i> Phone</td>
                                            <td>{{$instructor->user->phone}}</td>
                                        </tr>

                                        <tr>
                                            <td> <i class="uil uil-mars"></i> Gender</td>
                                            <td>{{$instructor->user->gender}}</td>
                                        </tr>
                                        <tr>
                                            <td> <i class="uil uil-calendar-alt"></i> Birth on</td>
                                            <td>{{$instructor->user->brith_date}}</td>
                                        </tr>

										<tr>
                                            <td> <i class="uil uil-home-alt"></i> Address</td>
                                            <td>{{$instructor->user->address}}</td>
                                        </tr>

                                    </table>
                                </div>

								<div class="col-lg-6 col-md-6">
                                    <table class="my-table" style="margin-top:20px;color:white">
										<tr>
                                            <td> <i class="uil uil-book"></i></i> Courses</td>
                                            <td>{{$courses->count()}}</td>
                                        </tr>

                                        <tr>
                                            <td> <i class="uil uil-graduation-hat"></i></i> Students</td>
                                            <td>{{formatCount($student_enrolled)}}</td>
                                        </tr>

										<tr>
                                            <td> <i class="uil uil-bell"></i></i> Subscribers</td>
                                            <td>{{formatCount($instructor->Subscribers->count())}}</td>
                                        </tr>

										<tr>
                                            <td> <i class="uil uil-star"></i></i> Reviews</td>
                                            <td>{{formatCount($review_count)}}</td>
                                        </tr>
										
                                    </table>
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
									<a class="nav-item nav-link" id="nav-purchased-tab" data-toggle="tab" href="#nav-purchased" role="tab" aria-selected="false">Purchased</a>
									<a class="nav-item nav-link" id="nav-reviews-tab" data-toggle="tab" href="#nav-reviews" role="tab" aria-selected="false">Blog</a>
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
											<p><div><?= $instructor->about ?></div></p>
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
								</div>

								<div class="tab-pane fade show" id="nav-purchased" role="tabpanel">
									<div class="_htg451">
										<div class="_htg452">
											 @if (count($instructor->user->saved_courses)>1) 
												<h3>Purchased Courses</h3>
												<div class="row">
													@foreach ($instructor->user->saved_courses as $myCourse)
														@php
															$course = $myCourse->course;
														@endphp
														<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
															@include('student.components.item-course')
														</div>
													@endforeach
												
												</div>
											@else
												<div style="text-align: center;color:#888">
													<br><br><br><br><br>
													<i style="font-size:80px;" class="uil uil-book"></i><br><br>
													<span style="font-size: 20px;">No purchased course</span>
													<br><br><br><br><br>
												</div>
											@endif
											 
										</div>																	
									</div>							
								</div>
								<div class="tab-pane fade" id="nav-reviews" role="tabpanel">
									<div class="student_reviews">
										<div class="row">
											<div class="col-lg-12">
												<div class="review_right">
													<div class="review_right_heading">
														<h3>instructor's Blog</h3>
													</div>
												</div>
												 
												<div class="">
													<div class="row">
														<div class="col-12" id="blog_container">
															
														</div>
													</div>
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

	<script src="{{asset('js/util.js')}}"></script>
	<script>
		const apiToken = "{{$api_token}}";
		const instructor = @json($instructor);

		let is_fetching = false;
		let arr = [];
		let fetch_url = `{{asset("")}}api/instructors/${instructor.id}/blogs?page=1`;
		let delete_blog_id = 0;
		$(document).ready(()=>{
	
			fetchBlog();

			$(window).scroll(()=>{
				if($(window).scrollTop() + $(window).height() > $(document).height() - 500) {
					if(!is_fetching){
						fetchBlog();
					}
				}
			});

		})

		function fetchBlog(){
			is_fetching = true;
			$('#shimmer').show();
			if(fetch_url==null){
				$('#shimmer').hide();
				return;
			}
			$.ajax({
				url: fetch_url,
				type: 'GET', // or 'GET' depending on your request
				headers: {
					'Authorization': 'Bearer '+apiToken // Example for Authorization header
				},
				
				success: function(res) {
					is_fetching=false;
					if(res){
						fetch_url = res.next_page_url;
						let blogs = res.data;
						setBlogs(blogs);
						
					}
				},
				error: function(xhr, status, error) {
					console.error('Error:', status, error);
				}
			});
		}

		function setBlogs(blogs){
			$('#shimmer').hide();
			blogs.map((blog,index)=>{
				arr.push(blog);	
				$('#blog_container').append(blogComponent(blog));
			})

			if(arr.length==0){
				$('#blog_container').html(`
					<div style="text-align: center;color:#888">
						<br><br><br><br><br>
						<i style="font-size:80px;" class="uil uil-blogger-alt"></i><br><br>
						<span style="font-size: 20px;">No blog.</span>
						<br><br><br><br><br>
					</div>
				`)
			}
		}

		function blogComponent(blog){
			let cover_photo = "";
			if(blog.image_url != ""){
				cover_photo = `
					<a href="blog_single_view.html" class="hf_img">
						<img src="{{asset('storage')}}/${blog.image_url}" alt="">
						<div class="course-overlay"></div>
					</a>
				`;
			}
			let url = `{{asset("")}}instructors/${instructor.id}/blogs/${blog.id}`;
			return `
				
				<div class="blogbg_1 mt-30">
					${cover_photo}
					<div class="hs_content">
						<div class="vdtodt">
							<span class="vdt14">${formatCounting(blog.view_count,'view')}</span>
							<span class="vdt14">${formatDateTime(new Date(blog.created_at))}</span>
						</div>
						<a href="${url}" class="crse14s title900">${blog.title}</a>
						<p class="blog_des">${blog.summary}</p>
						<a href="${url}" class="view-blog-link">Read More<i class="uil uil-arrow-right"></i></a>
					</div>
				</div>
			`;
		}

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
		