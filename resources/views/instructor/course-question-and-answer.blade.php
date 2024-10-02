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

		.content_body{
			overflow: auto;
	 
		}

		#editor{
			overflow: auto;
		}

		.content_body ul{
			list-style-type: disc;
			margin-inline-start: 20px;
			width: 100%;
		}

		.content_body div, #editor div{
			width: max-content;
		}




    </style>

	<!-- Add New Section Start -->
	<div class="modal fade" id="add_question_type_modal" tabindex="-1" aria-labelledby="lectureModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="lectureModalLabel">New Question Type</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="alert alert-warning">
						Be careful cause you cannot delete or edit after adding the new question type.
					</div>
					<div class="new-section-block">
						<div class="row">
							<div class="col-md-12" id="question_type_form_container">
								<div class="new-section">
									<div class="form_group">
										<label class="label25">Question Title*</label>
										<input id="input_question_type_title" class="form_input_1" type="text" placeholder="Question title here">
                                        <p id="input_question_type_error" style="display: none" class="error">The title field is required.</p>
									</div>
								</div>
							</div>
                            <div class="col-12" id="question_type_loading" style="display: none">
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
					<button id="btn_add_question_type" type="button" class="main-btn">Add Now</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Add New Section End -->
	    <!-- Delete Dialog Section Start -->
	<div class="modal fade" id="delete_dialog" tabindex="-1" aria-labelledby="lectureModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="lectureModalLabel">Delete</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="new-section-block">
						Do you reall want to delete
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="main-btn cancel" data-dismiss="modal">Close</button>
					<button id="btn_delete_dialog_add" onclick="deleteQA()" type="button" class="main-btn" data-dismiss="modal">Delete</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Delete Dialog Section End -->


	<!-- Add New Section Start -->
	<div class="modal fade" id="reply_dialog" tabindex="-1" aria-labelledby="lectureModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="lectureModalLabel">Reply</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="new-section-block">
						<div class="course_des_textarea lbel25">
							<div id="toolbar">
								<button data-command="bold" id="boldBtn"><i class="fas fa-bold"></i></button>
								<button data-command="italic" id="italicBtn"><i class="fas fa-italic"></i></button>
								<button data-command="insertUnorderedList" id="listBtn"><i class="fas fa-list-ul"></i></button>
								<button id="codeBtn"><i class="fas fa-code"></i></button>
								<button id="imageBtn"><i class="fas fa-image"></i></button>
							</div>
							<input id="dialog_input_file" type="file" accept="image/*" style="display: none">
							<div class="course_des_bg" >
								<div class="ui form swdh30">
									<div class="field">
										<div  id="editor" contenteditable="true"></div>
									</div>
								</div>
								
							</div>
							<span id="editor_input_error" style="color: red; padding:5px;display:none">*Please enter what on your mind.</span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="main-btn cancel" data-dismiss="modal">Close</button>
					<button id="btn_reply_dialog_add" type="button" class="main-btn" data-dismiss="modal">Post</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Add New Section End -->

	<div class="wrapper">
		<div class="sa4d25">
            <div class="container" id="main_container">	
				<div style="position: relative; display:flex;">
					<div style="flex:1"  id="main_layout">
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
											<h3 class="title"><i class="uil uil-comments-alt"></i> Question & Answer</h3>
										</div>
										
										<div>
											<div class="_215b03">
												<h2>{{$course->title}}</h2>
												<span class="_215b04">{{$course->category->title}} <i class="uil uil-arrow-right"></i> {{$course->sub_category->title}} <i class="uil uil-arrow-right"></i>  {{$course->topic->title}}</span>
											</div>

											<div class="_215b05">
												<h4>Related Question types</h4>
												<ul>
													@foreach ($course->question_types as $type)
														<li> <i class="uil uil-arrow-right"></i> {{$type->title}}</li>
													@endforeach
													
												</ul>
											</div>
											<br>
                                            <button class="main-btn color btn-hover ml-left add-section-title reloadFun" data-toggle="modal" data-target="#add_question_type_modal">New Question Type</button>
										</div>							
											
										 
									</div>
								</div>
							</div>
						</div>
						<br>
						 <div id="question_container">
                                                
						</div>

						<div class="" id="answer_container" style="display:none">
							<h5 id="btn_back_answer" style="cursor: pointer;margin-bottom:30px;"><i class='uil uil-arrow-left'></i> Back</h5>
							<div>
								<div class="review_item">
									<div class="review_usr_dt" id="question_layout">
										
									</div> 
									<div style="padding-left:50px;" id="answers_layout">

									</div>  
								</div>
							</div>

							<div id="answer_loading">
								<br><br><br>
								<div class="main-loader mt-50 mb-50">													
									<div class="spinner">
										<div class="bounce1"></div>
										<div class="bounce2"></div>
										<div class="bounce3"></div>
									</div>																										
								</div>
								<br><br><br>
								<br><br><br>
							</div>

						</div>

						<div id="question_loading">
							<br><br><br>
							<div class="main-loader mt-50 mb-50">													
								<div class="spinner">
									<div class="bounce1"></div>
									<div class="bounce2"></div>
									<div class="bounce3"></div>
								</div>																										
							</div>
							<br><br><br>
							<br><br><br>
						</div>
					</div>
					@include('instructor.components.course-menu-drawer')
				</div>

			</div>
		</div>
		@include('instructor.components.footer')
	</div>
	<!-- Body End -->

	<script src="{{asset('js/util.js')}}"></script>
	<script src="{{asset('js/editor.js')}}"></script>
	<script>

 		const apiToken = "{{$api_token}}";
        const course = @json($course);
		const imageShimmer = "{{asset('images/courses/img-1.jpg')}}";
		const user = @json($user);

		let is_question_fetching = false;
		let question_mode = true;
		let fetch_question_url = `/api/courses/${course.id}/questions`;
		let questionArr = [];

		let is_answer_is_fetching = false;
		let answer_mode = false;

		let reply_question_id = 0;
		 
	 
		$(document).ready(()=>{

			$('#main_layout').width(300);

			$(window).scroll(()=>{
                if($(window).scrollTop() + $(window).height() > $(document).height() - 500) {
                    if(!is_question_fetching && question_mode){
                        fetchQuestion();
                    }

					if(!is_answer_is_fetching && answer_mode){
                        fetchAnswer();
                    }
                }
            });

			fetchQuestion();

			$('#btn_add_question_type').click(()=>{
				addNewQuestionType();
			})

			$('#btn_back_answer').click(()=>{
                $('#question_container').show();
                $('#answer_container').hide();
                $('#question_loading').hide();
                $('#search_input').show();

				question_mode = true;
				answer_mode = false;
            })

			$('#imageBtn').click(()=>{
				$('#dialog_input_file').click();
			})

			$('#dialog_input_file').change(()=>{
				var files=$('#dialog_input_file').prop('files');
				var file=files[0];
					
				uploadPhoto(file)
			})

			$('#btn_reply_dialog_add').click(()=>{
				reply();
			})

			$('#editor').on('input',()=>{ $('#editor_input_error').hide() })
		})

		function fetchQuestion(){
            is_question_fetching = true;
            $('#question_loading').show();
            if(fetch_question_url==null){
                $('#question_loading').hide();
                return;
            }

            $.get(fetch_question_url,function(res,status){
                is_question_fetching=false;
                $('#question_loading').hide();
                if(res){
                    fetch_question_url = res.next_page_url;
                    let questions = res.data;
                    setQuestions(questions);
					console.log(questions);
                    
                }
                
            })
        }

        function setQuestions(questions){
            questions.map((question,index)=>{
                $('#question_container').append(questionComponent(question));
                questionArr.push(question);
            })
        }

        function questionComponent(question){
            return `
				<div id="question_component_${question.id}">
					<div class="fcrse_1" style="margin-bottom:5px;">
						<div class="review_usr_dt">
							<img src="http://localhost:8000/storage/${question.user.image_url}" alt="">
							<div class="rv1458" style="width:100%">
								<h5 class="">${question.title}</h5>
								<span style="display: inline" class="time_145">By ${question.user.name}</span> . <span style="display: inline"  class="time_145">${formatDateTime(new Date(question.created_at))}</span>
								<span style="float:right;cursor:pointer" onclick="replyNow(${question.id})"><u>Reply Now </u><i class='uil uil-comments-alt'></i> ${question.answer_count} </span>
								<span style="float:right;cursor:pointer" onclick="defineDeleteQA(${question.id},true)"  data-toggle="modal" data-target="#delete_dialog"><u>Delete </u><i class='uil uil-trash'></i> </span>
							</div>
						</div>   
					</div>
				</div>
            `;
        }

		function replyNow(question_id){
			question_mode = false;
			answer_mode = true;
            const question = questionArr.find(q=>q.id ===question_id );
            $('#answers_layout').html("");
            $('#question_layout').html(`
                <img src="http://localhost:8000/storage/${question.user.image_url}" alt="">
                <div class="rv1458" style="width:100%">
                    <div>
                        <h5 class="">${question.title}</h5>
                        <div class="content_body">${question.body}</div>
                        <br>
                    </div>
                    
                    <span style="display: inline" class="time_145">By ${question.user.name}</span> . <span style="display: inline"  class="time_145">${formatDateTime(new Date(question.created_at))}</span>
                    <span onclick="defineReply(${question_id})"  style="float:right;cursor:pointer" data-toggle="modal" data-target="#reply_dialog" ><u>Answer</u><i class='uil uil-comments-alt'></i> ${question.answer_count} </span>
                </div>
            `);


            $('#question_container').hide();
            $('#answer_container').show();

            fetch_answer_url= `/api/courses/${course.id}/questions/${question.id}/answers`;
            fetchAnswer();

        }

		function fetchAnswer(question_id){
            is_answer_is_fetching = true;
            $('#answer_loading').show();
            if(fetch_answer_url==null){
                $('#answer_loading').hide();
                return;
            }

            $.get(fetch_answer_url,function(res,status){
                is_answer_is_fetching=false;
                $('#answer_loading').hide();
                if(res){
                    fetch_answer_url = res.next_page_url;
                    let answers = res.data;
					console.log(answers);
					setAnswer(answers);
                     
                }
                
            })
        }

		function setAnswer(answers){
			answers.map((answer,index)=>{
                $('#answers_layout').append(answerComponent(answer));
               // questionArr.push(question);
            })
		}

		function answerComponent(answer){
			return `
				<div class="review_item" id="answer_component_${answer.id}">
					<div class="review_usr_dt">
						<img src="http://localhost:8000/storage/${answer.user.image_url}" alt="" style="width:30px; height:30px;">
						<div class="rv1458"  style="width:100%">
							<div class="content_body">${answer.body}</div>
							<span style="display: inline" class="time_145">By ${answer.user.name}</span> . <span style="display: inline"  class="time_145">${formatDateTime(new Date(answer.created_at))}</span>
							. <span onclick="defineReply(${answer.question_id})"  style="cursor:pointer" data-toggle="modal" data-target="#reply_dialog" ><u>Answer</u><i class='uil uil-comments-alt'></i>  </span>
							. <span style="cursor:pointer" onclick="defineDeleteQA(${answer.id},false)"  data-toggle="modal" data-target="#delete_dialog"><u>Delete </u><i class='uil uil-trash'></i> </span>
						</div>
					</div>
				</div>
			`;
		}

		function addNewQuestionType(){
			let course_id = course.id;
			let title = $('#input_question_type_title').val();
			$('#input_question_type_error').hide();
			if(title == ""){
				$('#input_question_type_error').show();
				return; 
			}

			$('#question_type_form_container').hide();
			$('#question_type_loading').show();
			$.ajax({
				url: 'http://localhost:8000/instructor/api/question-types', // Replace with your API endpoint
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
					console.log(response);
				},
				error: function(xhr, status, error) {
					console.error('Error:', status, error);
				}
			});
		}

		function defineReply(question_id){
			$('#editor').html("");
			reply_question_id = question_id;
		}

		function reply(){
			const body = $('#editor').html();
			if(body==""){
				$('#editor_input_error').show();
				return;
			}

			let formData = {};
			formData.body = body;
			formData.user_id = user.id;
			formData.question_id = reply_question_id;
			 
			console.log(formData);
			$.ajax({
				url: `http://localhost:8000/api/answers`,
				type: 'POST',
				data: formData,
				headers: {
					'Authorization': 'Bearer ' + apiToken,
					'Accept': 'application/json'
				},
				success: function(response) {
					let answer = response;
                    answer.user = user;
                    $('#answers_layout').append(answerComponent(answer));
				 
				},
				error: function(xhr, status, error) {
					console.log('Error:', xhr.status, error);
					 
				}
			});

		}

		function uploadPhoto(file){
			var image_id = Date.now();
			let imageView = `
				<br>
				<img style="width:200px;border-radius:5px;height:auto" id="${image_id}" src = "${imageShimmer}" />
				<br>
			`;
			$('#editor').append(imageView);

			let formData = new FormData();
			formData.append('image_file', file);

			$.ajax({
				url: `http://localhost:8000/api/questions/upload-photo`,
				type: 'POST',
				data: formData,
				contentType: false, // Important
				processData: false, // Important
				headers: {
					'Authorization': 'Bearer ' + apiToken,
					'Accept': 'application/json'
				},
				success: function(response) {
					console.log(response);
					$('#'+image_id).attr('src',"http://localhost:8000/storage/"+response);
				},
				error: function(xhr, status, error) {
					console.log('Error:', xhr.status, error);
					 
				}
			});
			
		}

		var deleteQAContentId = 0;
        var isQuestionDelete;

        function defineDeleteQA(id, isQuestion){
            deleteQAContentId = id;
            isQuestionDelete = isQuestion;
        }

        function deleteQA(){
            let api_url;
            if(isQuestionDelete){
                api_url = `/api/questions/${deleteQAContentId}`;
                $('#question_component_'+deleteQAContentId).html("");
            }else{
                api_url = `/api/answers/${deleteQAContentId}`;
                $('#answer_component_'+deleteQAContentId).html("");
            }
            
             $.ajax({
				url: api_url, // Replace with your API endpoint
				type: 'DELETE', // or 'GET' depending on your request
				headers: {
					'Authorization': 'Bearer '+apiToken // Example for Authorization header
				},
                
				success: function(response) {

				},
				error: function(xhr, status, error) {
					console.error('Error:', status, error);
				}
			});
        }

	</script>
	@endsection

	


	