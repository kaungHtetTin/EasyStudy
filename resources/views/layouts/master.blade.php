<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head')
</head>
<body>
    @include('layouts.header')

	@auth
		 @include('layouts.navbar')
	@endauth
   
   
	@auth
	<div class="wrapper">
	@else
	<div style="padding-top:60px;">
	@endauth
		@guest
			@include('layouts.cover_area')
		@endguest
		@yield('content')
		
		@include('layouts.footer')
	</div>
    
    <script src="js/vertical-responsive-menu.min.js"></script>
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="vendor/OwlCarousel/owl.carousel.js"></script>
	<script src="vendor/semantic/semantic.min.js"></script>
	<script src="js/custom.js"></script>
	<script src="js/night-mode.js"></script>
    
</body>
</html>