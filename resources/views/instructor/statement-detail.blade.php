	@extends('instructor.master')

	@section('content')

    <style>
        form{
            display: inline;
        }

		.night-mode .kht-table{
			color:whitesmoke;
		}
		
    </style>
    <!-- Body Start -->
	<div class="wrapper">
		<div class="sa4d25">
			<div class="container-fluid">		
				
				<div class="row">
					<div class="col-lg-12">	
						<h2 class="st_title"><i class="uil uil-file-alt"></i> Statements <i class="uil uil-arrow-right"></i> Invoice</h2>
					</div>					
				</div>				
				<div class="row">					
					<div class="col-lg-7 col-md-7">
						<div class="top_countries mt-30">
							 <img src="{{asset('storage/'.$payment_history->screenshot_url)}}" style="width:100%" />
						</div>			
					</div>
					<div class="col-lg-5 col-md-5">
						<div class="top_countries mt-30">
							<div class="top_countries_title">
								<h2>Order By</h2>
							</div>
							<div class="statement_invoice_content" style="height: max-content">
								 <img src="{{asset('storage/'.$payment_history->user->image_url)}}"  style="width: 40px; height:40px; border-radius:50px;"/> 
								 <span style="font-weight: bold;font-size:14px;margin-left:15px;"> {{$payment_history->user->name}}</span>
								 <table class="table kht-table" style="margin-top:20px;">
									<tr>
										<td>Email</td>
										<td>{{$payment_history->user->email}}</td>
									</tr>
									<tr>
										<td>Phone</td>
										<td>{{$payment_history->user->phone}}</td>
									</tr>
									<tr>
										<td>Address</td>
										<td>{{$payment_history->user->address}}</td>
									</tr>
									<tr>
										<td>Course</td>
										<td>{{$payment_history->course->title}}</td>
									</tr>
									<tr>
										<td>Amount</td>
										<td>{{$payment_history->amount}} MMK</td>
									</tr>
									<tr>
										<td>Date</td>
										<td>{{$payment_history->created_at->diffForHumans()}}</td>
									</tr>
								 </table>
								 @if ($payment_history->verified==0)
									<form action="{{route('instructor.statements.change',$payment_history->id)}}" method="post">@csrf @method("PUT")
										<input type="hidden" value="1" name="verified">
										<button class="st_download_btn" style="padding:5px;font-size:12px;" >Approved <i class="uil uil-check-circle"></i></button>
									</form>
								@endif
								
								<button class="st_download_btn" style="padding:5px;font-size:12px;"  data-toggle="modal" data-target="#delete-section">Delete <i class="uil uil-trash"></i></button>

							</div>
						</div>			
					</div>
			 
				</div>
			</div>
		</div>

		<div class="modal fade" id="delete-section" tabindex="-1" aria-labelledby="lectureModalLabel" aria-hidden="true">
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
						<form action="{{route('instructor.statements.remove',$payment_history->id)}}" method="post">
							@csrf
							@method('DELETE')
							<button type="submit" class="main-btn">Delete</button>
						</form>
					</div>
				</div>
			</div>
		</div>

		@include('instructor.components.footer')
	</div>
	<!-- Body End -->
    
	@endsection