@php
    $api_token = Cookie::get('api_auth_token');
@endphp

@extends('student.components.master')


@section('content')

	@auth
	<div class="wrapper _bg4586">
	@else
	<div style="padding-top:60px;">
	@endauth
		<div class="_215v12">
			<div class="container-fluid">			
				<div class="row">
					<div class="col-lg-12">
						<div class="section3125">							
							<div class="row justify-content-md-center">						
								<div class="col-md-6">					
									<div class="help_stitle">					
										<h2>How may we help you?</h2>
										<div class="explore_search">
											<div class="ui search focus">
												<div class="ui left icon input swdh11">
													<input class="prompt srch_explore" type="text" placeholder="Search for solutions">
													<i class="uil uil-search-alt icon icon2"></i>
												</div>
											</div>
										</div>
									</div>															
								</div>															
							</div>							
						</div>							
					</div>															
				</div>
			</div>
		</div>
		<div class="_215b15">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">						
						<div class="course_tabs">
							<nav>
								<div class="nav nav-tabs help_tabs tab_crse justify-content-center" id="nav-tab" role="tablist">
									<a class="nav-item nav-link active" id="nav-instructor-tab" data-toggle="tab" href="#nav-instructor" role="tab" aria-selected="true">Instructor</a>
									<a class="nav-item nav-link" id="nav-student-tab" data-toggle="tab" href="#nav-student" role="tab" aria-selected="false">Student</a>									
								</div>
							</nav>						
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="_215b17">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="course_tab_content">
							<div class="tab-content" id="nav-tabContent">
								<div class="tab-pane fade show active" id="nav-instructor" role="tabpanel">
									<div class="tpc152">
										<div class="crse_content">
											<h3>Select a topic to search for help</h3>																			
										</div>
										<div class="section3126 mt-20">
											<div class="row">
												<div class="col-md-4">
													<a href="#" class="value_props50">
														<div class="value_icon">
															<i class="uil uil-wallet"></i>
														</div>
														<div class="value_content">
															<h4>Payments</h4>
															<p>Understand the revenue share and how to receive payments.</p>
														</div>
													</a>
												</div>
												<div class="col-md-4">
													<a href="#" class="value_props50">
														<div class="value_icon">
															<i class="uil uil-megaphone"></i>
														</div>
														<div class="value_content">
															<h4>Selling & Promotion</h4>
															<p>Learn about the announcement and promotional tools.</p>
														</div>
													</a>
												</div>
												<div class="col-md-4">
													<a href="#" class="value_props50">
														<div class="value_icon">
															<i class="uil uil-file-check-alt"></i>
														</div>
														<div class="value_content">
															<h4>Quality Standards</h4>
															<p>Learn what it takes to create a high quality course.</p>
														</div>
													</a>
												</div>
												<div class="col-md-4">
													<a href="#" class="value_props50">
														<div class="value_icon">
															<i class="uil uil-file-edit-alt"></i>
														</div>
														<div class="value_content">
															<h4>Course Building</h4>
															<p>Build your course curriculum and landing page.</p>
														</div>
													</a>
												</div>
												<div class="col-md-4">
													<a href="#" class="value_props50">
														<div class="value_icon">
															<i class="uil uil-window"></i>
														</div>
														<div class="value_content">
															<h4>Course Management</h4>
															<p>Maintain your course and engage with students.</p>
														</div>
													</a>
												</div>
												<div class="col-md-4">
													<a href="#" class="value_props50">
														<div class="value_icon">
															<i class="uil uil-file-shield-alt"></i>
														</div>
														<div class="value_content">
															<h4>Trust & Safety</h4>
															<p>Policy and copyright questions and guidance.</p>
														</div>
													</a>
												</div>
											</div>
										</div>
									</div>
									<div class="tpc152">
										<div class="crse_content">
											<h3>Frequently Asked Questions</h3>																			
										</div>
										<div class="section3126 mt-20">
											<div class="row">
												<div class="col-md-4">
													<a href="#" class="value_props51">																											
														Promote Your Course With Coupons and Referral Links																													
													</a>
												</div>
												<div class="col-md-4">
													<a href="#" class="value_props51">																											
														How to Select Your Payout Method And Become a Premium Instructor																													
													</a>
												</div>
												<div class="col-md-4">
													<a href="#" class="value_props51">																											
														Cursus Course Quality Checklist																												
													</a>
												</div>
												<div class="col-md-4">
													<a href="#" class="value_props51">																											
														Instructor Revenue Share																													
													</a>
												</div>
												<div class="col-md-4">
													<a href="#" class="value_props51">																											
														Instructor Promotional Agreements and Cursus Deals																												
													</a>
												</div>
												<div class="col-md-4">
													<a href="#" class="value_props51">																											
														How to Become an Instructor: FAQ																												
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="nav-student" role="tabpanel">
									<div class="tpc152">
										<div class="crse_content">
											<h3>Select a topic to search for help</h3>																			
										</div>
										<div class="section3126 mt-20">
											<div class="row">
												<div class="col-md-4">
													<a href="#" class="value_props50">
														<div class="value_icon">
															<i class="uil uil-file-check-alt"></i>
														</div>
														<div class="value_content">
															<h4>Getting Started</h4>
															<p>Learn how Cursus works and how to start learning.</p>
														</div>
													</a>
												</div>
												<div class="col-md-4">
													<a href="#" class="value_props50">
														<div class="value_icon">
															<i class="uil uil-user"></i>
														</div>
														<div class="value_content">
															<h4>Account/Profile</h4>
															<p>Manage your account settings.</p>
														</div>
													</a>
												</div>
												<div class="col-md-4">
													<a href="#" class="value_props50">
														<div class="value_icon">
															<i class="uil uil-desktop-cloud-alt"></i>
														</div>
														<div class="value_content">
															<h4>Troubleshooting</h4>
															<p>Experiencing a bug? Check here.</p>
														</div>
													</a>
												</div>
												<div class="col-md-4">
													<a href="#" class="value_props50">
														<div class="value_icon">
															<i class="uil uil-book-alt"></i>
														</div>
														<div class="value_content">
															<h4>Course Taking</h4>
															<p>Everything about taking a course on Udemy.</p>
														</div>
													</a>
												</div>
												<div class="col-md-4">
													<a href="#" class="value_props50">
														<div class="value_icon">
															<i class="uil uil-wallet"></i>
														</div>
														<div class="value_content">
															<h4>Purchase/Refunds</h4>
															<p>Learn about coupons, how to send gifts, and refunds.</p>
														</div>
													</a>
												</div>
												<div class="col-md-4">
													<a href="#" class="value_props50">
														<div class="value_icon">
															<i class="uil uil-mobile-android-alt"></i>
														</div>
														<div class="value_content">
															<h4>Mobile</h4>
															<p>On the go? Learn about our mobile app.</p>
														</div>
													</a>
												</div>
											</div>
										</div>
									</div>
									<div class="tpc152">
										<div class="crse_content">
											<h3>Frequently Asked Questions</h3>																			
										</div>
										<div class="section3126 mt-20">
											<div class="row">
												<div class="col-md-4">
													<a href="#" class="value_props51">																											
														Lifetime Access																													
													</a>
												</div>
												<div class="col-md-4">
													<a href="#" class="value_props51">																											
														Cursus FAQ 																													
													</a>
												</div>
												<div class="col-md-4">
													<a href="#" class="value_props51">																											
														Downloading Courses																													
													</a>
												</div>
												<div class="col-md-4">
													<a href="#" class="value_props51">																											
														Certificate of Completion																													
													</a>
												</div>
												<div class="col-md-4">
													<a href="#" class="value_props51">																											
														Refund a Course																													
													</a>
												</div>
												<div class="col-md-4">
													<a href="#" class="value_props51">																											
														How to Solve Payment Issues																													
													</a>
												</div>
											</div>
										</div>
									</div>									
								</div>								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
 
@endsection
