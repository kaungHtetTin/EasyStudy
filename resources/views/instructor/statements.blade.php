	@extends('instructor.master')

	@section('content')

    <style>
        form{
            display: inline;
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
				<div class="row">					
					<div class="col-lg-8 col-md-7">
						<div class="top_countries mt-30">
							<div class="top_countries_title">
								<h2>Earnings</h2>
							</div>
							<div class="statement_content">
								<p class="tt-body">Your sales earnings for current month</p>
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
													<span class="js-earnings__earnings t-currency">$458.00</span>
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
								<h2>View Invoices</h2>
							</div>
							<div class="statement_invoice_content">
								<div class="date_selector mt-0">
									<div class="ui selection dropdown skills-search vchrt-dropdown invoice-dropdown">
										<input name="date" type="hidden" value="default">
										<i class="dropdown icon d-icon"></i>
										<div class="text">Monthly Invoices</div>
										<div class="menu">
											<div class="item" data-value="0">April 2020</div>
											<div class="item" data-value="1">March 2020</div>
										</div>
									</div>
									<button class="st_download_btn"><i class="uil uil-download-alt"></i></button>
								</div>
							</div>
						</div>			
					</div>
					<div class="col-lg-12 col-md-12">
						<ul class="more_options_tt">
							<li><button id="btn_unverified" class="more_items_14 {{$verified==0 ? 'active':''}}" >Unverified</button></li>
							<li><button id="btn_approved" class="more_items_14 {{$verified==1 ? 'active':''}}">Approved</button></li>
							{{-- <li>
								<div class="explore_search">
									<div class="ui search focus">
										<div class="ui left icon input swdh11 swdh15">
											<input class="prompt srch_explore" type="text" placeholder="Document Number">
											<i class="uil uil-search-alt icon icon8"></i>
										</div>
									</div>
								</div>
							</li> --}}
						</ul>
					</div>
					<div class="col-lg-12 col-md-12">
						<div class="table-responsive mt-30">
							<table class="table ucp-table earning__table">
								<thead class="thead-s">
									<tr>
										<th scope="col">Date</th>
										<th scope="col">Order ID</th>
										<th scope="col">Title</th>
										<th scope="col">Amount</th>	
										<th scope="col">Invoice</th>		
                                        <th  class="text-center" scope="col">Action</th>							
									</tr>
								</thead>
								<tbody>
                                    @if (count($payment_histories)>0)
                                        @foreach ($payment_histories as $history)
                                            <tr>										
                                                <td>{{$history->updated_at->diffForHumans()}}</td>	
                                                <td>{{$history->id}}</td>	
                                                <td>{{$history->course->title}}</td>	
                                                <td>{{$history->amount}}</td>	
                                                <td><a href="{{asset('storage/'.$history->screenshot_url)}}">View</a></td>	
                                                <td class="text-center">
                                                    @if ($history->verified==0)
                                                        <form action="{{route('instructor.statements.change',$history->id)}}" method="post">@csrf @method("PUT")
                                                            <input type="hidden" value="1" name="verified">
                                                            <button class="st_download_btn" style="padding:5px;font-size:12px;" >Approved <i class="uil uil-check-circle"></i></button>
                                                        </form>
                                                    @endif
                                                    
                                                    <button class="st_download_btn" style="padding:5px;font-size:12px;"  data-toggle="modal" data-target="#delete-section{{$history->id}}">Delete <i class="uil uil-trash"></i></button>
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
															Do you really want to delete this statement
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
                                            <td class="text-center" colspan="5">No statement</td>
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
        $(document).ready(()=>{
            $('#btn_unverified').click(()=>{
                window.location.href = statement_url+"?verified=0";
            });

            $('#btn_approved').click(()=>{
                window.location.href = statement_url+"?verified=1";
            });
        });


    </script>
	@endsection