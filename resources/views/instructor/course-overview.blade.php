	@php
    	$api_token = Cookie::get('api_auth_token');
		$user = Auth::user();
		if (!function_exists('calculateHour')) {
			function calculateHour($min){
				$hr = $min/60;
				$hr = floor($hr);
				return $hr;
			}
		}

		if (!function_exists('calculateStorage')) {
			function calculateStorage($mb){
				if($mb < 1024){
					return $mb . ' MB';
				}else{
					return floor($mb/1024).' GB';
				}
			}
		}

		$downloadable_count = 0;
		$article_count = 0;
		$assignment_count = 0;
		foreach ($course->lessons as $key => $lesson) {
		
			# code...
			if($lesson->downloadable==1){
				$downloadable_count++;
			}
			if($lesson->lesson_type_id==2){
				$article_count++;

			}
			if($lesson->lesson_type_id==3){
				$assignment_count++;
			}
		}
    @endphp
    @extends('instructor.master')

	@section('content')

    <style>
        .error{
            color:red;
			display: none;
        }

		._215b05{
			padding:5px;
		}

		.rating-star1 {
			font-size: 1rem;
			width: 1rem;
			height: 1rem;
			position: relative;
			display: inline-block;
		}

    </style>

	<div class="wrapper">
		<div class="sa4d25">
            <div class="container">	
				<div style="position: relative; display:flex">
					<div style="flex:1">
						@if (session('msg'))
							<div class="alert alert-success">
								{{session('msg')}}
							</div>
						@endif
						<div class="row">
							<div class="col-12">
								<div class="step-tab-panel step-tab-gallery" id="tab_step2">
									<div class="tab-from-content">
										<div class="title-icon">
											<h3 class="title"><i class="uil uil-analytics"></i> Overview</h3>
										</div> 
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<div class="section3125">			
									<div class="row justify-content-center">
										<div class="col-12">
											<div class="_215b03">
												<h2>{{$course->title}}</h2>
												<span class="_215b04">{{$course->category->title}} <i class="uil uil-arrow-right"></i> {{$course->sub_category->title}} <i class="uil uil-arrow-right"></i>  {{$course->topic->title}}</span>
											</div>
											<div class="_215b05">
												<div class="crse_reviews mr-2">
													<i class="uil uil-star"></i>{{$course->rating}}
													<br>
													({{$course->rating_count}} ratings )
												</div>
												
											</div>

											<div class="row">
												<div class="col-6 _215b08">
													<div class="_215b05" style="display: flex">		
														<span><i class='uil uil-play-circle'></i></span>
														<div>
															{{calculateHour($course->duration)}} hours on-demand video
														</div>
													</div>
												</div>
												<div class="col-6 _215b08">
													<div class="_215b05" style="display: flex">										
														<span><i class='uil uil-file-alt'></i></span>
														<div>{{$assignment_count}} Assignments</div>
													</div>
												</div>
												<div class="col-6 _215b08">
													<div class="_215b05" style="display: flex">										
														<span><i class='uil uil-document'></i></span>
														<div>{{$article_count}} articles</div>
													</div>
												</div>
												<div class="col-6 _215b08">
													<div class="_215b05" style="display: flex">										
														<span><i class='uil uil-cloud-download'></i></span>
														<div>{{$downloadable_count}} downloable resourses</div>
													</div>
												</div>
												<div class="col-6 _215b08">
													<div class="_215b05" style="display: flex">										
														<span><i class='uil uil-graduation-hat'></i></span>
														<div>{{$course->enroll_count}} students enrolled</div>
													</div>
												</div>
												<div class="col-6 _215b08">
													<div class="_215b05" style="display: flex">										
														<span><i class='uil uil-clock-seven'></i></span>
														<div>Full life-time access</div>
													</div>
												</div>
												<div class="col-6 _215b08">
													<div class="_215b05" style="display: flex">										
														<span><i class='uil uil-comment'></i></span>
														<div>{{$course->language()->type}}</div>
													</div>
												</div>
												<div class="col-6 _215b08">
													<div class="_215b05" style="display: flex">										
														<span><i class='uil uil-database'></i></span>
														<div>{{calculateStorage($storage_used)}} storage used</div>
													</div>
												</div>
												@if ($course->certificate)
													<div class="col-6 _215b08">
														<div class="_215b05" style="display: flex">										
															<span><i class='uil uil-trophy'></i></span>
															<div>Certification of completion</div>
														</div>
													</div>
												@endif
											</div>
										</div>							
									</div>							
								</div>							
							</div>	
						</div>
						<div class="date_selector">
							<div class="ui selection dropdown skills-search vchrt-dropdown">
								<input name="date" type="hidden" value="{{$request['year']}}" id="year_selector">
								<i class="dropdown icon d-icon"></i>
								<div class="text" id="year_text">{{$request['year']}}</div>
								<div class="menu" id="year_container">
								
								</div>
							</div>

							<div class="ui selection dropdown skills-search vchrt-dropdown">
								<input name="date" type="hidden" value="{{$request['month']}}" id="month_selector">
								<i class="dropdown icon d-icon"></i>
								<div class="text" id="month_text">Month</div>
								<div class="menu" id="month_container">
								
								</div>
							</div>
						</div>	
						<div class="row">
							<div class="col-xl-12 col-md-12">
								<!-- Sales Graph -->
								<div class="card card-default analysis_card p-0" data-scroll-height="450">
									<div class="card-header">
										<h2>Sales Of The Year</h2>
									</div>
									<div class="card-body p-5" style="height: 450px;" id="project_sale_of_year_container">
										<canvas id="project_sale_of_year" class="chartjs"></canvas>
									</div>
								</div>
							</div>

							<div class="col-xl-12 col-md-12">
								<!-- Sales Graph -->
								<div class="card card-default analysis_card p-0" data-scroll-height="450">
									<div class="card-header">
										<h2>Sales Of The Month</h2>
									</div>
									<div class="card-body p-5" style="height: 450px;" id="project_sale_of_month_container">
										<canvas id="project_sale_of_month" class="chartjs"></canvas>
									</div>
									<div style="margin-left:70px;display:flex;padding:10px;">
										Previous Month <div style="height:5px; width: 30px; background:rgba(255, 230, 0);margin-left:10px;margin-right:30px;margin-top:5px;"></div>
										Current Month <div style="height:5px; width: 30px; background:#ed2a26;margin-left:10px;margin-top:5px;"></div>
									</div>
									<br>
									<div style="margin-left:70px;margin-bottom:30px;padding:10px;">
									<span style="font-weight:bold;color:#333">Note:</span> We got <span id="previous_month_amount"></span> mmk on this day of previous month.
									</div>
									
								</div>
							</div>
						</div>
					</div>
					@include('instructor.components.course-menu-drawer')
				</div>

			</div>
		</div>
		@include('instructor.components.footer')

		<script>

			const apiToken = "{{$api_token}}";
			const course = @json($course);
        	const user = @json($user);
			const request = @json($request);
			const saleOfYears = @json($saleOfYears);
			const saleofMonth = @json($saleofMonth);
			const saleofPreviousMonth = @json($saleofPreviousMonth);

			const ui_project_sale_of_month_container = document.getElementById('project_sale_of_month_container');
			const ui_project_sale_of_year_container = document.getElementById('project_sale_of_year_container');

			$(document).ready(()=>{
				setMonths();
				setYears();
				setSaleOfYearChar(saleOfYears);
				setSaleOfMonthChart(saleofMonth,saleofPreviousMonth);
				$('#year_selector').change(()=>{
					requestNow();
				})

				$('#month_selector').change(()=>{
					requestNow();
				})
			})

			function setYears(){
				let currentYear= new Date().getFullYear();
				let content = "";
				for(var i=currentYear;i>=2023;i--){
					content+=`
						<div class="item" data-value="${i}">${i}</div>
					`;
				}
				$('#year_container').html(content);
				$('#year_text').html(request.year);

			}

			function requestNow(){
				let year = $('#year_selector').val();
				let month = $('#month_selector').val();
				if(year==0){
					year = new Date().getFullYear();
				}
				if(month==0){
					month = new Date().getMonth();
				}

				let url = `{{asset("")}}instructor-dashboard/courses/${course.id}/overview?year=${year}&month=${month}`;
				window.location.href=url;
			}

			function setMonths(){
				let months =[
						"Jan",
						"Feb",
						"Mar",
						"Apr",
						"May",
						"Jun",
						"Jul",
						"Aug",
						"Sep",
						"Oct",
						"Nov",
						"Dec"
					];
				let content = "";
				for(var i=0;i<months.length;i++){
					content+=`
						<div class="item" data-value="${(i+1)}">${months[i]}</div>
					`;
				}    
				$('#month_container').html(content);
				
				let index = request.month - 1;
				$('#month_text').html(months[index]);
				$('#statement_title').html("Your sales earning for "+months[index]+", "+request.year);
			}
			//sale of years
			function setSaleOfYearChar(sales){

				var data=[];

				for(var i=0;i<12;i++){
					var month=i+1;
					var current_sale=sales.filter(sale=>sale.month==month);
					if(current_sale.length>0){
						data[i]=current_sale[0].amount;
					}else{
						data[i]=0;
					}
					
				}
				clearChart(ui_project_sale_of_year_container,'project_sale_of_year');
				var ctx = document.getElementById('project_sale_of_year');
			
			
				if (ctx !== null) {
					var chart = new Chart(ctx, {
					// The type of chart we want to create
					type: "line",

					// The data for our dataset
					data: {
						labels: [
						"Jan",
						"Feb",
						"Mar",
						"Apr",
						"May",
						"Jun",
						"Jul",
						"Aug",
						"Sep",
						"Oct",
						"Nov",
						"Dec"
						],
						datasets: [
						{
							label: "",
							backgroundColor: "transparent",
							borderColor: "rgb(237, 42, 38)",
							data,
							lineTension: 0.3,
							pointRadius: 5,
							pointBackgroundColor: "rgba(255,255,255,1)",
							pointHoverBackgroundColor: "rgba(255,255,255,1)",
							pointBorderWidth: 2,
							pointHoverRadius: 8,
							pointHoverBorderWidth: 1
						}
						]
					},

					// Configuration options go here
					options: {
						responsive: true,
						maintainAspectRatio: false,
						legend: {
						display: false
						},
						layout: {
						padding: {
							right: 10
						}
						},
						scales: {
						xAxes: [
							{
							gridLines: {
								display: false
							}
							}
						],
						yAxes: [
							{
							gridLines: {
								display: true,
								color: "#efefef",
								zeroLineColor: "#efefef",
							},
							ticks: {
								callback: function(value) {
								var ranges = [
									{ divider: 1e6, suffix: "M" },
									{ divider: 1e4, suffix: "k" }
								];
								function formatNumber(n) {
									for (var i = 0; i < ranges.length; i++) {
									if (n >= ranges[i].divider) {
										return (
										(n / ranges[i].divider).toString() + ranges[i].suffix
										);
									}
									}
									return n;
								}
								return formatNumber(value);
								}
							}
							}
						]
						},
						tooltips: {
						callbacks: {
							title: function(tooltipItem, data) {
							return data["labels"][tooltipItem[0]["index"]];
							},
							label: function(tooltipItem, data) {
							return "MMK " + data["datasets"][0]["data"][tooltipItem["index"]];
							}
						},
						responsive: true,
						intersect: false,
						enabled: true,
						titleFontColor: "#333",
						bodyFontColor: "#686f7a",
						titleFontSize: 12,
						bodyFontSize: 14,
						backgroundColor: "rgba(256,256,256,0.95)",
						xPadding: 20,
						yPadding: 10,
						displayColors: false,
						borderColor: "rgba(220, 220, 220, 0.9)",
						borderWidth: 2,
						caretSize: 10,
						caretPadding: 15
						}
					}
					});
				}
			}

			function setSaleOfMonthChart(sales,lastSales){

				var data=[]; // current month;
				var data2=[];  // previous month
				var previous_month_amount=0;
				var now=new Date();

				for(var i=0;i<daysInThisMonth();i++){
					var day=i+1;
					var current_sale=sales.filter(sale=>sale.day==day);
					if(current_sale.length>0){
						data[i]=current_sale[0].amount;
					}else{
						data[i]=0;
					}

					if(lastSales){
						var last_sale=lastSales.filter(sale=>sale.day==day);
						if(last_sale.length>0){
							data2[i]=last_sale[0].amount;
							if(day<=now.getDate()) previous_month_amount+=parseInt(data2[i]);
						}else{
							data2[i]=0;
						}
					}else{
						data2[i]=0;
					}
					
				}

				$('#previous_month_amount').html(previous_month_amount);

				var dayLabels=[];
				for(var i=0;i<daysInThisMonth();i++){
					dayLabels[i]=i+1;
				}
				
				clearChart(ui_project_sale_of_month_container,'project_sale_of_month');
				
				var dual = document.getElementById("project_sale_of_month");
			
				if (dual !== null) {
					var urChart = new Chart(dual, {
					type: "line",
					data: {
						labels: dayLabels,
						datasets: [
						{
							label: "Old",
							pointRadius: 4,
							pointBackgroundColor: "rgba(255,255,255,1)",
							pointBorderWidth: 2,
							fill: false,
							backgroundColor: "transparent",
							borderWidth: 2,
							borderColor: "#ed2a26",
							data: data
						},
						{
							label: "New",
							fill: false,
							pointRadius: 4,
							pointBackgroundColor: "rgba(255,255,255,1)",
							pointBorderWidth: 2,
							backgroundColor: "transparent",
							borderWidth: 2,
							borderColor: "rgba(255, 230, 0)",
							data: data2
						}
						]
					},
					options: {
						responsive: true,
						maintainAspectRatio: false,
						legend: {
						display: false
						},
						layout: {
						padding: {
							right: 10
						}
						},
						scales: {
						xAxes: [
							{
							gridLines: {
								display: false
							}
							}
						],
						yAxes: [
							{
							gridLines: {
								display: true,
								color: "#efefef",
								zeroLineColor: "#efefef",
							},
							ticks: {
								callback: function(value) {
								var ranges = [
									{ divider: 1e6, suffix: "M" },
									{ divider: 1e4, suffix: "k" }
								];
								function formatNumber(n) {
									for (var i = 0; i < ranges.length; i++) {
									if (n >= ranges[i].divider) {
										return (
										(n / ranges[i].divider).toString() + ranges[i].suffix
										);
									}
									}
									return n;
								}
								return formatNumber(value);
								}
							}
							}
						]
						},
						tooltips: {
						callbacks: {
							title: function(tooltipItem, data) {
							return data["labels"][tooltipItem[0]["index"]];
							},
							label: function(tooltipItem, data) {
							return "MMK " + data["datasets"][0]["data"][tooltipItem["index"]];
							}
						},
						responsive: true,
						intersect: false,
						enabled: true,
						titleFontColor: "#333",
						bodyFontColor: "#686f7a",
						titleFontSize: 12,
						bodyFontSize: 14,
						backgroundColor: "rgba(256,256,256,0.95)",
						xPadding: 20,
						yPadding: 10,
						displayColors: false,
						borderColor: "rgba(220, 220, 220, 0.9)",
						borderWidth: 2,
						caretSize: 10,
						caretPadding: 15
						}
					}
					});
				}

			}

			function daysInThisMonth() {
				var now = new Date();
				var currentMonth;
				if(request.month){
					currentMonth=request.month;
				}else {
					currentMonth=now.getMonth();
				}
				return new Date(now.getFullYear(), currentMonth+1, 0).getDate();
			}

			function clearChart(container,chartId){
				container.innerHTML=`
					<canvas id="${chartId}" class="chartjs"></canvas>
				`;
			}

		</script>
		
		<script src="{{asset('js/util.js')}}"></script>
		<script src="{{asset('vendor/charts/Chart.min.js')}}"></script>

	</div>
	<!-- Body End -->
	@endsection

	


	