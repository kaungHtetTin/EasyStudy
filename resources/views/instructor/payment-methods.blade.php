	@extends('instructor.master')

	@section('content')
	<style>
		.payment_content{
			padding: 10px 25px 25px 25px;
			float: left;
			width: 100%;
		}
		.input_error{
			color:red;
			display: none;
		}

        .icon-bank{
            width:30px;
            height:30px;
            border-radius: 5px;
        }

	</style>
	<div class="wrapper">
		<div class="sa4d25">
			<div class="container-fluid">	
				<div class="row">	
					<div class="col-12">
						@if (session('success_msg'))
							<div class="alert alert-success">
								{{session('success_msg')}}
							</div>
						@endif
					</div>		
                    <div class="col-lg-12">	
						<h2 class="st_title"><i class="uil uil-card-atm"></i> Payment Methods</h2>
					</div>		
					<div class="col-lg-7 col-md-6">
						@if (count($payment_methods)>0)
							<div class="table-responsive mt-30">
								<table class="table ucp-table earning__table">
									<thead class="thead-s">
										<tr>
											<th scope="col" colspan="2" style="text-align: center">Bank</th>
											<th scope="col">Account Name</th>
											<th scope="col">Phone</th>	
											<th scope="col">Aciton</th>									
										</tr>
									</thead>
									<tbody>
										@foreach ($payment_methods as $method)
											<tr>
												<td>
													<img class="icon-bank" src="{{asset($method->payment_method_type->icon_url)}}" alt="">
												</td>
												<td>{{$method->payment_method_type->type}} </td>
												<td>{{$method->account_name}}</td>
												<td>{{$method->method}}</td>
												<td class="text-center">
													<a href="#" title="Delete Payment Method" data-toggle="modal" data-target="#delete-section{{$method->id}}" class="gray-s"><i class='uil uil-trash-alt'></i></a>
												</td> 
											</tr>

											<div class="modal fade" id="delete-section{{$method->id}}" tabindex="-1" aria-labelledby="lectureModalLabel" aria-hidden="true">
												<div class="modal-dialog modal-lg">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="lectureModalLabel">Delete Payment Methods</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															<div style="width:300px; margin:auto">
																<div class="top_countries" style="padding:10px;">
																	<div style="display:flex">
																		<img style="height: 20px; width:20px;border-radius:3px;" src="{{asset($method->payment_method_type->icon_url)}}" alt="">
																		<span style="font-weight:bold; font-size:14px;margin-left:10px;"> {{$method->payment_method_type->type}} </span>
																	</div>
																	<div style="margin-left:30px;margin-top:10px;">
																		<span style="font-weight: bold">Account Name</span> <br>
																		<span>{{$method->account_name}} </span> <br>

																		<div style="margin-top:10px;">
																			<span style="font-weight:bold;">Phone number</span> <br>
																			<span>{{$method->method}} </span> <br>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="modal-footer">
															<button type="button" class="main-btn cancel" data-dismiss="modal">Close</button>
															<form action="{{route('instructor.payment-methods.remove',$method->id)}}" method="post">
																@csrf
																@method('DELETE')
																<button type="submit" class="main-btn">Delete</button>
															</form>
														</div>
													</div>
												</div>
											</div>
										@endforeach								
									</tbody>				
								</table>
							</div>
						@else
							<div style="text-align: center;padding:50px;">
								<br><br><br>
								No payment method. <br> Please add your payment method.
							</div>
						@endif
						
					</div>
					<div class="col-lg-5 col-md-6">
						<div class="top_countries mt-30">
							<div class="top_countries_title">
								<h2>Add New Payment Method</h2>
							</div>
							<div class="payment_content">
								<form action="{{route('instructor.payment-methods.save')}}" method="POST" id="form_payment_method">
									@csrf
									<label class="label25">Banking Phone*</label>
									<span class="input_error" id="input_phone_error"> Please enter the phone number </span>
									<input name="phone" id="input_phone_number" class="form_input_1" type="text" placeholder="Phone number here">
									<br><br>
									<label class="label25">Account Name*</label>
									<span class="input_error" id="input_name_error"> Please enter the phone number </span>
									<input name="acc_name" id="input_name" class="form_input_1" type="text" placeholder="Account name here">

									<br><br>
									<label class="label25">Bank*</label>
									<span class="input_error" id="banking_selector_error"> Please select the banking service </span>
									<select name="payment_method_type_id" id="banking_selector" class="ui hj145 dropdown cntry152 prompt srch_explore" >
										<option value="">Select a mobile banking service</option>
										@foreach ($payment_method_types as $type)
											<option value="{{$type->id}}"> <i class="uil uil-card-atm"></i> {{$type->type}}</option>
										@endforeach
									</select>
                                    
								</form>
								<button id="btn_submit_payment" style="float:right" class="btn btn-default steps_btn mt-3">Add</button>
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
		// adding payment methods

		$(document).ready(()=>{
			$('#banking_selector').change(()=>{
				$('#banking_selector_error').hide();
			})

			$('#btn_submit_payment').click(()=>{
				if(validate()){
					$('#form_payment_method').submit();
				}

			})

			$('#input_phone_number').on('input',()=>{ $('#input_phone_error').hide() })
			$('#input_name').on('input',()=>{ $('#input_name_error').hide() })
		})
		

		function validate(){
			let isValidate = true;
			const phone = $('#input_phone_number').val();
			if(phone ==""){
				isValidate =false;
				$('#input_phone_error').show();
			}

			const name = $('#input_name').val();
			if(name==""){
				isValidate = false;
				$('#input_name_error').show();
			}

			const payment_method_type_id = $('#banking_selector').val();
			if(payment_method_type_id==""){
				isValidate =false;
				$('#banking_selector_error').show();
			}

			return isValidate;

		}

	</script>
	@endsection