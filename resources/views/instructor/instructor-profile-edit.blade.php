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
			
			
	@extends('instructor.master')

	@section('content')


	<style>
		#toolbar button {
			background-color: transparent;
			color: #333;
			border: none;
			padding: 10px;
			cursor: pointer;
			display: flex;
			align-items: center;
			justify-content: center;
			width: 40px;
			height: 40px;
			transition: color 0.3s;
		}

		#toolbar {
			margin-bottom: 10px;
			display: flex;
			gap: 10px;
		}


		#toolbar button:hover {
			color: #475692;
		}

		#toolbar button.active {
			color: #475692;
		}


		pre code {
			background-color: #ecffeb;
			color: #3a3a3a;
			font-family: 'Courier New', Courier, monospace;
			padding: 3px;
			border-radius: 2px;
			display: block;
			font-size: 12px;
			white-space: pre-wrap;
		}

		.field div ul{
			list-style-type: disc;
			margin-inline-start: 20px;
		}
		.input_error{
			color:red;
			padding:5px;
			display: none;
		}
	</style>

	<div class="wrapper">
		<div class="sa4d25">
			<div class="container">	
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
									<h3 class="title"><i class="uil uil-edit-alt"></i> Instructor Profile Edit</h3>
								</div> 
							</div>
						</div>
					</div>
				</div>

				<div class="fcrse_1" style="padding:10px;">
					<div class="row">
						<div class="col-12">
							<div class="review_usr_dt" style="width:100%;">
								<img src="{{asset('storage/'.$user->image_url)}}" alt="">
								<div class="rv1458">
									<h4 class="tutor_name1">{{$user->name}}</h4>
									<div class="time_145">
										<span>
											@foreach ($instructor->categories as $index=> $category)
													@if ($index>0)
														,
													@endif
												{{$category->title}} 
											@endforeach
										</span>	
									</div> 

									<ul class="tutor_social_links">
										@foreach ($user->social_contacts as $contact)
											<li>
												<a href="{{$contact->link}}">
													<?= $contact->social_media->web_icon ?>
												</a>
												
											</li>
										@endforeach
									</ul>
								</div>

								<div style="flex:1">
									<a href="{{route('setting')}}" style="float: right;"><i class="uil uil-cog "></i> Setting</a>
								</div>
								
							</div>
						</div>

						<div class="col-lg-6 col-md-6">
							<table class="table kht-table" style="margin-top:20px;">
								<tr>
									<td> <i class="uil uil-graduation-hat"></i></i> Students Enrolled</td>
									<td>{{formatCount($student_enrolled)}} </td>
								</tr>
								<tr>
									<td> <i class="uil uil-book-alt"></i> Courses</td>
									<td>{{$courses->count()}}  </td>
								</tr>
								 
							</table>
						</div>

						<div class="col-lg-6 col-md-6">
							<table class="table kht-table" style="margin-top:20px;">
								<tr>
									<td> <i class="uil uil-star"></i></i> Reviews</td>
									<td>{{formatCount($review_count)}} </td>
								</tr>
								<tr>
									<td> <i class="uil uil-bell"></i> Subscribers</td>
									<td>{{formatCount($instructor->subscriber)}}  </td>
								</tr>
								 
							</table>
						</div>

						<div class="col-lg-12 col-md-12">
							<div class="course_des_textarea mt-30 lbel25" style="padding:10px;">
								<label><h5>About</h5></label>
								<span class="input_error" id="editor_error"> Please enter the description about yourself </span>
								<div class="course_des_bg">
									<div id="toolbar">
										<button data-command="bold" id="boldBtn"><i class="fas fa-bold"></i></button>
										<button data-command="italic" id="italicBtn"><i class="fas fa-italic"></i></button>
										<button data-command="insertUnorderedList" id="listBtn"><i class="fas fa-list-ul"></i></button>
									</div>
									<div class="ui form swdh30">
										<div class="field">
											<div id="editor" contenteditable="true"><?= $instructor->about ?></div>
										</div>
									</div>
								</div>
								<br>
								<form id="form_about" action="{{route('instructor.profile.update')}}" method="post">
									@csrf
									@method('put')
									<input id="input_about" type="hidden" name="about">
								</form>
								<button id="btn_save_about" class="main-btn" type="submit" style="float:right;">Save</button>
							</div>
						</div>

						<div class="col-lg-12 col-md-12">
							<div class="course_des_textarea mt-30 lbel25" style="padding:10px;">
								<label><h5>Subject Category</h5></label>
								<div class="table-responsive">
									<table class="table ucp-table earning__table">
										<thead class="thead-s">
											<tr>
												<th width="30px;"></th>
												<th scope="col">Category</th> 	
												<th scope="col" class="text-center"  width=70px;>Aciton</th>		
											</tr>
										</thead>
										<tbody>
											@if (count($instructor->categories)>0)
												@foreach ($instructor->categories as $key=>$category)
													<tr>
														<td>
														 <?= $category->web_icon ?>
														<td> {{$category->title}}   </td>
														<td class="text-center">
															<a href="#" title="Delete Contact" data-toggle="modal" data-target="#category-delete-section-{{$category->id}}" class="gray-s"><i class='uil uil-trash-alt'></i></a>
														</td>
													</tr>
													
													<div class="modal fade" id="category-delete-section-{{$category->id}}" tabindex="-1" aria-labelledby="lectureModalLabel" aria-hidden="true">
														<div class="modal-dialog modal-lg">
															<div class="modal-content">
																<div class="modal-header">
																	<h5 class="modal-title" id="lectureModalLabel">Delete Subject Field</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body">
																	<div class="alert alert-warning">
																		Do you really want to delete this category?
																	</div>
																</div>
																<div class="modal-footer">
																	<button type="button" class="main-btn cancel" data-dismiss="modal">Close</button>
																	<form action="{{route('instructor.profile.categories.remove',$category->id)}}" method="post">
																		@csrf
																		@method('DELETE')
																		<button type="submit" class="main-btn">Delete</button>
																	</form>
																</div>
															</div>
														</div>
													</div>
												@endforeach	
											@else
												<tr>
													<td colspan="3" class="text-center"> No subject category. <br> Add new.</td>
												</tr>
											@endif			
										</tbody>				
									</table>
									<div class="section-add-item-wrap p-3">
										<button  class="add_lecture" data-toggle="modal" data-target="#add-category"><i class="far fa-plus-square mr-2"></i><span style="font-size: 14px;">Add New</span></button>
									</div>
								</div>
							</div>
							
						</div>
						<div class="col-lg-12 col-md-12">
							<div class="course_des_textarea mt-30 lbel25" style="padding:10px;">
								<label><h5>Social Media Contact</h5></label>
								<div class="table-responsive">
								<table class="table ucp-table earning__table">
									<thead class="thead-s">
										<tr>
											<th></th>
											<th scope="col">Social Media</th>
											<th scope="col">Link</th>
											<th scope="col" class="text-center" width=70px;>Aciton</th>									
										</tr>
									</thead>
									<tbody>
										@if (count($user->social_contacts)>0)
											@foreach ($user->social_contacts as $contact)
												<tr>
													<td>
														<ul class="tutor_social_links">
															<li><?= $contact->social_media->web_icon ?></li>
														</ul>
													<td> {{$contact->social_media->media}} </td>
													<td style="overflow-x: hidden">
														<a href="{{$contact->link}}">
															{{$contact->link}}
														</a>
													</td>
													<td class="text-center">
														<a href="#" title="Delete Contact" data-toggle="modal" data-target="#contact-delete-section-{{$contact->id}}" class="gray-s"><i class='uil uil-trash-alt'></i></a>
													</td> 
												</tr>
												<div class="modal fade" id="contact-delete-section-{{$contact->id}}" tabindex="-1" aria-labelledby="lectureModalLabel" aria-hidden="true">
													<div class="modal-dialog modal-lg">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="lectureModalLabel">Delete Contact</h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<div class="alert alert-warning">
																	Do you really want to delete this contact?
																</div>
															</div>
															<div class="modal-footer">
																<button type="button" class="main-btn cancel" data-dismiss="modal">Close</button>
																<form action="{{route('instructor.profile.social-contacts.remove',$contact->id)}}" method="post">
																	@csrf
																	@method('DELETE')
																	<button type="submit" class="main-btn">Delete</button>
																</form>
															</div>
														</div>
													</div>
												</div>
											@endforeach		
										@else
											<tr>
												<td colspan="4" class="text-center"> No social contact. <br> Add new.</td>
											</tr>
										@endif		
									</tbody>				
								</table>
								<div class="section-add-item-wrap p-3">
									<button  class="add_lecture" data-toggle="modal" data-target="#add-social-contact"><i class="far fa-plus-square mr-2"></i><span style="font-size: 14px;">Add New</span></button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="add-category" tabindex="-1" aria-labelledby="lectureModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="lectureModalLabel">Add new category</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="course_des_textarea lbel25">
							<form class="form" action="{{route('instructor.profile.categories.add')}}" method="POST" id="form_category">
								@csrf
								<label class="label25">Category*</label>
								<span class="input_error" id="category_selector_error"> Please select the social media </span>
								<select name="category_id" id="category_selector" class="ui hj145 dropdown cntry152 prompt srch_explore" >
									<option value="">Select a category</option>
									@foreach ($categories as $category)
										<option value="{{$category->id}}">{{$category->title}}</option>
									@endforeach
								</select>
								<br><br><br>
							</form>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="main-btn cancel" data-dismiss="modal">Close</button>
						<button id="btn_submit_category_form" type="submit" class="main-btn">Add</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="add-social-contact" tabindex="-1" aria-labelledby="lectureModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="lectureModalLabel">Add new social contact</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="course_des_textarea lbel25" id="add_social_form_container">
							<form class="form" action="{{route('instructor.profile.social-contacts.add')}}" method="POST" id="form_social_contact">
								@csrf
								<label class="label25">Acc Link*</label>
								<span class="input_error" id="input_account_link_error"> Please enter the link</span>
								<input name="link" id="input_account_link" class="form_input_1" type="text" placeholder="Account link">
									
								<br><br>
								<label class="label25">Social Media*</label>
								<span class="input_error" id="media_selector_error"> Please select the social media </span>
								<select name="social_media_id" id="media_selector" class="ui hj145 dropdown cntry152 prompt srch_explore" >
									<option value="">Select a social media</option>
									@foreach ($social_media as $medium)
										<option value="{{$medium->id}}">{{$medium->media}}</option>
									@endforeach
								</select>
							</form>
							 <br><br><br>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="main-btn cancel" data-dismiss="modal">Close</button>
						<button id="btn_submit_social_form" type="submit" class="main-btn">Add</button>
					</div>
				</div>
			</div>
		</div>


		@include('instructor.components.footer')
	</div>
	<script src="{{asset('js/editor.js')}}"></script>
	<script>
		$(document).ready(()=>{

			$('#editor').on('input',()=>{ $('#editor_error').hide() });
			$('#input_account_link').on('input',()=>{ $('#input_account_link_error').hide() });
			$('#media_selector').change(()=>{ $('#media_selector_error').hide() });
			$('#category_selector').change(()=>{ $('#category_selector_error').hide() });

			$('#btn_save_about').click(()=>{
				const about = $('#editor').html();
				if(about==""){
					$('#editor_error').show();
					return;
				}
				$('#input_about').val(about);
				$('#form_about').submit();

			});

			$('#btn_submit_social_form').click(()=>{
				let validated = true;

				const account_link = $('#input_account_link').val();
				if(account_link==""){
					validated = false;
					$('#input_account_link_error').show();
				}

				const media = $('#media_selector').val();
				if(media==""){
					validated = false;
					$('#media_selector_error').show();
				}

				if(validated) $('#form_social_contact').submit();

			})

			$('#btn_submit_category_form').click(()=>{
				const category_id = $('#category_selector').val();
				if(category_id==""){
					$('#category_selector_error').show();
					return;
				}
				$('#form_category').submit();
			})
		})
	</script>
	<!-- Body End -->
	@endsection 