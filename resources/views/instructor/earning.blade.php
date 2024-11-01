	@php
		$user = Auth::user();

		if (!function_exists('search_course')) {
			function search_course($id, $earnings){
				$result = null;
				foreach ($earnings as $key => $earning) {
					if($id==$earning->course_id){
						$result = $earning;
						break;
					}
				}

				return $result;
			}
		}
    @endphp

	@extends('instructor.master')

	@section('content')
	<style>
	 
	 
	</style>
	<div class="wrapper">
		<div class="sa4d25">
            <div class="container-fluid">			
				<div class="row">
					<div class="col-lg-12">	
						<h2 class="st_title"><i class="uil uil-dollar-sign"></i> Earning</h2>
					</div>					
				</div>				
				<div class="row">
					<div class="col-md-4">						
						<div class="earning_steps">						
							<p>This Month</p>
							<h2>{{$this_month_earnings->sum('amount')}}</h2>
						</div>
					</div>
					<div class="col-md-4">						
						<div class="earning_steps">						
							<p>This Year:</p>
							<h2>{{$this_year_earnings->sum('amount')}}</h2>
						</div>
					</div>
					<div class="col-md-4">						
						<div class="earning_steps">						
							<p>All Time</p>
							<h2>{{$all_time_earnings->sum('amount')}}</h2>
						</div>
					</div>
					<div class="col-12">
						<div class="table-responsive mt-30">
							<table class="table ucp-table earning__table">
								<thead class="thead-s">
									<tr>
										<th scope="col">Course</th>
										<th scope="col">This Month </th>
										<th scope="col">This Year </th>
										<th scope="col">All Time </th>
										<th scope="col">Sale </th>						
									</tr>
								</thead>
								<tbody>
									@foreach ($instructor->courses as $course)
										@php
											$m_earning = search_course($course->id, $this_month_earnings);
											$y_earning = search_course($course->id, $this_year_earnings);
											$a_earning = search_course($course->id, $all_time_earnings);
										@endphp
										<tr>										
											<td>{{$course->title}}</td>	
											<td>{{$m_earning!=null ? $m_earning->amount: '0'}}</td>	
											<td>{{$y_earning!=null ? $y_earning->amount: '0'}}</td>
											<td>{{$a_earning!=null ? $a_earning->amount: '0'}}</td>	
											<td>{{$a_earning!=null ? $a_earning->sale: '0'}}</td>
										</tr>
									@endforeach
									
									 
								</tbody>
								<tfoot>
									<tr>
										<td>Total</td>
										<td>{{$this_month_earnings->sum('amount')}}</td>	
										<td>{{$this_year_earnings->sum('amount')}}</td>
										<td>{{$all_time_earnings->sum('amount')}}</td>	
										<td>{{$all_time_earnings->sum('sale')}}</td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		@include('instructor.components.footer')
	</div>
	<!-- Body End -->
	 
	<script src="{{asset('js/util.js')}}"></script>

	@endsection