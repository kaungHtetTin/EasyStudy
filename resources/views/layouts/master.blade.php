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
	
		@guest
			@if ((request()->route()->getName() == 'index'))
				@include('layouts.cover_area')
			@endif
			
		@endguest

		@yield('content')
		
		@include('layouts.footer')
	</div>
    
    <script src="{{asset('js/vertical-responsive-menu.min.js')}}"></script>
	<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('vendor/OwlCarousel/owl.carousel.js')}}"></script>
	<script src="{{asset('vendor/semantic/semantic.min.js')}}"></script>
	<script src="{{asset('js/custom.js')}}"></script>
	<script src="{{asset('js/night-mode.js')}}"></script>
    
</body>
</html>