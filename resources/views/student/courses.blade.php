@php

	if(isset(request()->topic_ids))$topic_ids = request()->topic_ids;
	$api_token = Cookie::get('api_auth_token');
	
@endphp

@extends('student.components.master')


@section('content')

	<style>

		.sub_category{
			padding:3px 10px 3px 10px;
			border:1px solid black;
			margin-right:10px;
			border-radius:2px;
			display: inline-block
		}

		.sub_category:hover{
			cursor: pointer;
			background:#475692;
			color:white;
		}

		.sub_category_active{
		 	padding:7px 10px 7px 10px;
			border:1px solid black;
			margin-right:10px;
			background:#475692;
			color:white;
			border-radius:2px;
			display: inline-block
		}

		.sub_category_active:hover{
		 	padding:7px 10px 7px 10px;
			cursor: pointer;
			border:1px solid black;
			margin-right:10px;
			background:#475692;
			color:white;

		}

		.scroll-container {
            width: 100%; /* Set a fixed width for the container */
            overflow-x: auto;
            white-space: nowrap;
        }


		.btn-menu{
            cursor: pointer;
            position: fixed;
            right:20px;
            top:70px;
            padding:10px;
            background: #475692;
            color:white;
            border-radius: 30px;
            z-index: 1000;
            font-size:24px;
            transition: all 0.3s ease-out;
        }

		.right_drawer {
            width: 300px;
            transition: all 0.3s ease-out;
        }

        .right_drawer_closed {
            position: fixed;
            right: 0;
            width: 0px;
            transition: all 0.3s ease-out;
        }

        .right_drawer_opened {
            position: fixed;
            right: 0;
            width: 300px;
            z-index: 500;
            background:#fff;
            transition: all 0.3s ease-out;
			margin-bottom:100px;
			overflow:auto;
			height: 100%;
        }


	</style>
    @auth
	<div class="wrapper">
	@else
	<div style="padding-top:60px;">
	@endauth
		<div class="sa4d25">
			<div class="container-fluid">	
				<span class="btn-menu" id="btn-drawer-toggle">
					<i class='uil  uil-angle-down'></i>
				</span>		
				<div class="row">
					<div class="col-10">
						<div class="mCustomScrollbar">
							@guest
								<br>
							@endguest
							@foreach ($sub_categories as $key=>$sub_category)
								<span style="margin-top:7px;" onclick="sub_category_click({{$sub_category->id}})" class="{{$sub_category_id==$sub_category->id ? 'sub_category_active':'sub_category'}}"> {{$sub_category->title}} </span>
							@endforeach
						</div>
					</div>			
				</div>
				<div style="position: relative;display:flex">
					<div style="flex:1">
						<div class="_14d25">
							<div class="row" id="course_container">
								<div class="col-md-12">
									<br><br><br><br><br>
									<div class="main-loader mt-50">													
										<div class="spinner">
											<div class="bounce1"></div>
											<div class="bounce2"></div>
											<div class="bounce3"></div>
										</div>																										
									</div>
								</div>
							</div>				
						</div>				
					</div>	
			 
					<div class="right_drawer" id="drawer" style="display: none">
						<div style="padding-left:15px;padding-top:20px;position:relative">
							<div class="fcrse_1 mt-10">
								<div class="crse14s">
									Popular Topics
								</div>
									@foreach ($topics as $topic)
										<div class="ui checkbox mncheck">
											<input class="topic_inputs" type="checkbox" tabindex="0" class="hidden" value="{{$topic->id}}"
											@if (isset($topic_ids))
												@if (in_array($topic->id,$topic_ids))
													@checked(true)
												@endif
											@endif
											
											>
											<label>{{$topic->title}}</label>
										</div> <br>
									@endforeach
								<hr>
								
								<div class="crse14s">
									Rating
								</div>
									<div class="ui checkbox mncheck">
										<input class="rating_inputs" type="checkbox" tabindex="0" class="hidden" value="4.5">
										<label>Rating 4.5 & up</label>
									</div><br>
									<div class="ui checkbox mncheck">
										<input class="rating_inputs" type="checkbox" tabindex="0" class="hidden" value="4.0">
										<label>Rating 4.0 & up</label>
									</div><br>
									<div class="ui checkbox mncheck">
										<input class="rating_inputs" type="checkbox" tabindex="0" class="hidden" value="3.5">
										<label>Rating 3.5 & up</label>
									</div><br>
									<div class="ui checkbox mncheck">
										<input class="rating_inputs" type="checkbox" tabindex="0" class="hidden" value="3.0">
										<label>Rating 3.0 & up</label>
									</div>

								<hr>
								<div class="crse14s">
									Course Duration
								</div>
									<div class="ui checkbox mncheck">
										<input class="duration_inputs" type="checkbox" tabindex="0" class="hidden" value="0">
										<label>0 - 3 Hours</label>
									</div> <br>
									<div class="ui checkbox mncheck">
										<input class="duration_inputs" type="checkbox" tabindex="0" class="hidden" value="1">
										<label>3 - 10 Hours</label>
									</div><br>
									<div class="ui checkbox mncheck">
										<input class="duration_inputs" type="checkbox" tabindex="0" class="hidden" value="2">
										<label>10 - 20 Hours</label>
									</div><br>
									<div class="ui checkbox mncheck">
										<input class="duration_inputs" type="checkbox" tabindex="0" class="hidden" value="3">
										<label>20 and above</label>
									</div>
								<hr>
								
								<div class="crse14s">
									Level
								</div> 
										<div class="ui checkbox mncheck">
											<input id="all_level" type="checkbox" tabindex="0" class="hidden" value="all">
											<label>All levels</label>
										</div><br>
									@foreach ($levels as $level)
										<div class="ui checkbox mncheck">
											<input class="level_inputs" type="checkbox" tabindex="0" class="hidden" value="{{$level->id}}">
											<label>{{$level->level}}</label>
										</div><br>
									@endforeach
								<hr>
								<div class="crse14s">
									Price
								</div>
									<div class="ui checkbox mncheck">
										<input class="price_inputs" type="checkbox" tabindex="0" class="hidden" value="1">
										<label>Paid</label>
									</div><br>
									<div class="ui checkbox mncheck">
										<input class="duration_inputs" type="checkbox" tabindex="0" class="hidden" value="0">
										<label>Free</label>
									</div>

								<div class="crse14s" style="height:150px;" id="offset">
									 
								</div>
							</div>
						</div>
					</div>
						
			  
				</div>
			</div>
		</div>
	
	<script src="{{asset('js/class/course.js')}}"></script>
	<script>
		
		const courses = @json($courses);
		const categories =@json($categories);
		const sub_categories=@json($sub_categories);
		let Context = {};
		Context.apiToken = "{{$api_token}}";
		Context.csrf = `@csrf`;
		Context.rootDir = "{{asset('')}}";

		let small_screen;
        let toggle_open = false;


		let topic_ids = [];
		let intervals = [
			{initial:0,final:180},
			{initial:181,final:600},
			{initial:601,final:1200},
			{initial:1201,final:60000}
		];
		let durations = [];
		let ratings = [];


		console.log(courses);

		const current_link = "{{ route('courses') }}" + "?category_id={{request()->category_id}}";
		console.log(current_link);

		function sub_category_click(id) {
			window.location.href = current_link + "&sub_category_id=" + id;
		}

		$(document).ready(function() {
		
			const checkboxes = $('.topic_inputs');
			const durationBoxes = $('.duration_inputs');
			const ratingBoxes = $('.rating_inputs');

			checkboxes.on('change', function() {
				
				$('#course_container').html(setLoading());

				if ($(this).prop('checked')) {
					topic_ids.push($(this).val());
				} else {
					const index = topic_ids.indexOf($(this).val());
					if (index != -1) topic_ids.splice(index, 1);
				}

				setCourse(filtering());
			});

			durationBoxes.on('change',function(){
				if ($(this).prop('checked')) {
					const index = parseInt($(this).val());
					 
					durations.push(intervals[index]);
				} else {
					const index = durations.indexOf(intervals[parseInt($(this).val())]);
					if (index != -1) durations.splice(index, 1);
				}

				setCourse(filtering());
			});

			ratingBoxes.on('change',function(){
				if ($(this).prop('checked')) {
					ratings.push(parseFloat($(this).val()));
				} else {
					const index = ratings.indexOf(parseFloat($(this).val()));
					if (index != -1) ratings.splice(index, 1);
				}
			 
				setCourse(filtering());
			});

			 
			setCourse(courses);

			$('#btn-drawer-toggle').click(()=>{
                $('#drawer').css({'display':'block'});
                if(toggle_open) {
                    $('#drawer').attr('class','right_drawer_closed');
                    $('#btn-drawer-toggle').html(`<i class='uil  uil-angle-down'></i>`);
                    toggle_open=false;
                }else{
                    $('#drawer').attr('class','right_drawer_opened');
                    $('#btn-drawer-toggle').html(`<i class='uil  uil-angle-up'></i>`);
                    toggle_open=true;
                }
                
            });

			adjustLayout();
            $(window).on('resize', function() {
                adjustLayout();
            });


		});


		function filtering(){
			let topicCourses = [];

			courses.map(course=>{
				if(topic_ids.length>0){
					topic_ids.map(topic_id=>{
						if(course.topic_id==topic_id){
							topicCourses.push(course);
						}
					});
				}else{
					topicCourses.push(course);
				}
				
			});

			let durationCourses = [];
			topicCourses.map(course=>{
				if(durations.length>0){
					durations.map(duration=>{
						if(course.duration>=duration.initial && course.duration<=duration.final){
							durationCourses.push(course);
						}
					});
				}else{
					durationCourses.push(course);
				}
			});

			let ratingCourses = [];
			durationCourses.map(course=>{
				if(ratings.length>0){
					ratings.map(rating=>{
						//console.log(course.rating, rating);
						if(course.rating>=rating && course.rating<=(rating+0.5)){
							console.log(course.rating, rating, 'true');
							ratingCourses.push(course);
						}else{
							console.log(course.rating, rating, 'false');
						}
					})
					
				}else{
					ratingCourses.push(course);
				}
			})

			return ratingCourses;
		}

		function setCourse(courses){

			$('#course_container').html("");
			courses.map(course=>{
				let courseComponent = new CourseComponent(Context,course);
				$('#course_container').append(`
					<div class="col-lg-6 col-md-6">
						${courseComponent.view}
					</div>
				`);
				courseComponent.initializeCallback();

			})
		}
 
		function setLoading(){
			return `
			<div class="col-md-12">
				<br><br><br><br><br>
				<div class="main-loader mt-50">													
					<div class="spinner">
						<div class="bounce1"></div>
						<div class="bounce2"></div>
						<div class="bounce3"></div>
					</div>																										
				</div>
			</div>
			`;
		}

		function adjustLayout(){
            var w = window.innerWidth;
            if(w<=768){
                $('#btn-drawer-toggle').css({'display':''});
                $('#drawer').css({'display':'none'});
                small_screen=true;
				$('#offset').show();
            }else{
                $('#drawer').attr('class','right_drawer');
                $('#drawer').css({'display':'block'});
                $('#btn-drawer-toggle').css({'display':'none'});
                small_screen=false;
				$('#offset').hide();
            }
        }

	</script>
@endsection
