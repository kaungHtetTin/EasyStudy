<nav class="vertical_nav">
    <div class="left_section menu_left" id="js-menu" >
        <div class="left_section">
            <ul>
                <li class="menu--item">
                    <a href="{{route('index')}}" class="menu--link {{$page_title=='Home'?'active':''}}" title="Home">
                        <i class='uil uil-home-alt menu--icon'></i>
                        <span class="menu--label">Home</span>
                    </a>
                </li>
                <li class="menu--item">
                    <a href="{{route('explore')}}" class="menu--link {{$page_title=='Explore'?'active':''}}" title="Explore">
                        <i class='uil uil-search menu--icon'></i>
                        <span class="menu--label">Explore</span>
                    </a>
                </li>
                <li class="menu--item menu--item__has_sub_menu">
                    <label class="menu--link {{$page_title=='Courses'?'active':''}}" title="Categories">
                        <i class='uil uil-layers menu--icon'></i>
                        <span class="menu--label">Categories</span>
                    </label>
                    <ul class="sub_menu">
                        @foreach ($categories as $category)
                            <li class="sub_menu--item">
                                <a href="{{route('courses')}}?category_id={{$category->id}}" class="sub_menu--link">{{$category->title}}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="menu--item">
                    <a href="{{route('notifications.list')}}" class="menu--link {{$page_title=='Notifications'?'active':''}}" title="Notifications">
                        <i class='uil uil-bell menu--icon'></i>
                        <span class="menu--label">Notifications</span>
                    </a>
                </li>
                <li class="menu--item">
                    <a href="{{route('cart')}}" class="menu--link {{$page_title=='Cart'?'active':''}}" title="Live Streams">
                        <i class='uil uil-shopping-cart-alt menu--icon'></i>
                        <span class="menu--label">Cart</span>
                    </a>
                </li>
                <li class="menu--item">
                    <a href="{{route('mycourses')}}" class="menu--link {{$page_title=='My Courses'?'active':''}}" title="Saved Courses">
                        <i class="uil uil-heart-alt menu--icon"></i>
                        <span class="menu--label">My Courses</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="left_section">
            <h6 class="left_title">SUBSCRIPTIONS</h6>
            <ul>
                <li class="menu--item">
                    <a href="instructor_profile_view.html" class="menu--link user_img">
                        <img src="images/left-imgs/img-1.jpg" alt="">
                        Rock Smith
                        <div class="alrt_dot"></div>
                    </a>
                </li>
                <li class="menu--item">
                    <a href="instructor_profile_view.html" class="menu--link user_img">
                        <img src="images/left-imgs/img-2.jpg" alt="">
                        Jassica William
                    </a>
                    <div class="alrt_dot"></div>
                </li>
                <li class="menu--item">
                    <a href="{{route('instructors')}}" class="menu--link {{$page_title=='Instructors'?'active':''}}" title="Instructors">
                        <i class='uil uil-plus-circle menu--icon'></i>
                        <span class="menu--label">Browse Instructors</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="left_section pt-2">
            <ul>
                <li class="menu--item">
                    <a href="{{route('setting')}}" class="menu--link {{$page_title=='Setting'?'active':''}}" title="Setting">
                        <i class='uil uil-cog menu--icon'></i>
                        <span class="menu--label">Setting</span>
                    </a>
                </li>
                <li class="menu--item">
                    <a href="help.html" class="menu--link" title="Help">
                        <i class='uil uil-question-circle menu--icon'></i>
                        <span class="menu--label">Help</span>
                    </a>
                </li>
                <li class="menu--item">
                    <a href="{{route('reports.list')}}" class="menu--link {{$page_title=='Report History'?'active':''}}" title="Report History">
                        <i class='uil uil-windsock menu--icon'></i>
                        <span class="menu--label">Report History</span>
                    </a>
                </li>
                <li class="menu--item">
                    <a href="{{route('feedback.create')}}" class="menu--link {{$page_title=='Feedback'?'active':''}}" title="Send Feedback">
                        <i class='uil uil-comment-alt-exclamation menu--icon'></i>
                        <span class="menu--label">Send Feedback</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="left_footer">
            <ul>
                <li><a href="{{route('about-us')}}">About</a></li>
                <li><a href="press.html">Blog</a></li>
                <li><a href="{{route('contact-us')}}">Contact Us</a></li>
                <li><a href="{{route('teach-on')}}">Teach On</a></li>
                <li><a href="{{route('help')}}">Help</a></li>
                <li><a href="{{route('terms')}}">Terms</a></li>
                <li><a href="{{route('privacy-policy')}}">Privacy Policy</a></li>
                <li><a href="{{route('sitemap')}}">Sitemap</a></li>
            </ul>
            <div class="left_footer_content">
                <p>© 2024 <strong>CalamusEducation</strong>. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</nav>