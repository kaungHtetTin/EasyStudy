	@php
    	$api_token = Cookie::get('api_auth_token');
		$user = Auth::user();
    @endphp

	@extends('instructor.master')

	@section('content')

    <style>
        .input_error{
			color:red;
			padding:5px;
			display: none;
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
	 
	<div class="wrapper">
		<div class="sa4d25">
			<div class="container-fluid">			
				<div class="row">
					<div class="col-12">	
						<h2 class="st_title"><i class="uil uil-edit-alt"></i> Edit Course</h2>
					</div>	
				</div>		
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section3125">			
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <div class="_215b03">
                                        <h2>{{$course->title}}</h2>
                                        <span class="_215b04">{{$course->category->title}} <i class="uil uil-arrow-right"></i> {{$course->sub_category->title}} <i class="uil uil-arrow-right"></i>  {{$course->topic->title}}</span>
                                    </div>
                                </div>							
                            </div>							
                        </div>							
                    </div>															
                </div>		
                <br><br>
				<div class="thumbnail-into">
                    <div class="row">
                        <div class="col-12">
                            <div class="thumb-item">
                                <div id="canvas-container" style="display: none">
                                    <canvas id="canvas"></canvas>
                                    <div id="crop-area" style="display:none"></div>
                                </div>
                                <canvas id="cropped-canvas" style="display: none"></canvas>
                                <img id="img_course_placeholder" src="{{asset('storage/'.$course->cover_url)}}" alt="">
                                <span class="input_error" id="input_course_thumbnail"> <br> Please select course thumbnail </span>
                                <div class="thumb-dt">													
                                    <div class="upload-btn">													
                                        <input class="uploadBtn-main-input" type="file" id="ThumbFile__input--source" accept="image/*">
                                        <label for="ThumbFile__input--source" title="Zip">Choose Thumbnail</label>
                                    </div>
                                    <span class="uploadBtn-main-file">Supports: jpg,jpeg, or png ( 530 x 300 Recommended )</span>
                                     
                                    <button id="btn_save" class="main-btn" style="width:80%;margin:auto;margin-top:20px;display:none">Save</button>
                                     
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
                 
               
			</div>
		</div>
		@include('instructor.components.footer')
	</div>
 
    <script>
        const apiToken = "{{$api_token}}";
        const canva_container = document.getElementById('canvas-container');

        $(document).ready(()=>{
            $('#btn_save').click(()=>{
                cropImageAndPutToInput((file)=>{
					 if(file==null){
                        $('#input_course_thumbnail').show();
                    }else{
                        uploadCoverPhoto(file);
                    }
				});
            });

            document.getElementById('ThumbFile__input--source').addEventListener('change', function (e) {
                const file = e.target.files[0];
                const reader = new FileReader();
                
                $('#canvas-container').show();
                $('#btn_save').show();
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

        });

        function uploadCoverPhoto(file){

			let formData = new FormData();
			formData.append('thumbnail_file', file);
			$('#cover_spinner_container').show();
			$('#cover_spinner').show();
			
			$.ajax({
				url: `{{asset("")}}instructor/api/courses/{{$course->id}}/update-cover-image`,
				type: 'POST',
				data: formData,
				contentType: false, // Important
				processData: false, // Important
				headers: {
					'Authorization': 'Bearer ' + apiToken,
					'Accept': 'application/json'
				},
				success: function(response) {

					window.location.href = "";

				},
				error: function(xhr, status, error) {
					console.log('Error:', xhr.status, error);
					 
				}
			});

		}

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
            
				onComplete(file);

			});
		}
    </script>

	@endsection