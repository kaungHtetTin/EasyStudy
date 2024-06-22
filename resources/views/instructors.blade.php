@php
if (!function_exists('formatCounting')) {
	function formatCounting($count,$unit){

		if($count<=1){
			return $count.' '.$unit;
		}else if($count>1 && $count<1000){
			return $count.' '.$unit.'s';
		}else if($count>=1000 && $count<1000000){
			return floor($count/1000).'k'.' '.$unit.'s';
		}else{
			return floor($count/1000000).'M'.' '.$unit.'s';;
		}
	}
}
@endphp

@extends('layouts.master')


@section('content')

	@auth
	<div class="wrapper">
	@else
	<div style="padding-top:80px;">
	@endauth
		<div class="sa4d25">
			<div class="container-fluid">			
				<div class="row">
					<div class="col-xl-12 col-lg-8">
						<div class="section3125">
							<div class="explore_search">
								<div class="ui search focus">
									<div class="ui left icon input swdh11">
										<input class="prompt srch_explore" type="text" placeholder="Search Tutors...">
										<i class="uil uil-search-alt icon icon2"></i>
									</div>
								</div>
							</div>							
						</div>							
					</div>	
					<div class="col-md-12">
						<div class="_14d25">
							<div class="row">
                                @foreach ($instructors as $instructor)
                                    <div class="col-xl-3 col-lg-4 col-md-6">
                                        <div class="fcrse_1 mt-30">
                                            <div class="tutor_img">
                                                <a href="{{route('instructor_detail',['id'=>$instructor->id])}}"><img src="images/left-imgs/img-1.jpg" alt=""></a>												
                                            </div>
                                            <div class="tutor_content_dt">
                                                <div class="tutor150">
                                                    <a href="{{route('instructor_detail',['id'=>$instructor->id])}}" class="tutor_name">{{$instructor->user->name}}</a>
                                                    <div class="mef78" title="Verify">
                                                        <i class="uil uil-check-circle"></i>
                                                    </div>
                                                </div>
                                                <div class="tutor_cate">
                                                    @foreach ($instructor->categories as $index=> $category)
                                                            @if ($index>0)
                                                                &amp;
                                                            @endif
                                                        {{$category->title}} 
                                                    @endforeach
                                                </div>
                                                <ul class="tutor_social_links">
                                                    <li><a href="#" class="fb"><i class="fab fa-facebook-f"></i></a></li>
                                                    <li><a href="#" class="tw"><i class="fab fa-twitter"></i></a></li>
                                                    <li><a href="#" class="ln"><i class="fab fa-linkedin-in"></i></a></li>
                                                    <li><a href="#" class="yu"><i class="fab fa-youtube"></i></a></li>
                                                </ul>
                                                <div class="tut1250">
                                                    <span class="vdt15">{{formatCounting($instructor->student_enroll,' Student')}}</span>
                                                    <span class="vdt15">
                                                        @php
                                                            $courseCount = $instructor->total_course;
                                                            if ($courseCount>1) {
                                                                echo $courseCount." Courses";
                                                            }else{
                                                                echo $courseCount." Course";
                                                            }
                                                        @endphp
                                                    </span>
                                                </div>
                                            </div>
                                        </div>										
                                    </div>
								 @endforeach
								<div class="col-md-12">
									<div class="main-loader mt-50">													
										<div class="spinner">
											<div class="bounce1"></div>
											<div class="bounce2"></div>
											<div class="bounce3"></div>
										</div>																										
									</div>
								</div>
							</div>				
						</div>				
					</div>				
				</div>
			</div>
		</div>

		<script>
			let instructors = @json($instructors);
			console.log(instructors);


		</script>
@endsection