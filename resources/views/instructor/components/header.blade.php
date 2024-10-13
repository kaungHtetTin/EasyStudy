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
                <a href="#" class="option_links" title="Messages"><i class='uil uil-envelope-alt'></i><span class="noti_count">3</span></a>
                <div class="menu dropdown_ms">
                    <a href="#" class="channel_my item">
                        <div class="profile_link">
                            <img src="images/left-imgs/img-6.jpg" alt="">
                            <div class="pd_content">
                                <h6>Zoena Singh</h6>
                                <p>Hi! Sir, How are you. I ask you one thing please explain it this video price.</p>
                                <span class="nm_time">2 min ago</span>
                            </div>							
                        </div>							
                    </a>
                    <a href="#" class="channel_my item">
                        <div class="profile_link">
                            <img src="images/left-imgs/img-5.jpg" alt="">
                            <div class="pd_content">
                                <h6>Joy Dua</h6>
                                <p>Hello, I paid you video tutorial but did not play error 404.</p>
                                <span class="nm_time">10 min ago</span>
                            </div>							
                        </div>							
                    </a>
                    <a href="#" class="channel_my item">
                        <div class="profile_link">
                            <img src="images/left-imgs/img-8.jpg" alt="">
                            <div class="pd_content">
                                <h6>Jass</h6>
                                <p>Thanks Sir, Such a nice video.</p>
                                <span class="nm_time">25 min ago</span>
                            </div>							
                        </div>							
                    </a>
                    <a href="#" class="channel_my item">
                        <div class="profile_link">
                            <img src="images/left-imgs/img-5.jpg" alt="">
                            <div class="pd_content">
                                <h6>Joy Dua</h6>
                                <p>Hello, I paid you video tutorial but did not play error 404.</p>
                                <span class="nm_time">10 min ago</span>
                            </div>							
                        </div>							
                    </a>
                    <a href="#" class="channel_my item">
                        <div class="profile_link">
                            <img src="images/left-imgs/img-8.jpg" alt="">
                            <div class="pd_content">
                                <h6>Jass</h6>
                                <p>Thanks Sir, Such a nice video.</p>
                                <span class="nm_time">25 min ago</span>
                            </div>							
                        </div>							
                    </a>
                    
                    <a class="vbm_btn" href="instructor_messages.html">View All <i class='uil uil-arrow-right'></i></a>
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
                        <a href="{{route('profile.edit')}}" class="dp_link_12">Edit Profile</a>	
                        <a href="{{route('instructor.profile.edit')}}" class="dp_link_12">Instructor Account Setting</a>						
                    </div>
                    <div class="night_mode_switch__btn">
                        <a href="#" id="night-mode" class="btn-night-mode">
                            <i class="uil uil-moon"></i> Night mode
                            <span class="btn-night-mode-switch">
                                <span class="uk-switch-button"></span>
                            </span>
                        </a>
                    </div>
                    <a href="/" class="item channel_item">Student Dashboard</a>						
                    <a href="membership.html" class="item channel_item">Paid Memberships</a>
                    <a href="setting.html" class="item channel_item">Setting</a>
                    <a href="help.html" class="item channel_item">Help</a>
                    <a href="feedback.html" class="item channel_item">Send Feedback</a>
                    <a href="{{route('logout')}}" class="item channel_item">Sign Out</a>
                </div>
            </li>
        </ul>
    </div>

    <script>
        {
            const apiToken = "{{$api_token}}";
            const user = @json($user);
        

            $(document).ready(()=>{
                $('#btn_nav_notification').click(()=>{
                    console.log('fetch notification');
                    navfetchNotification();
                })
            });

            function navfetchNotification(){
                $.ajax({
                    url: "http://localhost:8000/instructor/api/notifications?page=1&seen=0",
                    type: 'GET', // or 'GET' depending on your request
                    headers: {
                        'Authorization': 'Bearer '+apiToken // Example for Authorization header
                    },
                    
                    success: function(res) {
                        $('#nav_notification_shimmer').hide();
                        if(res){
                            
                            console.log('nav bar noti res', res);
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
                return `
                    <a href="${createNotificationToUrl(notification)}" class="channel_my item bg-unseen" onclick="navNotificationSeen(${notification.id})">
                        <div class="profile_link" style="padding:5px 10px 5px 10px;">
                            <div>
								<img src="http://localhost:8000/storage/${notification.user.image_url}" alt=""/>
								${notification.notification_type.web_icon}
							</div>
                            <div class="pd_content">
                                <h6>${notification.user.name}</h6>
                                <p>${notification.notification_type.description}<strong> ${notification.body}</strong>.</p>
                                <span class="nm_time">${formatDateTime(new Date(notification.created_at))}</span>
                            </div>							
                        </div>							
                    </a>
                `;
            }

            function navNotificationSeen(notification_id){
				$.ajax({
					url: `http://localhost:8000/instructor/api/notifications/${notification_id}`, // Replace with your API endpoint
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
    <script src="{{asset('js/util.js')}}"></script>
</header>