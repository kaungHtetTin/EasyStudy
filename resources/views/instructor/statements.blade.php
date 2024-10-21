	@extends('instructor.master')

	@section('content')

    <style>
        form{
            display: inline;
        }
		.table-summery td{
			padding: 4px;
		}

		.approve td{
			color:green;
		}

		.night-mode .approve td{
			color:rgb(0, 215, 0);
		}
    </style>
    <!-- Body Start -->
	<div class="wrapper">
		<div class="sa4d25">
			<div class="container-fluid">		
				@if (session('msg'))
					<div class="alert alert-success">
						{{session('msg')}}
					</div>
				@endif	
				<div class="row">
					<div class="col-lg-12">	
						<h2 class="st_title"><i class="uil uil-file-alt"></i> Statements</h2>
					</div>					
				</div>
				<div class="date_selector">
					<div class="ui selection dropdown skills-search vchrt-dropdown">
						<input name="date" type="hidden" value="{{$request['year']}}" id="year_selector">
						<i class="dropdown icon d-icon"></i>
						<div class="text" id="year_text">{{$request['year']}}</div>
						<div class="menu" id="year_container">
						
						</div>
					</div>

					<div class="ui selection dropdown skills-search vchrt-dropdown">
						<input name="date" type="hidden" value="{{$request['month']}}" id="month_selector">
						<i class="dropdown icon d-icon"></i>
						<div class="text" id="month_text">Month</div>
						<div class="menu" id="month_container">
						
						</div>
					</div>
				</div>		
				<div class="row">	
					<div class="col-lg-8 col-md-7">
						<div class="top_countries mt-30">
							<div class="top_countries_title">
								<h2>Earnings</h2>
							</div>
							<div class="statement_content" style="height:150px;">
								<p class="tt-body" id="statement_title">Loading.. .. </p>
								<table class="statement-summary__table">
									<thead>
										<tr>
											<th>
												<p class="t-heading">Earnings</p>
											</th>
											<th>
												<p class="t-heading">Service Fee</p>
											</th>
											<th>
												<p class="t-heading">Net Profit</p>
											</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="statement-summary__earnings">
												<p class="js-earnings__earnings-wrapper">
													<span class="tt__earning">+</span>
													<span class="js-earnings__earnings t-currency">{{$earning_request_month}} MMK</span>
												</p>
											</td>
											<td class="statement-summary__fees">
												<p class="js-earnings__fees-wrapper">
													<span class="tt__earning">-</span>
													<span class="js-earnings__fees t-currency">$154.86</span>
												</p>
											</td>
											<td class="statement-summary__funds">
												<p class="js-earnings__instructor-funds-wrapper">
													<span class=""></span>
													<span class="js-earnngs__instructor-funds t-currency">$289.64</span>
												</p>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>			
					</div>

					<div class="col-lg-4 col-md-5">
						<div class="top_countries mt-30">
							<div class="top_countries_title">
								<h2>Total</h2>
							</div>
							<div class="statement_content" style="height:150px;">
								<table class="table-summery">
									<tr>
										<td>Today</td>
										<td>  {{$earning_today}} mmk </td>
									</tr>
									<tr>
										<td>Current Month</td>
										<td> {{$earning_current_month}} mmk </td>
									</tr>
									<tr>
										<td>Current Year</td>
										<td> {{$earning_current_year}} mmk </td>
									</tr>
									<tr>
										<td>All Time</td>
										<td> {{$earning_all_time}} mmk </td>
									</tr>
								</table>
							</div>
						</div>
					</div>

					<div class="col-lg-12 col-md-12">
						<ul class="more_options_tt">
							<li><button id="btn_all" class="more_items_14 {{$verified==2 ? 'active':''}}" >All</button></li>
							<li><button id="btn_unverified" class="more_items_14 {{$verified==0 ? 'active':''}}" >Unverified</button></li>
							<li><button id="btn_approved" class="more_items_14 {{$verified==1 ? 'active':''}}">Approved</button></li>
						</ul>
					</div>
					<div class="col-lg-12 col-md-12">
						<div class="table-responsive mt-30">
							<table class="table ucp-table earning__table">
								<thead class="thead-s">
									<tr>
										<th scope="col">Date</th>
										<th scope="col">Order ID</th>
										<th scope="col">Order By</th>
										<th scope="col">Title</th>
										<th scope="col">Amount</th>	
										<th scope="col">Invoice</th>		
                                        <th class="text-center" scope="col">Action</th>							
									</tr>
								</thead>
								<tbody>
                                    @if (count($payment_histories)>0)
                                        @foreach ($payment_histories as $history)
                                            <tr class="{{$history->verified==1 ? 'approve':''}}">										
                                                <td>{{$history->created_at->diffForHumans()}}</td>	
                                                <td>{{$history->id}}</td>	
												<td>{{$history->user->name}}</td>	
                                                <td>{{$history->course->title}}</td>	
                                                <td>{{$history->amount}}</td>	
                                                <td><a href="{{route('instructor.statements.view',$history->id)}}">View</a></td>	
                                                <td class="text-center">
                                                    @if ($history->verified==0)
                                                        <form action="{{route('instructor.statements.change',$history->id)}}" method="post">@csrf @method("PUT")
                                                            <input type="hidden" value="1" name="verified">
                                                            <button class="st_download_btn" style="padding:5px;font-size:12px;" ><i class="uil uil-check-circle"></i></button>
                                                        </form>
                                                    @endif
                                                    
                                                    <button class="st_download_btn" style="padding:5px;font-size:12px;"  data-toggle="modal" data-target="#delete-section{{$history->id}}"><i class="uil uil-trash"></i></button>
                                                </td> 
                                            </tr>

											<div class="modal fade" id="delete-section{{$history->id}}" tabindex="-1" aria-labelledby="lectureModalLabel" aria-hidden="true">
												<div class="modal-dialog modal-lg">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="lectureModalLabel">Delete Statements</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															<div class="alert alert-warning">
																<b>Important warning: </b> By deleting this statemt, {{$history->user->name}} will have no longer access to the {{$history->course->title}}. It is the same that the user is removed from the course's student list.
															</div>
														</div>
														<div class="modal-footer">
															<button type="button" class="main-btn cancel" data-dismiss="modal">Close</button>
															<form action="{{route('instructor.statements.remove',$history->id)}}" method="post">
																@csrf
																@method('DELETE')
																<button type="submit" class="main-btn">Delete</button>
															</form>
														</div>
													</div>
												</div>
											</div>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="text-center" colspan="7">No statement</td>
                                        </tr>
                                    @endif
                                    
								</tbody>				
							</table>
						</div>
				
					</div>
				</div>
			</div>
		</div>
		@include('instructor.components.footer')
	</div>
	<!-- Body End -->
    <script>

        let statement_url = "{{route('instructor.statements.lists')}}";
		let verified = "{{$verified}}";
		const request = @json($request);
		
		console.log(request);

        $(document).ready(()=>{
            $('#btn_unverified').click(()=>{
				verified = 0;
                requestNow();
            });

            $('#btn_approved').click(()=>{
				verified = 1;
                requestNow();
            });

			$('#btn_all').click(()=>{
				verified = 2;
				requestNow();
			})

			setMonths();
			setYears();

			$('#year_selector').change(()=>{
				requestNow();
			})

			$('#month_selector').change(()=>{
				requestNow();
			})
        });

		function setYears(){
			let currentYear= new Date().getFullYear();
			let content = "";
			for(var i=currentYear;i>=2023;i--){
				content+=`
					<div class="item" data-value="${i}">${i}</div>
				`;
			}
			$('#year_container').html(content);
			$('#year_text').html(request.year);
		}

		function setMonths(){
			let months =[
					"Jan",
					"Feb",
					"Mar",
					"Apr",
					"May",
					"Jun",
					"Jul",
					"Aug",
					"Sep",
					"Oct",
					"Nov",
					"Dec"
				];
			let content = "";
			for(var i=0;i<months.length;i++){
				content+=`
					<div class="item" data-value="${(i+1)}">${months[i]}</div>
				`;
			}    
			$('#month_container').html(content);
			
			let index = request.month - 1;
			$('#month_text').html(months[index]);
			$('#statement_title').html("Your sales earning for "+months[index]+", "+request.year);
		}

		function requestNow(){

			let year = $('#year_selector').val();
			let month = $('#month_selector').val();
			if(year==0){
				year = new Date().getFullYear();
			}
			if(month==0){
				month = new Date().getMonth();
			}

			let url = `{{asset("")}}instructor-dashboard/statements?verified=${verified}&year=${year}&month=${month}`;
			window.location.href=url;
		}

    </script>
	
	@endsection