@php
    if(isset($_COOKIE['api_auth_token'])){
		$api_token = $_COOKIE['api_auth_token'];
	}else{
		$api_token = "";
	}
    $user = Auth::user();
@endphp

@extends('student.components.master')

@section('content')
	@auth
	<div class="wrapper">
	@else
	<div style="padding-top:60px;">
	@endauth
		<div class="sa4d25">
		    <div class="container-fluid">			
				<div class="row">
					<div class="col-lg-12">
						<h2 class="st_title"><i class='uil uil-windsock'></i> Report history</h2>
						<div class="row">
							<div class="col-lg-12">
								<div class="report_history">
									<h4>Thanks for reporting</h4>
									<p>Any member of the Edututs+ community can flag content to us that they believe violates our Community Guidelines. When something is flagged, it’s not automatically taken down. Flagged content is reviewed in line with the following guidelines:</p>
									<ul>
										<li><p>Content that violates our <a href="#">Community Guidelines</a> is removed from Edututs+.</p></li>
										<li><p>Content that may not be appropriate for all younger audiences may be age-restricted.</p></li>
									</ul>
									<a href="#" class="lnk586">Learn more about reporting content on Edututs+.</a>
									<span>You haven't submitted any reports.</span>
								</div>
							</div>
						</div>		
						
						<div style="margin-bottom:20px;">
							<h6>Report to User</h6>
							<div style="color:#999">Kaung Htet Tin <span style="color:green;margin-left:10px;"> Action taken <i class="uil uil-check-circle"></i> </span> </div>
						</div>

						<div style="margin-bottom:20px;">
							<h6>Report to User</h6>
							<div style="color:#999">Kaung Htet Tin <span style="color:green;margin-left:10px;"> Action taken <i class="uil uil-check-circle"></i> </span> </div>
						</div>
					</div>						
				</div>
			</div>
		</div>

@endsection
