@php
	if (!function_exists('formatCounting')) {
		function formatCounting($count,$unit){
			if($count<=1){
				return $count.' '.$unit;
			}else if($count>1 && $count<1000){
				return $count.' '.$unit.'s';
			}else if($count>=1000 && $count<1000000){
				return floor($count/1000).'k'.' '.$unit.'s';
			}else{
				return floor($count/1000000).'M'.' '.$unit.'s';;
			}
		}
	}
@endphp
@extends('student.components.master')

<style>
        .content_body{
			overflow: auto;
	 
		}

		.content_body ul{
			list-style-type: disc;
			margin-inline-start: 20px;
			width: 100%;
		}

		.content_body div{
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

@section('content')

	@auth
	<div class="wrapper">
	@else
	<div style="padding-top:80px;">
	@endauth
		<div class="sa4d25">
			<div class="container-fluid">			
				<div class="row">
					<div class="col-lg-9 col-md-9">
						<div class="row justify-content-md-center">		
							<div class="col-12">	
								<h2 class="st_title"><i class="uil uil-blogger-alt"></i> {{$blog->title}}</h2>
							</div>				
							<div class="col-md-10">
								<div class="bg_blog2">
									<img src="{{asset('storage/'.$blog->image_url)}}" alt="">
								</div>
								<div class="vew120 frc123">
									<div class="vdtodt55">
										<span class="vdt24">{{formatCounting($blog->view_count, 'view')}}</span>
										<span class="vdt24">{{$blog->created_at->diffForHumans()}}</span>
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
					<div class="col-lg-3 col-md-3">
						<h3 style="color:#888">Blogged by</h3><br>
						<div class="img148">
							<img src="{{asset('storage/'.$instructor->user->image_url)}}" alt="">										
						</div>
						<div style="text-align: center">
							<h4>{{$instructor->user->name}}</h4>
							<p>
								@foreach ($instructor->categories as $index=> $category)
										@if ($index>0)
											&amp;
										@endif
									{{$category->title}} 
								@endforeach
							</p>

							<form action="{{route('instructor.subscribe',['id'=>$instructor->id])}}" method="POST">
							@csrf
								@if ($subscribed)
									<button type="submit" class="subscribe-btn btn500" style="border-radius:15px;background:#efeeff;color:#475692">
										<span><i class='uil uil-bell'></i> Subscribed</span>
									</button>
								@else
									<button type="submit" class="subscribe-btn btn500">Subscribe</button>
								@endif
							</form>

						</div>
						
					</div>
				</div>
				 
			</div>
		</div>
		
		<script src="{{asset('js/util.js')}}"></script>
@endsection