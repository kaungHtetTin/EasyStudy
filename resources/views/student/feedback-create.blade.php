@php
    $api_token = Cookie::get('api_auth_token');
    $user = Auth::user();
@endphp

@extends('student.components.master')

@section('content')
	<style>
		#input_error{
			color:red;
			display: none;
		}
	</style>
	@auth
	<div class="wrapper">
	@else
	<div style="padding-top:60px;">
	@endauth
		<div class="sa4d25">
			 <div class="container-fluid">		
				@if (session('msg'))
					<div class="alert alert-success">
						{{ session('msg') }}
					</div>
				@endif

				<div class="row">
					<div class="col-lg-12">
						<h2 class="st_title"><i class="uil uil-comment-info-alt"></i> Send Feedback</h2>
						<div class="row">
							<div class="col-lg-6 col-md-8">
								<form action="{{route('feedback.save')}}" method="post" id="feedback_form" enctype="multipart/form-data">
									@csrf
									<p id="input_error">Please enter the description or add a screenshot</p>
									<div class="ui search focus">																
										<div class="ui form swdh30">
											<div class="field">
												<textarea rows="6" name="description" id="input_description" placeholder="Describe your issue or share your ideas"></textarea>
											</div>
										</div>
									</div>

									<div class="form-group1 mt-30">
										<label for="file5">Add Screenshots</label>
										<div class="image-upload-wrap">
											<input class="file-upload-input" name="screenshot_image" id="input_screenshot" type="file" onchange="readURL(this);" accept="image/*">
											<div class="drag-text">
											<i id="upload_icon" class="fas fa-cloud-upload-alt"></i>
											<img id="upload_image"  alt="" style="width: 150px;border-radius:3px;display:none">
											<h4>Select screenshots to upload</h4>
											<p>or drag and drop screenshots</p>
											</div>
										</div>															
									</div>
								</form>	
								<button id="btn_save" class="save_btn">Send Feedback</button>
							</div>
						</div>
					</div>						
				</div>
			</div>
		</div>

		<script>

			let imageSrc = "";

			$(document).ready(()=>{
				$('#input_screenshot').change(()=>{
					let files = $('#input_screenshot').prop('files');
					let file = files[0];
					$('#input_error').hide();

					let reader = new FileReader();
					reader.onload = function (e){
						imageSrc=e.target.result;
						$('#upload_image').attr('src', imageSrc);
						$('#upload_image').show();
						$('#upload_icon').hide();
					}

					reader.readAsDataURL(file);
				})

				$('#input_description').on('input',()=>{ $('#input_error').hide(); })

				$('#btn_save').click(()=>{
					const description = $('#input_description').val();
					if(description=="" && imageSrc==""){
						$('#input_error').show();
					}else{
						$('#feedback_form').submit();
					}
				})
			})


		</script>
@endsection
