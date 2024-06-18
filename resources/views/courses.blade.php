@php

	if(isset(request()->topic_ids))$topic_ids = request()->topic_ids;
	
@endphp

@extends('layouts.master')


@section('content')

	<style>

		.sub_category{
			padding:10px;
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
		 	padding:10px;
			border:1px solid black;
			margin-right:10px;
			background:#475692;
			color:white;
			border-radius:2px;
			display: inline-block
		}

		.sub_category_active:hover{
		 	padding:10px;
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


	</style>
    @auth
	<div class="wrapper">
	@else
	<div style="padding-top:60px;">
	@endauth
		<div class="sa4d25">
			<div class="container-fluid">			
				<div class="row">
					<div class="col-12">
						<div class="scroll-container">
							@guest
								<br>
							@endguest
							@foreach ($sub_categories as $key=>$sub_category)
								<span onclick="sub_category_click({{$sub_category->id}})" class="{{$sub_category_id==$sub_category->id ? 'sub_category_active':'sub_category'}}"> {{$sub_category->title}} </span>
							@endforeach
						</div>
				 
					</div>
					<div class="col-md-8">
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
					<div class="col-md-4">
						<div class="fcrse_1 mt-10">
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
								Topic
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
						</div>
					</div>			
				</div>
			</div>
		</div>

	<script>
		
		const courses = @json($courses);
		const categories =@json($categories);
		const sub_categories=@json($sub_categories);

		console.log(categories,sub_categories);

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

				$('#course_container').html(setCourse(filtering()));
			});

			durationBoxes.on('change',function(){
				if ($(this).prop('checked')) {
					const index = parseInt($(this).val());
					 
					durations.push(intervals[index]);
				} else {
					const index = durations.indexOf(intervals[parseInt($(this).val())]);
					if (index != -1) durations.splice(index, 1);
				}

				$('#course_container').html(setCourse(filtering()));
			});

			ratingBoxes.on('change',function(){
				if ($(this).prop('checked')) {
					ratings.push(parseFloat($(this).val()));
				} else {
					const index = ratings.indexOf(parseFloat($(this).val()));
					if (index != -1) ratings.splice(index, 1);
				}
			 
				$('#course_container').html(setCourse(filtering()));
			});

			$('#course_container').html(setCourse(courses));
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
						if(course.rating>=rating && course.rating<(rating+0.5)){
							ratingCourses.push(course);
						}
					})
				}else{
					ratingCourses.push(course);
				}
			})

			return ratingCourses;
		}

		function setCourse(courses){

			let result = "";
			courses.map(course=>{
				result += `
					<div class="col-lg-6 col-md-6">
						<div class="fcrse_1 mt-30">
							<a href="/courses/${course.id}" class="fcrse_img">
								<img src="images/courses/img-2.jpg" alt="">
								<div class="course-overlay">
									<div class="badge_seller">Bestseller</div>
									<div class="crse_reviews">
										<i class="uil uil-star"></i>${course.rating}
									</div>
									<span class="play_btn1"><i class="uil uil-play"></i></span>
									<div class="crse_timer">
										${calculateDuration(course.duration)}
									</div>
								</div>
							</a>
							<div class="fcrse_content">
								<div class="eps_dots more_dropdown">
									<a href="#"><i class="uil uil-ellipsis-v"></i></a>
									<div class="dropdown-content">
										<span><i class='uil uil-share-alt'></i>Share</span>
										<span><i class="uil uil-shopping-cart-alt"></i>Add to cart</span>
										<span><i class="uil uil-windsock"></i>Report</span>
									</div>																									
								</div>
								<div class="vdtodt">
									<span class="vdt14">5M views</span>
									<span class="vdt14">${formatDateTime(new Date(course.created_at))} </span>
								</div>
								<a href="course_detail_view.html" class="crse14s">${course.title}</a>
								<a href="#" class="crse-cate">
									${searchCategory(categories,course.category_id).title} <i class="uil uil-arrow-right"></i>  ${searchCategory(sub_categories,course.sub_category_id).title}
								</a>
								<div class="auth1lnkprce">
									<div class="prce142">${course.fee} MMK</div>
									<button class="shrt-cart-btn" title="cart"><i class="uil uil-shopping-cart-alt"></i></button>
								</div>
							</div>
						</div>
					</div>
				`
			})

			return result;
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

		function calculateDuration(min){
			let result = Math.floor(min/60);

			if(result>1){
				return result + " hours";
			}else{
				return result + " hour";
			}
		}

		function formatDateTime(cmtTime){
			var currentTime = Date.now();
			var min=60;
			var h=min*60;
			var day=h*24;

			var diff =currentTime-cmtTime
			diff=diff/1000;
			
			if(diff<day*3){
				if(diff<min){
					return "a few second ago";
				}else if(diff>=min&&diff<h){
					return Math.floor(diff/min)+'min ago';
				}else if(diff>=h&&diff<day){
					return Math.floor(diff/h)+'h ago';
				}else{
					return Math.floor(diff/day)+'d ago';
				}
			}else{
				var date = new Date(Number(cmtTime));
				return date.toLocaleDateString("en-GB");
			}
		}

		function searchCategory(categories,id){
			let result;
			categories.map(category=>{
				if(category.id==id){
					result = category;
				}
			})

			return result;
		}

	</script>
@endsection
