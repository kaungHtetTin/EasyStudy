	@php
    	$api_token = Cookie::get('api_auth_token');
		$user = Auth::user();

		$reviews = $course->reviews;

		if (!function_exists('calculatePercent')) {
			function calculatePercent($star_count,$total_star){
				if($total_star==0) return 0;
				return floor(($star_count/$total_star)*100);
			}
		}


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


    @endphp
    @extends('instructor.master')

	@section('content')

    <style>
        .error{
            color:red;
			display: none;
        }

		._215b05{
			padding:5px;
		}

		.rating-star1 {
			font-size: 1rem;
			width: 1rem;
			height: 1rem;
			position: relative;
			display: inline-block;
		}

    </style>

	<div class="wrapper">
		<div class="sa4d25">
            <div class="container">	
				<div style="position: relative; display:flex">
					<div style="flex:1">
						@if (session('msg'))
							<div class="alert alert-success">
								{{session('msg')}}
							</div>
						@endif
						<div class="row">
							<div class="col-12">
								<div class="step-tab-panel step-tab-gallery" id="tab_step2">
									<div class="tab-from-content">
										<div class="title-icon">
											<h3 class="title"><i class="uil uil-star"></i> Reviews</h3>
										</div>
										
										<div>
											<div class="_215b03">
												<h2>{{$course->title}}</h2>
												<span class="_215b04">{{$course->category->title}} <i class="uil uil-arrow-right"></i> {{$course->sub_category->title}} <i class="uil uil-arrow-right"></i>  {{$course->topic->title}}</span>
											</div>
											                                           
										</div>
										
										<div class="student_reviews" style="">
											<div class="reviews_left">
												<h3>Student Feedback</h3>
												<div class="row _rate003">
													<div class="col-lg-3 col-md-5 col-sm-6"  style="">
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
													<div class="col-lg-9 col-md-7 col-sm-6">
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
											<div class="reviews_left" style="margin-top: 5px;">
												<h3>Reviews</h3>
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
					@include('instructor.components.course-menu-drawer')
				</div>

			</div>
		</div>
		@include('instructor.components.footer')

		<script>

			const apiToken = "{{$api_token}}";
			const course = @json($course);
        	const user = @json($user);

			let is_review_fetching = false;
			let reviewArr = [];
			let fetch_review_url = `/api/courses/${course.id}/reviews`

			$(document).ready(()=>{
				adjustLayout2();
				fetchReviews();

				$(window).scroll(()=>{
					if($(window).scrollTop() + $(window).height() > $(document).height() - 500) {
						if(!is_review_fetching){
							fetchReviews();
						}
					}
				});

			})

			function adjustLayout2(){
				var w = window.innerWidth;
				if(w<=768){
					$('#course_rating_text1').show();
					$('#course_rating_text2').hide();
				}else{
					$('#course_rating_text1').hide();
					$('#course_rating_text2').show();
				}
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
							<img src="{{asset('')}}storage/${review.user.image_url}" alt="">
							<div class="rv1458">
								<h4 class="tutor_name1">${review.user.name}</h4>
								<span class="time_145">${formatDateTime(new Date(review.created_at))}</span>
							</div>
						</div>
						<div class="rating-box mt-20">
							${star}
						</div>
						<p class="rvds10">${review.body}</p>
						<br>
					</div> 
				`;
			}

		</script>
		<script src="{{asset('js/util.js')}}"></script>

	</div>
	<!-- Body End -->
	@endsection

	


	