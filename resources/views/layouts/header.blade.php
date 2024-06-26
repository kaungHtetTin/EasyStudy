

<header class="header clearfix">
    @auth
    <button type="button" id="toggleMenu" class="toggle_menu">
        <i class='uil uil-bars'></i>
    </button>
    <button id="collapse_menu" class="collapse_menu">
        <i class="uil uil-bars collapse_menu--icon "></i>
        <span class="collapse_menu--label"></span>
    </button>
    @endauth
    <div class="main_logo" id="logo">
        <a href="{{route('index')}}"><img src="{{asset('images/logo.svg')}}" alt=""></a>
        <a href="{{route('index')}}"><img class="logo-inverse" src="{{asset('images/ct_logo.svg')}}" alt=""></a>
    </div>
    
  
    <div class="ui simple dropdown item">
        <a href="#" class="option_links p-0" title="categories"> <i class='uil uil-apps'></i></a>
        <div class="menu dropdown_category5">
            @foreach ($categories as $category)
                <a href="{{route('courses')}}?category_id={{$category->id}}" class="item channel_item">
                    {{$category->title}}	
                </a>
            @endforeach
        </div>
    </div>
    
    <div class="search120" >
        <div class="ui search">
            <div class="ui left icon input swdh10" >
                <input class="prompt srch10" type="text" placeholder="Search for Tuts Videos, Tutors, Tests and more..">
                <i class='uil uil-search-alt icon icon1'></i>
            </div>
        </div>
    </div>

    @auth
    <div class="header_right">
        <ul>
            <li>
                <a href="create_new_course.html" class="upload_btn" title="Create New Course">My Learning</a>
            </li>
            <li>
                <a href="{{route('cart')}}" class="option_links" title="cart"><i class='uil uil-shopping-cart-alt'></i>
                    @php
                        $cart_item_count = Auth::user()->carts->count();
                    @endphp
                    @if ( $cart_item_count>0)
                        <span class="noti_count">{{$cart_item_count}}</span>
                    @endif
                    
                </a>
            </li>
            <li class="ui dropdown">
                <a href="#" class="option_links" title="Messages"><i class='uil uil-envelope-alt'></i><span class="noti_count">3</span></a>
                <div class="menu dropdown_ms">
                    <a href="#" class="channel_my item">
                        <div class="profile_link">
                            <img src="{{asset('images/left-imgs/img-6.jpg')}}" alt="">
                            <div class="pd_content">
                                <h6>Zoena Singh</h6>
                                <p>Hi! Sir, How are you. I ask you one thing please explain it this video price.</p>
                                <span class="nm_time">2 min ago</span>
                            </div>							
                        </div>							
                    </a>
                    <a href="#" class="channel_my item">
                        <div class="profile_link">
                            <img src="{{asset('images/left-imgs/img-5.jpg')}}" alt="">
                            <div class="pd_content">
                                <h6>Joy Dua</h6>
                                <p>Hello, I paid you video tutorial but did not play error 404.</p>
                                <span class="nm_time">10 min ago</span>
                            </div>							
                        </div>							
                    </a>
                    <a href="#" class="channel_my item">
                        <div class="profile_link">
                            <img src="{{asset('images/left-imgs/img-8.jpg')}}" alt="">
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
                <a href="#" class="option_links" title="Notifications"><i class='uil uil-bell'></i><span class="noti_count">3</span></a>
                <div class="menu dropdown_mn">
                    <a href="#" class="channel_my item">
                        <div class="profile_link">
                            <img src="{{asset('images/left-imgs/img-1.jpg')}}" alt="">
                            <div class="pd_content">
                                <h6>Rock William</h6>
                                <p>Like Your Comment On Video <strong>How to create sidebar menu</strong>.</p>
                                <span class="nm_time">2 min ago</span>
                            </div>							
                        </div>							
                    </a>
                    <a href="#" class="channel_my item">
                        <div class="profile_link">
                            <img src="{{asset('images/left-imgs/img-2.jpg')}}" alt="">
                            <div class="pd_content">
                                <h6>Jassica Smith</h6>
                                <p>Added New Review In Video <strong>Full Stack PHP Developer</strong>.</p>
                                <span class="nm_time">12 min ago</span>
                            </div>							
                        </div>							
                    </a>
                    <a href="#" class="channel_my item">
                        <div class="profile_link">
                            <img src="images/left-imgs/img-9.jpg" alt="">
                            <div class="pd_content">
                                <p> Your Membership Approved <strong>Upload Video</strong>.</p>
                                <span class="nm_time">20 min ago</span>
                            </div>							
                        </div>							
                    </a>
                    <a class="vbm_btn" href="instructor_notifications.html">View All <i class='uil uil-arrow-right'></i></a>
                </div>
            </li>
            <li class="ui dropdown">
                <a href="#" class="opts_account" title="Account">
                    <img src="{{asset('images/hd_dp.jpg')}}" alt="">
                </a>
                <div class="menu dropdown_account">
                    <div class="channel_my">
                        <div class="profile_link">
                            <img src="{{asset('images/hd_dp.jpg')}}" alt="">
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
                        <a href="my_instructor_profile_view.html" class="dp_link_12">View Profile</a>						
                    </div>
                    <div class="night_mode_switch__btn">
                        <a href="#" id="night-mode" class="btn-night-mode">
                            <i style="background:#efeeff" class="uil uil-moon"></i> Night mode
                            <span class="btn-night-mode-switch">
                                <span class="uk-switch-button"></span>
                            </span>
                        </a>
                    </div>
                    <a href="instructor_dashboard.html" class="item channel_item">Cursus dashboard</a>						
                    <a href="membership.html" class="item channel_item">Paid Memberships</a>
                    <a href="setting.html" class="item channel_item">Setting</a>
                    <a href="help.html" class="item channel_item">Help</a>
                    <a href="feedback.html" class="item channel_item">Send Feedback</a>
                    <a href="{{route('logout')}}" class="item channel_item">Sign Out</a>
                </div>
            </li>
        </ul>
    </div>
    @else
    <div class="header_right">
        <ul>
            <li>
                <a href="{{route('cart',['user_id'=>0000])}}" class="option_links" title="cart"><i class='uil uil-shopping-cart-alt'></i></a>
            </li>

            <li>
                <a href="{{ route('login') }}" class="kht_login_btn" title="Create New Course">Log In</a>
            </li>

            <li>
                <a href="{{ route('register') }}" class="option_links upload_btn" title="Create New Course">Sign up</a>
            </li>
             
        </ul>
    </div>
    @endauth
</header>