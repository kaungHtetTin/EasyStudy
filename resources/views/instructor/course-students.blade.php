	@php
		$user = Auth::user();
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

		.user_menu_btn{
			padding:5px;
			font-size:12px;
			float:right;
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
											<h3 class="title"><i class="uil uil-graduation-hat"></i> Students Enrolled</h3>
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
										</div>							
									</div>							
								</div>							
							</div>															
						</div>

						<div id="student_container" style="margin-top: 20px;">
							
							  
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
					@include('instructor.components.course-menu-drawer')
				</div>

			</div>
		</div>
		@include('instructor.components.footer')

		<script>
			const course = @json($course);
        	const user = @json($user);

			let is_fetching = false;
			let arr = [];
			let fetch_url = `{{asset("")}}instructor-dashboard/api/courses/${course.id}/students`

			$(document).ready(()=>{
	
				fetchStudents();

				$(window).scroll(()=>{
					if($(window).scrollTop() + $(window).height() > $(document).height() - 500) {
						if(!is_fetching){
							fetchStudents();
						}
					}
				});

			})

			function fetchStudents(){
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
							let students = res.data;
							setStudents(students);
							console.log(students);
						}
					},
					error: function(xhr, status, error) {
						console.error('Error:', status, error);
					}
				});
			}

			function setStudents(students){
				$('#shimmer').hide();
				students.map((student,index)=>{
					arr.push(student);	
					$('#student_container').append(studentComponent(student));
				})
			}

			function studentComponent(student){
				let approve_btn ="";
				if(student.verified==0){
					approve_btn = `<button onclick="approve(${student.user.id})" class="st_download_btn user_menu_btn" >Approved <i class="uil uil-check-circle"></i></button>`;
				}
				return `
					<div class="fcrse_1">
						<a href="{{asset('')}}instructor-dashboard/courses/${course.id}/students/${student.user.id}">
							<div class="review_usr_dt">
								<img src="{{asset('')}}storage/${student.user.image_url}" alt="">
								<div class="rv1458">
									<h4 class="tutor_name1">${student.user.name}</h4>
									<span class="time_145">Joined . ${formatDateTime(new Date(student.created_at))}</span>
									
								</div>
							</div>
						</a>
						<div>
							${approve_btn}
							<button class="st_download_btn user_menu_btn" >Call <i class="uil uil-phone-alt"></i></button>
						</div>
					</div> 
				
				`;
			}

			function approve(student_id){
				let url = `{{asset("")}}instructor-dashboard/courses/${course.id}/students/${student_id}/approve`;
				window.location.href=url;
			}
	</script>
	<script src="{{asset('js/util.js')}}"></script>
	</div>
	<!-- Body End -->
	@endsection

	


	