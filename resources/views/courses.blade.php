@extends('layouts.master')


@section('content')

    @auth
	<div class="wrapper">
	@else
	<div style="padding-top:60px;">
	@endauth
		<div class="sa4d25">
			<div class="container-fluid">			
				<div class="row">
					<div class="col-12">
						This is also filtering for subcategory
					</div>
					<div class="col-md-8">
						<div class="_14d25">
							<div class="row">

								@for ($i = 0; $i < 20; $i++)
									<div class="col-lg-6 col-md-6">
										<div class="fcrse_1 mt-30">
											<a href="course_detail_view.html" class="fcrse_img">
												<img src="images/courses/img-1.jpg" alt="">
												<div class="course-overlay">
													<div class="badge_seller">Bestseller</div>
													<div class="crse_reviews">
														<i class="uil uil-star"></i>4.5
													</div>
													<span class="play_btn1"><i class="uil uil-play"></i></span>
													<div class="crse_timer">
														25 hours
													</div>
												</div>
											</a>
											<div class="fcrse_content">
												<div class="eps_dots more_dropdown">
													<a href="#"><i class="uil uil-ellipsis-v"></i></a>
													<div class="dropdown-content">
														<span><i class='uil uil-share-alt'></i>Share</span>
														<span><i class="uil uil-heart"></i>Save</span>
														<span><i class='uil uil-ban'></i>Not Interested</span>
														<span><i class="uil uil-windsock"></i>Report</span>
													</div>																											
												</div>
												<div class="vdtodt">
													<span class="vdt14">109k views</span>
													<span class="vdt14">15 days ago</span>
												</div>
												<a href="course_detail_view.html" class="crse14s">Complete Python Bootcamp: Go from zero to hero in Python 3</a>
												<a href="#" class="crse-cate">Web Development | Python</a>
												<div class="auth1lnkprce">
													<p class="cr1fot">By <a href="#">John Doe</a></p>
													<div class="prce142">$10</div>
													<button class="shrt-cart-btn" title="cart"><i class="uil uil-shopping-cart-alt"></i></button>
												</div>
											</div>
										</div>													
									</div>
								@endfor
								
								<div class="col-md-12">
									<div class="main-loader mt-50">													
										<div class="spinner">
											<div class="bounce1"></div>
											<div class="bounce2"></div>
											<div class="bounce3"></div>
										</div>																										
									</div>
								</div>
							</div>				
						</div>				
					</div>	
					<div class="col-md-4">
						<div class="fcrse_1">
							<div class="crse14s">
								Rating
							</div>
								<div class="ui checkbox mncheck">
									<input type="checkbox" tabindex="0" class="hidden">
									<label>Rating 4.5 & up</label>
								</div><br>
								<div class="ui checkbox mncheck">
									<input type="checkbox" tabindex="0" class="hidden">
									<label>Rating 4.0 & up</label>
								</div><br>
								<div class="ui checkbox mncheck">
									<input type="checkbox" tabindex="0" class="hidden">
									<label>Rating 3.5 & up</label>
								</div><br>
								<div class="ui checkbox mncheck">
									<input type="checkbox" tabindex="0" class="hidden">
									<label>Rating 3.0 & up</label>
								</div>

							<hr>
							<div class="crse14s">
								Course Duration
							</div>
								<div class="ui checkbox mncheck">
									<input type="checkbox" tabindex="0" class="hidden">
									<label>0 - 3 Hours</label>
								</div> <br>
								<div class="ui checkbox mncheck">
									<input type="checkbox" tabindex="0" class="hidden">
									<label>3 - 10 Hours</label>
								</div><br>
								<div class="ui checkbox mncheck">
									<input type="checkbox" tabindex="0" class="hidden">
									<label>10 - 20 Hours</label>
								</div><br>
								<div class="ui checkbox mncheck">
									<input type="checkbox" tabindex="0" class="hidden">
									<label>20 and above</label>
								</div>
							<hr>
							<div class="crse14s">
								Topic
							</div>
							<hr>
							<div class="crse14s">
								Level
							</div> 
							<hr>
							<div class="crse14s">
								Price
							</div>
							 
						</div>
					</div>			
				</div>
			</div>
		</div>

@endsection
