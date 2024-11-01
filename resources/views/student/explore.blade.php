@extends('student.components.master')

@php
    $api_token = Cookie::get('api_auth_token');
    $user = Auth::user();
@endphp


@section('content')
    <div class="wrapper">
		<div class="sa4d25">
			<div class="container-fluid">			
				<div class="row">
					<div class="col-xl-12 col-lg-8">
						<div class="section3125">
							<div class="explore_search">
								<div class="ui search focus">
									<div class="ui left icon input swdh11">
										<input id="input_search" class="prompt srch_explore" type="text" placeholder="Enter a course title, category, subcategory or topic">
										<i class="uil uil-search-alt icon icon2"></i>
									</div>
								</div>
							</div>							
						</div>							
					</div>
					<div class="col-md-12">
						<div class="_14d25">
							<div class="row" id="course_container">
							 
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

	<script src="{{asset('js/class/course.js')}}"></script>
	<script src="{{asset('js/class/adapter.js')}}"></script>

	<script>
		let Context = {};
		Context.apiToken = apiToken;
		Context.csrf = `@csrf`;
		Context.rootDir = "{{asset('')}}";

		let is_fetching = false;
		let arr = [];
		let fetch_url = `{{asset("")}}api/courses?page=1`

		$(document).ready(()=>{
	
				fetchCourse();

				$(window).scroll(()=>{
					if($(window).scrollTop() + $(window).height() > $(document).height() - 500) {
						if(!is_fetching){
							fetchCourse();
						}
					}
				});

				$('#input_search').on('keyup',(x)=>{
					const search_str = $('#input_search').val();

					if(x.key === "Enter" || x.key === " " || search_str==="" ){
						fetch_url = `{{asset("")}}api/courses/search?q=${search_str}`
						if(search_str==""){
							fetch_url = `{{asset("")}}api/courses?page=1`
						}
						arr = [];
						$('#shimmer').show();
						fetchCourse(true);
					}

				})

			})

			function fetchCourse(search = false){
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
						'Authorization': 'Bearer '+Context.apiToken // Example for Authorization header
					},
					
					success: function(res) {
						is_fetching=false;
						if(res){
							fetch_url = res.next_page_url;
							if(fetch_url !=null) fetch_url+= "&q="+$('#input_search').val();
							let courses = res.data;
							if(search) $('#course_container').html("");
							setCourses(courses);
							
						}
					},
					error: function(xhr, status, error) {
						if(xhr.status==401){
							location.href="{{asset('')}}logout";
						}
					}
				});
			}

			function setCourses(courses){
				$('#shimmer').hide();
				courses.map((course,index)=>{
					arr.push(course);	
					let courseComponent = new CourseComponent(Context,course);
					$('#course_container').append(`
						<div class="col-lg-4 col-md-4">
							${courseComponent.view}
						</div>
					`);
					courseComponent.initializeCallback();
					 
				})

				if(arr.length==0){
					$('#course_container').html(`
						<div style="text-align: center;color:#888">
							<br><br><br><br><br>
							<i style="font-size:80px;" class="uil uil-bell"></i><br><br>
								<span style="font-size: 20px;">No course</span>
							<br><br><br><br><br>
						</div>
					`)
				}
			}
	</script>
@endsection