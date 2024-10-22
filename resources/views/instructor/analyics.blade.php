	@extends('instructor.master')

	@section('content')
	<div class="wrapper">
		<div class="sa4d25">
			<div class="container-fluid">			
				<div class="row">
					<div class="col-lg-12">	
						<h2 class="st_title"><i class="uil uil-analysis"></i> Analyics</h2>
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
					<div class="col-xl-6 col-sm-6">
						<div class="card card-mini analysis_card">
							<div class="card-body">
								<h2 class="mb-2" id="total_subscriber_in_year">0</h2>
								<p>Subscribers In Year</p>
								<div class="chartjs-wrapper">
									<canvas id="barChart"></canvas>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-6 col-sm-6">
						<div class="card card-mini analysis_card">
							<div class="card-body">
								<h2 class="mb-1" id="total_weekly_visitor">0</h2>
								<p>Weekly Visitors</p>
								<div class="chartjs-wrapper">
									<canvas id="dual-line"></canvas>
								</div>
							</div>
						</div>
                    </div>
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
                    <div class="col-xl-6 col-sm-6">
						<div class="card  card-mini  analysis_card">
							<div class="card-body">
								<h2 class="mb-2" id="total_sale_of_course">0</h2>
								<p id="sale_of_course_year_text">Sales Of Course In Year</p>
								<div class="chartjs-wrapper" style="height:200px">
									<canvas id="barChart2" style="height:200px"></canvas>
								</div>

                                <div style="margin-left:20;display:flex;padding:10px;">
                                    Last Year <div style="height:10px; width: 10px; background:rgba(255, 230, 0);margin-left:10px;margin-right:30px;margin-top:5px;"></div>
                                    Current Year <div style="height:10px; width: 10px; background:#ed2a26;margin-left:10px;margin-top:5px;"></div>
                                </div>
							</div>
						</div>
					</div>
                    <div class="col-xl-6 col-sm-6">
						<div class="card  card-mini  analysis_card">
							<div class="card-body">
								<h2 class="mb-2" id="total_sale_of_course_in_month">0</h2>
								<p id="sale_of_course_month_text">Sales Of Course In Month</p>
								<div class="chartjs-wrapper" style="height:200px">
									<canvas id="barChart3" style="height:200px"></canvas>
								</div>
                                <div style="margin-left:20;display:flex;padding:10px;">
                                    Last Month <div style="height:10px; width: 10px; background:rgba(255, 230, 0);margin-left:10px;margin-right:30px;margin-top:5px;"></div>
                                    Current Month <div style="height:10px; width: 10px; background:#ed2a26;margin-left:10px;margin-top:5px;"></div>
                                </div>
							</div>
						</div>
					</div>
				</div>
            </div>
		</div>
		@include('instructor.components.footer')
	</div>
	<!-- Body End -->
    <script src="{{asset('vendor/charts/Chart.min.js')}}"></script>
    <script>
        let today = @json($today);
        let subscribers = @json($subscribers);
        const saleOfYears = @json($saleOfYears);
        const saleofMonth = @json($saleofMonth);
		const saleofPreviousMonth = @json($saleofPreviousMonth);
        const salesOfCourse = @json($salesOfCourse);
        const salesOfCourseLastYear = @json($salesOfCourseLastYear);
        const salesOfCourseInMonth = @json($salesOfCourseInMonth);
        const salesOfCourseLastMonth = @json($salesOfCourseLastMonth);
        const request = @json($request);
        const courses = @json($courses);

        let subscriber_dataset = [];
        let total_subscriber_in_year = 0;
        let total_weekly_visitor = 0;

        let visitors = @json($visitors);
        let days_of_week = ["Sun", "Mon", "Tue", "Wed", "Thu","Fri", "Sat"];

        $(document).ready(()=>{

            setMonths();
			setYears(); 

            $('#year_selector').change(()=>{
                requestNow();
            })

            $('#month_selector').change(()=>{
                requestNow();
            })

            setYearlySubscriberChart();
            setWeeklyVisitorChart();
            setSaleOfYearChar(saleOfYears);
            setSaleOfMonthChart(saleofMonth,saleofPreviousMonth);
            setSalesOfCourseChart(salesOfCourse,salesOfCourseLastYear,"barChart2","total_sale_of_course");
            setSalesOfCourseChart(salesOfCourseInMonth,salesOfCourseLastMonth,"barChart3","total_sale_of_course_in_month");
        })

        // yearly subscriber
        function setWeeklyVisitorChart(){
            var dual = document.getElementById("dual-line");
            if (dual !== null) {

                let check_day = today.day_of_week;
                let today_index = days_of_week.findIndex((day)=> day===check_day);
                let label_data_set = [];
                for(let i = 0 ; i<7; i++){
                    if(today_index < 6){
                        today_index++;
                    }else{
                        today_index  = 0;
                    }
                    label_data_set [i] = days_of_week[today_index];
                }

                let new_visitor_data_set = [];
                let old_visitor_data_set = [];
                check_day = today.day_of_month;
                let j = 0;
                for(let i = check_day - 6; i <= check_day; i++){
                    let current_visitor=visitors.filter(visitor=>visitor.day==i);
                    if(current_visitor.length>0){
                        new_visitor_data_set[j]=current_visitor[0].visitor;
                        total_weekly_visitor += new_visitor_data_set[j];
                    }else{
                        new_visitor_data_set[j]=0;
                    }

                    let old_visitor=visitors.filter(visitor=>visitor.day==(i-7));
                    if(old_visitor.length>0) old_visitor_data_set[j] = old_visitor[0].visitor;
                    else old_visitor_data_set[j] =0;
                    j++;
                }
                
                $('#total_weekly_visitor').html(total_weekly_visitor);

                var urChart = new Chart(dual, {
                type: "line",
                data: {
                    labels: label_data_set,
                    datasets: [
                    {
                        label: "Old",
                        pointRadius: 4,
                        pointBackgroundColor: "rgba(255,255,255,1)",
                        pointBorderWidth: 2,
                        fill: false,
                        backgroundColor: "transparent",
                        borderWidth: 2,
                        borderColor: "#ffc136",
                        data: old_visitor_data_set
                    },
                    {
                        label: "New",
                        fill: false,
                        pointRadius: 4,
                        pointBackgroundColor: "rgba(255,255,255,1)",
                        pointBorderWidth: 2,
                        backgroundColor: "transparent",
                        borderWidth: 2,
                        borderColor: "#ed2a26",
                        data: new_visitor_data_set
                    }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                    padding: {
                        right: 10
                    }
                    },

                    legend: {
                    display: false
                    },
                    scales: {
                    xAxes: [
                        {
                        gridLines: {
                            drawBorder: false,
                            display: false
                        },
                        ticks: {
                            display: false, // hide main x-axis line
                            beginAtZero: true
                        },
                        barPercentage: 1.8,
                        categoryPercentage: 0.2
                        }
                    ],
                    yAxes: [
                        {
                        gridLines: {
                            drawBorder: false, // hide main y-axis line
                            display: false
                        },
                        ticks: {
                            display: false,
                            beginAtZero: true
                        }
                        }
                    ]
                    },
                    tooltips: {
                    titleFontColor: "#333",
                    bodyFontColor: "#686f7a",
                    titleFontSize: 12,
                    bodyFontSize: 14,
                    backgroundColor: "rgba(256,256,256,0.95)",
                    displayColors: true,
                    borderColor: "rgba(220, 220, 220, 0.9)",
                    borderWidth: 2
                    }
                }
                });
            }
        }

        // weekly visitor
        function setYearlySubscriberChart(){
            var barX = document.getElementById("barChart");
            if (barX !== null) {
                for(let i=0;i<12;i++){
                    let month=i+1;
                    let current_subscriber=subscribers.filter(subscriber=>subscriber.month==month);
                    
                    if(current_subscriber.length>0){
                        subscriber_dataset[i]=current_subscriber[0].subscriber;
                        total_subscriber_in_year+= subscriber_dataset[i];
                    }else{
                        subscriber_dataset[i]=0;
                    }
                    
                }

                $('#total_subscriber_in_year').html(total_subscriber_in_year);

                var myChart = new Chart(barX, {
                    type: "bar",
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
                        label: "Subscribe",
                        data: subscriber_dataset,
                        backgroundColor: "#ed2a26"
                        }
                    ]
                    },
                    options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    scales: {
                        xAxes: [
                        {
                            gridLines: {
                            drawBorder: false,
                            display: false
                            },
                            ticks: {
                            display: false, // hide main x-axis line
                            beginAtZero: true
                            },
                            barPercentage: 1.8,
                            categoryPercentage: 0.2
                        }
                        ],
                        yAxes: [
                        {
                            gridLines: {
                            drawBorder: false, // hide main y-axis line
                            display: false
                            },
                            ticks: {
                            display: false,
                            beginAtZero: true
                            }
                        }
                        ]
                    },
                    tooltips: {
                        titleFontColor: "#333",
                        bodyFontColor: "#686f7a",
                        titleFontSize: 12,
                        bodyFontSize: 12,
                        backgroundColor: "rgba(256,256,256,0.95)",
                        displayColors: false,
                        borderColor: "rgba(220, 220, 220, 0.9)",
                        borderWidth: 2
                    }
                    }
                });
            }
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

        // sale of month
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

        //sales of course
        function setSalesOfCourseChart(salesOfCourse,lastSales, chart_id,total_id){
            var barX = document.getElementById(chart_id);
            let sale_data_set =  [];
            let last_sale_data_set =  [];
            let label_data_set = [];
            let total_sale_of_course = 0;
            if (barX !== null) {
                for(let i=0;i<courses.length;i++){
                    let course = courses[i];
                    let current_sale=salesOfCourse.filter((sale)=> sale.course_id == course.id );
                    if(current_sale.length==0) sale_data_set[i] = 0;
                    else sale_data_set[i] = current_sale[0].amount;
                    total_sale_of_course += parseInt(sale_data_set[i]);

                    let last_sale = lastSales.filter((sale)=> sale.course_id == course.id );
                    if(last_sale.length==0)  last_sale_data_set[i] = 0;
                    else last_sale_data_set[i] = last_sale[0].amount;
                    label_data_set[i] = course.title
                    
                }

                $('#'+total_id).html(total_sale_of_course + ' MMK');

                var myChart = new Chart(barX, {
                    type: "bar",
                    data: {
                    labels:label_data_set,
                    datasets: [
                        {
                        label: "MMK",
                        data: last_sale_data_set, 
                        backgroundColor: "rgba(255, 230, 0)"
                        },
                        {
                        label: "MMK",
                        data: sale_data_set,
                        backgroundColor: "#ed2a26"
                        }
                    ]
                    },
                    options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    scales: {
                        xAxes: [
                        {
                            gridLines: {
                            drawBorder: false,
                            display: false
                            },
                            ticks: {
                            display: false, // hide main x-axis line
                            beginAtZero: true
                            },
                            barPercentage: 1.8,
                            categoryPercentage: 0.2
                        }
                        ],
                        yAxes: [
                        {
                            gridLines: {
                            drawBorder: false, // hide main y-axis line
                            display: false
                            },
                            ticks: {
                            display: false,
                            beginAtZero: true
                            }
                        }
                        ]
                    },
                    tooltips: {
                        titleFontColor: "#333",
                        bodyFontColor: "#686f7a",
                        titleFontSize: 12,
                        bodyFontSize: 12,
                        backgroundColor: "rgba(256,256,256,0.95)",
                        displayColors: false,
                        borderColor: "rgba(220, 220, 220, 0.9)",
                        borderWidth: 2
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
            $('#sale_of_course_year_text').html("Sales Of Course In "+request.year)
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

            let url = `{{asset("")}}instructor-dashboard/analyics?year=${year}&month=${month}`;
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
            $('#sale_of_course_month_text').html("Sales Of Course In "+months[index]+", "+request.year)
        }


 
    </script>
    
	@endsection