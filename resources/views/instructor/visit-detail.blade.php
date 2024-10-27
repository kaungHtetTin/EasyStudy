	@php
    	$api_token = Cookie::get('api_auth_token');
		$user = Auth::user();
    @endphp

	@extends('instructor.master')

	@section('content')
	<style>

       .btn500 {
            height: 30px !important;
            padding: 0 15px !important;
            margin-top: 10px;
        }

	</style>
	<div class="wrapper">
		<div class="sa4d25">
			<div class="container-fluid">			
				<div class="row">
					<div class="col-12">	
						<h2 class="st_title"><i class="uil uil-eye"></i> Recent Visits</h2>
					</div>	
				</div>	
            
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section3125">			
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <div class="_215b03">
                                        <h2>{{$visit->course->title}}</h2>
                                        <span class="_215b04">{{$visit->course->category->title}} <i class="uil uil-arrow-right"></i> {{$visit->course->sub_category->title}} <i class="uil uil-arrow-right"></i>  {{$visit->course->topic->title}}</span>
                                    </div>
                                </div>							
                            </div>							
                        </div>							
                    </div>															
                </div>

				<br>		
				<div class="fcrse_1">
                    <br>
                    <div class="row">
                        <div class="col-lg-7 col-md-7">
                            <div class="review_usr_dt">
                                <img src="{{asset('storage/'.$visit->user->image_url)}}" alt="">
                                <div class="rv1458">
                                    <h4 class="tutor_name1">{{$visit->user->name}}</h4>
                                    <span class="time_145">
                                        Visited . {{$visit->created_at->diffForHumans()}}
                                    </span> 
                                    <span class="time_145">For <strong>{{$count}}</strong> {{$count>1 ? ' times':' time'}}</span>
                                    
                                    <button onclick="window.location.href='{{route('instructor.users.message',$visit->user->id)}}'" class="main-btn btn500"><i class="uil uil-message"></i> Message</button>
                                    <button class="main-btn btn500"><i class="uil uil-phone"></i> Call  </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <table class="table kht-table" style="margin-top:20px;">
                                <tr>
                                    <td> <i class="uil uil-envelope"></i></i> Email</td>
                                    <td>{{$visit->user->email}}</td>
                                </tr>
                                <tr>
                                    <td> <i class="uil uil-phone-alt"></i> Phone</td>
                                    <td>{{$visit->user->phone}}</td>
                                </tr>
                                
                            </table>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <table class="table kht-table" style="margin-top:20px;">
                                <tr>
                                    <td> <i class="uil uil-graduation-hat"></i> Education</td>
                                    <td>{{$visit->user->education}}</td>
                                </tr>
                                <tr>
                                    <td> <i class="uil uil-home-alt"></i> Address</td>
                                    <td>{{$visit->user->address}}</td>
                                </tr>
                                
                            </table>
                        </div>
                    </div>
                </div>
             
                <div class="card card-default analysis_card p-0" data-scroll-height="450" style="margin-top:20px;">
                    <div class="card-header">
                        <h2>Visit In Current Month</h2>
                    </div>
                    <div class="card-body p-5" style="height: 450px;" id="project_sale_of_month_container">
                        <canvas id="project_sale_of_month" class="chartjs"></canvas>
                    </div>
                </div>
			</div>
		</div>
		@include('instructor.components.footer')
	</div>
	<!-- Body End -->

    <script>
        const visit_times = @json($visit_times);
        const ui_project_sale_of_month_container = document.getElementById('project_sale_of_month_container');
    
        let months = [
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
		]

        let monthInAlphabet = months[new Date().getMonth()];

        $(document).ready(()=>{
            setSaleOfMonthChart(visit_times);
        });

        function setSaleOfMonthChart(visit_times){

            var data=[]; // current month;
            var now=new Date();

            for(var i=0;i<daysInThisMonth();i++){
                var day=i+1;
                var current_visit=visit_times.filter(visit=>visit.day==day);
                if(current_visit.length>0){
                    data[i]=current_visit[0].visit_count;
                }else{
                    data[i]=0;
                } 
                
            }

            var dayLabels=[];
            for(var i=0;i<daysInThisMonth();i++){
                dayLabels[i]= monthInAlphabet+', '+(i+1);
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
                        return "time " + data["datasets"][0]["data"][tooltipItem["index"]];
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
            var currentMonth = now.getMonth();
            return new Date(now.getFullYear(), currentMonth+1, 0).getDate();
        }

        function clearChart(container,chartId){
            container.innerHTML=`
                <canvas id="${chartId}" class="chartjs"></canvas>
            `;
        }


    </script>
    <script src="{{asset('vendor/charts/Chart.min.js')}}"></script>
	@endsection