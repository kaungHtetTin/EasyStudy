@php
if (!function_exists('calculateHour')) {
	function calculateHour($min){
		$hr = $min/60;
		$hr = floor($hr);
		return $hr;
	}
}
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

if (!function_exists('formatCount')) {
	function formatCount($count){

		if($count<=1){
			return $count;
		}else if($count>1 && $count<1000){
			return $count;
		}else if($count>=1000 && $count<1000000){
			return floor($count/1000).'k';
		}else{
			return floor($count/1000000).'M';
		}
	}
}

    $api_token = Cookie::get('api_auth_token');
	$current_user = Auth::user();

@endphp


@extends('student.components.master')
@section('content')
	<style>
		._htg452 ul{
			list-style-type: disc;
			margin-inline-start: 20px;
		}

        .my-table td{
            padding:5px;
        }
	</style>
@auth
<div class="wrapper _bg4586">
@else
<div style="padding-top:60px;">
@endauth
		<div class="_216b01">
			<div class="container-fluid">			
				<div class="row justify-content-md-center">
					<div class="col-md-10">
						<div class="section3125 rpt145">							
							<div class="row">						
								<div class="col-lg-7">
									@auth
										@if ($user->id == $current_user->id)
											<a href="{{route('setting')}}" class="_216b22">										
												<span><i class="uil uil-cog"></i></span>Setting
											</a>
										@else
											<a href="#" class="_216b22">										
												<span><i class="uil uil-windsock"></i></span>Report
											</a>
										@endif
									@endauth
									
									<div class="dp_dt150">						
										<div class="img148">
											<img src="{{asset('storage/'.$user->image_url)}}" alt="">										
										</div>
										<div class="prfledt1">
											<h2>{{$user->name}}</h2>
											<span>{{$user->bio}}</span>
										</div>										
									</div>
 
									 
								</div>
								<div class="col-lg-5">
									@auth
										@if ($user->id == $current_user->id)
											<a href="{{route('setting')}}" class="_216b12">										
												<span><i class="uil uil-cog"></i></span>Setting
											</a>
										@else
											<a href="#" class="_216b12">										
												<span><i class="uil uil-windsock"></i></span>Report
											</a>
											<div class="rgt-145">
												<ul class="tutor_social_links">
													<button onclick="window.location.href='{{route('users.message',$user->id)}}'" class="subscribe-btn btn500">Message</button>
												</ul>
											</div>
										@endif
									@endauth
									
								</div>		
                                
                                <div class="col-lg-6 col-md-6">
                                    <table class="my-table" style="margin-top:20px;color:white">
                                        <tr>
                                            <td> <i class="uil uil-envelope"></i></i> Email</td>
                                            <td>{{$user->email}}</td>
                                        </tr>
                                        <tr>
                                            <td> <i class="uil uil-phone-alt"></i> Phone</td>
                                            <td>{{$user->phone}}</td>
                                        </tr>
                                        <tr>
                                            <td> <i class="uil uil-home-alt"></i> Address</td>
                                            <td>{{$user->address}}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <table class="my-table" style="margin-top:20px;color:white">
                                        <tr>
                                            <td> <i class="uil uil-graduation-hat"></i> Education</td>
                                            <td>{{$user->education}}</td>
                                        </tr>
                                        <tr>
                                            <td> <i class="uil uil-mars"></i> Gender</td>
                                            <td>{{$user->gender}}</td>
                                        </tr>
                                        <tr>
                                            <td> <i class="uil uil-calendar-alt"></i> Birth on</td>
                                            <td>{{$user->brith_date}}</td>
                                        </tr>
                                    </table>
                                </div>
							</div>							
						</div>							
					</div>															
				</div>
			</div>
		</div>
		 
		<div class="_215b17">
			<div class="container-fluid">
				<div>
                    <div class="_htg451">
                        <div class="_htg452">
                            @if (count($purchased_courses)>1) 
                                <h3>Purchased Courses</h3>
                                <div class="row">
                                    @foreach ($purchased_courses as $myCourse)
                                        @php
                                            $course = $myCourse->course;
                                        @endphp
                                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                            @include('student.components.item-course')
                                        </div>
                                    @endforeach
                                
                                </div>
                            @else
                                <div style="text-align: center;color:#888">
                                    <br><br><br><br><br>
                                    <i style="font-size:80px;" class="uil uil-book"></i><br><br>
                                     <span style="font-size: 20px;">No purchased course</span>
                                    <br><br><br><br><br>
                                </div>
                            @endif
                        </div>																	
                    </div>							
                </div>
			</div>
		</div>

	<script>
		const apiToken = "{{$api_token}}";

		function addToCart(courseId){
			document.getElementById('cart_form_'+courseId).submit();
		}	

		function copyCourseUrl(url,id){
			
			// Create a temporary input element to hold the URL
			const tempInput = document.createElement('input');
			tempInput.value =url;
			document.body.appendChild(tempInput);

			// Select the input element's value
			tempInput.select();
			tempInput.setSelectionRange(0, 99999); // For mobile devices

			// Copy the text inside the input element
			document.execCommand('copy');

			// Remove the temporary input element
			document.body.removeChild(tempInput);

			// Optionally, alert the user that the URL has been copied

			alert('URL copied to clipboard: ' +url);

			$.ajax({
				url: '{{asset("")}}api/courses/share/'+id, // Replace with your API endpoint
				type: 'POST', // or 'GET' depending on your request
				headers: {
					'Authorization': 'Bearer '+apiToken // Example for Authorization header
				},
				success: function(response) {
					console.log('Success:', response);
				},
				error: function(xhr, status, error) {
					console.error('Error:', status, error);
				}
			});

		}
	</script>

@endsection
		