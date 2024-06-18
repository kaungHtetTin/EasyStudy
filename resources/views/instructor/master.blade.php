<!DOCTYPE html>
<html lang="en">
    @include('instructor.components.head')
<body>
	<!-- Header Start -->
	
    @include('instructor.components.header')
	<!-- Header End -->

	<!-- Left Sidebar Start -->
	@include('instructor.components.navbar')

	<!-- Left Sidebar End -->
	<!-- Body Start -->
    @yield('content')
	
	<!-- Body End -->
	@include('instructor.components.foot-link')
</body>
</html>