@php
    $api_token = Cookie::get('api_auth_token');
    $user = Auth::user();
@endphp

	<style>
		/* .my-nav-item{
			cursor: pointer;
		}

		.my-nav-item:hover{
			color: #475692;
    		background-color: #e6e4ff;
		}

		.night-mode .my-nav-item:hover{
			color: #475692;
    		background-color: #555;
		} */


	</style>

<header class="header clearfix">
    <button type="button" id="toggleMenu" class="toggle_menu">
        <i class='uil uil-bars'></i>
    </button>
    <button id="collapse_menu" class="collapse_menu">
        <i class="uil uil-bars collapse_menu--icon "></i>
        <span class="collapse_menu--label"></span>
    </button>
    <div class="main_logo" id="logo">
        <a href="index.html"><img src="{{asset("images/logo.svg")}}" alt=""></a>
        <a href="index.html"><img class="logo-inverse" src="{{asset("images/ct_logo.svg")}}" alt=""></a>
    </div>

    <div class="search120">
        <div class="ui search">
            <div class="ui left icon input swdh10">
            <input class="prompt srch10" type="text" placeholder="Search for Tuts Videos, Tutors, Tests and more..">
            <i class='uil uil-search-alt icon icon1'></i>
            </div>
        </div>
    </div>
    <div class="header_right">
        <ul>
            <li>
                <a href="#" class="upload_btn" title="Create New Course">Guide</a>
            </li>
            <li>
                <a href="{{route('instructor.statements.lists')}}" class="option_links" title="Statements"><i class='uil uil-file-alt'></i>
                    
                    @if ($unapproved_payment_count>0)
                        <span class="noti_count">{{$unapproved_payment_count}}</span>
                    @endif
                </a>
               
            </li>
            <li class="ui dropdown">
                <a id="btn_nav_message" href="#" class="option_links" title="Messages"><i class='uil uil-envelope-alt'></i>
                    @if ($unseen_message_count>0)
                        <span class="noti_count">{{$unseen_message_count}}</span>
                    @endif
                </a>
                
                <div class="menu dropdown_ms" id="nav_message_container">
                    <a href="#" class="channel_my item" id="nav_message_shimmer">
                        <div class="row">				
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
                    </a> 
                </div>
            </li>
            <li class="ui dropdown">
                <a id="btn_nav_notification" href="#" class="option_links" title="Notifications"><i class='uil uil-bell'></i>
                    @if ($unseen_notification_count>0)
                        <span class="noti_count">{{$unseen_notification_count}}</span>
                    @endif
                </a>  
                <div class="menu dropdown_mn" id="nav_notification_container">
                    <a href="#" class="channel_my item" id="nav_notification_shimmer">
                        <div class="row">				
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
                    </a>
                </div>
            </li>
            <li class="ui dropdown">
                <a href="#" class="opts_account" title="Account">
                    <img src="{{asset('storage/'.Auth::user()->image_url)}}" alt="">
                </a>
                <div class="menu dropdown_account">
                    <div class="channel_my">
                        <div class="profile_link">
                            <img src="{{asset('storage/'.Auth::user()->image_url)}}" alt="">
                            <div class="pd_content">
                                <div class="rhte85">
                                    <h6>{{Auth::user()->name}}</h6>
                                    <div class="mef78" title="Verify">
                                        <i class='uil uil-check-circle'></i>
                                    </div>
                                </div>
                                <span>{{Auth::user()->email}}</span>
                            </div>							
                        </div>
                       <div style="display: flex">
                            <a style="margin-right:10px;" href="{{route('instructor_detail',$instructor->id)}}" class="dp_link_12">View Profile</a>
                            <a href="#" class="dp_link_12"> | </a>
                            <a style="margin-left:10px;" href="{{route('instructor.profile.edit')}}" class="dp_link_12">Edit</a>						
                       </div>
                    </div>
                    <div class="night_mode_switch__btn">
                        <a href="#" id="night-mode" class="btn-night-mode">
                            <i class="uil uil-moon"></i> Night mode
                            <span class="btn-night-mode-switch">
                                <span class="uk-switch-button"></span>
                            </span>
                        </a>
                    </div>
                    <a href="{{route('index')}}" class="item channel_item">Home</a>						
                    <a href="membership.html" class="item channel_item">Paid Memberships</a>
                    <a href="{{route('setting')}}" class="item channel_item">Setting</a>
                    <a href="{{route('help')}}" class="item channel_item">Help</a>
                    <a href="{{route('feedback.create')}}" class="item channel_item">Send Feedback</a>
                    <a id="btn_logout" href="{{route('logout')}}" class="item channel_item">Sign Out</a>
                </div>
            </li>
        </ul>
    </div>

    <script>
        {
            const user = @json($user);
            const unseen_notification_count = "{{$unseen_notification_count}}";

            $(document).ready(()=>{
                $('#btn_nav_notification').click(()=>{
                   if(unseen_notification_count>0){
                        navfetchNotification();
                    }else{
                        location.href = "{{route('instructor.notifications.list')}}";
                    }
                })

                $('#btn_nav_notification').on('touchstart',()=>{
                    if(unseen_notification_count>0){
                        navfetchNotification();
                    }else{
                        location.href = "{{route('instructor.notifications.list')}}";
                    }
                });

                $('#btn_logout').click(()=>{
                    localStorage.removeItem('api_token');
                })
            });

            function navfetchNotification(){
                $.ajax({
                    url: "{{asset('')}}instructor-dashboard/api/notifications?page=1&seen=0",
                    type: 'GET', // or 'GET' depending on your request
                    headers: {
                        'Authorization': 'Bearer '+apiToken // Example for Authorization header
                    },
                    
                    success: function(res) {
                        $('#nav_notification_shimmer').hide();
                        if(res){
                            let notifications = res.data;
                            setNavNotifications(notifications);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', status, error);
                    }
                });
            }

            function setNavNotifications(notifications){
                let notificationHTML = ""
                notifications.map((notification,index)=>{
                    if(index<3) notificationHTML += navNotificationComponent(notification);
                })

                $('#nav_notification_container').html(notificationHTML);
                $('#nav_notification_container').append(`<a class="vbm_btn" href="{{route('instructor.notifications.list')}}">View All <i class='uil uil-arrow-right'></i></a>`);
            }

            function navNotificationComponent(notification){
				let active = notification.seen==0?"active":"";
				return `
                
					<div  id="noti_${notification.id}" onclick=notificationClick(${notification.id}) class="channel_my item chat__message__dt ${active}">
						<div class="user-status">											
							<div class="user-avatar">
								<img src="{{asset('')}}storage/${notification.user.image_url}" alt="">
								${notification.notification_type.web_icon}
							</div>
							<p class="user-status-title"><span class="bold">${notification.user.name}</span></p>
							<p class="user-status-text">${notification.notification_type.description} <strong>${notification.body}</strong>.</p>
							<p class="user-status-time floaty">${formatDateTime(new Date(notification.created_at))}</p>
						</div>
					</div>
                
				`;
			}

            function navNotificationSeen(notification_id){
				$.ajax({
					url: `{{asset("")}}instructor-dashboard/api/notifications/${notification_id}`, // Replace with your API endpoint
					type: 'PUT', // or 'GET' depending on your request
					headers: {
						'Authorization': 'Bearer '+apiToken // Example for Authorization header
					},
					success: function(response) {
						 console.log(response);
					},
					error: function(xhr, status, error) {
						console.error('Error:', status, error);
					}
				});
			}
        }
    </script>
    <script>
    {
        const user = @json($user);
        const unseen_message_count = "{{$unseen_message_count}}";

        $(document).ready(()=>{
            $('#btn_nav_message').click(()=>{
                if(unseen_message_count>0){
                    navfetctMessage();
                }else{
                    location.href = "{{route('instructor.chatrooms.lists')}}";
                }
            })

            $('#btn_nav_message').on('touchstart',()=>{
                if(unseen_message_count>0){
                    navfetctMessage();
                }else{
                    location.href = "{{route('instructor.chatrooms.lists')}}";
                }
            });
        });

        function navfetctMessage(){
            $.ajax({
                url: "{{asset('')}}api/chatrooms?page=1&seen=0",
                type: 'GET', // or 'GET' depending on your request
                headers: {
                    'Authorization': 'Bearer '+apiToken // Example for Authorization header
                },
                
                success: function(res) {
                    $('#nav_message_shimmer').hide();
                    if(res){
                        console.log('nav bar message res', res);
                        let messages = res.data;
                        setNavMessages(messages);
                        
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', status, error);
                }
            });
        }

        function setNavMessages(messages){
            let messageHTML = ""
            messages.map((message,index)=>{
                if(index<3) messageHTML += navMessageComponent(message);
            })

            $('#nav_message_container').html(messageHTML);
            $('#nav_message_container').append(`<a class="vbm_btn" href="{{route('instructor.chatrooms.lists')}}">View All <i class='uil uil-arrow-right'></i></a>`);
        }

        function navMessageComponent(message){
            let active = message.seen==0?"active":"";
            return `
            
                <div  id="noti_${message.id}" onclick=messageClick(${message.id}) class="channel_my item chat__message__dt ${active}">
                    <div class="user-status">											
                        <div class="user-avatar">
                            <img src="{{asset('')}}storage/${message.user.image_url}" alt="">
                            <span class='noti-icon-course'> ${message.new_message_count}   </span>
                        </div>
                        <p class="user-status-title"><span class="bold">${message.user.name}</span></p>
                        <p class="user-status-text"><strong>${message.message}</strong>.</p>
                        <p class="user-status-time floaty">${formatDateTime(new Date(message.updated_at))}</p>
                    </div>
                </div>
            
            `;
        }
 

        function messageClick(id){
            window.location.href = `{{route('instructor.chatrooms.lists')}}/${id}`;
        }
    }
    </script>
    <script src="{{asset('js/util.js')}}"></script>
</header>