	@php
    	$api_token = Cookie::get('api_auth_token');
		$user = Auth::user();

        $month_index = $next_month['month'];
        $month_index--;

        $months = [
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


    @endphp

	@extends('instructor.master')

	@section('content')

	<style>
		.btn_payment_cancel {
			font-size: 14px;
			font-weight: 400;
			font-family: 'Roboto', sans-serif;
			color: #fff !important;
			background: #475692;
			text-align: center;
			border: 0;
			width: 100%;
			height: 40px;
			float: right;
			right: 0;
			padding: 10px 0;
		}

		.btn_payment_cancel:hover {
			color: #fff !important;
			background: #333;
		}

		.payment_method{
            padding:5px;
            border-radius: 7px;
        }

        .payment_method:hover{
            color :#475692;
            background:#efeeff;
            border-radius: 7px;
            padding:5px;
            cursor: pointer;
        }

		.checkout_title h4 {
			font-size: 18px;
			font-weight: 500;
			font-family: 'Roboto', sans-serif;
			margin-bottom: 10px !important;
			color: #333;
			text-align: left;
			line-height: 26px;
		}

		.order_title {
			float: left;
			width: 100%;
			padding: 10px 0;
			border-bottom: 1px solid #efefef;
		}

		.order_title h2 {
			font-size: 20px;
			font-weight: 600;
			font-family: 'Roboto', sans-serif;
			color: #333;
			float: left;
			width: 70%;
			text-align: left;
			line-height: 24px;
			margin-bottom: 0;
		}

		.order_title .order_price5 {
			font-size: 20px;
			font-weight: 600;
			font-family: 'Roboto', sans-serif;
			color: #333;
			text-align: right;
			float: right;
			width: 30%;
			margin-bottom: 0;
		}
 

	</style>

    {{-- Paynow modal Start --}}
    <div style="" class="modal vd_mdl fade" id="payModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<div style="text-align: right">
						<button class="btn_payment_cancel" style="width:35px;height:35px;float:right;margin-top:0" type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>

					<div id="loading" style="display: none">
						<div class="col-md-12">
							<br><br><br><br><br>
							<div class="main-loader mt-50" style="margin-bottom:150px;">													
								<div class="spinner">
									<div class="bounce1"></div>
									<div class="bounce2"></div>
									<div class="bounce3"></div>
								</div>																										
							</div>
						</div>
					</div>

					<div class="membership_chk_bg rght1528">
						<div class="coupon_code">
							<h4>How to apply?</4>
							<p>
								Select the payout method. <br>
								Transfer the required amount ({{$billed_amount}} MMK). <br>
								Send the payment screenshot with transaction ID. <br>
								<br><br>
							</p>
						</div>

						<div class="checkout_title">
							<h4>Payment Methods</h4>
							<img src="{{asset('images/line.svg')}}" alt="">
						</div>
						<div class="order_dt_section">

							@foreach ($payout_methods as $method)
								<div class="fcrse_1 payment_method" style="margin:3px;padding:0">
									<div class="" style="display: flex;padding:5px;">
										<img style="width:30px;height:30px;margin-right:20px;background:#475692;border-radius:3px;" src="{{asset($method['icon_url'])}}" alt="">
										<div >
											<strong>{{$method['account_name']}}</strong>
											<div>{{$method['method']}}</div>
										</div>
									</div>
								</div>
							@endforeach
							
							<div class="order_title">
								<h2>Amount</h2>
								<div class="order_price5">{{$billed_amount}} MMK</div>
							</div>

							<div class="coupon_code">
								<h4> </4>
								<p>
									
									<br>
								</p>
							</div>
							<div style="text-align: center;">
								<img id="img_screenshot" style="width: 180px;height:320px;display:none" src="" alt="">
								<br><br>
								
								<span id="screenshot_picker" style="border: 1px solid #475692;border-radius:7px;color:#475692;padding:10px;cursor:pointer">
									Upload Screenshot
								</span><br><br>
								Select a payment screenshot
								<p id="form_error" style="text-align:center;font-size:12px;color:red;margin-top:10px;display:none"> Add the transaction sreenshot of your payout.  </p>	
							
								<form id="checkoutform" action="{{route('instructor.bills.create')}}" method="post" enctype="multipart/form-data">
									@csrf
									<input type="file" name="screenshot" id="input_screenshot" style="display:none" accept="image/*">
									<input type="hidden" name="payment" value="" />
									<input type="hidden" name="history_from" value="{{$history_from}}" />
									<input type="hidden" name="history_to" value="{{$history_to}}" />
									
								 
								</form>
								<br><br>
								<button onclick="checkoutNow()"class="main-btn">Checkout Now</button>
							</div>
						</div>
					</div>
				</div>
				<script>

					let screenshot_src = null;
					const payment_methods = @json($payout_methods);

					$(document).ready(()=>{

					 
						$('.payment_method').each((j,method)=>{
							$(method).click(()=>{
								const payment_method_id = payment_methods[j].id;
								$('#payment_method').val(payment_method_id);

								$('.payment_method').each((i,m)=>{
									$(m).css({"border":""});
								})

								$(method).css({"border":"2px solid #475692"});
								
							})
						})

						$('#screenshot_picker').click(()=>{
							$('#input_screenshot').click();
							$('#img_screenshot').attr('src', '');
							$('#img_screenshot').hide();
						});

						$('#input_screenshot').change(()=>{
							$('#form_error').hide();
							var files=$('#input_screenshot').prop('files');
							var file=files[0];
							var reader = new FileReader();

							reader.onload = function (e) {
								let imageSrc=e.target.result;
								screenshot_src = imageSrc;
								$('#img_screenshot').attr('src', imageSrc);
								$('#img_screenshot').show();
							};

							reader.readAsDataURL(file);
								
						});
					})

					function checkoutNow(){
						var files=$('#input_screenshot').prop('files');
						if(files.length==0){
							$('#form_error').show();
						}else{
							$('#checkoutform').submit();
						}
						
					}
				</script>
			</div>
		</div>
	</div>
    {{-- Paynow modal End --}}
	 
	<div class="wrapper">
		<div class="sa4d25">
			 <div class="container-fluid">	
				@if (session('msg'))
					<div class="alert alert-success">
						{{session('msg')}}
					</div>
				@endif		
				@if (session('error'))
					<div class="alert alert-danger">
						{{session('error')}}
					</div>
				@endif		
				<div class="row">
					<div class="col-lg-12">	
						<h2 class="st_title"><i class="uil uil-wallet"></i> Payout</h2>
					</div>					
				</div>				
				<div class="row">					
					<div class="col-lg-4 col-md-5">
						<div class="top_countries mt-30">
							<div class="top_countries_title">
								<h2>Next payout</h2>
							</div>
							<div class="payout_content">
								<span><strong>{{$billed_amount}} MMK</strong></span>
								 <br>
								<p><small class="payout__small-notification">Your payout must be processed on  <strong>{{$months[$month_index]}} 5, {{$next_month['year']}}</strong></small></p>
							</div>
						</div>
						<div class="top_countries mt-30">
							<div class="top_countries_title">
								<h2>Payout Method</h2>
							</div>
							<div class="payout_content">
								@foreach ($payout_methods as $method)
                                    <div class="" style="margin:3px;padding:0">
                                        <div class="" style="display: flex;padding:5px;">
                                            <img style="width:30px;height:30px;margin-right:20px;background:#475692;border-radius:3px;" src="{{asset($method['icon_url'])}}" alt="">
                                            <div >
                                                <strong>{{$method['account_name']}}</strong>
                                                <div>{{$method['method']}}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
								<p><a href="#" class="payout__btn" data-toggle="modal" data-target="#payModal">Payout Now</a></p>
							</div>
						</div>
					</div>
					<div class="col-lg-8 col-md-7">
						<div class="table-responsive mt-30">
							<table class="table ucp-table earning__table">
								<thead class="thead-s">
									<tr>
										<th scope="col" class="text-center">Status</th>	
										<th scope="col">Amount</th>
										<th scope="col">Date Processed</th>	
										<th scope="col">Invoice</th>	
									</tr>
								</thead>
								<tbody id="bill_container">

								</tbody>				
							</table> 
						</div>
						<div id="no_data_container" style="display: none">
							<div style="text-align: center;color:#888">
								<br><br><br><br>
								<i style="font-size:80px;" class="uil uil-wallet"></i><br><br>
									<span style="font-size: 20px;">No billing statement</span>
								<br><br><br><br>
							</div>
						</div>
						<div class="row" id="shimmer">				
							<div class="col-md-12">
								<br><br><br>
								<div class="main-loader mt-50">													
									<div class="spinner">
										<div class="bounce1"></div>
										<div class="bounce2"></div>
										<div class="bounce3"></div>
									</div>																										
								</div>
								<br><br><br>
							</div>
							<div class="col-md-12">
								<br><br><br>
							</div>
						</div>		
					</div>
				</div>
			</div>
		</div>
		@include('instructor.components.footer')
	</div>
	<!-- Body End -->

	<script>
        const user = @json($user);

		let is_fetching = false;
		let arr = [];
		let fetch_url = `{{asset("")}}instructor-dashboard/api/bills?page=1`

		$(document).ready(()=>{
	
			fetchBills();

			$(window).scroll(()=>{
				if($(window).scrollTop() + $(window).height() > $(document).height() - 500) {
					if(!is_fetching){
						fetchBills();
					}
				}
			});

		});

		function fetchBills(){
			is_fetching = true;
			$('#shimmer').show();
			if(fetch_url==null){
				$('#shimmer').hide();
				return;
			}
			$.ajax({
				url: fetch_url,
				type: 'GET', // or 'GET' depending on your request
				headers: {
					'Authorization': 'Bearer '+apiToken // Example for Authorization header
				},
				
				success: function(res) {
					is_fetching=false;
					if(res){
						fetch_url = res.next_page_url;
						let bills = res.data;
						setBills(bills);
						
					}
				},
				error: function(xhr, status, error) {
					console.error('Error:', status, error);
				}
			});
		}

		function setBills(bills){
			$('#shimmer').hide();
			bills.map((bill,index)=>{
				arr.push(bill);	
				$('#bill_container').append(billComponent(bill));
			})

			if(arr.length==0){
				$('#no_data_container').show();
			}
		}

		function billComponent(bill){
			let status = "";
			if(bill.verified == 1){
				status = `<i style="color:rgb(42, 184, 42)" class="uil uil-check-circle"></i>`;
			}else{
				status = `<i style="color: yellow" class="uil uil-circle"></i>`;
				status = `<div style="width:10px; height:10px; border-radius:50px; background:yellow; margin:auto;"></div>`;
			}
			return `
				<tr>		
					<td> ${status} </td>								
					<td>${bill.amount} MMK</td>	
					<td>${formatDateTime(new Date(bill.created_at))}</td>	
					<td> <a href="{{asset('storage')}}/${bill.screenshot_url}">Invoice</a> </td>
				</tr>	
			`;
		}

	</script>
	<script src="{{asset('js/util.js')}}"></script>
	@endsection