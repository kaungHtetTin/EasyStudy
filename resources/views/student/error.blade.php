<!DOCTYPE html>
<html lang="en">

	<head>
		@include('student.components.head')
	</head> 

<body class="coming_soon_style">
	
	<!-- Body Start -->
	<div class="wrapper coming_soon_wrapper">		
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="cmtk_group">
						<div class="ct-logo">
							<a href="{{route('index')}}"><img src="images/ct_logo.svg" alt=""></a>
						</div>
						<div class="cmtk_dt">
							<h1 class="title_404">404</h1>
							<h4 class="thnk_title1">The page you were looking for could not be found.</h4>
							<a href="{{route('index')}}" class="bk_btn">Go To Homepage</a>
						</div>
						<div class="tc_footer_main">
							<div class="tc_footer_left">
								<ul>
									<li><a href="about_us.html">About</a></li>
									<li><a href="press.html">Press</a></li>
									<li><a href="contact_us.html">Contact Us</a></li>
									<li><a href="coming_soon.html">Advertise</a></li>
									<li><a href="coming_soon.html">Developers</a></li>
									<li><a href="terms_of_use.html">Copyright</a></li>
									<li><a href="terms_of_use.html">Privacy Policy</a></li>
									<li><a href="terms_of_use.html">Terms</a></li>
								</ul>						
							</div>
							<div class="tc_footer_right">
								<p>© 2020 <strong>Cursus</strong>. All Rights Reserved.</p>
							</div>
						</div>
					</div> 	
				</div>	
			</div>	
		</div>		
	</div>	
	<!-- Body End -->

	<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
	<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('vendor/OwlCarousel/owl.carousel.js')}}"></script>
	<script src="{{asset('vendor/semantic/semantic.min.js')}}"></script>
	<script src="{{asset('js/custom.js')}}"></script>	
	
</body>
</html>