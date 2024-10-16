	@php
    	$api_token = Cookie::get('api_auth_token');
		$user = Auth::user();
    @endphp

	@extends('instructor.master')

	@section('content')
	<style>
		.item-notification{
			cursor: pointer;
		}

		.item-notification:hover{
			color: #475692;
    		background-color: #e6e4ff;
		}

		.night-mode .item-notification:hover{
			color: #475692;
    		background-color: #555;
		}
	</style>

	<div class="modal fade" id="delete-section" tabindex="-1" aria-labelledby="lectureModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="lectureModalLabel">Delete Blog</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="alert alert-warning">
						Do you really want to delete?
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="main-btn cancel" data-dismiss="modal">Close</button>
					<form action="" method="post" id="form_delete">
						@csrf
						@method('DELETE')
						<button id="btn_delete" type="button" class="main-btn">Delete</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="wrapper">
		<div class="sa4d25">
			<div class="container-fluid">	
				@if (session('msg'))
					<div class="alert alert-success">
						{{ session('msg') }}
					</div>
				@endif	

				<div class="row">
					<div class="col-6">	
						<h2 class="st_title"><i class="uil uil-blogger-alt"></i> My Blog</h2>
					</div>	
					<div class="col-6">
						<span onclick="window.location.href = '{{route('instructor.blog.create')}}' " id="btn_readAll" class="btn_span" style="float:right">Create New Blog <i class="uil uil-plus-circle"></i></span>
					</div>					
				</div>			
                <br>	
				<div class="row">
					<div class="col-12">
						 
                        <div class="review_all120" id="blog_container">
                            
                        </div>

						<div class="row" id="shimmer">				
							<div class="col-md-12">
								<br><br><br>
								<div class="main-loader mt-50">													
									<div class="spinner">
										<div class="bounce1"></div>
										<div class="bounce2"></div>
										<div class="bounce3"></div>
									</div>																										
								</div>
								<br><br><br>
							</div>
							<div class="col-md-12">
								<br><br><br>
							</div>
						</div>			
					</div>
				</div>
			</div>
		</div>
		@include('instructor.components.footer')
	</div>
	<!-- Body End -->
	 
	<script src="{{asset('js/util.js')}}"></script>
	<script>
		const apiToken = "{{$api_token}}";
		const user = @json($user);
		const instructor = @json($instructor);

		let is_fetching = false;
		let arr = [];
		let fetch_url = `http://localhost:8000/api/instructors/${instructor.id}/blogs?page=1`;
		let delete_blog_id = 0;
		$(document).ready(()=>{
	
			fetchBlog();

			$(window).scroll(()=>{
				if($(window).scrollTop() + $(window).height() > $(document).height() - 500) {
					if(!is_fetching){
						fetchBlog();
					}
				}
			});

			$('#btn_delete').click(()=>{
				$('#form_delete').attr('action',`{{asset("")}}instructor/blogs/${delete_blog_id}`);
				$('#form_delete').submit();
			});
		})

		function fetchBlog(){
			is_fetching = true;
			$('#shimmer').show();
			if(fetch_url==null){
				$('#shimmer').hide();
				return;
			}
			$.ajax({
				url: fetch_url,
				type: 'GET', // or 'GET' depending on your request
				headers: {
					'Authorization': 'Bearer '+apiToken // Example for Authorization header
				},
				
				success: function(res) {
					is_fetching=false;
					if(res){
						fetch_url = res.next_page_url;
						let blogs = res.data;
						setBlogs(blogs);
						
					}
				},
				error: function(xhr, status, error) {
					console.error('Error:', status, error);
				}
			});
		}

		function setBlogs(blogs){
			$('#shimmer').hide();
			blogs.map((blog,index)=>{
				arr.push(blog);	
				$('#blog_container').append(blogComponent(blog));
			})

			if(arr.length==0){
				$('#blog_container').html(`
					<br><br><br>
					<div style="text-align:center;font-size:16px;">
						<i style="font-size:50px;" class="uil uil-bell"></i><br>
						No blog.
					</div>
					<br><br><br>
				`)
			}
		}

		function blogComponent(blog){
			 
			return `
				<div class="row mt-50" style="margin:10px;">
					<div class="col-lg-4 col-md-5">
						<a href="blog_single_view.html" class="hf_img">
							<img src="{{asset('storage')}}/${blog.image_url}" alt="" style="width:100%">
						</a>
					</div>
					<div class="col-lg-8 col-md-7">
						<div class="hs_content" style="width:100%">
							<div class="vdtodt">
								<span class="vdt14">${formatCounting(blog.view_count,'view')}</span>
								<span class="vdt14">${formatDateTime(new Date(blog.created_at))}</span>
							</div>
							<a href="blog_single_view.html" class="crse14s title900">${blog.title}</a>
							<p class="blog_des">${blog.summary}</p>
							<a href="{{asset('')}}instructor/blogs/${blog.id}" class="view-blog-link">Read More<i class="uil uil-arrow-right"></i></a>
							<span onclick = "defineDeleteId(${blog.id})" style="float:right" class="btn_span" data-toggle="modal" data-target="#delete-section">Delete <i class="uil uil-trash"></i> </span>
							<span onclick="edit(${blog.id})" style="float:right" class="btn_span">Edit <i class="uil uil-edit-alt"></i> </span>
						</div>
						<hr>
					</div>
				</div>
			`;
		}

		function edit(id){
			window.location.href = `{{asset("")}}instructor/blogs/${id}/edit`;
		}

		
		function defineDeleteId(id){
			delete_blog_id = id;
		}

	 

	</script>
    
	@endsection