	@php
    	$api_token = Cookie::get('api_auth_token');
		$user = Auth::user();

	 


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

		.rating-star1 {
			font-size: 1rem;
			width: 1rem;
			height: 1rem;
			position: relative;
			display: inline-block;
		}
		
 
    </style>

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
						<button id="btn_delete_dialog_add" type="button" class="main-btn" data-dismiss="modal">Delete</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Delete Dialog Section End -->

	<div class="wrapper">
		<div class="sa4d25">
            <div class="container">	
				<div style="position: relative; display:flex">
					<div style="flex:1">
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
											<h3 class="title"><i class="uil uil-notes"></i> Announcements</h3>
										</div>
										
										<div>
											<div class="_215b03">
												<h2>{{$course->title}}</h2>
												<span class="_215b04">{{$course->category->title}} <i class="uil uil-arrow-right"></i> {{$course->sub_category->title}} <i class="uil uil-arrow-right"></i>  {{$course->topic->title}}</span>
											</div>
											                                           
										</div>
										
										<div class="student_reviews" style="">
											<div class="reviews_left">
												<h4>Create new</h4>
												<div style="display: flex;margin-top:10px;">
                                                    <div>
                                                        <img src="{{asset('storage/'.$user->image_url)}}" alt="" style="width: 30px;height:30px; border-radius:50px;">
                                                    </div>
                                                    <div style="margin-left: 15px;flex:1;margin-right:15px;">
														<span style="font-weight:bold;margin-bottom:5px;">{{$course->title}}</span> <br>
														<span>By {{$user->name}}</span>

														<br><br>
														<form action="{{route('instructor.announcements.save')}}" method="post" enctype="multipart/form-data">
															@csrf
															<div class="ui search focus lbel25">	
																<div class="ui form swdh30">
																	<div class="field">
																		<textarea rows="3" name="body" id="" placeholder="Enter your anouncement here..."></textarea>
																		<div style="display: flex">
																			<div id="btn_add_img" class="btn_span" style="padding: 5px; margin:5px;width:max-content"> Photo <i class="uil uil-camera-plus"></i></div>
																			<div id="btn_add_resource" class="btn_span" style="padding: 5px; margin:5px;width:max-content"> Resource (.zip)  <i class="uil uil-link-alt"></i></div>
																		</div>
																		<img id="img_post" style="width:100px;margin-top:10px;border-radius:3px;display:none" src="" alt="">
																		<div class="resource" id="resource_attachment" style="display: none"></div>
																	</div>
																</div>
															</div>	
															<input id="input_image_file" type="file" accept="image/*" name="attach_photo" style="display: none"/>
															<input id="input_resource_file" type="file" accept=".zip" name="attach_resource" style="display: none"/>
															<input type="hidden" name="course_id" value="{{$course->id}}" />
															<button class="main-btn" type="submit" style="float: right;margin-top:10px;">Post</button>		
														</form>
                                                    </div>
                                                </div>
											</div>	

											<div id="anouncement_container">

											</div>

											<div class="row" id="shimmer">				
												<div class="col-md-12">
													<br><br><br>
													<div class="main-loader mt-50">													
														<div class="spinner">
															<div class="bounce1"></div>
															<div class="bounce2"></div>
															<div class="bounce3"></div>
														</div>																										
													</div>
													<br><br><br>
												</div>
												<div class="col-md-12">
													<br><br><br>
												</div>
											</div>			
											
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

		<script>

			const apiToken = "{{$api_token}}";
			const course = @json($course);
        	const user = @json($user);

			let is_anouncement_fetching = false;
			let anouncementArr = [];
			let fetch_anouncement_url = `/api/courses/${course.id}/announcements`;

			$(document).ready(()=>{
	 
				fetchAnnouncements();

				$(window).scroll(()=>{
					if($(window).scrollTop() + $(window).height() > $(document).height() - 500) {
						if(!is_anouncement_fetching){
							fetchAnnouncements();
						}
					}
				});

				$('#btn_add_img').click(()=>{
					$('#input_image_file').click();
				})

				$('#btn_add_resource').click(()=>{
					$('#input_resource_file').click();
				})

				$('#input_image_file').change(()=>{
					let files = $('#input_image_file').prop('files');
					let file = files[0];
					let reader = new FileReader();
					reader.onload = function (e) {
						imageSrc=e.target.result;
						$('#img_post').attr('src', imageSrc);
						$('#img_post').show();
						
					};
					reader.readAsDataURL(file);
				});

				$('#input_resource_file').change(()=>{
					let files = $('#input_resource_file').prop('files');
					let file = files[0];
					if(file){
						let fileName = file.name;
						$('#resource_attachment').html(fileName);
						$('#resource_attachment').show();
					}
				})

			})

			
			function fetchAnnouncements(){
				is_anouncement_fetching = true;
				$('#shimmer').show();
				if(fetch_anouncement_url==null){
					$('#shimmer').hide();
					return;
				}

				$.get(fetch_anouncement_url,function(res,status){
					is_anouncement_fetching=false;
					if(res){
						fetch_anouncement_url = res.next_page_url;
						let anouncements = res.data;
						setAnouncement(anouncements);
						console.log(anouncements);
					}
					
				})
			}

			function setAnouncement(anouncements){
					$('#shimmer').hide();
					anouncements.map((anouncement,index)=>{
						anouncementArr.push(anouncement);	
						$('#anouncement_container').append(anouncementComponent(anouncement));
					})
			}

			function anouncementComponent(anouncement){
				let photo_attachment = "";
				if(anouncement.image_url!=""){
					photo_attachment = `<img style="width:100px;margin-top:10px;border-radius:3px;" src="http://localhost:8000/storage/${anouncement.image_url}" alt="">`;
				}
				let resource_file = "";
				if(anouncement.resource_url!=""){
					resource_file = `
					 <a href="http://localhost:8000/storage/${anouncement.resource_url}"> <div class="resource" id="resource_attachment">Resource <i class="uil uil-download-alt"></i></div> </a>
					`;
				}
				return `
					<div class="reviews_left" style="margin-top: 5px;">
						<div style="display: flex;">
							<div>
								<img src="http://localhost:8000/storage/${user.image_url}" alt="" style="width: 30px;height:30px; border-radius:50px;">
							</div>
							<div style="margin-left: 15px;flex:1;margin-right:15px;">
								<span style="font-weight:bold;margin-bottom:5px;">{{$course->title}}</span> <br>
								<span class="time_145">Announced by ${user.name} . ${formatDateTime(new Date(anouncement.created_at))}</span>

								<br>
								<div>
									${anouncement.body}	<br>
									${photo_attachment}
									${resource_file}
								</div>
								<span class="btn_span" style="float:right" onclick=""  data-toggle="modal" data-target="#delete_dialog">Delete<i class='uil uil-trash'></i> </span>
							</div>
						</div>					
					</div>
				`
			}

			function defineDeleteItem(id){

			}

			function deleteReview(){

			}
				
		</script>
		<script src="{{asset('js/util.js')}}"></script>

	</div>
	<!-- Body End -->
	@endsection

	


	