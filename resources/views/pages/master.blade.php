<!DOCTYPE html>
<html lang="en">

    @include('pages.components.head')

<body>
	<!-- Header Start -->
	@include('pages.components.header')
	<!-- Header End -->
    
	<!-- Body Start -->
    @yield('content')
	<!-- Body End -->

	<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
	<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('vendor/OwlCarousel/owl.carousel.js')}}"></script>
	<script src="{{asset('vendor/semantic/semantic.min.js')}}"></script>
	<script src="{{asset('js/custom.js')}}"></script>	
	<script src="{{asset('js/night-mode.js')}}"></script>	
	
</body>
</html>