	@php
    	$api_token = Cookie::get('api_auth_token');
		$user = Auth::user();
    @endphp

	@extends('instructor.master')

	@section('content')
	<style>
		.item-notification{
			cursor: pointer;
		}

		.item-notification:hover{
			color: #475692;
    		background-color: #e6e4ff;
		}

		.night-mode .item-notification:hover{
			color: #475692;
    		background-color: #555;
		}


	</style>
	<div class="wrapper">
		<div class="sa4d25">
			<div class="container-fluid">			
				<div class="row">
					<div class="col-6">	
						<h2 class="st_title"><i class="uil uil-bell"></i> Notifications</h2>
					</div>	
					<div class="col-6">
						<span id="btn_readAll" class="btn_span" style="float:right">Mark as read all <i class="uil  uil-cloud-check"></i></span>
					</div>	
					<div class="col-12">
						<a href="#" class="setting_noti">Notification Setting</a>
					</div>				
				</div>		
				<br>		
				<div class="row">
					<div class="col-12">
						
						<div class="" id="notification_container">
							
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
		@include('instructor.components.footer')
	</div>
	<!-- Body End -->
	<script>
		{
			const apiToken = "{{$api_token}}";
        	const user = @json($user);

			let is_fetching = false;
			let arr = [];
			let fetch_url = `{{asset("")}}instructor-dashboard/api/notifications?page=1`

			$(document).ready(()=>{
	
				fetchNotification();

				$(window).scroll(()=>{
					if($(window).scrollTop() + $(window).height() > $(document).height() - 500) {
						if(!is_fetching){
							fetchNotification();
						}
					}
				});

				$('#btn_readAll').click(()=>{
					readAll();
				})

			})

			function fetchNotification(){
				is_fetching = true;
				$('#shimmer').show();
				if(fetch_url==null){
					$('#shimmer').hide();
					return;
				}
				$.ajax({
					url: fetch_url,
					type: 'GET', // or 'GET' depending on your request
					headers: {
						'Authorization': 'Bearer '+apiToken // Example for Authorization header
					},
					
					success: function(res) {
						is_fetching=false;
						if(res){
							fetch_url = res.next_page_url;
							let notifications = res.data;
							setNotifications(notifications);
							
						}
					},
					error: function(xhr, status, error) {
						console.error('Error:', status, error);
					}
				});
			}

			function setNotifications(notifications){
				$('#shimmer').hide();
				notifications.map((notification,index)=>{
					arr.push(notification);	
					$('#notification_container').append(notificationComponent(notification));
				})

				if(arr.length==0){
					$('#notification_container').html(`
						<div style="text-align: center;color:#888">
							<br><br><br><br><br>
							<i style="font-size:80px;" class="uil uil-bell"></i><br><br>
								<span style="font-size: 20px;">No notification</span>
							<br><br><br><br><br>
						</div>
					`)
				}
			}

			function notificationComponent(notification){
				let seen = notification.seen==1?"":"bg-unseen";
				return `
					<div id="noti_${notification.id}" onclick=notificationClick(${notification.id}) class="channel_my item all__noti5 item-notification ${seen}">
						<div class="profile_link">
							<div>
								<img src="{{asset('')}}storage/${notification.user.image_url}" alt=""/>
								${notification.notification_type.web_icon}
							</div>
							<div class="pd_content">
								<h6>${notification.user.name}</h6>
								<p class="noti__text5">${notification.notification_type.description} <strong>${notification.body}</strong>.</p>
								<span class="nm_time">${formatDateTime(new Date(notification.created_at))}</span>
							</div>	
												
						</div>							
					</div>
				`;
			}

			function notificationClick(id){
				const notification = arr.find((notification)=> notification.id == id);
				if(notification.seen == 0){
					$('#noti_'+notification.id).attr('class','channel_my item all__noti5 item-notification');
					seen(id,()=>{ location.href = createNotificationToUrl(notification,"{{asset('')}}"); });
				}else{
					location.href = createNotificationToUrl(notification,"{{asset('')}}");
				}
			}

			function seen(notification_id,loadPage){
				$.ajax({
					url: `{{asset("")}}instructor-dashboard/api/notifications/${notification_id}`, // Replace with your API endpoint
					type: 'PUT', // or 'GET' depending on your request
					headers: {
						'Authorization': 'Bearer '+apiToken // Example for Authorization header
					},
					success: function(response) {
						 loadPage();
					},
					error: function(xhr, status, error) {
						console.error('Error:', status, error);
					}
				});
			}

			function readAll(){

				$('.item-notification').each((index,item)=>{
					$(item).attr('class','channel_my item all__noti5 item-notification');
				})

				$.ajax({
					url: `{{asset("")}}instructor-dashboard/api/mark-as-read-all-notifications`, // Replace with your API endpoint
					type: 'POST', // or 'GET' depending on your request
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

		}
	</script>
	<script src="{{asset('js/util.js')}}"></script>

	@endsection