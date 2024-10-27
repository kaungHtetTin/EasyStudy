@php
    $api_token = Cookie::get('api_auth_token');
    $user = Auth::user();
@endphp

@extends('student.components.master')


@section('content')

	@auth
	<div class="wrapper">
	@else
	<div style="padding-top:60px;">
	@endauth
		<div class="sa4d25">
			<div class="container-fluid">	
				@if (session('msg'))
					<div class="alert alert-success">
						{{session('msg')}}
					</div>
				@endif			
				<div class="row">
					<div class="col-lg-12">	
						<h2 class="st_title"><i class="uil uil-comments"></i> Messages</h2>
					</div>					
				</div>				
				<div class="row">
					<div class="col-12">
						<div class="all_msg_bg">
							<div class="row no-gutters">
								<div class="col-12">					
									<div class="msg_search">
										<div class="ui search focus">
											<div class="ui left icon input swdh11 swdh15">
												<input class="prompt srch_explore" type="text" placeholder="Search Messages...">
												<i class="uil uil-search-alt icon icon8"></i>
											</div>
										</div>
									</div>
									<div class="simplebar-content-wrapper">
										<div class="group_messages" id="conversation_container"> 

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
			</div>
		</div>
    
	<script src="{{asset('js/util.js')}}"></script>
	<script>
		const apiToken = "{{$api_token}}";
		const user = @json($user);
		const root_dir = `{{asset("")}}`;
		const target_dir = `{{asset('')}}`;
	</script>
	<script src="{{asset('js/conversation.js')}}"></script>
@endsection