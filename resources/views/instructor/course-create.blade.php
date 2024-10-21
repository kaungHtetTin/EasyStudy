@php
	$api_token = Cookie::get('api_auth_token');
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

		#canvas {
            border: 1px solid #ccc;
            cursor: pointer;
        }

        #crop-area {
            border: 2px dashed #000;
            position: absolute;
            cursor: move;
        }

        #canvas-container {
            position: relative;
            width: 100%;
        }
        #cropped-canvas{
            width: 100px;
        }

	</style>
	
	<!-- Body Start -->
	<div class="wrapper">
		<div class="sa4d25">
			<div class="container">	
				<div class="row">
					<div class="col-lg-12">	
						<h2 class="st_title"><i class="uil uil-plus-circle"></i> Create New Course</h2>
					</div>					
				</div>				
				<div class="row">
					<div class="col-12">
						<div class="course_tabs_1">
							<div id="add-course-tab" class="step-app">
								<ul class="step-steps">
									<li id="step-1" class="active">
										<a href="#tab_step1">
											<span class="number"></span>
											<span class="step-name">Basic</span>
										</a>
									</li>
									<li id="step-2">
										<a href="#tab_step2">
											<span class="number"></span>
											<span class="step-name">Media</span>
										</a>
									</li>
									<li id="step-3">
										<a href="#tab_step3">
											<span class="number"></span>
											<span class="step-name">Price</span>
										</a>
									</li>
									<li id="step-4">
										<a href="#tab_step4">
											<span class="number"></span>
											<span class="step-name">Publish</span>
										</a>
									</li>
								</ul>
								<div class="step-content">
									<div class="step-tab-panel step-tab-info active" id="tab_step1"> 
										<div class="tab-from-content">
											<div class="title-icon">
												<h3 class="title"><i class="uil uil-info-circle"></i>Basic Information</h3>
											</div>
											<div class="course__form">
												<div class="general_info10">
													<div class="row">
														<div class="col-lg-12 col-md-12">															
															<div class="ui search focus mt-30 lbel25">
																<label>Course Title*</label> <span class="input_error" id="input_title_error"> Please enter the title </span>
																<div class="ui left icon input swdh19">
																	<input id="input_title" class="prompt srch_explore" type="text" placeholder="Course title here" name="title" data-purpose="edit-course-title" maxlength="60" id="main[title]" value="">															
																	<div id="title_count" class="badge_num">60</div>
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
																			<div id="editor" contenteditable="true"></div>
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
																	<option value="{{$level->id}}">{{$level->level}}</option>
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
																	<option value="{{$language->id}}">{{$language->type}}</option>
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
																	<option value="{{$category->id}}">{{$category->title}}</option>	
																@endforeach	
															</select>
														</div>

														<div class="col-lg-6 col-md-6" style="display:none" id="sub_category_container">
															<div class="mt-30 lbel25">
																<label>Sub Category*</label>
																<span class="input_error" id="subcategory_selector_error"> Please select the sub category </span>
															</div>
															<select id="subcategory_selector" class="ui hj145 dropdown cntry152 prompt srch_explore" >
																<option value="">Select Category</option>
															</select>
														</div>

														<div class="col-lg-6 col-md-6" id="topic_container" style="display:none">
															<div class="mt-30 lbel25">
																<label>Topic*</label>
																<span class="input_error" id="topic_selector_error"> Please select the topic</span>
															</div>
															<select id="topic_selector" class="ui hj145 dropdown cntry152 prompt srch_explore">
																<option value="">Select Category</option>
															</select>
														</div>
														<div class="col-12">
															<div class="cogs-toggle mt-30">
																<label class="switch">
																	<input type="checkbox" id="certification_access" value="">
																	<span></span>
																</label>
																<label for="certification_access" class="lbl-quiz">Certification of completion</label>
															</div>
														</div>								
													</div>
												</div>
													
											</div>
										</div>
									</div>

									<div class="step-tab-panel step-tab-location" id="tab_step2">
										<div class="tab-from-content">
											<div class="title-icon">
												<h3 class="title"><i class="uil uil-image"></i>Media</h3>
											</div>
											<div class="thumbnail-into">
												<div class="row">
													<div class="col-12">
														<label class="label25 text-left">Course thumbnail*</label>
														<div class="thumb-item">
															<div id="canvas-container" style="display: none">
																<canvas id="canvas"></canvas>
																<div id="crop-area" style="display:none"></div>
															</div>
															<canvas id="cropped-canvas" style="display: none"></canvas>
															<img id="img_course_placeholder" src="{{asset('images/thumbnail-demo.jpg')}}" alt="">
															<span class="input_error" id="input_course_thumbnail"> <br> Please select course thumbnail </span>
															<div class="thumb-dt">													
																<div class="upload-btn">													
																	<input class="uploadBtn-main-input" type="file" id="ThumbFile__input--source" accept="image/*">
																	<label for="ThumbFile__input--source" title="Zip">Choose Thumbnail</label>
																</div>
																<span class="uploadBtn-main-file">Supports: jpg,jpeg, or png ( 530 x 300 Recommended )</span>
															</div>
															
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									
									<div class="step-tab-panel step-tab-amenities" id="tab_step3">
										<div class="tab-from-content">
											<div class="title-icon">
												<h3 class="title"><i class="uil uil-usd-square"></i>Price</h3>
											</div>
										   <div class="course__form">
												<div class="price-block">
													<div class="row">
														<div class="col-md-12">
															<div class="course-main-tabs">
																<div class="cogs-toggle mt-3">
																	<label class="switch">
																		<input type="checkbox" id="checkbox_free" value="">
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
																							<input class="prompt srch_explore" type="text" placeholder="$0" name="" id="fee" value="">															
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
																							<input class="prompt srch_explore" type="text" placeholder="$0" name="" id="discount" value="">															
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
														</div>
													</div>
												</div>
											</div>
										 </div>
									</div>
									<div class="step-tab-panel step-tab-location" id="tab_step4">
										<div class="tab-from-content">
											<div id="preview_container">
												<div class="title-icon">
													<h3 class="title"><i class="uil uil-upload"></i>Preview</h3>
												</div>
												<div class="row">
													<div class="col-lg-5 col-md-12">
														<div class="fcrse_1 mt-30">
															<a href="#" class="fcrse_img">
																<img id="preview_course_thumbnail" src="{{asset('images/thumbnail-demo.jpg')}}" alt="">
															</a>
															<div class="fcrse_content">
																<div class="eps_dots more_dropdown">
																	<a href="#"><i class="uil uil-ellipsis-v"></i></a>															
																</div>
																<div class="vdtodt">
																	109k views . 15 days ago
																</div>
																<a href="#" class="crse14s" id="preview_course_title"> </a>
																<a href="#" class="crse-cate" id="preview_course_category">This is course thumbnail preview. </a>
																
																<div class="auth1lnkprce">
																	<p class="cr1fot">By <a href="#">{{Auth::user()->name}}</a></p>
																	<div id="preview_course_price" class="prce142"></div>
																</div>
															</div>
														</div>	
													</div>
													<div class="col-lg-7 col-md-12">
														<div class="fcrse_1 mt-30 description_preview" id="preview_course_description">
															
														</div>	
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
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="step-footer step-tab-pager">
									<button id="btn_prev" data-direction="prev" class="btn btn-default steps_btn">PREVIOUS</button>
									<button id="btn_next" data-direction="next" class="btn btn-default steps_btn">NEXT</button>
									<button id="btn_submit" data-direction="finish" class="btn btn-default steps_btn">Submit for Review</button>
								</div>
							</div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
		@include('instructor.components.footer')
	</div>
	<!-- Body End -->

	<script src="{{asset('js/jquery-steps.min.js')}}"></script>
	<script src="{{asset('js/editor.js')}}"></script>
	
	<script>
		$('#add-course-tab').steps({
		   
		});		
	</script>
	<script>
		$( function() {
			$( ".sortable" ).sortable();
			$( ".sortable" ).disableSelection();
		} );
  
	</script>

	<script>
		const apiToken = "{{$api_token}}";

		let categories = @json($categories);
		let sub_categories = @json($sub_categories);
		let filtered_sub_categories;
		let topics = @json($topics);
		let step = 1;
		let form_data = new FormData();
		let cover_photo_file = null;
		const canva_container = document.getElementById('canvas-container');

		$(document).ready(()=>{
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

			$('#btn_prev').click(()=>{ if(step>0) step--; })

			$('#btn_next').click(()=>{
				if(step<4) step++;
				if(step==4){
					if(validateFormData()){
						displayPreview();
					}
				}
			})

			$('#step-1').click(()=>{ step = 1;})
			$('#step-2').click(()=>{ step = 2;})
			$('#step-3').click(()=>{ step = 3;})
			$('#step-4').click(()=>{
				step = 4;
				if(validateFormData()){
					displayPreview();
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

			$('#input_title').on('input',()=>{
				$('#input_title_error').hide() 
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

			$('#btn_submit').click(()=>{
				if(validateFormData()){
					submit();
				}
			})
		})

		function validateFormData (){

			let isValidate = true;
			const title = $('#input_title').val();
			if(title==""){
				isValidate = false;
				$('#input_title_error').show();
			}else{
				form_data.append('title',title);
			}

			const description = $('#editor').html();
			if(description==""){
				isValidate = false;
				$('#editor_error').show();
			}else{
				form_data.append('description',description);
			}
			
			const level_id = $('#level_selector').val();
			if(level_id==""){
				isValidate = false;
				$('#level_selector_error').show();
			}else{
				form_data.append('level_id',level_id);
			}

			const language = $('#language_selector').val();
			if(language==""){
				isValidate = false;
				$('#language_selector_error').show();
			}else{
				form_data.append('language_id',language);
			}

			const category_id =  $('#category_selector').val();
			if(category_id==""){
				isValidate = false;
				$('#category_selector_error').show();
			}else{
				form_data.append('category_id',category_id);
			}

			const subcategory_id = $('#subcategory_selector').val();
			if(subcategory_id==""){
				isValidate = false;
				$('#subcategory_selector_error').show();
			}else{
				form_data.append('sub_category_id',subcategory_id);
			}

			const topic_id = $('#topic_selector').val();
			if(topic_id==""){
				isValidate = false;
				$('#topic_selector_error').show();
			}else{
				form_data.append('topic_id',topic_id);
			}

			if($('#certification_access').prop('checked')){
				 form_data.append('certificate',true);
			} else {
				form_data.append('certificate',false);
			}

			if(!isValidate){
				$('#step-1').click();
				return false;
			}

			// ================ Step 2 =================

			if(cover_photo_file==null){
				$('#input_course_thumbnail').show();
				$('#step-2').click();
				return false;
			} 

			// ================ Step 3 =================

			let fee = $('#fee').val();
			if(fee=="") fee = 0;
			form_data.append('fee',fee);

			let discount = $('#discount').val();
			if(discount=="") discount = 0;
			form_data.append('discount',discount);

			return true;
		}

		function submit(){
			$('#loading').show();
			var ajax=new XMLHttpRequest();
            $('#image_loading').show();
            $('#img_profile').hide();
            ajax.onload =function(){
                if(ajax.status==200 || ajax.readyState==4){
					let course = JSON.parse(ajax.responseText);
					console.log(course);
					location.href ="{{asset('')}}instructor-dashboard/modules?course_id="+course.id;
                }else{
                    console.log('Error');
					$('#loading').hide();
                }
            };
            ajax.open("post",`{{asset("")}}instructor-dashboard/api/courses`,true);
			ajax.setRequestHeader('Authorization','Bearer '+apiToken);
			ajax.setRequestHeader('Accept','application/json');
            ajax.send(form_data);
		}

		function displayPreview(){
			console.log('formdata', form_data);
		
			$('#preview_course_thumbnail').attr('src', form_data.get('thumbnail_src'));
			$('#preview_course_title').text(form_data.get('title'));
			const category_id = form_data.get('category_id');
			const category = categories.find(category => category.id == category_id);
		
			const subcategory_id = form_data.get('sub_category_id');
			const subcategory = sub_categories.find(sub => sub.id == subcategory_id);

			const topic_id = form_data.get('topic_id');
			const topic = topics.find(topic => topic.id == topic_id);

			$('#preview_course_category').html(`
				${category.title} <i class="uil uil-arrow-right"></i> ${subcategory.title}  <i class="uil uil-arrow-right"></i>  ${topic.title};
			`);

			$('#preview_course_description').html(form_data.get('description'));
		}

		function setSubCategorySelectorOption(category_id){
			$('#sub_category_container').show();
			$('#subcategory_selector').val("");
			let htmlContent = createOption("","Select Sub Category");
			sub_categories.map((sub)=>{
				if(sub.category_id==category_id){
					htmlContent+= createOption(sub.id,sub.title);
				}
			})
			$('#subcategory_selector').html(htmlContent);
			$('#subcategory_selector').prop('selectedIndex', 0);

		}

		function setTopicSelectorOption(sub_category_id){
			$('#topic_container').show();
			$('#topic_selector').val("");
			
			let htmlContent = createOption("","Select Topic");
			topics.map((topic)=>{
				if(topic.id==sub_category_id){
					htmlContent+= createOption(topic.id, topic.title);
				}
			})
			$('#topic_selector').html(htmlContent);
			$('#topic_selector').prop('selectedIndex', 0);
		}

		function createOption(id,title){
			return `
				<option value="${id}">${title}</option>
			`;
		}


		document.getElementById('ThumbFile__input--source').addEventListener('change', function (e) {
			const file = e.target.files[0];
			const reader = new FileReader();
			
			$('#canvas-container').show();
			document.getElementById('crop-area').setAttribute('style','display:block');

			reader.onload = function (event) {
				const img = new Image();
				img.onload = function () {

					$('#img_course_placeholder').hide();

					const canvas = document.getElementById('canvas');
					const ctx = canvas.getContext('2d');
					const maxWidth = canva_container.clientWidth;
					console.log('maxWitdh', maxWidth);
					const scale = maxWidth / img.width;

					const displayWidth = maxWidth;
					const displayHeight = img.height * scale;

					// Set the display size
					canvas.style.width = displayWidth + 'px';
					canvas.style.height = displayHeight + 'px';

					// Set the actual canvas size to the original image size
					canvas.width = img.width;
					canvas.height = img.height;
			
					ctx.drawImage(img, 0, 0, img.width, img.height);

					initCropArea(displayWidth, displayHeight);
				}
				img.src = event.target.result;
			}

			reader.readAsDataURL(file);
		});

		function initCropArea(displayWidth, displayHeight) {
			const cropArea = document.getElementById('crop-area');
			const canvasContainer = document.getElementById('canvas-container');
			const canvas = document.getElementById('canvas');

			cropArea.style.width = canva_container.clientWidth+'px';
			cropArea.style.height = (canva_container.clientWidth * 0.5084) + 'Px'; // 590 x 300

			
			cropArea.style.left = '85px';
			cropArea.style.top = '10px';

			cropArea.onmousedown = function (e) {
				e.preventDefault();

				let shiftX = e.clientX - cropArea.getBoundingClientRect().left;
				let shiftY = e.clientY - cropArea.getBoundingClientRect().top;

				document.onmousemove = function (e) {
					let newLeft = e.clientX - shiftX - canvasContainer.getBoundingClientRect().left;
					let newTop = e.clientY - shiftY - canvasContainer.getBoundingClientRect().top;

					newLeft = Math.max(0, Math.min(newLeft, displayWidth - cropArea.clientWidth));
					newTop = Math.max(0, Math.min(newTop, displayHeight - cropArea.clientHeight));

					cropArea.style.left = newLeft + 'px';
					cropArea.style.top = newTop + 'px';
				}

				document.onmouseup = function () {
					document.onmousemove = null;
					document.onmouseup = null;

					cropImageAndPutToInput(()=>{
						 console.log('image was cropped');
					});
				}
			}

			cropArea.ontouchstart = function (e){
				e.preventDefault();
				let shiftX = e.targetTouches[0].clientX - cropArea.getBoundingClientRect().left;
				let shiftY = e.targetTouches[0].clientY - cropArea.getBoundingClientRect().top;

				document.ontouchmove = function (e) {
			
					let newLeft = e.targetTouches[0].clientX - shiftX  - canvasContainer.getBoundingClientRect().left;
				
					let newTop = e.targetTouches[0].clientY - shiftY  - canvasContainer.getBoundingClientRect().top;
				

					newLeft = Math.max(0, Math.min(newLeft, displayWidth - cropArea.clientWidth));
					newTop = Math.max(0, Math.min(newTop, displayHeight - cropArea.clientHeight));

					cropArea.style.left = newLeft + 'px';
					cropArea.style.top = newTop + 'px';
				}

				document.ontouchend = function () {
					document.ontouchmove = null;
					document.ontouchend = null;

					cropImageAndPutToInput(()=>{
						 console.log('image was cropped');
					});
				}

			}
		
			cropArea.ondragstart = function (e) {
				console.log('ondrag');
			}
		}

		function cropImageAndPutToInput(onComplete){
			const cropArea = document.getElementById('crop-area');
			const canvas = document.getElementById('canvas');
			const ctx = canvas.getContext('2d');

			const cropCanvas = document.getElementById('cropped-canvas');
			const cropCtx = cropCanvas.getContext('2d');

			const displayWidth = parseInt(canvas.style.width);
			const displayHeight = parseInt(canvas.style.height);
			const actualWidth = canvas.width;
			const actualHeight = canvas.height;

			const scaleX = actualWidth / displayWidth;
			const scaleY = actualHeight / displayHeight;

			const cropX = parseInt(cropArea.style.left) * scaleX;
			const cropY = parseInt(cropArea.style.top) * scaleY;
			const cropWidth = cropArea.clientWidth * scaleX;
			const cropHeight = cropArea.clientHeight * scaleY;

			cropCanvas.width = cropWidth;
			cropCanvas.height = cropHeight;

			const imageData = ctx.getImageData(cropX, cropY, cropWidth, cropHeight);
			cropCtx.putImageData(imageData, 0, 0);

			// Convert the cropped canvas to a data URL and create a new File object
			cropCanvas.toBlob(function(blob) {
				const file = new File([blob], "cropped-image.png", { type: "image/png" });
	
				var reader = new FileReader();
				reader.onload = function (e) {
					imageSrc=e.target.result;
					form_data.append('thumbnail_src',imageSrc);
					form_data.append('thumbnail_file',file);
				};

				cover_photo_file = file;
				reader.readAsDataURL(file);
				onComplete();

			});
		}

	</script>

 

    @endsection