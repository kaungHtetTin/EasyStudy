@extends('instructor.master')

    @section('content')
	<link href="{{asset('vendor/jquery-ui-1.12.1/jquery-ui.css')}}" rel="stylesheet">	
    <link href="{{asset('css/jquery-steps.css')}}" rel="stylesheet">	
	<!-- Stylesheets -->
	


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
							<div class="col-md-12">
								<div class="new-section">
									<div class="form_group">
										<label class="label25">Section Name*</label>
										<input class="form_input_1" type="text" placeholder="Section title here">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="main-btn cancel" data-dismiss="modal">Close</button>
					<button type="button" class="main-btn">Add Section</button>
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
										<a class="flex-sm-fill text-sm-center nav-link active" data-toggle="tab" href="#nav-basic" role="tab" aria-selected="true"><i class="fas fa-file-alt mr-2"></i>Basic</a>
										<a class="flex-sm-fill text-sm-center nav-link" data-toggle="tab" href="#nav-video" role="tab" aria-selected="false"><i class="fas fa-video mr-2"></i>Video</a>
										<a class="flex-sm-fill text-sm-center nav-link" data-toggle="tab" href="#nav-attachment" role="tab" aria-selected="false"><i class="fas fa-paperclip mr-2"></i>Attachments</a>
									</div>
									<div class="tab-content">
										<div class="tab-pane fade show active" id="nav-basic" role="tabpanel">
											<div class="new-section mt-30">
												<div class="form_group">
													<label class="label25">Lecture Title*</label>
													<input class="form_input_1" type="text" placeholder="Title here">
												</div>
											</div>
											<div class="ui search focus lbel25 mt-30">	
												<label>Description*</label>
												<div class="ui form swdh30">
													<div class="field">
														<textarea rows="3" name="description" id="" placeholder="description here..."></textarea>
													</div>
												</div>
											</div>
											<div class="preview-dt">
												<span class="title-875">Free Preview</span>
												<label class="switch">
													<input type="checkbox" name="preview_op" value="">
													<span></span>
												</label>
											</div>
										</div>
										<div class="tab-pane fade" id="nav-video" role="tabpanel">
											<div class="lecture-video-dt mt-30">
												<span class="video-info">Select your preferred video type. (.mp4, YouTube, Vimeo etc.)</span>
												<div class="video-category">
													<label ><input type="radio" name="colorRadio" value="mp4" checked=""><span>HTML5(mp4)</span></label>
													<label><input type="radio" name="colorRadio" value="url"><span>External URL</span></label>
													<label><input type="radio" name="colorRadio" value="youtube"><span>YouTube</span></label>
													<label><input type="radio" name="colorRadio" value="vimeo"><span>Vimeo</span></label>
													<label><input type="radio" name="colorRadio" value="embedded"><span>embedded</span></label>
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
													<div class="url video-box">
														<div class="new-section">
															<div class="ui search focus mt-30 lbel25">
																<label>External URL*</label>
																<div class="ui left icon input swdh19">
																	<input class="prompt srch_explore" type="text" placeholder="External Video URL" name="" id="" value="">															
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
													<div class="youtube video-box">
														<div class="new-section">
															<div class="ui search focus mt-30 lbel25">
																<label>Youtube URL*</label>
																<div class="ui left icon input swdh19">
																	<input class="prompt srch_explore" type="text" placeholder="Youtube Video URL" name="" id="" value="">															
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
													<div class="vimeo video-box">
														<div class="new-section">
															<div class="ui search focus mt-30 lbel25">
																<label>Vimeo URL*</label>
																<div class="ui left icon input swdh19">
																	<input class="prompt srch_explore" type="text" placeholder="Vimeo Video URL" name="" id="" value="">															
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
													<div class="embedded video-box">
														<div class="new-section">
															<div class="ui search focus mt-30 lbel25">
																<label>Embedded Code*</label>
																<div class="ui form swdh30">
																	<div class="field">
																		<textarea rows="3" name="" id="" placeholder="Place your embedded code here"></textarea>
																	</div>
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
															<input class="uploadBtn-main-input" type="file" id="SourceFile__input--source">
															<label for="SourceFile__input--source" title="Zip"><i class="far fa-plus-square mr-2"></i>Attachment</label>
														</div>
														<span class="uploadBtn-main-file">Supports: jpg, jpeg, png, pdf or .zip</span>
														<div class="add-attachments-dt">
															<div class="attachment-items">
																<div class="attachment_id">Uploaded ID: 12</div>
																<button class="cancel-btn" type="button"><i class="fas fa-trash-alt"></i></button>
															</div>
															<div class="attachment-items">
																<div class="attachment_id">Uploaded ID: 13</div>
																<button class="cancel-btn" type="button"><i class="fas fa-trash-alt"></i></button>
															</div>
															<div class="attachment-items">
																<div class="attachment_id">Uploaded ID: 14</div>
																<button class="cancel-btn" type="button"><i class="fas fa-trash-alt"></i></button>
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
					<button type="button" class="main-btn cancel" data-dismiss="modal">Close</button>
					<button type="button" class="main-btn">Add Lecture</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Add Lecture End -->
	<!-- Add Quiz Start -->
	<div class="modal fade" id="add_quiz_model" tabindex="-1" aria-labelledby="lectureModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="lectureModalLabel">Add Quiz</h5>
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
										<a class="flex-sm-fill text-sm-center nav-link active" data-toggle="tab" href="#nav-quizbasic" role="tab" aria-selected="true"><i class="fas fa-file-alt mr-2"></i>Basic</a>
										<a class="flex-sm-fill text-sm-center nav-link" data-toggle="tab" href="#nav-questions" role="tab" aria-selected="false"><i class="fas fa-question-circle mr-2"></i>Questions</a>
										<a class="flex-sm-fill text-sm-center nav-link" data-toggle="tab" href="#nav-setting" role="tab" aria-selected="false"><i class="fas fa-cog mr-2"></i>Setting</a>
									</div>
									<div class="tab-content">
										<div class="tab-pane fade show active" id="nav-quizbasic" role="tabpanel">
											<div class="new-section">
												<div class="form_group mt-30">
													<label class="label25">Quiz Title*</label>
													<input class="form_input_1" type="text" placeholder="Title here">
												</div>
											</div>
											<div class="ui search focus lbel25 mt-30">	
												<label>Description*</label>
												<div class="ui form swdh30">
													<div class="field">
														<textarea rows="3" name="description" id="" placeholder="description here..."></textarea>
													</div>
												</div>
											</div>
										</div>
										<div class="tab-pane fade" id="nav-questions" role="tabpanel">
											<div class="lecture-video-dt mt-30">
												<div class="add-ques-dt">
													<button type="button" class="main-btn color btn-hover w-100" data-toggle="collapse" data-target="#add-ques"><i class="far fa-plus-square mr-2"></i>Add Question</button>
													<div id="add-ques" class="collapse">
														<div class="lecture-video-dt mt-30">
															<span class="video-info">Question Type</span>
															<div class="video-category">
																<label ><input type="radio" name="colorRadio" value="schoice"><span><i class="far fa-dot-circle mr-2"></i>Single Choice</span></label>
																<label><input type="radio" name="colorRadio" value="mchoice"><span><i class="far fa-check-circle mr-2"></i>Multiple Choice</span></label>
																<label><input type="radio" name="colorRadio" value="sline"><span><i class="far fa-edit mr-2"></i>Single Line Text</span></label>
																<label><input type="radio" name="colorRadio" value="mline"><span><i class="far fa-file-alt mr-2"></i>Milti Line Text</span></label>
																<div class="schoice quiz-box">
																	<div class="ques-box">
																		<div class="row">
																			<div class="col-lg-2 col-md-2">
																				<div class="form_group mt-30">
																					<label class="label25 text-left">Image*</label>
																					<div class="upload-thumb">													
																						<input class="uploadBtn-input-preview" type="file" accept="image/png" id="thumbnail_source">
																						<label class="mx-0 my-0"  for="thumbnail_source" title="Image"><img class="img-thumbnail" src="images/placeholder-image.png" alt=""></label>
																					</div>
																				</div>
																			</div>																		
																			<div class="col-lg-7 col-md-9">
																				<div class="form_group mt-30">
																					<label class="label25 text-left">Question Title*</label>
																					<input class="form_input_1" type="text" placeholder="Write question title">
																				</div>
																			</div>
																			<div class="col-lg-3 col-md-12">
																				<div class="form_group mt-30">
																					<label class="label25 text-left">Score*</label>
																					<input class="form_input_1" type="number" placeholder="Score">
																				</div>
																			</div>																		
																		</div>
																	</div>
																	<div class="ans-box">
																		<div class="row">																		
																			<div class="col-lg-12 col-md-12">
																				<button class="main-btn color btn-hover mt-30">Add Option</button>
																			</div>
																			<div class="col-lg-12 col-md-12">
																				<div class="option-item">
																					<div class="opt-title">
																						<h4>1. Option</h4>
																						<span class="opt-del"><i class="fas fa-trash-alt"></i></span>
																					</div>
																					<div class="option-wrap">
																						<div class="form_group">
																							<label class="label25 text-left">Option Title*</label>
																							<input class="form_input_1" type="text" placeholder="Option title">
																						</div>																		
																						<div class="agree_checkbox">
																							<input type="checkbox" id="check1">
																							<label for="check1">Correct answer</label>
																						</div>																	
																					</div>																	
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="mchoice quiz-box">
																	<div class="ques-box">
																		<div class="row">
																			<div class="col-lg-2 col-md-2">
																				<div class="form_group mt-30">
																					<label class="label25 text-left">Image*</label>
																					<div class="upload-thumb">													
																						<input class="uploadBtn-input-preview" type="file" accept="image/png" id="thumbnail_source1">
																						<label class="mx-0 my-0"  for="thumbnail_source1" title="Image"><img class="img-thumbnail" src="images/placeholder-image.png" alt=""></label>
																					</div>
																				</div>
																			</div>																		
																			<div class="col-lg-7 col-md-9">
																				<div class="form_group mt-30">
																					<label class="label25 text-left">Question Title*</label>
																					<input class="form_input_1" type="text" placeholder="Write question title">
																				</div>
																			</div>
																			<div class="col-lg-3 col-md-12">
																				<div class="form_group mt-30">
																					<label class="label25 text-left">Score*</label>
																					<input class="form_input_1" type="number" placeholder="Score">
																				</div>
																			</div>																		
																		</div>
																	</div>
																	<div class="ans-box">
																		<div class="row">																		
																			<div class="col-lg-12 col-md-12">
																				<button class="main-btn color btn-hover mt-30">Add Option</button>
																			</div>
																			<div class="col-lg-12 col-md-12">
																				<div class="option-item">
																					<div class="opt-title">
																						<h4>1. Option</h4>
																						<span class="opt-del"><i class="fas fa-trash-alt"></i></span>
																					</div>
																					<div class="option-wrap">
																						<div class="form_group">
																							<label class="label25 text-left">Option Title*</label>
																							<input class="form_input_1" type="text" placeholder="Option title">
																						</div>																		
																						<div class="agree_checkbox">
																							<input type="checkbox" id="check2">
																							<label for="check2">Correct answer</label>
																						</div>																	
																					</div>																	
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="sline quiz-box">
																	<div class="ques-box">
																		<div class="row">
																			<div class="col-lg-2 col-md-2">
																				<div class="form_group mt-30">
																					<label class="label25 text-left">Image*</label>
																					<div class="upload-thumb">													
																						<input class="uploadBtn-input-preview" type="file" accept="image/png" id="thumbnail_source2">
																						<label class="mx-0 my-0"  for="thumbnail_source2" title="Image"><img class="img-thumbnail" src="images/placeholder-image.png" alt=""></label>
																					</div>
																				</div>
																			</div>																		
																			<div class="col-lg-7 col-md-9">
																				<div class="form_group mt-30">
																					<label class="label25 text-left">Question Title*</label>
																					<input class="form_input_1" type="text" placeholder="Write question title">
																				</div>
																			</div>
																			<div class="col-lg-3 col-md-12">
																				<div class="form_group mt-30">
																					<label class="label25 text-left">Score*</label>
																					<input class="form_input_1" type="number" placeholder="Score">
																				</div>
																			</div>																		
																		</div>
																	</div>
																</div>
																<div class="mline quiz-box">
																	<div class="ques-box">
																		<div class="row">
																			<div class="col-lg-2 col-md-2">
																				<div class="form_group mt-30">
																					<label class="label25 text-left">Image*</label>
																					<div class="upload-thumb">													
																						<input class="uploadBtn-input-preview" type="file" accept="image/png" id="thumbnail_source3">
																						<label class="mx-0 my-0"  for="thumbnail_source3" title="Image"><img class="img-thumbnail" src="images/placeholder-image.png" alt=""></label>
																					</div>
																				</div>
																			</div>																		
																			<div class="col-lg-7 col-md-9">
																				<div class="form_group mt-30">
																					<label class="label25 text-left">Question Title*</label>
																					<input class="form_input_1" type="text" placeholder="Write question title">
																				</div>
																			</div>
																			<div class="col-lg-3 col-md-12">
																				<div class="form_group mt-30">
																					<label class="label25 text-left">Score*</label>
																					<input class="form_input_1" type="number" placeholder="Score">
																				</div>
																			</div>																		
																		</div>
																	</div>																
																</div>																
															</div>
														</div>
														<div class="share-submit-btns pl-0 pb-0">
															<button class="main-btn color btn-hover"><i class="fas fa-save mr-2"></i>Save Question</button>
														</div>
													</div>
													<div class="added-ques">
														<div class="section-group-list pl-0 pr-0 sortable">
															<div class="section-list-item">
																<div class="section-item-title">
																	<i class="far fa-dot-circle mr-2"></i>
																	<span class="section-item-title-text">Question Title</span>
																</div>
																<button type="button" class="section-item-tools"><i class="fas fa-edit"></i></button>
																<button type="button" class="section-item-tools"><i class="fas fa-trash-alt"></i></button>
																<button type="button" class="section-item-tools ml-auto"><i class="fas fa-bars"></i></button>
															</div>
															<div class="section-list-item">
																<div class="section-item-title">
																	<i class="far fa-check-circle mr-2"></i>
																	<span class="section-item-title-text">Question Title</span>
																</div>
																<button type="button" class="section-item-tools"><i class="fas fa-edit"></i></button>
																<button type="button" class="section-item-tools"><i class="fas fa-trash-alt"></i></button>
																<button type="button" class="section-item-tools ml-auto"><i class="fas fa-bars"></i></button>
															</div>
															<div class="section-list-item">
																<div class="section-item-title">
																	<i class="far fa-edit mr-2"></i>
																	<span class="section-item-title-text">Question Title</span>
																</div>
																<button type="button" class="section-item-tools"><i class="fas fa-edit"></i></button>
																<button type="button" class="section-item-tools"><i class="fas fa-trash-alt"></i></button>
																<button type="button" class="section-item-tools ml-auto"><i class="fas fa-bars"></i></button>
															</div>
															<div class="section-list-item">
																<div class="section-item-title">
																	<i class="far fa-file-alt mr-2"></i>
																	<span class="section-item-title-text">Question Title</span>
																</div>
																<button type="button" class="section-item-tools"><i class="fas fa-edit"></i></button>
																<button type="button" class="section-item-tools"><i class="fas fa-trash-alt"></i></button>
																<button type="button" class="section-item-tools ml-auto"><i class="fas fa-bars"></i></button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="tab-pane fade" id="nav-setting" role="tabpanel">
											<div class="new-section mt-30">
												<div class="quiz-cogs-step">
													<label class="label25 quiz-st-ft text-left">Gradable</label>
													<div class="cogs-toggle">
														<label class="switch">
															<input type="checkbox" id="gradable_quiz" value="">
															<span></span>
														</label>
														<label for="gradable_quiz" class="lbl-quiz">Quiz Gradable</label>
													</div>
													<p>If this quiz test affect on the students grading system for this course.</p>
												</div>
												<div class="quiz-cogs-step mt-30">
													<label class="label25 quiz-st-ft text-left">Remaining time display</label>
													<div class="cogs-toggle">
														<label class="switch">
															<input type="checkbox" id="show_time" value="">
															<span></span>
														</label>
														<label for="show_time" class="lbl-quiz">Show Time</label>
													</div>
													<p>By enabling this option, quiz taker will show remaining time during attempt.</p>
												</div>
												<div class="row">
													<div class="col-lg-4">
														<div class="form_group mt-30">
															<label class="label25">Time Limit*</label>
															<div class="input-group">
																<input class="form_input_1 white-bg" type="number" placeholder="">
																<div class="input-group-append">
																	<span class="input-group-text int4856">Minutes</span>
																</div>
																<span class="alt-text">Set zero to disable time limit.</span>
															</div>
														</div>
													</div>
													<div class="col-lg-4">
														<div class="form_group mt-30">
															<label class="label25">Passing Score(%)*</label>
															<input class="form_input_1" type="number" placeholder="">
															<span class="alt-text">Student have to collect this score in percent for the pass this quiz.</span>
														</div>
													</div>
													<div class="col-lg-4">
														<div class="form_group mt-30">
															<label class="label25">Questions Limit*</label>
															<input class="form_input_1" type="number" placeholder="">
															<span class="alt-text">The number of questions student have to answer in this quiz.</span>
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
					<button type="button" class="main-btn cancel" data-dismiss="modal">Close</button>
					<button type="button" class="main-btn">Add Quiz</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Add Quiz End -->
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
										<input class="form_input_1" type="text" placeholder="Assignment title here">
									</div>
									<div class="form_group mt-30">				
										<label class="label25">Description*</label>
										<div class="text-editor">			
											<div id="editor4"></div>
										</div>
									</div>
									<div class="form_group mt-30">				
										<div class="row g-4">				
											<div class="col-lg-4 mt-30">				
												<label class="label25">Time Duration*</label>
												<div class="row no-gutters">
													<div class="col-6">
														<input class="form_input_1" type="number" value="0" placeholder="">
													</div>
													<div class="col-6 pl-2">
														<select class="ui hj145 dropdown cntry152 assignment prompt srch_explore">
															<option value="">Select</option>
															<option>Weeks</option>															
															<option>Days</option>
															<option>Hours</option>	
														</select>
													</div>
												</div>
												<span class="alt-text">Assignment time duration, set 0 for no limit.</span>
											</div>
											<div class="col-lg-4 mt-30">				
												<label class="label25">Total Number*</label>
												<input class="form_input_1" type="number" value="10" placeholder="">
												<span class="alt-text">Maximum points a student can score</span>
											</div>
											<div class="col-lg-4 mt-30">				
												<label class="label25">Minimum Pass Number*</label>
												<input class="form_input_1" type="number" value="5" placeholder="">
												<span class="alt-text">Minimum points required for the student to pass this assignment.</span>
											</div>
										</div>
									</div>
									<div class="assgn152 mt-30 pt-30">
										<div class="row g-6">				
											<div class="col-lg-6 mt-30">
												<label class="label25">Upload attachment limit*</label>
												<input class="form_input_1" type="text" value="1" placeholder="">
												<span class="alt-text">Maximum attachment size limit</span>
											</div>
											<div class="col-lg-6 mt-30">
												<label class="label25">Maximum attachment size limit</label>
												<input class="form_input_1" type="text" value="10" placeholder="">
												<span class="alt-text">Define maximum attachment size in MB</span>
											</div>
										</div>
									</div>
									<div class="upload-file-dt mt-30">
										<div class="upload-btn">													
											<input class="uploadBtn-main-input" type="file" id="AssignmentFile__input--source">
											<label for="AssignmentFile__input--source" title="Zip"><i class="far fa-plus-square mr-2"></i>Attachment</label>
										</div>
										<span class="uploadBtn-main-file">Supports: jpg, jpeg, png, pdf or .zip</span>
										<div class="add-attachments-dt">
											<div class="attachment-items">
												<div class="attachment_id">Uploaded ID: 5</div>
												<button class="cancel-btn" type="button"><i class="fas fa-trash-alt"></i></button>
											</div>
											<div class="attachment-items">
												<div class="attachment_id">Uploaded ID: 6</div>
												<button class="cancel-btn" type="button"><i class="fas fa-trash-alt"></i></button>
											</div>											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="main-btn cancel" data-dismiss="modal">Close</button>
					<button type="button" class="main-btn">Add Assignment</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Add Assignment End -->


	<!-- Body Start -->
	<div class="wrapper">
		<div class="sa4d25">
			<div class="container">			
				<div class="row">
					<div class="col-lg-12">	
						<h2 class="st_title"><i class="uil uil-analysis"></i> Create New Course</h2>
					</div>					
				</div>				
				<div class="row">
					<div class="col-12">
						<div class="course_tabs_1">
							<div id="add-course-tab" class="step-app">
								<ul class="step-steps">
									<li class="active">
										<a href="#tab_step1">
											<span class="number"></span>
											<span class="step-name">Basic</span>
										</a>
									</li>
									<li>
										<a href="#tab_step2">
											<span class="number"></span>
											<span class="step-name">Curriculum</span>
										</a>
									</li>
									<li>
										<a href="#tab_step3">
											<span class="number"></span>
											<span class="step-name">Media</span>
										</a>
									</li>
									<li>
										<a href="#tab_step4">
											<span class="number"></span>
											<span class="step-name">Price</span>
										</a>
									</li>
									<li>
										<a href="#tab_step5">
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
																<label>Course Title*</label>
																<div class="ui left icon input swdh19">
																	<input class="prompt srch_explore" type="text" placeholder="Course title here" name="title" data-purpose="edit-course-title" maxlength="60" id="main[title]" value="">															
																	<div class="badge_num">60</div>
																</div>
																<div class="help-block">(Please make this a maximum of 100 characters and unique.)</div>
															</div>									
														</div>
														<div class="col-lg-12 col-md-12">															
															<div class="ui search focus lbel25 mt-30">	
																<label>Short Description*</label>
																<div class="ui form swdh30">
																	<div class="field">
																		<textarea rows="3" name="description" id="" placeholder="Item description here..."></textarea>
																	</div>
																</div>
																<div class="help-block">220 words</div>
															</div>								
														</div>
														<div class="col-lg-12 col-md-12">
															<div class="course_des_textarea mt-30 lbel25">
																<label>Course Description*</label>
																<div class="course_des_bg">
																	<ul class="course_des_ttle">
																		<li><a href="#"><i class="uil uil-bold"></i></a></li>
																		<li><a href="#"><i class="uil uil-italic"></i></a></li>
																		<li><a href="#"><i class="uil uil-list-ul"></i></a></li>
																		<li><a href="#"><i class="uil uil-left-to-right-text-direction"></i></a></li>
																		<li><a href="#"><i class="uil uil-right-to-left-text-direction"></i></a></li>
																		<li><a href="#"><i class="uil uil-list-ui-alt"></i></a></li>
																		<li><a href="#"><i class="uil uil-link"></i></a></li>
																		<li><a href="#"><i class="uil uil-text-size"></i></a></li>
																		<li><a href="#"><i class="uil uil-text"></i></a></li>
																	</ul>
																	<div class="textarea_dt">															
																		<div class="ui form swdh339">
																			<div class="field">
																				<textarea rows="5" name="description" id="id_course_description" placeholder="Insert your course description"></textarea>
																			</div>
																		</div>										
																	</div>
																</div>
															</div>
														</div>
														<div class="col-lg-6 col-md-12">															
															<div class="ui search focus lbel25 mt-30">	
																<label>What will students learn in your course?*</label>
																<div class="ui form swdh30">
																	<div class="field">
																		<textarea rows="3" name="description" id="" placeholder=""></textarea>
																	</div>
																</div>
																<div class="help-block">Student will gain this skills, knowledge after completing this course. (One per line).</div>
															</div>								
														</div>
														<div class="col-lg-6 col-md-12">															
															<div class="ui search focus lbel25 mt-30">	
																<label>Requirements*</label>
																<div class="ui form swdh30">
																	<div class="field">
																		<textarea rows="3" name="description" id="" placeholder=""></textarea>
																	</div>
																</div>
																<div class="help-block">What knowledge, technology, tools required by users to start this course. (One per line).</div>
															</div>								
														</div>
														<div class="col-lg-6 col-md-12">
															<div class="mt-30 lbel25">
																<label>Course Level*</label>
															</div>
															<select class="ui hj145 dropdown cntry152 prompt srch_explore" multiple="">
																<option value="">Select Level</option>
																<option value="1">Beginner</option>
																<option value="2">Intermediate</option>
																<option value="3">Expert</option>
															</select>
														</div>
														<div class="col-lg-6 col-md-12">
															<div class="mt-30 lbel25">
																<label>Audio Language*</label>
															</div>
															<select class="ui hj145 dropdown cntry152 prompt srch_explore" multiple="">
																<option value="">Select Audio</option>
																<option>English</option>															
																<option>Español</option>
																<option>Português</option>
																<option>日本語</option>
																<option>Deutsch</option>
																<option>Français</option>
																<option>Türkçe</option>
																<option>Italiano</option>
																<option>हिन्दी</option>
																<option>Polski</option>
																<option>Tamil</option>
																<option>मराठी</option>
																<option>Telugu</option>														
																<option>Română</option>	
															</select>
														</div>
														<div class="col-lg-6 col-md-6">
															<div class="mt-30 lbel25">
																<label>Close Caption*</label>
															</div>
															<select class="ui hj145 dropdown cntry152 prompt srch_explore" >
																<option value="">Select Caption</option>
																<option>English</option>															
																<option>Español</option>
																<option>Português</option>
																<option>Italiano</option>
																<option>Français</option>
																<option>Polski</option>
																<option>Deutsch</option>
																<option>Bahasa Indonesia</option>
																<option>ภาษาไทย</option>
																<option>हिन्दी</option>
																<option>Tamil</option>
																<option>मराठी</option>
																<option>Telugu</option>		
															</select>
														</div>
														<div class="col-lg-6 col-md-6">
															<div class="mt-30 lbel25">
																<label>Course Category*</label>
															</div>
															<div class="ui selection dropdown cntry152 prompt srch_explore optgroup">
																<div class="default text">Select</div>
																<i class="dropdown icon"></i>
																<div class="menu cate_menu">
																	<div class="ui horizontal divider opt_title">Development</div>
																	<div class="item">Web Development</div>
																	<div class="item">Data Science</div>
																	<div class="item">Programming Languages</div>
																	<div class="item">Mobile Apps</div>
																	<div class="item">Game Development</div>
																	<div class="item">Databases</div>
																	<div class="item">Software Testing</div>
																	<div class="item">Software Engineering</div>
																	<div class="item">Development Tools</div>
																	<div class="item">E-Commerce</div>																
																	<div class="ui horizontal divider opt_title">Business</div>
																	<div class="item">Finance</div>
																	<div class="item">Entrepreneurship</div>
																	<div class="item">Communications</div>
																	<div class="item">Management</div>
																	<div class="item">Sales</div>
																	<div class="item">Strategy</div>
																	<div class="item">Operations</div>
																	<div class="item">Project Management</div>
																	<div class="item">Business Law</div>
																	<div class="item">Data & Analytics</div>
																	<div class="item">Home Business</div>
																	<div class="item">Human Resources</div>
																	<div class="item">Industry</div>
																	<div class="item">Media</div>
																	<div class="item">Real Estate</div>
																	<div class="item">Other</div>
																	<div class="ui horizontal divider opt_title">Finance & Accounting</div>
																	<div class="item">Accounting & Bookkeeping</div>
																	<div class="item">Compliance</div>
																	<div class="item">Cryptocurrency & Blockchain</div>
																	<div class="item">Economics</div>
																	<div class="item">Finance</div>
																	<div class="item">Finance Cert & Exam Prep</div>
																	<div class="item">Financial Modeling & Analysis</div>
																	<div class="item">Investing & Trading</div>
																	<div class="item">Money Management Tools</div>
																	<div class="item">Taxes</div>
																	<div class="item">Other Finance & Economics</div>
																	<div class="ui horizontal divider opt_title">IT & Software</div>
																	<div class="item">IT Certification</div>
																	<div class="item">Network & Security</div>
																	<div class="item"> Hardware</div>
																	<div class="item">Operating Systems</div>
																	<div class="item">Other</div>
																	<div class="ui horizontal divider opt_title">Office Productivity</div>
																	<div class="item">Microsoft</div>
																	<div class="item">Apple</div>
																	<div class="item">Google</div>
																	<div class="item">SAP</div>
																	<div class="item">Oracle</div>
																	<div class="ui horizontal divider opt_title">Personal Development</div>
																	<div class="item">Personal Transformation</div>
																	<div class="item">Productivity</div>
																	<div class="item">Leadership</div>
																	<div class="item">Personal Finance</div>
																	<div class="item">Career Development</div>
																	<div class="item">Parenting & Relationships</div>
																	<div class="item">Happiness</div>
																	<div class="item">Religion & Spirituality</div>
																	<div class="item">Personal Brand Building</div>
																	<div class="item">Creativity</div>
																	<div class="item">Influence</div>
																	<div class="item">Self Esteem</div>
																	<div class="item">Stress Management</div>
																	<div class="item">Memory & Study Skills</div>
																	<div class="item">Motivation</div>
																	<div class="item">Other</div>
																	<div class="ui horizontal divider opt_title">Design</div>
																	<div class="item">Web Design</div>
																	<div class="item">Graphic Design</div>
																	<div class="item">Design Tools</div>
																	<div class="item">User Experience</div>
																	<div class="item">Game Design</div>
																	<div class="item">Design Thinking</div>
																	<div class="item">3D & Animation</div>
																	<div class="item">Fashion</div>
																	<div class="item">Architectural Design</div>
																	<div class="item">Interior Design</div>
																	<div class="ui horizontal divider opt_title">Marketing</div>
																	<div class="item">Digital Marketing</div>
																	<div class="item">Search Engine Optimization</div>
																	<div class="item">Social Media Marketing</div>
																	<div class="item">Branding</div>
																	<div class="item">Marketing Fundamentals</div>
																	<div class="item">Analytics & Automation</div>
																	<div class="item">Public Relations</div>
																	<div class="item">Advertising</div>
																	<div class="item">Video & Mobile Marketing</div>
																	<div class="item">Content Marketing</div>
																	<div class="item">Growth Hacking</div>
																	<div class="item">Affiliate Marketing</div>
																	<div class="item">Product Marketing</div>
																	<div class="ui horizontal divider opt_title">Lifestyle</div>
																	<div class="item">Arts & Crafts</div>
																	<div class="item">Food & Beverage</div>
																	<div class="item">Beauty & Makeup</div>
																	<div class="item">Travel</div>
																	<div class="item">Gaming</div>
																	<div class="item">Home Improvement</div>
																	<div class="item">Pet Care & Training</div>
																	<div class="ui horizontal divider opt_title">Photography</div>
																	<div class="item">Digital Photography</div>
																	<div class="item">Photography Fundamentals</div>
																	<div class="item">Portraits</div>
																	<div class="item">Photography Tools</div>
																	<div class="item">Commercial Photography</div>
																	<div class="item">Video Design</div>
																	<div class="ui horizontal divider opt_title">Health & Fitness</div>
																	<div class="item">Fitness</div>
																	<div class="item">General Health</div>
																	<div class="item">Sports</div>
																	<div class="item">Nutrition</div>
																	<div class="item">Yoga</div>
																	<div class="item">Mental Health</div>
																	<div class="item">Dieting</div>
																	<div class="item">Self Defense</div>
																	<div class="item">Safety & First Aid</div>
																	<div class="item">Dance</div>
																	<div class="item">Meditation</div>
																	<div class="ui horizontal divider opt_title">Music</div>
																	<div class="item">Instruments</div>
																	<div class="item">Production</div>
																	<div class="item">Music Fundamentals</div>
																	<div class="item">Vocal</div>
																	<div class="item">Music Techniques</div>
																	<div class="item">Music Software</div>
																</div>
															</div>
														</div>															
													</div>
												</div>
											</div>
										</div>
									</div>
									
									<div class="step-tab-panel step-tab-gallery" id="tab_step2">
										<div class="tab-from-content">
											<div class="title-icon">
												<h3 class="title"><i class="uil uil-notebooks"></i>Curriculum</h3>
											</div>
											<div class="curriculum-section">
												<div class="row">
													<div class="col-md-12">
														<div class="curriculum-add-item">
															<h4 class="section-title mt-0"><i class="fas fa-th-list mr-2"></i>Curriculum</h4>
															<button class="main-btn color btn-hover ml-left add-section-title" data-toggle="modal" data-target="#add_section_model">New Section</button>
														</div>
														<div class="added-section-item mb-30">
															<div class="section-header">
																<h4><i class="fas fa-bars mr-2"></i>Introduction</h4>
																<div class="section-edit-options">
																	<button class="btn-152" type="button" data-toggle="collapse" data-target="#edit-section"><i class="fas fa-edit"></i></button>
																	<button class="btn-152" type="button"><i class="fas fa-trash-alt"></i></button>
																</div>
															</div>
															<div id="edit-section" class="collapse">
																<div class="new-section smt-25">
																	<div class="form_group">
																		<div class="ui search focus mt-30 lbel25">
																			<label>Section Name*</label>
																			<div class="ui left icon input swdh19">
																				<input class="prompt srch_explore" type="text" placeholder="" name="title" maxlength="60" id="main[title]" value="Introduction">															
																			</div>
																		</div>
																	</div>
																	<div class="share-submit-btns pl-0">
																		<button class="main-btn color btn-hover"><i class="fas fa-save mr-2"></i>Update Section</button>
																	</div>
																</div>
															</div>
															<div class="section-group-list sortable">
																<div class="section-list-item">
																	<div class="section-item-title">
																		<i class="fas fa-file-alt mr-2"></i>
																		<span class="section-item-title-text">lecture Title</span>
																	</div>
																	<button type="button" class="section-item-tools"><i class="fas fa-edit"></i></button>
																	<button type="button" class="section-item-tools"><i class="fas fa-trash-alt"></i></button>
																	<button type="button" class="section-item-tools ml-auto"><i class="fas fa-bars"></i></button>
																</div>
																<div class="section-list-item">
																	<div class="section-item-title">
																		<i class="fas fa-stream mr-2"></i>
																		<span class="section-item-title-text">Quiz Title</span>
																	</div>
																	<button type="button" class="section-item-tools"><i class="fas fa-edit"></i></button>
																	<button type="button" class="section-item-tools"><i class="fas fa-trash-alt"></i></button>
																	<button type="button" class="section-item-tools ml-auto"><i class="fas fa-bars"></i></button>
																</div>
																<div class="section-list-item">
																	<div class="section-item-title">
																		<i class="fas fa-clipboard-list mr-2"></i>
																		<span class="section-item-title-text">Assignment Title</span>
																	</div>
																	<button type="button" class="section-item-tools"><i class="fas fa-edit"></i></button>
																	<button type="button" class="section-item-tools"><i class="fas fa-trash-alt"></i></button>
																	<button type="button" class="section-item-tools ml-auto"><i class="fas fa-bars"></i></button>
																</div>
															</div>
															<div class="section-add-item-wrap p-3">
																<button class="add_lecture" data-toggle="modal" data-target="#add_lecture_model"><i class="far fa-plus-square mr-2"></i>Lecture</button>
																<button class="add_quiz" data-toggle="modal" data-target="#add_quiz_model"><i class="far fa-plus-square mr-2"></i>Quiz</button>
																<button class="add_assignment" data-toggle="modal" data-target="#add_assignment_model"><i class="far fa-plus-square mr-2"></i>Assignment</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="step-tab-panel step-tab-location" id="tab_step3">
										<div class="tab-from-content">
											<div class="title-icon">
												<h3 class="title"><i class="uil uil-image"></i>Media</h3>
											</div>
											<div class="lecture-video-dt mb-30">
												<span class="video-info">Intro Course overview provider type. (.mp4, YouTube, Vimeo etc.)</span>
												<div class="video-category">
													<label ><input type="radio" name="colorRadio" value="mp4" checked><span>HTML5(mp4)</span></label>
													<label><input type="radio" name="colorRadio" value="url"><span>External URL</span></label>
													<label><input type="radio" name="colorRadio" value="youtube"><span>YouTube</span></label>
													<label><input type="radio" name="colorRadio" value="vimeo"><span>Vimeo</span></label>
													<label><input type="radio" name="colorRadio" value="embedded"><span>embedded</span></label>
													<div class="mp4 intro-box" style="display: block;">
														<div class="row">
															<div class="col-lg-5 col-md-12">
																<div class="upload-file-dt mt-30">
																	<div class="upload-btn">													
																		<input class="uploadBtn-main-input" type="file" id="IntroFile__input--source">
																		<label for="IntroFile__input--source" title="Zip">Upload Video</label>
																	</div>
																	<span class="uploadBtn-main-file">File Format: .mp4</span>
																	<span class="uploaded-id"></span>
																</div>
															</div>														
														</div>
													</div>
													<div class="url intro-box">
														<div class="new-section">
															<div class="ui search focus mt-30 lbel25">
																<label>External URL*</label>
																<div class="ui left icon input swdh19">
																	<input class="prompt srch_explore" type="text" placeholder="External Video URL" name="" id="" value="">															
																</div>
															</div>
														</div>														
													</div>
													<div class="youtube intro-box">
														<div class="new-section">
															<div class="ui search focus mt-30 lbel25">
																<label>Youtube URL*</label>
																<div class="ui left icon input swdh19">
																	<input class="prompt srch_explore" type="text" placeholder="Youtube Video URL" name="" id="" value="">															
																</div>
															</div>
														</div>														
													</div>
													<div class="vimeo intro-box">
														<div class="new-section">
															<div class="ui search focus mt-30 lbel25">
																<label>Vimeo URL*</label>
																<div class="ui left icon input swdh19">
																	<input class="prompt srch_explore" type="text" placeholder="Vimeo Video URL" name="" id="" value="">															
																</div>
															</div>
														</div>														
													</div>
													<div class="embedded intro-box">
														<div class="new-section">
															<div class="ui search focus mt-30 lbel25">
																<label>Embedded Code*</label>
																<div class="ui form swdh30">
																	<div class="field">
																		<textarea rows="3" name="" id="" placeholder="Place your embedded code here"></textarea>
																	</div>
																</div>
															</div>
														</div>														
													</div>
												</div>
											</div>
											<div class="thumbnail-into">
												<div class="row">
													<div class="col-lg-5 col-md-6">
														<label class="label25 text-left">Course thumbnail*</label>
														<div class="thumb-item">
															<img src="images/thumbnail-demo.jpg" alt="">
															<div class="thumb-dt">													
																<div class="upload-btn">													
																	<input class="uploadBtn-main-input" type="file" id="ThumbFile__input--source">
																	<label for="ThumbFile__input--source" title="Zip">Choose Thumbnail</label>
																</div>
																<span class="uploadBtn-main-file">Size: 590x300 pixels. Supports: jpg,jpeg, or png</span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									
									<div class="step-tab-panel step-tab-amenities" id="tab_step4">
										<div class="tab-from-content">
											<div class="title-icon">
												<h3 class="title"><i class="uil uil-usd-square"></i>Price</h3>
											</div>
										   <div class="course__form">
												<div class="price-block">
													<div class="row">
														<div class="col-md-12">
															<div class="course-main-tabs">
																<div class="nav nav-pills flex-column flex-sm-row nav-tabs" role="tablist">
																	<a class="flex-sm-fill text-sm-center nav-link active" data-toggle="tab" href="#nav-free" role="tab" aria-selected="true"><i class="fas fa-tag mr-2"></i>Free</a>
																	<a class="flex-sm-fill text-sm-center nav-link" data-toggle="tab" href="#nav-paid" role="tab" aria-selected="false"><i class="fas fa-cart-arrow-down mr-2"></i>Paid</a>
																</div>
																<div class="tab-content">
																	<div class="tab-pane fade show active" id="nav-free" role="tabpanel">
																		<div class="price-require-dt">
																			<div class="cogs-toggle center_d">
																				<label class="switch">
																					<input type="checkbox" id="require_login" value="">
																					<span></span>
																				</label>
																				<label for="require_login" class="lbl-quiz">Require Log In</label>
																			</div>
																			<div class="cogs-toggle center_d mt-3">
																				<label class="switch">
																					<input type="checkbox" id="require_enroll" value="">
																					<span></span>
																				</label>
																				<label for="require_enroll" class="lbl-quiz">Require Enroll</label>
																			</div>
																			<p>If the course is free, if student require to enroll your course, if not required enroll, if students required sign in to your website to take this course.</p>
																		</div>
																	</div>
																	<div class="tab-pane" id="nav-paid" role="tabpanel">
																		<div class="license_pricing mt-30">
																			<label class="label25">Regular Price*</label>
																			<div class="row">
																				<div class="col-lg-4 col-md-6 col-sm-6">
																					<div class="loc_group">
																						<div class="ui left icon input swdh19">
																							<input class="prompt srch_explore" type="text" placeholder="$0" name="" id="" value="">															
																						</div>
																						<span class="slry-dt">USD</span>
																					</div>
																				</div>
																			</div>																		
																		</div>
																		<div class="license_pricing mt-30 mb-30">
																			<label class="label25">Discount Price*</label>
																			<div class="row">
																				<div class="col-lg-4 col-md-6 col-sm-6">
																					<div class="loc_group">
																						<div class="ui left icon input swdh19">
																							<input class="prompt srch_explore" type="text" placeholder="$0" name="" id="" value="">															
																						</div>
																						<span class="slry-dt">USD</span>
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
									</div>
									<div class="step-tab-panel step-tab-location" id="tab_step5">
										<div class="tab-from-content">
											<div class="title-icon">
												<h3 class="title"><i class="uil uil-upload"></i>Submit</h3>
											</div>
										</div>
										<div class="publish-block">
											<i class="far fa-edit"></i>
											<p>Your course is in a draft state. Students cannot view, purchase or enroll in this course. For students that are already enrolled, this course will not appear on their student Dashboard.</p>
										</div>
									</div>
								</div>
								<div class="step-footer step-tab-pager">
									<button data-direction="prev" class="btn btn-default steps_btn">PREVIOUS</button>
									<button data-direction="next" class="btn btn-default steps_btn">Next</button>
									<button data-direction="finish" class="btn btn-default steps_btn">Submit for Review</button>
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
	<script>
		$('#add-course-tab').steps({
		  onFinish: function () {
			alert('Wizard Completed');
		  }
		});		
	</script>
	<script>
		$( function() {
			$( ".sortable" ).sortable();
			$( ".sortable" ).disableSelection();
		} );
  
	</script>
    @endsection