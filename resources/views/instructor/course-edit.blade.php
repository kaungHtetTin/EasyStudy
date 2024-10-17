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
	<link href="{{asset('vendor/jquery-ui-1.12.1/jquery-ui.css')}}" rel="stylesheet">	
    <link href="{{asset('css/jquery-steps.css')}}" rel="stylesheet">	
	<!-- Stylesheets -->
	<style>
		#editor {
			border: 1px solid rgba(34, 36, 38, .15);
			padding: 10px;
			background: #fff;
			color:#333;
			min-height: 200px;
			border-radius: 3px;
			white-space: pre-wrap;
		}


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

		.description_preview ul{
			list-style-type: disc;
			margin-inline-start: 20px;
		}

		.title-icon {
			border-bottom: 0px solid #efefef;
			border-top: 0px solid #efefef;
			padding: 18px 0;
			margin-bottom: 8px;
		}

		#cover_spinner{
			position: absolute;
			top: 50%;          /* Position from the top */
    		left: 50%; 
			transform: translate(-50%, -50%);
			display: none;
			
		}

		#cover_spinner_container{
			position: absolute;
			top:0;
			left: 0;
			width: 100%;
			height: 100%;
			background: #ffffff53;
			display: none;
		}

		.edit-menu{
			position: absolute;
			right:10px;
			bottom:10px;
		}

		.edit-cover{
			padding:10px;
			background: #dededebd;
			border-radius: 50px;
			color:#333;
			cursor: pointer;
			margin-top:10px;
		}

		.edit-cover:hover{
			background:black;
			color:white;
		}


	</style>
	
	<!-- Body Start -->
	<div class="wrapper">
		<div class="sa4d25">
			<div class="container">
				<div style="position: relative;display:flex">
					<div style="flex:1">
						<div class="row">
							<div class="col-lg-12">	
								<h2 class="st_title"><i class="uil uil-edit-alt"></i> Edit Course</h2>
							</div>	
						</div>		
						<br><br>

						<div class="row">
							<div class="col-lg-12">
								<div class="section3125">			
									<div class="row justify-content-center">						
										<div class="col-xl-4 col-lg-5 col-md-6" style="position: relative">						
											<div class="fcrse_img">						
												<img src="{{asset('storage/'.$course->cover_url)}}" alt="" id="img_cover">
												<div id="cover_spinner_container">
													<div class="spinner" id="cover_spinner">
														<div class="bounce1"></div>
														<div class="bounce2"></div>
														<div class="bounce3"></div>
													</div>
												</div>	

												<div class="edit-menu">
													<div class="edit-cover" id="btn_cover_edit"> 
														<i class="uil uil-edit"></i>
													</div>
													<div class="edit-cover" id="btn_cover_save" style="display: none"> 
														<i class="uil uil-check"></i>
													</div>
												</div>
											</div>
											<input type="file" id="input_cover" accept="image/*" style="display: none" />
										</div>
										<div class="col-xl-8 col-lg-7 col-md-6">
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

						<div class="">
							<div class="title-icon">
								<h3 class="title"><i class="uil uil-info-circle"></i>Course Information</h3>
							</div>
							<div class="course__form">
								<div class="general_info10">
									<div class="row">
										<div class="col-lg-12 col-md-12">															
											<div class="ui search focus mt-30 lbel25">
												<label>Course Title*</label> <span class="input_error" id="input_title_error"> Please enter the title </span>
												<div class="ui left icon input swdh19">
													<input id="input_title" class="prompt srch_explore" type="text" placeholder="Course title here" name="title" data-purpose="edit-course-title" maxlength="60" id="main[title]" value="{{$course->title}}">															
													<div id="title_count" class="badge_num"></div>
												</div>
													
											</div>									
										</div>

										<div class="col-lg-12 col-md-12">
											<div class="course_des_textarea mt-30 lbel25">
												<label>Course Description*</label>
												<span class="input_error" id="editor_error"> Please enter course description </span>
												<div class="course_des_bg">
													<div id="toolbar">
														<button data-command="bold" id="boldBtn"><i class="fas fa-bold"></i></button>
														<button data-command="italic" id="italicBtn"><i class="fas fa-italic"></i></button>
														<button data-command="insertUnorderedList" id="listBtn"><i class="fas fa-list-ul"></i></button>
													</div>
													<div class="ui form swdh30">
														<div class="field">
															<div id="editor" contenteditable="true"><?= $course->description ?></div>
														</div>
													</div>
													
												</div>
											</div>
										</div>
										<div class="col-lg-6 col-md-6">
											<div class="mt-30 lbel25">
												<label>Level*</label>
												<span class="input_error" id="level_selector_error"> Please select the level </span>
											</div>
											<select id="level_selector" class="ui hj145 dropdown cntry152 prompt srch_explore" >
												<option value="">Select Level</option>
												@foreach ($levels as $level)
													<option {{$level->id==$course->level_id ? 'selected': ''}} value="{{$level->id}}">{{$level->level}}</option>
												@endforeach		
											</select>
										</div>

										<div class="col-lg-6 col-md-6">
											<div class="mt-30 lbel25">
												<label>Audio Language*</label>
												<span class="input_error" id="language_selector_error"> Please select the language </span>
											</div>
											<select id="language_selector" class="ui hj145 dropdown cntry152 prompt srch_explore" >
												<option value="">Select Audio Language</option>
												@foreach ($languages as $language)
													<option {{$language->id == $course->language_id ? 'selected':''}} value="{{$language->id}}">{{$language->type}}</option>	
												@endforeach
											</select>
										</div>
										
										<div class="col-lg-6 col-md-6">
											<div class="mt-30 lbel25">
												<label>Category*</label>
												<span class="input_error" id="category_selector_error"> Please select the category </span>
											</div>
											<select id="category_selector" class="ui hj145 dropdown cntry152 prompt srch_explore">
												<option value="">Select Category</option>
												@foreach ($categories as $category)
													<option {{$category->id==$course->category_id ? 'selected':''}} value="{{$category->id}}">{{$category->title}}</option>	
												@endforeach	
											</select>
										</div>

										<div class="col-lg-6 col-md-6" id="sub_category_container">
											<div class="mt-30 lbel25">
												<label>Sub Category*</label>
												<span class="input_error" id="subcategory_selector_error"> Please select the sub category </span>
											</div>
											<select id="subcategory_selector" class="ui hj145 dropdown cntry152 prompt srch_explore" >
												<option value="">Select Sub Category</option>
											</select>
										</div>

										<div class="col-lg-6 col-md-6" id="topic_container">
											<div class="mt-30 lbel25">
												<label>Topic*</label>
												<span class="input_error" id="topic_selector_error"> Please select the topic</span>
											</div>
											<select id="topic_selector" class="ui hj145 dropdown cntry152 prompt srch_explore">
												<option value="">Select Topic</option>
											</select>
										</div>
										<div class="col-12">
											<div class="cogs-toggle mt-30">
												<label class="switch">
													<input type="checkbox" id="certification_access" value="" {{$course->certificate==1? 'checked':''}}>
													<span></span>
												</label>
												<label for="certification_access" class="lbl-quiz">Certification of completion</label>
											</div>
										</div>	
										<div class="col-md-12">
											<div class="course-main-tabs">
												<div class="cogs-toggle mt-3">
													<label class="switch">
														<input type="checkbox" id="checkbox_free" value="" {{$course->fee == 0 ? 'checked':''}}>
														<span></span>
													</label>
													<label for="checkbox_free" class="lbl-quiz">Free</label>
												</div>

												<div class="row" id="price_container">
													<div class="col-lg-6 col-md-6">
														<div class="license_pricing mt-30">
															<label class="label25">Regular Price*</label>
															<div class="row">
																<div class="col-12">
																	<div class="loc_group">
																		<div class="ui left icon input swdh19">
																			<input class="prompt srch_explore" type="text" placeholder="$0" name="" id="fee" value="{{$course->fee}}">															
																		</div>
																		<span class="slry-dt">MMK</span>
																	</div>
																</div>
															</div>																		
														</div>
													</div>

													<div class="col-lg-6 col-md-6">
														<div class="license_pricing mt-30 mb-30">
															<label class="label25">Discount Price*</label>
															<div class="row">
																<div class="col-12">
																	<div class="loc_group">
																		<div class="ui left icon input swdh19">
																			<input class="prompt srch_explore" type="text" placeholder="$0" name="" id="discount" value="{{$course->discount}}">															
																		</div>
																		<span class="slry-dt">MMK</span>
																	</div>
																</div>
															</div>																		
														</div>
													</div>
												</div>

												<p> Regular price with 0 amount will make the course free. </p>
											</div>

											<div class="col-12" id="loading" style="display: none">
												<div class="main-loader mt-50">													
													<div class="spinner">
														<div class="bounce1"></div>
														<div class="bounce2"></div>
														<div class="bounce3"></div>
													</div>																										
												</div>
											</div>
											<div class="col-12" id="saved" style="display: none">
												<div class="main-loader mt-50" style="text-align: center">													
													<i class="uil uil-check-circle" style="color:green;font-size:40px;"></i>																					
												</div>
											</div>
										</div>

										<div class="col-12">
											<button id="btn_save_basic_info" class="btn btn-default steps_btn" style="margin-top:40px;float:right;">Save</button>
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
	</div>
	<!-- Body End -->

	<script src="{{asset('js/jquery-steps.min.js')}}"></script>
	<script src="{{asset('js/editor.js')}}"></script>
	
	<script>
		const apiToken = "{{$api_token}}";

		let categories = @json($categories);
		let sub_categories = @json($sub_categories);
		let course = @json($course);
		let topics = @json($topics);

		$(document).ready(()=>{

			setSubCategorySelectorOption(course.category_id);
			setTopicSelectorOption(course.sub_category_id);
			 
			
			$('#category_selector').change(()=>{
				let category_id = $('#category_selector').val();
				setSubCategorySelectorOption(category_id);
				$('#category_selector_error').hide();
			})

			$('#subcategory_selector').change(()=>{
				let sub_category_id = $('#subcategory_selector').val();
				setTopicSelectorOption(sub_category_id);
				$('#subcategory_selector_error').hide();
			})

			$('#btn_cover_edit').click(()=>{ $('#input_cover').click(); });

			$('#input_cover').change(()=>{
				var files=$('#input_cover').prop('files');
				var file=files[0];
					
				var reader = new FileReader();
				reader.onload = function (e) {
					imageSrc=e.target.result;
					$('#img_cover').attr('src', imageSrc);
					$('#btn_cover_save').show();
					// form_data.append('thumbnail_src',imageSrc);
					// form_data.append('thumbnail_file',file);
				};
				reader.readAsDataURL(file);
			})

			$('#btn_cover_save').click(()=>{
				var files=$('#input_cover').prop('files');
				if(files.length>0){
					let file=files[0];
					uploadCoverPhoto(file);
				}
			})

			$('#checkbox_free').change(()=>{
				if($('#checkbox_free').prop('checked')){
					$('#fee').val("0");
					$('#discount').val("0");
				}else{
					$('#fee').val("");
					$('#discount').val("");
				}
			})

			$('#fee').on('input',()=>{
				if($('#checkbox_free').prop('checked')){
					$('#fee').val(0);
					return;
				}
				var fee = $('#fee').val();
				if(fee!=""){
					if(!Number.isFinite(Number(fee))) $('#fee').val("");
					else {
						fee = parseInt(fee);
						 $('#fee').val(fee);
					}
				}
				 
			})

			$('#discount').on('input',()=>{
				if($('#checkbox_free').prop('checked')){
					$('#discount').val(0);
					return;
				}
				var fee = $('#discount').val();
				if(fee!=""){
					if(!Number.isFinite(Number(fee))) $('#discount').val("");
					else {
						fee = parseInt(fee);
						$('#discount').val(fee);
					}
				}
				 
			})

			$('#title_count').html(60 - $('#input_title').val().length);

			$('#input_title').on('input',()=>{
				$('#input_title_error').hide();
				let text = $('#input_title').val();
                const letterLimit = 60;
				let letterCount = text.length;

				if(letterCount>letterLimit){
                    $('#input_title').val(text.substring(0, $('#input_title').val().length - 1));
                }else{
                    $('#title_count').html(letterLimit - letterCount);
                }

			});	
			$('#editor').on('input',()=> $('#editor_error').hide());
			$('#level_selector').change(()=>$('#level_selector_error').hide());
			$('#language_selector').change(()=> $('#language_selector_error').hide() );
			$('#topic_selector').change(()=> $('#topic_selector_error').hide() );

			$('#btn_save_basic_info').click(()=>{
				let form_data = validateBasicInformation();
				if(form_data){
					submitBasicInformation(form_data);
				}
			})
		})

		function validateBasicInformation (){
			let form_data = {};
			let isValidate = true;
			const title = $('#input_title').val();
			form_data.edit_mode=1;
			if(title==""){
				isValidate = false;
				$('#input_title_error').show();
			}else{
				form_data.title=title;
			}



			const description = $('#editor').html();
			if(description==""){
				isValidate = false;
				$('#editor_error').show();
			}else{
				form_data.description=description;
			}
			
			const level_id = $('#level_selector').val();
			if(level_id==""){
				isValidate = false;
				$('#level_selector_error').show();
			}else{
				form_data.level_id=level_id;
			}

			const language = $('#language_selector').val();
			if(language==""){
				isValidate = false;
				$('#language_selector_error').show();
			}else{
				form_data.language_id=language;
			}

			const category_id =  $('#category_selector').val();
			if(category_id==""){
				isValidate = false;
				$('#category_selector_error').show();
			}else{
				form_data.category_id=category_id;
			}

			const subcategory_id = $('#subcategory_selector').val();
			if(subcategory_id==""){
				isValidate = false;
				$('#subcategory_selector_error').show();
			}else{
				form_data.sub_category_id=subcategory_id;
			}

			const topic_id = $('#topic_selector').val();
			if(topic_id==""){
				isValidate = false;
				$('#topic_selector_error').show();
				return isValidate;
			}else{
				form_data.topic_id=topic_id;
			}

			if($('#certification_access').prop('checked')){
				 form_data.certificate=true;
			} else {
				form_data.certificate=false;
			}

			let fee = $('#fee').val();
			if(fee=="") fee = 0;
			form_data.fee = fee;

			let discount = $('#discount').val();
			if(discount=="") discount = 0;
			form_data.discount = discount;
		

			if(!isValidate){
				return false;
			}

			return form_data;
		}

		function submitBasicInformation(form_data){
			$('#loading').show();
			$.ajax({
				url: `{{asset("")}}instructor/api/courses/${course.id}`, // Replace with your API endpoint
				type: 'PUT', // or 'GET' depending on your request
				headers: {
					'Authorization': 'Bearer '+apiToken // Example for Authorization header
				},
                data: form_data,
				success: function(response) {
                    $('#loading').hide();
					$('#saved').show();
				},
				error: function(xhr, status, error) {
					console.error('Error:', status, error);
				}
			});
			  
		}

		function uploadCoverPhoto(file){

			let formData = new FormData();
			formData.append('thumbnail_file', file);
			$('#cover_spinner_container').show();
			$('#cover_spinner').show();
			
			$.ajax({
				url: `{{asset("")}}instructor/api/courses/${course.id}/update-cover-image`,
				type: 'POST',
				data: formData,
				contentType: false, // Important
				processData: false, // Important
				headers: {
					'Authorization': 'Bearer ' + apiToken,
					'Accept': 'application/json'
				},
				success: function(response) {

					$('#cover_spinner_container').hide();
					$('#cover_spinner').hide();
					$('#btn_cover_save').hide();

				},
				error: function(xhr, status, error) {
					console.log('Error:', xhr.status, error);
					 
				}
			});

		}

		function displayPreview(){
			console.log('formdata', formData);
			$('#preview_course_thumbnail').attr('src', formData.thumbnail_src);
			$('#preview_course_title').text(formData.title);
			const category_id = formData.category_id;
			const category = categories.find(category => category.id == category_id);
		
			const subcategory_id = formData.subcategory_id;
			const subcategory = sub_categories.find(sub => sub.id == subcategory_id);

			const topic_id = formData.topic_id;
			const topic = topics.find(topic => topic.id == topic_id);

			$('#preview_course_category').html(`
				${category.title} <i class="uil uil-arrow-right"></i> ${subcategory.title}  <i class="uil uil-arrow-right"></i>  ${topic.title};
			`);

			$('#preview_course_description').html(formData.description);
		}

		function setSubCategorySelectorOption(category_id){
			$('#sub_category_container').show();
			$('#subcategory_selector').val("");
			let htmlContent = "";
		 
			let isCurrentSelection = false;
			sub_categories.map((sub)=>{
				if(sub.category_id==category_id){
					let selected = "";
					if(sub.id == course.sub_category_id){
						selected="selected";
						isCurrentSelection = true;
					}
					htmlContent+= createOption(sub.id,sub.title,selected);
				}
			})
			$('#subcategory_selector').html(htmlContent);
			if(!isCurrentSelection)$('#subcategory_selector').prop('selectedIndex', 0);
			$('#subcategory_selector').change();
		}

		function setTopicSelectorOption(sub_category_id){
			$('#topic_container').show();
			$('#topic_selector').val("");
			
			let htmlContent ="";
			let isCurrentSelection = false;
			topics.map((topic)=>{
				if(topic.id==sub_category_id){
					let selected = "";
					if(topic.id == course.topic_id){
						selected="selected";
						isCurrentSelection = true;
					}
					htmlContent+= createOption(topic.id, topic.title,selected);
				}
			})
			$('#topic_selector').html(htmlContent);
			if(!isCurrentSelection) $('#topic_selector').prop('selectedIndex', 0);
		}

		function createOption(id,title,selected=""){
			return `
				<option ${selected} value="${id}">${title}</option>
			`;
		}


	</script>

    @endsection