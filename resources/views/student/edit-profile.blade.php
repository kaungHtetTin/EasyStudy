@php
    $api_token = Cookie::get('api_auth_token');
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
            border-radius: 10px;
            z-index: 1000;
            
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
                    More setting <i class='uil  uil-angle-double-down'></i>
                </span>
                
				<div style="position: relative;display:flex">
                    <div class="profile_form" style="flex:1">
                        <div class="col-lg-9 col-md-8 col-sm-8">
                            <div align="center">
                                <h3 id="form-title">Title</h3>
                                <p id="form-description">This is discription</p>
                            </div>

                        <div class="edit-container" id="form-profile">
                                Profile form
                        </div>

                        <div class="edit-container" id="form-photo">
                                photo form
                        </div>

                        <div class="edit-container" id="form-privacy">
                                Privacy Form
                        </div>

                        <div class="edit-container" id="form-notification">
                                Notification Form
                        </div>

                        <div class="edit-container" id="form-close-account">
                                Close Account Form
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

        const titles = [
            {title:"Profile",description:"Edit your profile"},
            {title:"Photo",description:"Upload your profile photo"},
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
                    
                });
            });

            $('.edit-menu').get(0).click();

            let toggle_open = false;
            $('#btn-drawer-toggle').click(()=>{
                $('#drawer').css({'display':'block'});
                if(toggle_open) {
                    $('#drawer').attr('class','profile_nav_menu_closed');
                    toggle_open=false;
                }else{
                    $('#drawer').attr('class','profile_nav_menu_opened');
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
            }else{
                $('#drawer').attr('class','profile_nav_menu');
                $('#drawer').css({'display':'block'});
                $('#btn-drawer-toggle').css({'display':'none'});
            }
        }

    </script>
@endsection
