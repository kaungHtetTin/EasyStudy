@php
    use Carbon\Carbon;
    $api_token = Cookie::get('api_auth_token');
    $user = Auth::user();

    $months =[
                "Jan",
                "Feb",
                "March",
                "April",
                "May",
                "June",
                "July",
                "Aug",
                "Sept",
                "Oct",
                "Nov",
                "Dec"
            ];
    
    $birthday = $user->birth_date;
    if($birthday!=null){
        $birthday = Carbon::createFromFormat('Y-m-d H:i:s', $user->birth_date);
        $day = $birthday->format('d');
        $month = $birthday->format('m');
        $month_text = $months[($month-1)];
        $year = $birthday->format('Y');
    }else{
        $day = null;
        $month =  null;
        $month = null;
        $year = null;
        $month_text = null;
    }

@endphp

@extends('student.components.master')


@section('content')

    <style>
        .edit-menu:hover{
            background: #475692;
            color:#fff !important;
        }

        .edit-container{
            display: none;
           
        }

        .profile_form{
            padding: 20px;
            transition: all 0.3s ease-out;
        }

        .profile_nav_menu {
            width: 240px;
            overflow: hidden;
            transition: all 0.3s ease-out;
        }

        .profile_nav_menu_closed {
            position: fixed;
            right: 0;
            width: 0px;
            transition: all 0.3s ease-out;
        }

        .profile_nav_menu_opened {
            position: fixed;
            right: 0;
            width: 250px;
            overflow: hidden;
            z-index: 500;
            background:#fff;
            transition: all 0.3s ease-out;
        }

        .btn-menu{
            cursor: pointer;
            position: fixed;
            right:20px;
            top:70px;
            padding:10px;
            background: #475692;
            color:white;
            border-radius: 30px;
            z-index: 1000;
            font-size:24px;
            transition: all 0.3s ease-out;
        }

        .optional{
            color:#888;
            font-size: 12px;
        }

    </style>

	@auth
	<div class="wrapper" onresize="adjustLayout()">
	@else
	<div style="padding-top:60px;">
	@endauth
		<div class="sa4d25">
			<div class="container-fluid">	
                
                 
                <span class="btn-menu" id="btn-drawer-toggle" style="display: none">
                   <i class='uil  uil-angle-down'></i>
                </span>
                
				<div style="position: relative;display:flex">
                    <div class="profile_form" style="flex:1">
                        <div>
                            <div align="center">
                                <h3 id="form-title"> </h3>
                                <p id="form-description"> </p>
                            </div>

                            <br><br>
                            <div class="edit-container" id="form-profile">
                                <div style="padding-left:30px; padding-right: 30px;">
                                    <form id="profile_form" method="POST" action="{{ route('profile.update') }}">
                                        @csrf
                                        <h5>Name</h5>
                                        <div class="ui search focus mt-15">
                                            <div class="ui input swdh95">
                                                <input class="prompt srch_explore" type="text" name="name" value="{{$user->name}}" id="id_profile_name" required="" maxlength="64" placeholder="Name">															
                                            </div>
                                        </div>
                                        <p id="profile_name_error" style="color: red;margin-top:15px;"></p>
                                        
                                        <h5>Bio <span class="optional"> (Optional) </span></h5>
                                        <div class="ui search focus mt-15">
                                            <div class="ui input swdh95">
                                                <input class="prompt srch_explore" type="text" name="bio" value="{{$user->bio}}" placeholder="Bio">															
                                                
                                            </div>
                                        </div>

                                        <h5>Phone <span class="optional"> (Optional) </span></h5>
                                        <div class="ui search focus mt-15">
                                            <div class="ui input swdh95">
                                                <input class="prompt srch_explore" type="text" name="phone" value="{{$user->phone}}" placeholder="Phone">															
                                                
                                            </div>
                                        </div>
                                        <h5>Gender <span class="optional"> (Optional) </span></h5>
                                        <div class="ui fluid search selection dropdown focus">
                                            <input type="hidden" name="gender" class="prompt srch_explore" placeholder="Gender" value="{{$user->gender}}">
                                            <i class="dropdown icon"></i>
                                                <div class="default text">{{$user->gender}}</div>
                                                <div class="menu">
                                                <div class="item" data-value="Male"></i>Male</div>
                                                <div class="item" data-value="Female"></i>Female</div>
                                            </div>
                                        </div>

                                        <h5>Birthday <span class="optional"> (Optional) </span></h5>
                                        <div class="row">
                                            <div class="col-4">
                                                Day
                                                <div class="ui fluid search selection dropdown focus">
                                                    
                                                    <input type="hidden" name="day" value="{{$day}}" class="prompt srch_explore" id="selector_day" placeholder="Day">
                                                    <i class="dropdown icon"></i>
                                                    <div class="default text"> {{$day}} </div>
                                                    <div class="menu" id="day_container">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                Month
                                                <div class="ui fluid search selection dropdown focus">
                                                    
                                                    <input type="hidden" name="month" value="{{$month}}" class="prompt srch_explore" id="selector_month" placeholder="Month">
                                                    <i class="dropdown icon"></i>
                                                    <div class="default text"> {{$month_text}} </div>
                                                    <div class="menu" id="month_container">
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                Year
                                                <div class="ui fluid search selection dropdown focus">
                                                    <input type="hidden" name="year" value="{{$year}}" class="prompt srch_explore" id="selector_year" placeholder="Year">
                                                    <i class="dropdown icon"></i>
                                                    <div class="default text"> {{$year}} </div>
                                                    <div class="menu" id="year_container">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <h5>Education <span class="optional"> (Optional) </span></h5>
                                        <div class="ui search focus mt-15">
                                            <div class="ui input swdh95">
                                                <input class="prompt srch_explore" type="text" name="education" value="{{$user->education}}" placeholder="Education">	
                                            </div>
                                        </div>

                                        <h5>Address <span class="optional"> (Optional) </span></h5>
                                        <div class="ui search focus mt-15">
                                            <div class="ui input swdh95">
                                                <input class="prompt srch_explore" type="text" name="address" value="{{$user->address}}" placeholder="Address">	
                                            </div>
                                        </div>
                                        <button id="" class="login-btn" type="submit">Save</button>
                                    </form>
                                    
                                </div>
                                <script>
                                    // basic form script
                                    let months =[
                                        "Jan",
                                        "Feb",
                                        "March",
                                        "April",
                                        "May",
                                        "June",
                                        "July",
                                        "Aug",
                                        "Sept",
                                        "Oct",
                                        "Nov",
                                        "Dec"
                                    ];

                                    var dateObj = new Date();
                                    var currentYear=dateObj.getUTCFullYear();

                                    $(document).ready(()=>{
                                        for(var i=1;i<32;i++){
                                            $('#day_container').append(`<div class="item" data-value="${i}"></i>${i}</div>`);
                                        }

                                        for(var i=0;i<months.length;i++){
                                            $('#month_container').append(`<div class="item" data-value="${(i+1)}"></i>${months[i]}</div>`);
                                        }

                                        for(var i=currentYear-14;i>1950;i--){
                                            $('#year_container').append(`<div class="item" data-value="${i}"></i>${i}</div>`);
                                        }

                                        $('#btn_profile_update').click(()=>{
                                            let name = $('#id_profile_name').val();

                                        });
                                    });

                                </script>
                            </div>

                            <div class="edit-container" id="form-photo" style="margin:0 auto;">
                                <div style="margin: auto;width:360px;">
                                    <h5>Image Preview</h5>
                                    <div>
                                        <img src="" alt="" style="width:360px; height:180px;">
                                    </div>

                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <h5>Add/Change Image</h5>
                                        <div class="ui search focus mt-15">
                                            <div class="ui input swdh95">
                                                <input class="prompt srch_explore" type="file" name="name" placeholder="Name" style="display: none">															
                                                <span>Upload Image</span>
                                            </div>
                                        </div>
                                            
                                    </form>
                                </div>
                            </div>

                            <div class="edit-container" id="form-privacy" style="padding-left:30px; padding-right: 30px;">
                                <h5>Profile page settings</h5>
                                
                            </div>

                            <div class="edit-container" id="form-notification" style="padding-left:30px; padding-right: 30px;">
                                <h5>Which notification do you want to receive?</h5>

                                <div class="ui checkbox mncheck">
									<input class="duration_inputs" type="checkbox" tabindex="0" class="hidden" value="0">
									<label> Promotion, course recommendation, helpful information from EasyStudy. </label>
								</div> <br>
								<div class="ui checkbox mncheck">
									<input class="duration_inputs" type="checkbox" tabindex="0" class="hidden" value="1">
									<label>Announcements from your instructors of the courses you enrolled.</label>
								</div><br>
								<div class="ui checkbox mncheck">
									<input class="duration_inputs" type="checkbox" tabindex="0" class="hidden" value="2">
									<label>Promotional emails</label>
								</div> 

                            </div>

                            <div class="edit-container" id="form-close-account" style="padding-left:30px; padding-right: 30px;">
                                <b style="color: red">Warning: </b>By deleting account, you will lose access to all data associated with this account forever and you will be unsubscribed from all of your courses even if 
                                you create the new account using the same email address in future.

                                <form id="del_account_form" method="GET" action="">
                                    @csrf
                                    <h5>Enter password</h5>
                                    <div class="ui search focus mt-15">
                                        <div class="ui input swdh95">
                                            <input class="prompt srch_explore" type="text" name="password" value="" id="del_account_password_input" required="" maxlength="64" placeholder="Enter your password">															
                                           
                                        </div>
                                    </div>
                                     <p id="del_account_error" style="margin-top:15px; color:red;"></p>
                                   
                                </form>
                                 <button id="btn_del_account" class="login-btn" type="submit">Delete Account</button>
                                <script>
                                    $(document).ready(()=>{
                                        $('#btn_del_account').click(()=>{
                                             $('#del_account_error').html("");
                                            let password = $('#del_account_password_input').val();
                                            if(password==""){
                                                $('#del_account_error').html("Please enter your password");
                                            }else{
                                                // check the password is correct or not

                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>

                    <div class="profile_nav_menu" id="drawer" style="display: none">
                        <div align="center">
                            <br> 
                            <img src="{{asset('images/hd_dp.jpg')}}" style="width: 80px; height:80px;" alt="Profile Picture">
                            <br>
                            <h4>{{$user->name}}</h4>
                        </div>

                        <ul class="allcate15 mt-10">
                            <li><a href="#" class="edit-menu ct_item">Profile</a></li>
                            <li><a href="#" class="edit-menu ct_item">Photo</a></li>
                            <li><a href="#" class="edit-menu ct_item">Privacy</a></li>
                            <li><a href="#" class="edit-menu ct_item">Notification</a></li>
                            <li><a href="#" class="edit-menu ct_item">Close Account</a></li>
                        </ul>
                    </div>
                </div>
			</div>
		</div>
    

    <script>

        let small_screen;
        let toggle_open = false;
        const titles = [
            {title:"Profile",description:"Add your information"},
            {title:"Photo",description:"Add your profile photo"},
            {title:"Privay",description:"Constomize your profile visibility"},
            {title:"Notification",description:"Customize your notification setting"},
            {title:"Close Account",description:"Close your account pernamently"},
        ];

        $(document).ready(()=>{
            adjustLayout();
            $('.edit-menu').each((menu_index, menu)=>{
                $(menu).click(()=>{
                    

                    $('.edit-menu').each((menu_index2, menu2)=>{
                        $(menu2).css({"background":""});
                        $(menu2).css({"color":""});
                    })

                    $(menu).css({"background":"#475692"});
                    $(menu).css({"color":"#fff"});

                    $('.edit-container').each((container_index,conatiner)=>{
                        if(container_index==menu_index){
                            $(conatiner).css({"display":"block"});
                        }else{
                            $(conatiner).css({"display":"none"});
                        }
                    });

                   let info = titles[menu_index];
                
                   $('#form-title').html(info.title);
                   $('#form-description').html(info.description);

                   if(small_screen){
                        $('#drawer').attr('class','profile_nav_menu_closed');
                        $('#btn-drawer-toggle').html(`<i class='uil  uil-angle-down'></i>`);
                        toggle_open=false;
                   }
                    
                });
            });

            $('.edit-menu').get(0).click();

            
            $('#btn-drawer-toggle').click(()=>{
                $('#drawer').css({'display':'block'});
                if(toggle_open) {
                    $('#drawer').attr('class','profile_nav_menu_closed');
                    $('#btn-drawer-toggle').html(`<i class='uil  uil-angle-down'></i>`);
                    toggle_open=false;
                }else{
                    $('#drawer').attr('class','profile_nav_menu_opened');
                    $('#btn-drawer-toggle').html(`<i class='uil  uil-angle-up'></i>`);
                    toggle_open=true;
                }
                
            });

            $(window).on('resize', function() {
                adjustLayout();
            });

            
        });
        

        function adjustLayout(){
            var w = window.innerWidth;
            if(w<=768){
                $('#btn-drawer-toggle').css({'display':''});
                $('#drawer').css({'display':'none'});
                small_screen=true;
            }else{
                $('#drawer').attr('class','profile_nav_menu');
                $('#drawer').css({'display':'block'});
                $('#btn-drawer-toggle').css({'display':'none'});
                small_screen=false;
            }
        }

    </script>
@endsection
