<style>
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

    .right_drawer {
        width: 240px;
        transition: all 0.3s ease-out;
    }

    .right_drawer_closed {
        position: fixed;
        right: 0;
        width: 0px;
        transition: all 0.3s ease-out;
    }

    .right_drawer_opened {
        position: fixed;
        right: 0;
        width: 240px;
        z-index: 500;
        background:#fff;
        transition: all 0.3s ease-out;
    }
</style>
<span class="btn-menu" id="btn-drawer-toggle">
    <i class='uil  uil-angle-down'></i>
</span>		
<div class="right_drawer" id="drawer" style="display: none">
    <div style="padding-left:15px;position:relative">
        <div class="fcrse_1 mt-10" style="padding:0">
            <img src="{{asset('storage/'.$course->cover_url)}}" width="100%" alt="">
            <div class="crse14s" style="margin-top:10px; margin-left:15px;">
                    {{$course->title}}
            </div>
            <nav>
                <div id="js-menu">
                    <ul>
                        <li class="menu--item">
                            <a href="{{route('instructor.courses.overview',$course->id)}}" class="menu--link {{$page_title=='Course Overview'?'active':''}}" title="Course Overview">
                                <i class='uil uil-analytics menu--icon'></i>
                                <span class="menu--label">Overview</span>
                            </a>
                        </li>
                        <li class="menu--item">
                            <a href="{{route('instructor.modules.lists')}}?course_id={{$course->id}}" class="menu--link {{$page_title=='Add Curriculum'?'active':''}}" title="Add Curriculum">
                                <i class='uil uil-plus-circle menu--icon'></i>
                                <span class="menu--label">Add Curriculum</span>
                            </a>
                        </li>
                        <li class="menu--item">
                            <a href="{{route('instructor.questions.lists')}}?course_id={{$course->id}}" class="menu--link {{$page_title=='Q & A'?'active':''}}" title="Q & A">
                                <i class='uil uil-comments-alt menu--icon'></i>
                                <span class="menu--label">Q & A</span>
                            </a>
                        </li>
                        <li class="menu--item">
                            <a href="{{route('instructor.reviews.lists')}}?course_id={{$course->id}}" class="menu--link {{$page_title=='Reviews'?'active':''}}" title="Reviews">
                                <i class='uil uil-star menu--icon'></i>
                                <span class="menu--label">Reviews</span>
                            </a>
                        </li>
                        <li class="menu--item">
                            <a href="{{route('instructor.announcements.lists')}}?course_id={{$course->id}}" class="menu--link {{$page_title=='Announcements'?'active':''}}" title="Announcements">
                                <i class='uil uil-notes menu--icon'></i>
                                <span class="menu--label">Announcements</span>
                            </a>
                        </li>
                        <li class="menu--item">
                            <a href="{{route('instructor.courses.students.lists',$course->id)}}" class="menu--link {{$page_title=='Students Enrolled'?'active':''}}" title="Students Enrolled">
                                <i class='uil uil-graduation-hat menu--icon'></i>
                                <span class="menu--label">Students Enrolled</span>
                            </a>
                        </li>
                        <li class="menu--item">
                            <a href="{{route('instructor.courses.modify',$course->id)}}" class="menu--link {{$page_title=='Edit Course'?'active':''}}" title="Edit Course">
                                <i class="uil uil-edit-alt menu--icon"></i>
                                <span class="menu--label">Edit Course</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    <script>
        let small_screen;
        let toggle_open = false;

        $(document).ready(()=>{
            adjustLayout();
            $(window).on('resize', function() {
                adjustLayout();
            });

            $('#btn-drawer-toggle').click(()=>{
                $('#drawer').css({'display':'block'});
                if(toggle_open) {
                    $('#drawer').attr('class','right_drawer_closed');
                    $('#btn-drawer-toggle').html(`<i class='uil  uil-angle-down'></i>`);
                    toggle_open=false;
                }else{
                    $('#drawer').attr('class','right_drawer_opened');
                    $('#btn-drawer-toggle').html(`<i class='uil  uil-angle-up'></i>`);
                    toggle_open=true;
                }
                
            });

           
        })

        function adjustLayout(){
            var w = window.innerWidth;
            if(w<=768){
                $('#btn-drawer-toggle').css({'display':''});
                $('#drawer').css({'display':'none'});
                small_screen=true;
                $('#offset').show();
            }else{
                $('#drawer').attr('class','right_drawer');
                $('#drawer').css({'display':'block'});
                $('#btn-drawer-toggle').css({'display':'none'});
                small_screen=false;
                $('#offset').hide();
            }
        }
    </script>
</div>