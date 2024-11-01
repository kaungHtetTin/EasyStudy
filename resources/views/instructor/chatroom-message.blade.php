	@php
		$user = Auth::user();
    @endphp

	@extends('instructor.master')

	@section('content')

	<div class="modal fade" id="delete-section" tabindex="-1" aria-labelledby="lectureModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="lectureModalLabel">Delete Conversation</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="alert alert-warning">
						 Do you really want to delete this conversation.
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="main-btn cancel" data-dismiss="modal">Close</button>
					<form action="{{route('instructor.chatrooms.remove')}}" method="post">
						<input type="hidden" name="user_id" value="{{$other->id}}">
						@csrf
						@method('DELETE')
						<button type="submit" class="main-btn">Delete</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="block-section" tabindex="-1" aria-labelledby="lectureModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="lectureModalLabel">Block Messaging</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="alert alert-warning">
						 Do you really want to block this user on messaging.
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="main-btn cancel" data-dismiss="modal">Close</button>
					<form action="{{route('users.block',$other->id)}}" method="post">
						@csrf
						<button type="submit" class="main-btn">Block</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="unblock-section" tabindex="-1" aria-labelledby="lectureModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="lectureModalLabel">Unblock Messaging</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="alert alert-warning">
						 Do you really want to unblock this user on messaging.
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="main-btn cancel" data-dismiss="modal">Close</button>
					<form action="{{route('users.unblock',$other->id)}}" method="post">
						@csrf
						<button type="submit" class="main-btn">Unblock</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<div class="wrapper">
		<div class="sa4d25">
			<div class="container-fluid">	
				@if (session('msg'))
					<div class="alert alert-success">
						{{session('msg')}}
					</div>
				@endif		
				@if (session('error'))
					<div class="alert alert-success">
						{{session('error')}}
					</div>
				@endif		
				<div class="row">
					<div class="col-12">
						<div class="all_msg_bg" style="margin-top:0px;">
							<div class="row no-gutters">
								<div class="col-12">			
									<div class="chatbox_right">
										<div class="chat_header">
											<div class="user-status">											
												<div class="user-avatar">
													<a href="{{route('profile',$other->id)}}">
														<img src="{{asset('storage/'.$other->image_url)}}" alt="">
													</a>
												</div>
												<p class="user-status-title"><span class="bold">{{$other->name}}</span></p>
												@if ($block)
													<span class="offline-status">Messaging is disabled</span>
												@else
													<div id="user_status">
														<span class="offline-status">Checking...</span>
													</div>
												@endif
																									
												<div class="user-status-time floaty eps_dots eps_dots5 more_dropdown">
													<a href="#"><i class="uil uil-ellipsis-h"></i></a>
													<div class="dropdown-content">
														<span onclick="window.location.href='{{route('profile',$other->id)}}'"><i class="uil uil-eye"></i>Profile</span>	
														<span data-toggle="modal" data-target="#delete-section"><i class="uil uil-trash-alt"></i>Delete</span>
														@if ($block)
															<span data-toggle="modal" data-target="#unblock-section"><i class="uil uil-ban"></i>Unblock</span>
														@else
															<span data-toggle="modal" data-target="#block-section"><i class="uil uil-ban"></i>Block</span>
														@endif
														<span><i class="uil uil-windsock"></i>Report</span>															
														{{-- <span><i class="uil uil-volume-mute"></i>Mute</span> --}}
													 </div>																										
												</div>													
											</div>
										</div> 
										<div class="row" id="shimmer">				
											<div class="col-md-12">
												<div class="main-loader mt-50">													
													<div class="spinner">
														<div class="bounce1"></div>
														<div class="bounce2"></div>
														<div class="bounce3"></div>
													</div>																										
												</div>
											</div>
										</div>		
										<div id="msg_profile" style="display: none;text-align:center">
											<div class="">
												<img src="{{asset('storage/'.$other->image_url)}}" alt="" style="width:80px;height:80px; border-radius:50%;margin-top:70px;">
											</div>
											<p style="font-size: 18px; text-align:center;margin-top:10px;">
												<span class="bold">{{$other->name}}</span> <br>
												
											</p>
											<span class="bold">Start a new message</span>
										</div>
										<div class="messages-line simplebar-content-wrapper2 scrollstyle_4" id="scroll_warpper">	
											<div class="mCustomScrollbar" id="message_container">	

											</div>
										</div>
										@if ($block)
											<div class="message-send-area">
												@if ($block->my_id == $user->id)
													<div>
														<span style="color:#999">The user was blocked. You need to unblock to send a message.</span>
														<span class="btn_span" data-toggle="modal" data-target="#unblock-section">Unblock now</span>
													</div>
												@else
													<span style="color:#999">You can't reply this message.</span>
												@endif
											</div>
										@else
											<div class="message-send-area">
												<div id="img_box" style="display: none">
													 <img id="img_display" src="" alt="" style="height:100px;border-radius:3px;">
													 <span id="img_cancel" style="font-size:20px; color:red;cursor: pointer;"><i class="uil uil-times-circle"></i></span>
												</div>
												<input id="input_image" type="file" style="display: none" accept="image/*">
												
												<div class="mf-field" style="display: flex">
													<div class="ui search focus input__msg">
														<div class="ui left icon input swdh19" style="width:100%">
															<input class="prompt srch_explore" type="text" id="input_message_text" name="chat_widget_message_text_2" placeholder="Write a message...">
														</div>
													</div>
													<span id="btn_select_image" class="send-image"><i class="uil uil-image-upload"></i></span>
													<button id="btn_sent_message" class="add_msg" type="submit"><i class="uil uil-message"></i></button>
												</div>
											</div>
										@endif
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
	<!-- Body End -->
 
	<script src="{{asset('js/util.js')}}"></script>
	<script>
		const user = @json($user);
		const other = @json($other);
		let root_dir = `{{asset("")}}`;
	</script>
	<script src="{{asset('js/chat.js')}}"></script>

	@endsection