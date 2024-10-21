	@php
    	$api_token = Cookie::get('api_auth_token');
		$user = Auth::user();

    @endphp

	@extends('instructor.master')

	@section('content')
	<style>

        .fcrse_1:hover{
            color: #475692;
    		background-color: #e6e4ff;
        }

	</style>
	<div class="wrapper">
		<div class="sa4d25">
			<div class="container-fluid">			
				<div class="row">
					<div class="col-12">	
						<h2 class="st_title"><i class="uil uil-eye"></i> Recent Visits</h2>
					</div>	
				</div>		
				<br>		
				<div>
                    @if (count($visits) > 0) 
                        @foreach ($visits as $visit)

                            <div class="fcrse_1">
                                <a href="{{route('instructor.visits.view',$visit->id)}}">
                                    <div class="review_usr_dt">
                                        <img src="{{asset('storage/'.$visit->user->image_url)}}" alt="">
                                        <div class="rv1458">
                                            <h4 class="tutor_name1">{{$visit->user->name}}</h4>
                                            <span class="time_145">{{$visit->course_title}}</span>
                                            <span class="time_145">Visited . {{$visit->created_at->diffForHumans()}}</span>
                                            
                                        </div>
                                    </div>
                                </a>
                            </div> 
                        @endforeach
                    @else
                        <div style="text-align: center;color:#888">
							<br><br><br><br><br>
							<i style="font-size:80px;" class="uil uil-eye"></i><br><br>
								<span style="font-size: 20px;">No data available</span>
							<br><br><br><br><br>
						</div>
                    @endif
                </div>
			</div>
		</div>
		@include('instructor.components.footer')
	</div>
	<!-- Body End -->
	@endsection