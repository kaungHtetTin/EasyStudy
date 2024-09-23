	@php
    	$api_token = Cookie::get('api_auth_token');
    @endphp
    @extends('instructor.master')

	@section('content')

    <style>
        .error{
            color:red;
			display: none;
        }
    </style>

    <!-- Add New Section Start -->
	<div class="modal fade" id="add_section_model" tabindex="-1" aria-labelledby="lectureModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="lectureModalLabel">New Section</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="new-section-block">
						<div class="row">
							<div class="col-md-12" id="module_form_container">
								<div class="new-section">
									<div class="form_group">
										<label class="label25">Section Name*</label>
										<input id="input_module_title" class="form_input_1" type="text" placeholder="Section title here">
                                        <p id="input_module_error" style="display: none" class="error">The title field is required.</p>
									</div>
								</div>
							</div>
                            <div class="col-12" id="module_loading" style="display: none">
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
				<div class="modal-footer">
					<button type="button" class="main-btn cancel" data-dismiss="modal">Close</button>
					<button id="btn_add_module" type="button" class="main-btn">Add Section</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Add New Section End -->
	<!-- Add Lecture Start -->
	<div class="modal fade" id="add_lecture_model" tabindex="-1" aria-labelledby="lectureModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="lectureModalLabel">Add Lecture</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
					<div class="new-section-block">
						<div class="row">
							<div class="col-md-12">
								<div class="course-main-tabs">
									<div class="nav nav-pills flex-column flex-sm-row nav-tabs" role="tablist">
										<a id="lecture_modal_tap_1" class="flex-sm-fill text-sm-center nav-link active" data-toggle="tab" href="#nav-basic" role="tab" aria-selected="true"><i class="fas fa-file-alt mr-2"></i>Basic</a>
										<a id="lecture_modal_tap_2" class="flex-sm-fill text-sm-center nav-link" data-toggle="tab" href="#nav-video" role="tab" aria-selected="false"><i class="fas fa-video mr-2"></i>Video</a>
										<a id="lecture_modal_tap_3" class="flex-sm-fill text-sm-center nav-link" data-toggle="tab" href="#nav-attachment" role="tab" aria-selected="false"><i class="fas fa-paperclip mr-2"></i>Attachments</a>
									</div>
									<div class="tab-content">
										<div class="tab-pane fade show active" id="nav-basic" role="tabpanel">
											
											<div class="new-section mt-30">
												<div class="form_group">
													<label class="label25">Lecture Title*</label>
													<input id="input_lecture_title" class="form_input_1" type="text" placeholder="Title here">
													<p class="error" id="input_lecture_title_error"> Please Enter the lecture title </p>
												</div>
											</div>

											<div class="ui search focus lbel25 mt-30">	
												<label>Description*</label>
												<div class="ui form swdh30">
													<div class="field">
														<textarea rows="3" name="description" id="input_lecture_description" placeholder="description here..."></textarea>
													</div>
												</div>
												<p class="error" id="input_lecture_description_error">Please enter the description</p>
											</div>
											<div class="preview-dt">
												<span class="title-875">Free Preview</span>
												<label class="switch">
													<input id="input_free_preview" type="checkbox" name="preview_op" value="">
													<span></span>
												</label>
											</div>
											<div class="preview-dt">
												<span class="title-875">Download Permission</span>
												<label class="switch">
													<input id="input_downloadable" type="checkbox" name="preview_op" value="">
													<span></span>
												</label>
											</div>
										</div>
										<div class="tab-pane fade" id="nav-video" role="tabpanel">
											<div class="lecture-video-dt mt-30">
												<span class="video-info">Select your preferred video type. (.mp4, YouTube, Vimeo etc.)</span>
												<div class="video-category">
													<div class="mp4 video-box" style="display: block;">
														<div class="row">
															<div class="col-lg-6 col-md-6">
																<div class="upload-file-dt mt-30">
																	<div class="upload-btn">													
																		<input class="uploadBtn-main-input" type="file" id="VideoFile__input--source">
																		<label for="VideoFile__input--source" title="Zip">Upload Video</label>
																	</div>
																	<span class="uploadBtn-main-file">File Format: .mp4</span>
																	<span class="uploaded-id">Uploaded ID : <b>12</b></span>
																</div>
															</div>
															<div class="col-lg-6 col-md-6">
																<div class="upload-file-dt mt-30">
																	<div class="upload-btn">													
																		<input class="uploadBtn-main-input" type="file" id="PosterFile__input--source">
																		<label for="PosterFile__input--source" title="Zip">Video Poster</label>
																	</div>
																	<span class="uploadBtn-main-file color-b">Uploaded ID : preview.jpg</span>
																	<span class="uploaded-id color-fmt">Size: 590x300 pixels. Supports: jpg,jpeg, or png</span>
																</div>
															</div>
														</div>
														<div class="video-duration">
															<label class="label25">Video Runtime - <strong>hh:mm:ss</strong>*</label>
															<div class="duration-time">
																<div class="input-group">
																	<input type="text" class="form_input_1" name="video[runtime][hours]" value="00">
																	<input type="text" class="form_input_1" name="video[runtime][mins]" value="1">
																	<input type="text" class="form_input_1" name="video[runtime][secs]" value="00">
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="tab-pane fade" id="nav-attachment" role="tabpanel">
											<div class="row">
												<div class="col-lg-12">
													<div class="upload-file-dt mt-30">
														<div class="upload-btn">													
															<input class="uploadBtn-main-input" type="file" id="input_attachment" accept=".jpg, .jpeg, .png, .pdf, .zip">
															<label for="input_attachment" title="Zip"><i class="far fa-plus-square mr-2"></i>Attachment</label>
														</div>
														<span class="uploadBtn-main-file">Supports: jpg, jpeg, png, pdf or .zip</span>
														<div class="add-attachments-dt" id="attachment_container" style="display: none">
															<div class="attachment-items">
																<div class="attachment_id" id="attachment"></div>
																<button id="btn_cancel_attachment" class="cancel-btn" type="button"><i class="fas fa-trash-alt"></i></button>
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
				<div class="modal-footer">
					<p id="lecture_content_error" class="error">Either a video or an attachment is required</p>
					<button type="button" class="main-btn cancel" data-dismiss="modal">Close</button>
					<button id="btn_add_lecture" type="button" class="main-btn">Add Lecture</button>
				</div>
            
			</div>
		</div>

	</div>
	<!-- Add Lecture End -->


	<!-- Add Assignment Start -->
	<div class="modal fade" id="add_assignment_model" tabindex="-1" aria-labelledby="lectureModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="lectureModalLabel">Add Assignment</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="new-section-block main-form">
						<div class="row">
							<div class="col-md-12">
								<div class="new-section">
									<div class="form_group">
										<label class="label25">Assignment Title*</label>
										<input class="form_input_1" type="text" placeholder="Assignment title here" id="input_assignment_title">
										<p class="error" id="input_assignment_title_error">Please enter the title</p>
									</div>
									<div class="ui search focus lbel25 mt-30">	
										<label>Description*</label>
										<div class="ui form swdh30">
											<div class="field">
												<textarea rows="3" name="description" id="input_assignment_description" placeholder="description here..."></textarea>
											</div>
										</div>
										<p class="error" id="input_assignment_description_error">Please enter the description</p>
									</div>

						
									<div class="upload-file-dt mt-30">
										<div class="upload-btn">													
											<input class="uploadBtn-main-input" type="file" id="input_assignment_file" accept=".jpg, .jpeg, .png, .pdf, .zip">
											<label for="input_assignment_file" title="Zip"><i class="far fa-plus-square mr-2"></i>Attachment</label>
										</div>
										<span class="uploadBtn-main-file">Supports: jpg, jpeg, png, pdf or .zip</span>
										<div class="add-attachments-dt" id="assignment_container" style="display: none">
											<div class="attachment-items">
												<div class="attachment_id" id="assignment_file">Uploaded ID: 5</div>
												<button id="btn_cancel_assignment" class="cancel-btn" type="button"><i class="fas fa-trash-alt"></i></button>
											</div>								
										</div>
									</div>
									<p class="error" id="assignment_file_error">Please select an attachment</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="main-btn cancel" data-dismiss="modal">Close</button>
					<button id="btn_add_assignment" type="button" class="main-btn">Add Assignment</button>
				</div>
			</div>
		</div>
	</div>

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
                                    <h3 class="title"><i class="uil uil-notebooks"></i>{{$course->title}}</h3>
                                </div>
                                <div class="curriculum-section">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="curriculum-add-item">
                                                <h4 class="section-title mt-0"><i class="fas fa-th-list mr-2"></i>Curriculum</h4>
                                                <button class="main-btn color btn-hover ml-left add-section-title reloadFun" data-toggle="modal" data-target="#add_section_model">New Section</button>
                                            </div>
                                                @foreach ($course->modules as $module)
                                                <div class="added-section-item mb-30">
                                                    <div class="section-header">
                                                        <h4><i class="fas fa-bars mr-2"></i>{{$module->title}}</h4>
                                                        <div class="section-edit-options">
                                                            <button class="btn-152 reloadFun" type="button" data-toggle="collapse" data-target="#edit-section"><i class="fas fa-edit"></i></button>
															<button class="btn-152 reloadFun" type="button" data-toggle="collapse" data-target="#delete-section"><i class="fas fa-trash-alt"></i></button>
															
                                                        </div>
                                                    </div>

													<div id="delete-section" class="collapse">
                                                        <div class="new-section smt-25">
                                                            <div class="form_group">
                                                                 <h5>Do you really want to this section ?</h5>
                                                            </div>
                                                            <div class="share-submit-btns pl-0">
																<form action="{{route('instructor.modules.remove',$module->id)}}" style="display: inline" method="POST">
																	@csrf
																	@method('DELETE')
																	<button  type="submit" class="main-btn color btn-hover"><i class="fas fa-trash-alt"></i> Delete Section</button>
																</form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="edit-section" class="collapse">
                                                        <div class="new-section smt-25">
															<form action="{{route('instructor.modules.change',$module->id)}}" method="post">
																@csrf
																@method('PUT')
																<div class="form_group">
																	<div class="ui search focus mt-30 lbel25">
																		<label>Section Name*</label>
																		<div class="ui left icon input swdh19">
																			<input class="prompt srch_explore" type="text" placeholder="" name="title" maxlength="60" id="main[title]" value="{{$module->title}}">															
																		</div>
																	</div>
																</div>
																<div class="share-submit-btns pl-0">
																	<button class="main-btn color btn-hover"><i class="fas fa-save mr-2"></i>Update Section</button>
																</div>
															</form>
                                                        </div>
                                                    </div>

                                                    <div class="section-group-list sortable">
                                                        @foreach ($module->lessons as $lesson)
                                                            <div class="section-list-item">
                                                                <div class="section-item-title">
                                                                    @if ($lesson->lesson_type_id==1)
                                                                        <i class="uil uil-play-circle"></i>
                                                                    @endif

                                                                    @if ($lesson->lesson_type_id==2)
                                                                        <i class="uil uil-file mr-2"></i>
                                                                    @endif

                                                                    @if ($lesson->lesson_type_id==3)
                                                                        <i class="uil uil-file mr-2"></i>
                                                                    @endif

                                                                    <span class="section-item-title-text">{{$lesson->title}}</span>
                                                                </div>
                                                                <button type="button" class="section-item-tools reloadFun"><i class="fas fa-edit"></i></button>
                                                                <button type="button" class="section-item-tools reloadFun"  data-toggle="modal" data-target="#delete-section{{$lesson->id}}" ><i class="fas fa-trash-alt"></i></button>
                                                           


																<div class="modal fade" id="delete-section{{$lesson->id}}" tabindex="-1" aria-labelledby="lectureModalLabel" aria-hidden="true">
																	<div class="modal-dialog modal-lg">
																		<div class="modal-content">
																			<div class="modal-header">
																				<h5 class="modal-title" id="lectureModalLabel">Delete Lesson</h5>
																				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																					<span aria-hidden="true">&times;</span>
																				</button>
																			</div>
																			<div class="modal-body">
																				Do you really want to delelet this lesson? <br><br>
																				<div class="section-item-title">
																					@if ($lesson->lesson_type_id==1)
																						<i class="uil uil-play-circle"></i>
																					@endif

																					@if ($lesson->lesson_type_id==2)
																						<i class="uil uil-file mr-2"></i>
																					@endif

																					@if ($lesson->lesson_type_id==3)
																						<i class="fas fa-clipboard-list mr-2"></i>
																					@endif

																					<span class="section-item-title-text">{{$lesson->title}}</span>
																				</div>
																			</div>
																			<div class="modal-footer">
																				<button type="button" class="main-btn cancel" data-dismiss="modal">Close</button>
																				<form action="{{route('instructor.lessons.remove',$lesson->id)}}" method="post">
																					@csrf
																					@method('DELETE')
																					<button type="submit" class="main-btn">Delete</button>
																				</form>
																			</div>
																		</div>
																	</div>
																</div>

                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="section-add-item-wrap p-3">
                                                        <button onclick="defineModuleIdForLecture({{$module->id}})" id="btn_add_lecture" class="add_lecture" data-toggle="modal" data-target="#add_lecture_model"><i class="far fa-plus-square mr-2"></i>Lecture</button>
                                                        <button onclick="defineModuleIdForAssignment({{$module->id}})" class="add_assignment" data-toggle="modal" data-target="#add_assignment_model"><i class="far fa-plus-square mr-2"></i>Assignment</button>
                                                    </div>
                                                </div>
                                                @endforeach
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
		@include('instructor.components.footer')

		<script>

			const apiToken = "{{$api_token}}";
			let course = @json($course);
			let modules = @json($course->modules);
			let lessons = @json($course->lessons);

			console.log(lessons);

			let module_id = 0;
			let formData = null;
			let video_url = null;
			let attachment = null; // article resource

			function defineModuleIdForLecture(id){

				module_id = id;
				$('#input_lecture_title').val("");
				$('#input_lecture_description').val("");
				$('#lecture_modal_tap_1').click();
				video_url = null;
				attachment = null;
				formData = new FormData();
			}

			function defineModuleIdForAssignment(id){
				module_id = id;
				$('#input_assignment_title').val("");
				$('#input_assignment_description').val("");
				formData = new FormData();
				attachment = null;
			}

			$(document).ready(()=>{


				$('#btn_add_module').click(()=>{
                    addModule();
                });

                $('#input_module_title').on('input',()=> { $('#input_module_error').hide();} );

				$('#btn_add_lecture').click(()=>{
					if(validateFormData()){
						addLecture(formData);
					}
				});

				$('#input_lecture_title').on('input',()=>{ $('#input_lecture_title_error').hide() });
				$('#input_lecture_description').on('input',()=>{ $('#input_lecture_description_error').hide() })

				$('#input_attachment').change(()=>{
					var files=$('#input_attachment').prop('files');
					attachment=files[0];
					console.log(attachment);
					if (attachment) {
						var fileName = attachment.name; // Full file name
						var fileExtension = fileName.split('.').pop(); // File extension
						console.log(fileName);
						$('#attachment_container').show();
						$('#attachment').html(fileName);
						$('#lecture_content_error').hide();
				
					} else {
						attachment = null;
					}
				})

				$('#input_assignment_file').change(()=>{
					var files=$('#input_assignment_file').prop('files');
					attachment=files[0];
					if (attachment) {
						var fileName = attachment.name; // Full file name
						var fileExtension = fileName.split('.').pop(); // File extension
						console.log(fileName);
						$('#assignment_container').show();
						$('#assignment_file').html(fileName);
						$('#assignment_file_error').hide();
					} else {
						attachment = null;
					}
				})

				$('#btn_cancel_attachment').click(()=>{
					$('#attachment_container').hide();
					attachment = null;
				})

				$('#input_assignment_title').on('input',()=>{ $('#input_assignment_title_error').hide() });
				$('#input_assignment_description').on('input',()=> { $('#input_assignment_description_error').hide() });

				$('#btn_add_assignment').click(()=>{
					if(validateAssignmentForm()){
						addLecture(formData);
					}
				})

				$('#btn_cancel_assignment').click(()=>{
					attachment = null;
					$('#assignment_file_error').hide();
				})

			})

			function addModule(){
                let course_id = course.id;
                let title = $('#input_module_title').val();
                $('#input_module_error').hide();
                if(title == ""){
                    $('#input_module_error').show();
                    return; 
                }

                $('#module_form_container').hide();
                $('#module_loading').show();
                $.ajax({
                    url: 'http://localhost:8000/instructor/api/modules', // Replace with your API endpoint
                    type: 'POST', // or 'GET' depending on your request
                    headers: {
                        'Authorization': 'Bearer '+apiToken, // Example for Authorization header
                        'Accept':'application/json'
                    },
                    data:{
                        'course_id':course_id,
                        'title':title,
                    },
                    success: function(response) {
                        window.location.href = "?course_id="+response.course_id;
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', status, error);
                    }
                });
            }

			function validateFormData(){
				let isValidate = true;

				const title = $('#input_lecture_title').val();
				if(title==""){
					isValidate = false;
					$('#input_lecture_title_error').show();
				}else{
					formData.append('title',title);
				}

				const description = $('#input_lecture_description').val();
				if(description == ""){
					isValidate = false;
					$('#input_lecture_description_error').show();
				}else{
					formData.append('description',description);
				}

				if(!isValidate){
					$('#lecture_modal_tap_1').click();
					return false;
				}

				if(video_url==null && attachment==null){
					console.log(attachment);
					isValidate = false;
					$('#lecture_content_error').show();
					$('#lecture_modal_tap_2').click();
					return false;
				}

				if(attachment){
					formData.append('attachment',attachment);
					formData.append('lesson_type_id',2);
				}

				if(video_url){
					formData.append('video_url',video_url);
					formData.append('lesson_type_id',1);
				}

				if($('#input_downloadable').prop('checked')){
					formData.append('downloadable',true);
				} else {
					formData.append('downloadable',false);
				}

				if($('#input_free_preview').prop('checked')){
					formData.append('free_preview',true);
				} else {
					formData.append('free_preview',false);
				}

				formData.append('module_id',module_id);

				return true;

			}

			function addLecture(formData){
				$('.reloadFun').hide();
				var ajax=new XMLHttpRequest();
				ajax.onload =function(){
					if(ajax.status==200 || ajax.readyState==4){
						let lesson = JSON.parse(ajax.responseText);
						console.log(lesson);
						$('.reloadFun').show();
					
					}else{
						console.log(ajax.responseText);
						
					}
				};
				ajax.open("post",`http://localhost:8000/instructor/api/lessons`,true);
				ajax.setRequestHeader('Authorization','Bearer '+apiToken);
				ajax.setRequestHeader('Accept','application/json');
				ajax.send(formData);
			}


			function validateAssignmentForm(){
				let isValidate = true;

				formData.append('module_id',module_id);
				formData.append('lesson_type_id',3);
				formData.append('downloadable',true);
				formData.append('free_preview',false);


				const title = $('#input_assignment_title').val();
				if(title==""){
					isValidate = false;
					 $('#input_assignment_title_error').show();
				}else{
					formData.append('title',title);
				}

				const description = $('#input_assignment_description').val();
				if( description == "" ){
					isValidate = false;
					$('#input_assignment_description_error').show();
				}else{
					formData.append('description',description);
				}

				if(attachment==null){
					isValidate = false;
					$('#assignment_file_error').show();
				}else{
					formData.append('attachment',attachment);
				}

				return isValidate;
			}

		</script>

	</div>
	<!-- Body End -->
	@endsection

	


	