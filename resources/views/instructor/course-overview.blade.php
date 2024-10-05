	@php
    	$api_token = Cookie::get('api_auth_token');
		$user = Auth::user();
		if (!function_exists('calculateHour')) {
			function calculateHour($min){
				$hr = $min/60;
				$hr = floor($hr);
				return $hr;
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
											<h3 class="title"><i class="uil uil-analytics"></i> Overview</h3>
										</div> 
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<div class="section3125">			
									<div class="row justify-content-center">
										<div class="col-12">
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
											<div class="_215b05">										
												30-Day Money-Back Guarantee
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


			$(document).ready(()=>{
				

			})

		
		<script src="{{asset('js/util.js')}}"></script>

	</div>
	<!-- Body End -->
	@endsection

	


	