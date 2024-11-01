	@php
		$user = Auth::user();
    @endphp

	@extends('instructor.master')

	@section('content')
	
    <style>
        .content_body{
			overflow: auto;
	 
		}

		#editor{
			overflow: auto;
		}

		.content_body ul{
			list-style-type: disc;
			margin-inline-start: 20px;
			width: 100%;
		}

		.content_body div, #editor div{
			width: max-content;
		}

		pre code {
			background-color: #ecffeb;
			color: #3a3a3a;
			font-family: 'Courier New', Courier, monospace;
			padding: 3px;
			border-radius: 2px;
			display: block;
			font-size: 12px;
			white-space: pre-wrap;
		}
		
    </style>
	<div class="wrapper">
		<div class="sa4d25">
			<div class="container-fluid">			
				<div class="row">
					<div class="col-12">	
						<h2 class="st_title"><i class="uil uil-blogger-alt"></i> {{$blog->title}}</h2>
					</div>	
				</div>		
                
               <div class="row justify-content-md-center">					
					<div class="col-md-8">
						<div class="bg_blog2">
							<img src="{{asset('storage/'.$blog->image_url)}}" alt="">
						</div>
						<div class="vew120 frc123">
							<div class="vdtodt55">
								<span class="vdt24">109k views</span>
								<span class="vdt24">March 10, 2020</span>
							</div>
						</div>
						<div class="vew120 mt-35 mb-30">			
							<h4>Summary</h4>
							<p>{{$blog->summary}}</p>
							 
						</div>
						<div class="vew120 mt-35 mb-30 content_body">			
							<?= $blog->body ?>
						</div>
						 				
					</div>

					{{-- <div class="col-md-12">
						<div class="blog_pagination">
							<a href="#" class="bp_left">
								<i class="uil uil-angle-double-left"></i>
								<div class="kslu15">
									<div class="prevlink">Previous</div>
									<div class="prev_title">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
								</div>
							</a>
							<a href="#" class="bp_right">								
								<div class="kslu16">
									<div class="prevlink1">Next</div>
									<div class="prev_title1">Vestibulum vulputate nulla quis dignissim ultricies.</div>
								</div>
								<i class="uil uil-angle-double-right"></i>
							</a>
						</div>
					</div> --}}
				</div>
				 
			</div>
		</div>
		@include('instructor.components.footer')
	</div>
	<!-- Body End -->
	 
	<script src="{{asset('js/util.js')}}"></script>
    <script>

    </script>
    
	@endsection