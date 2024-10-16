	@php
    	$api_token = Cookie::get('api_auth_token');
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

		.description_preview ul{
			list-style-type: disc;
			margin-inline-start: 20px;
		}


	</style>
	<div class="wrapper">
		<div class="sa4d25">
			<div class="container-fluid">		
				@if (session('msg'))
					<div class="alert alert-success">
						{{ session('msg') }}
					</div>
				@endif	
				<div class="row">
					<div class="col-6">	
						<h2 class="st_title"><i class="uil uil-edit-alt"></i> Edit Blog</h2>
					</div>	
				</div>			
                <br>	
				<div class="row">
					<div class="col-12">
						<div class="course__form">
                            <div class="general_info10">
                                <form action="{{route('instructor.blogs.change',$blog->id)}}" method="post" enctype="multipart/form-data" id="form_blog_create">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">															
                                            <div class="ui search focus mt-30 lbel25">
                                                <label>Blog Title*</label> <span class="input_error" id="input_title_error"> Please enter the title </span>
                                                <div class="ui left icon input swdh19">
                                                    <input id="input_title" class="prompt srch_explore" type="text" placeholder="Course title here" name="title" data-purpose="edit-course-title" maxlength="60" id="main[title]" value="{{$blog->title}}">															
                                                    <div id="title_count" class="badge_num">60</div>
                                                </div>
                                                    
                                            </div>									
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group1 mt-30">
                                                <label for="file5">Blog cover photo (Optional)</label>
                                                <div class="image-upload-wrap">
                                                    <input class="file-upload-input" name="cover_image" id="input_cover_photo" type="file" onchange="readURL(this);" accept="image/*">
                                                    <div class="drag-text">
                                                    <i id="upload_icon" style="{{$blog->image_url == "" ? "" : "display:none"}}" class="fas fa-cloud-upload-alt"></i>
                                                    <img src= "{{asset('storage/'.$blog->image_url)}}" id="upload_cover_image"  alt="" style="width: 250px;border-radius:3px; {{$blog->image_url == "" ? "display:none" : ""}}">
                                                    <h4>Select an image to upload</h4>
                                                    <p>or drag and drop screenshots</p>
                                                    </div>
                                                </div>															
                                            </div>
                                        </div>

										<div class="col-lg-12 col-md-12">															
											<div class="ui search focus lbel25 mt-30">	
												<label>Summary*</label>
												<span class="input_error" id="input_summary_error"> Please enter the summary </span>
												<div class="ui form swdh30">
													<div class="field">
														<textarea rows="3" name="summary" id="input_summary" placeholder="Blog summary here ...">{{$blog->summary}}</textarea>
													</div>
												</div>
												<div class="help-block" id="summary_count">220 words</div>
											</div>								
										</div>

                                        <div class="col-lg-12 col-md-12">
                                            <div class="course_des_textarea mt-30 lbel25">
                                                <label>Blog Description*</label>
                                                <span class="input_error" id="editor_error"> Please enter blog description </span>
                                                <div class="course_des_bg">
                                                    <div id="toolbar">
                                                        <button type="button" data-command="bold" id="boldBtn"><i class="fas fa-bold"></i></button>
                                                        <button type="button" data-command="italic" id="italicBtn"><i class="fas fa-italic"></i></button>
                                                        <button type="button" data-command="insertUnorderedList" id="listBtn"><i class="fas fa-list-ul"></i></button>
                                                        <button type="button" id="codeBtn"><i class="fas fa-code"></i></button>
                                                        <button type="button" id="imageBtn"><i class="fas fa-image"></i></button>
                                                    </div>
                                                    <div class="ui form swdh30">
                                                        <div class="field">
                                                            <div id="editor" contenteditable="true"><?= $blog->body ?></div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
											<input type="text" id="input_description" name="description" style="display: none">
                                        </div>

                                        <div class="col-12">
                                        <div class="mt-30">
                                            <button id="btn_submit" type="button" class="main-btn" style="float:right">Update</button>
                                        </div>
                                        </div>
                                        
                                    </div>
                                </form>
                                <input id="editor_input_file" type="file" accept="image/*" style="display: none">
                                
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>
		@include('instructor.components.footer')
	</div>
	<!-- Body End -->
	 
	<script src="{{asset('js/util.js')}}"></script>
    <script src="{{asset('js/editor.js')}}"></script>
    <script>

        const imageShimmer = "{{asset('images/courses/img-1.jpg')}}";
        const apiToken = "{{$api_token}}";
        const user = @json($user);

        $(document).ready(()=>{

            $('#imageBtn').click(()=>{
				$('#editor_input_file').click();
			})

            $('#editor_input_file').change(()=>{
				var files=$('#editor_input_file').prop('files');
				var file=files[0];
				uploadPhoto(file);
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

			$('#input_summary').on('input',()=>{
				$('#input_summary_error').hide();
				let summary = $('#input_summary').val();
				const letterLimit = 220;
				let letterCount = summary.length;
				if(letterCount>letterLimit){
					$('#input_summary').val(summary.substring(0,220));
				}else{
					$number = letterLimit - letterCount;
					$number = $number>1 ? $number +' words': $number+' word';
                    $('#summary_count').html($number);
				}
			});

            $('#editor').on('input',()=> $('#editor_error').hide());

            $('#input_cover_photo').change(()=>{
                let files = $('#input_cover_photo').prop('files');
                let file = files[0];
               
                let reader = new FileReader();
                reader.onload = function (e){
                    imageSrc=e.target.result;
                    $('#upload_cover_image').attr('src', imageSrc);
                    $('#upload_cover_image').show();
                    $('#upload_icon').hide();
                }

                reader.readAsDataURL(file);
            })

            $('#btn_submit').click(()=>{

                let isValidate = true;
                const title = $('#input_title').val();
                if(title==""){
                    isValidate = false;
                    $('#input_title_error').show();
                }

                const description = $('#editor').html();
                if(description==""){
                    isValidate = false;
                    $('#editor_error').show();
                }else{
					$('#input_description').val(description);
				}

				const summary = $('#input_summary').val();
				if(summary==""){
					isValidate = false;
					$('#input_summary_error').show();
				}

                if(isValidate) $('#form_blog_create').submit();
            })

        });

        function uploadPhoto(file){
			var image_id = Date.now();
			let imageView = `
				<br>
				<img style="width:75%;border-radius:5px;height:auto;margin:auto" id="${image_id}" src = "${imageShimmer}" />
				<br>
			`;
			$('#editor').append(imageView);

			let formData = new FormData();
			formData.append('image_file', file);

			$.ajax({
				url: `http://localhost:8000/api/blogs/upload-photo`,
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
    </script>
	@endsection