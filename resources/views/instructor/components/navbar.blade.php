<nav class="vertical_nav">
    <div class="left_section menu_left" id="js-menu" >
        <div class="left_section">
            <ul>
                <li class="menu--item">
                    <a href="{{route('instructor.home')}}" class="menu--link {{$page_title=='Dashboard'?'active':''}}" title="Dashboard">
                        <i class="uil uil-apps menu--icon"></i>
                        <span class="menu--label">Dashboard</span>
                    </a>
                </li>
                <li class="menu--item">
                    <a href="{{route('instructor.course-create')}}" class="menu--link {{$page_title=='Create Course'?'active':''}}"  title="Create Course">
                        <i class='uil uil-plus-circle menu--icon'></i>
                        <span class="menu--label">Create Course</span>
                    </a>
                </li>
                <li class="menu--item">
                    <a href="{{route('instructor.courses.lists')}}" class="menu--link {{$page_title=='Courses'?'active':''}}" title="Courses">
                        <i class='uil uil-book-alt menu--icon'></i>
                        <span class="menu--label">Courses</span>
                    </a>
                </li>
                <li class="menu--item">
                    <a href="instructor_analyics.html" class="menu--link" title="Analyics">
                        <i class='uil uil-analysis menu--icon'></i>
                        <span class="menu--label">Analyics</span>
                    </a>
                </li>
                <li class="menu--item">
                    <a href="instructor_messages.html" class="menu--link" title="Messages">
                        <i class='uil uil-comments menu--icon'></i>
                        <span class="menu--label">Messages</span>
                    </a>
                </li>
                <li class="menu--item">
                    <a href="{{route('instructor.notifications.list')}}" class="menu--link {{$page_title=='Notifications'?'active':''}}" title="Notifications">
                        <i class='uil uil-bell menu--icon'></i>
                        <span class="menu--label">Notifications</span>
                    </a>
                </li>
                <li class="menu--item">
                    <a href="instructor_my_certificates.html" class="menu--link" title="My Certificates">
                        <i class='uil uil-award menu--icon'></i>
                        <span class="menu--label">My Certificates</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="left_section pt-2">
            <ul>
                <li class="menu--item">
                    <a href="{{route('instructor.payment-methods.lists')}}"  class="menu--link {{$page_title=='Payment Methods'?'active':''}}"  title="Payment Methods">
                        <i class='uil uil-card-atm menu--icon'></i>
                        <span class="menu--label">Payment Methods</span>
                    </a>
                </li>
                <li class="menu--item">
                    <a href="{{route('instructor.statements.lists')}}" class="menu--link {{$page_title=='Statements'?'active':''}}" title="Statements">
                        <i class='uil uil-file-alt menu--icon'></i>
                        <span class="menu--label">Statements</span>
                    </a>
                </li>
                <li class="menu--item">
                    <a href="instructor_earning.html" class="menu--link" title="Earning">
                        <i class='uil uil-dollar-sign menu--icon'></i>
                        <span class="menu--label">Earning</span>
                    </a>
                </li>
                <li class="menu--item">
                    <a href="instructor_payout.html" class="menu--link" title="Payout">
                        <i class='uil uil-wallet menu--icon'></i>
                        <span class="menu--label">Payout</span>
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
                    <a href="feedback.html" class="menu--link" title="Send Feedback">
                        <i class='uil uil-comment-alt-exclamation menu--icon'></i>
                        <span class="menu--label">Send Feedback</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>