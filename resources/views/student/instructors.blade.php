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

@extends('layouts.master')


@section('content')

	<style>
		.shimmer {
			color: grey;
			display:inline-block;
			-webkit-mask:linear-gradient(-60deg,#000 30%,#0005,#000 70%) right/300% 100%;
			background-repeat: no-repeat;
			animation: shimmer 2.5s infinite;
			font-size: 50px;
			
		}
	</style>

	@auth
	<div class="wrapper">
	@else
	<div style="padding-top:80px;">
	@endauth
		<div class="sa4d25">
			<div class="container-fluid">			
				<div class="row">
					<div class="col-xl-12 col-lg-8">
						<div class="section3125">
							<div class="explore_search">
								<div class="ui search focus">
									<div class="ui left icon input swdh11">
										<input class="prompt srch_explore" type="text" placeholder="Search Tutors...">
										<i class="uil uil-search-alt icon icon2"></i>
									</div>
								</div>
							</div>							
						</div>							
					</div>	
					<div class="col-md-12">
						<div class="_14d25">
							<div class="row" id="instructor_container">
								
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
		</div>

		<script>
	
			let isFetching=false;
			let url = '/api/instructors';
			var instructorArr=[];


			$(document).ready(()=>{

				fetchInstructor();

				$(window).scroll(()=>{
					if($(window).scrollTop() + $(window).height() > $(document).height() - 500) {
						if(!isFetching){
							fetchInstructor();
						}
					}
				});
			});

			function fetchInstructor(){
				isFetching=true;
				$('#shimmer').show();
				if(url==null){
					$('#shimmer').hide();
					return;
				}

				$.get(url,function(res,status){
					isFetching=false;
					if(res){
						url = res.next_page_url;
						let instructors = res.data;
						setInstructors(instructors);
						console.log(instructors);
					}
					
				})
			}

			 function setInstructors(instructors){
				$('#shimmer').hide();
				instructors.map((instructor,index)=>{
					instructorArr.push(instructor);	
					$('#instructor_container').append(instructorComponent(instructor));
				})
			}

			function instructorComponent(instructor){
				return `
					<div class="col-xl-3 col-lg-4 col-md-6">
						<div class="fcrse_1 mt-30">
							<div class="tutor_img">
								<a href="/instructors/${instructor.id}"><img src="images/left-imgs/img-1.jpg" alt=""></a>												
							</div>
							<div class="tutor_content_dt">
								<div class="tutor150">
									<a href="/instructors/${instructor.id}" class="tutor_name">${instructor.user.name}</a>
									<div class="mef78" title="Verify">
										<i class="uil uil-check-circle"></i>
									</div>
								</div>
								<div class="tutor_cate">
									${setCategory(instructor.categories)}
								</div>
								<ul class="tutor_social_links">
									<li><a href="#" class="fb"><i class="fab fa-facebook-f"></i></a></li>
									<li><a href="#" class="tw"><i class="fab fa-twitter"></i></a></li>
									<li><a href="#" class="ln"><i class="fab fa-linkedin-in"></i></a></li>
									<li><a href="#" class="yu"><i class="fab fa-youtube"></i></a></li>
								</ul>
								<div class="tut1250">
									<span class="vdt15">${formatCounting(instructor.student_enroll,' Student')}</span>
									<span class="vdt15">${formatCounting(instructor.total_course,' Course')}</span>
								</div>
							</div>
						</div>										
					</div>
				`;
			}

			function setCategory(categories){
				let result = "";
				categories.map((category,i)=>{
					if(i==0){
						result+=category.title;
					}else{
						result+=`
						&amp;
						${category.title}
					`;
					}
					
				});

				return result;
			}

			function formatCounting(count,unit){
				if(count<=1){
					return count+' '+unit;
				}else if(count>1 && count<1000){
					return Math.floor(count/1000)+' '+unit+'s';
				}else if(count>=1000 && count<1000000){
					return Math.floor(count/1000)+'k '+unit+'s';
				}else {
					return Math.floor(count/1000000)+'M '+unit+'s';
				}
			}


		</script>
@endsection