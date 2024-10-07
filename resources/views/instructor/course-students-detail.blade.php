	@php
    	$api_token = Cookie::get('api_auth_token');
		$user = Auth::user();
		
    @endphp
    @extends('instructor.master')

	@section('content')

    <style>
        .error{
            color:red;
			display: none;
        }

		._215b05{
			padding:5px;
		}

		.rating-star1 {
			font-size: 1rem;
			width: 1rem;
			height: 1rem;
			position: relative;
			display: inline-block;
		}

		.user_menu_btn{
			padding:5px;
			font-size:12px;
			float:right;
		}

        .my-spinner {
            width: 100px;
            height:100px;
            border:0px solid green;
        }

        .module{
            border: 1px solid #777;
            border-radius:5px;
            padding:7px;
            margin-top:5px;
        }

        .night-mode .kht-table td{
            color:#eee
        }

    </style>

	<div class="wrapper">
		<div class="sa4d25">
            <div class="container">	
				<div style="position: relative; display:flex">
					<div style="flex:1">
						@if (session('msg'))
							<div class="alert alert-success">
								{{session('msg')}}
							</div>
						@endif
						<div class="row">
							<div class="col-12">
								<div class="step-tab-panel step-tab-gallery" id="tab_step2">
									<div class="tab-from-content">
										<div class="title-icon">
											<h3 class="title"><i class="uil uil-graduation-hat"></i> Student's Detail</h3>
										</div> 
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<div class="section3125">			
									<div class="row justify-content-center">
										<div class="col-12">
											<div class="_215b03">
												<h2>{{$course->title}}</h2>
												<span class="_215b04">{{$course->category->title}} <i class="uil uil-arrow-right"></i> {{$course->sub_category->title}} <i class="uil uil-arrow-right"></i>  {{$course->topic->title}}</span>
											</div>
										</div>							
									</div>							
								</div>							
							</div>															
						</div>
                        <br>
                        <div class="fcrse_1">
                            <br>
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="review_usr_dt">
                                        <img src="{{asset('storage/'.$student->image_url)}}" alt="">
                                        <div class="rv1458">
                                            <h4 class="tutor_name1">{{$student->name}}</h4>
                                            <span class="time_145">Joined . {{$joined->diffForHumans()}}</span> 
                                            <span class="time_145">Last Active . {{$student->last_active}}</span>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div align="center">
                                        <canvas class="my-spinner"  id="spinner" width="300" height="300"></canvas>
                                        <span class="time_145">Learning Progress</span>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <table class="table kht-table" style="margin-top:20px;">
                                        <tr>
                                            <td> <i class="uil uil-envelope"></i></i> Email</td>
                                            <td>{{$student->email}}</td>
                                        </tr>
                                        <tr>
                                            <td> <i class="uil uil-phone-alt"></i> Phone</td>
                                            <td>{{$student->phone}}</td>
                                        </tr>
                                        <tr>
                                            <td> <i class="uil uil-home-alt"></i> Address</td>
                                            <td>{{$student->address}}</td>
                                        </tr>
								    </table>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <table class="table kht-table" style="margin-top:20px;">
                                        <tr>
                                            <td> <i class="uil uil-graduation-hat"></i> Education</td>
                                            <td>{{$student->education}}</td>
                                        </tr>
                                         <tr>
                                            <td> <i class="uil uil-mars"></i> Gender</td>
                                            <td>{{$student->gender}}</td>
                                        </tr>
                                        <tr>
                                            <td> <i class="uil uil-calendar-alt"></i> Birth on</td>
                                            <td>{{$student->brith_date}}</td>
                                        </tr>
								    </table>
                                </div>
                            </div>
                        </div>
                        <div class="fcrse_1">
                            <div style="display: flex">
                                <h4>Learning History</h4>
                                <div style="flex:1;">
                                    <span style="flex:1; float:right;" class="btn_span" type="button" data-toggle="collapse" data-target="#lesson_container">See All  <i class='uil  uil-angle-down'></i></span>
                            </div>
                                </div>
                            <div class="collapse" id="lesson_container">
                                @php
                                    $learned_lesson_count = 0;
                                @endphp
                                @foreach ($course->modules as $module)
                                    <div class="module">
                                        <h5>{{$module->title}}</h5>
                                        <div class="row">
                                            @foreach ($module->mLessons($student->id) as $lesson)
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div style="display: flex;">
                                                        @if ($lesson->lesson_type_id==1)
                                                            <i class='uil uil-play-circle icon_142'></i> 
                                                        @else
                                                                <i class='uil uil-file icon_142'></i>
                                                        @endif
                                                        <div>{{$lesson->title}}</div>
                                                        @if ($lesson->learned==1)
                                                            <i style="color:green" class='uil uil-check-circle'></i>
                                                            @php
                                                                $learned_lesson_count++;
                                                            @endphp
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div> 

                        @if(count($other_courses)>0)
                        <div class="fcrse_1">
                            <h4>Other Courses</h4>
                            <ul>
                                @foreach ($other_courses as $other_course)
                                    <li class="menu--item">
                                        <a href="{{route('instructor.courses.student.show',['id'=>$other_course->id,'sid'=>$student->id])}}" class="menu--link {{$page_title=='Course Overview'?'active':''}}" title="Course Overview">
                                            <i class='uil uil-book-alt menu--icon'></i>
                                            <span class="menu--label">{{$other_course->title}}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            
                        </div>
                        @endif
					</div>
					@include('instructor.components.course-menu-drawer')
				</div>

			</div>
		</div>
		@include('instructor.components.footer')

		<script>

			const apiToken = "{{$api_token}}";
			const course = @json($course);
        	const user = @json($user);
            const learned_lesson_count = "{{$learned_lesson_count}}";
            const total_lecture = course.total_lecture;
            console.log('learnee  ',course);

			$(document).ready(()=>{
	
				drawProgressBar();

			})
 
            function drawProgressBar() {
                let degrees=0;
                if(total_lecture!=0) degrees=(learned_lesson_count/total_lecture)*360;
                console.log('total lecture ',total_lecture);
                let spinner = document.getElementById("spinner");
                let ctx = spinner.getContext("2d");
                let width = spinner.width;
                let height = spinner.height;
                let color = "#0f0";
                let bgcolor = "#ccc";
                let text;
                
                let animation_loop, redraw_loop;

                ctx.clearRect(0, 0, width, height);
            
                ctx.beginPath();
                ctx.strokeStyle = bgcolor;
                ctx.lineWidth = 30;
                ctx.arc(width/2, width/2, 100, 0, Math.PI*2, false);
                ctx.stroke();
                let radians = degrees * Math.PI / 180;
            
                ctx.beginPath();
                    ctx.strokeStyle = color;
                    ctx.lineWidth = 30;
                    ctx.arc(width/2, height/2, 100, 0 - 90*Math.PI/180, radians - 90*Math.PI/180, false); 
                    ctx.stroke();
                    ctx.fillStyle = color;
                        ctx.font = "50px arial";
                        text = Math.floor(degrees/360*100) + "%";
                        text_width = ctx.measureText(text).width;
                    ctx.fillText(text, width/2 - text_width/2, height/2 + 15);
            }

	</script>
	<script src="{{asset('js/util.js')}}"></script>
	</div>
	<!-- Body End -->
	@endsection

	


	