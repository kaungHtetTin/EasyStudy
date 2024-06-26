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
                    <a href="explore.html" class="menu--link" title="Explore">
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

                <li class="menu--item  menu--item__has_sub_menu">
                    <label class="menu--link" title="Tests">
                        <i class='uil uil-clipboard-alt menu--icon'></i>
                        <span class="menu--label">Tests</span>
                    </label>
                    <ul class="sub_menu">
                        <li class="sub_menu--item">
                            <a href="certification_center.html" class="sub_menu--link">Certification Center</a>
                        </li>
                        <li class="sub_menu--item">
                            <a href="certification_start_form.html" class="sub_menu--link">Certification Fill Form</a>
                        </li>
                        <li class="sub_menu--item">
                            <a href="certification_test_view.html" class="sub_menu--link">Test View</a>
                        </li>
                        <li class="sub_menu--item">
                            <a href="certification_test__result.html" class="sub_menu--link">Test Result</a>
                        </li>
                        <li class="sub_menu--item">
                            <a href="http://www.gambolthemes.net/html-items/edututs+/Instructor_Dashboard/my_certificates.html" class="sub_menu--link">My Certification</a>
                        </li>
                    </ul>
                </li>
                
                <li class="menu--item  menu--item__has_sub_menu">
                    <label class="menu--link" title="Pages">
                        <i class='uil uil-file menu--icon'></i>
                        <span class="menu--label">Pages</span>
                    </label>
                    <ul class="sub_menu">
                        <li class="sub_menu--item">
                            <a href="about_us.html" class="sub_menu--link">About</a>
                        </li>
                        <li class="sub_menu--item">
                            <a href="sign_in.html" class="sub_menu--link">Sign In</a>
                        </li>
                        <li class="sub_menu--item">
                            <a href="sign_up.html" class="sub_menu--link">Sign Up</a>
                        </li>
                        <li class="sub_menu--item">
                            <a href="sign_up_steps.html" class="sub_menu--link">Sign Up Steps</a>
                        </li>
                        <li class="sub_menu--item">
                            <a href="membership.html" class="sub_menu--link">Paid Membership</a>
                        </li>
                        <li class="sub_menu--item">
                            <a href="course_detail_view.html" class="sub_menu--link">Course Detail View</a>
                        </li>
                        <li class="sub_menu--item">
                            <a href="checkout_membership.html" class="sub_menu--link">Checkout</a>
                        </li>
                        <li class="sub_menu--item">
                            <a href="invoice.html" class="sub_menu--link">Invoice</a>
                        </li>
                        <li class="sub_menu--item">
                            <a href="career.html" class="sub_menu--link">Career</a>
                        </li>
                        <li class="sub_menu--item">
                            <a href="apply_job.html" class="sub_menu--link">Job Apply</a>
                        </li>
                        <li class="sub_menu--item">
                            <a href="our_blog.html" class="sub_menu--link">Our Blog</a>
                        </li>
                        <li class="sub_menu--item">
                            <a href="blog_single_view.html" class="sub_menu--link">Blog Detail View</a>
                        </li>
                        <li class="sub_menu--item">
                            <a href="company_details.html" class="sub_menu--link">Company Details</a>
                        </li>
                        <li class="sub_menu--item">
                            <a href="press.html" class="sub_menu--link">Press</a>
                        </li>
                        <li class="sub_menu--item">
                            <a href="live_output.html" class="sub_menu--link">Live Stream View</a>
                        </li>
                        <li class="sub_menu--item">
                            <a href="add_streaming.html" class="sub_menu--link">Add live Stream</a>
                        </li>
                        <li class="sub_menu--item">
                            <a href="search_result.html" class="sub_menu--link">Search Result</a>
                        </li>
                        <li class="sub_menu--item">
                            <a href="thank_you.html" class="sub_menu--link">Thank You</a>
                        </li>
                        <li class="sub_menu--item">
                            <a href="coming_soon.html" class="sub_menu--link">Coming Soon</a>
                        </li>
                        <li class="sub_menu--item">
                            <a href="error_404.html" class="sub_menu--link">Error 404</a>
                        </li>
                    </ul>
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
                    <a href="{{route('instructors')}}" class="menu--link" title="Browse Instructors">
                        <i class='uil uil-plus-circle menu--icon'></i>
                        <span class="menu--label">Browse Instructors</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="left_section pt-2">
            <ul>
                <li class="menu--item">
                    <a href="setting.html" class="menu--link" title="Setting">
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
                    <a href="report_history.html" class="menu--link" title="Report History">
                        <i class='uil uil-windsock menu--icon'></i>
                        <span class="menu--label">Report History</span>
                    </a>
                </li>
                <li class="menu--item">
                    <a href="feedback.html" class="menu--link" title="Send Feedback">
                        <i class='uil uil-comment-alt-exclamation menu--icon'></i>
                        <span class="menu--label">Send Feedback</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="left_footer">
            <ul>
                <li><a href="about_us.html">About</a></li>
                <li><a href="press.html">Press</a></li>
                <li><a href="contact_us.html">Contact Us</a></li>
                <li><a href="coming_soon.html">Advertise</a></li>
                <li><a href="coming_soon.html">Developers</a></li>
                <li><a href="terms_of_use.html">Copyright</a></li>
                <li><a href="terms_of_use.html">Privacy Policy</a></li>
                <li><a href="terms_of_use.html">Terms</a></li>
            </ul>
            <div class="left_footer_content">
                <p>© 2024 <strong>CalamusEducation</strong>. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</nav>