@extends('layouts.app') 
@section('title', 'LMS log data graph') 
@section('content')


@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif 

{!! Form::open(array('id'=>'frmGraph')) !!}
    <div class="col-xs-4 col-sm-4 col-md-4">
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <label>Subject</label>
                {!! Form::select('subject', ['' => 'Select'] + $subjects, null, ['class'=>'form-control', 'id'=>'ddlSubject']) !!}
                <!-- /.input group -->
            </div>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <label>Content</label>
                {!! Form::select('contentNumber', [], null, ['class'=>'form-control select2', 'style'=>'width: 100%;', 'id'=>'ddlContentNumber']) !!}
                <!-- /.input group -->
            </div>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <label>Rank</label>
                {!! Form::select('rank',  $ranks, null, ['class'=>'form-control', 'id'=>'ddlRank']) !!}
                <!-- /.input group -->
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label>From Date</label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    {!! Form::text('dateFrom', null, array('placeholder' => 'Contract Start Date', 'class' => 'form-control pull-right datepicker', 'id'=>'txtFromDateInput', 'onkeypress'=>'return false;')) !!}
                </div>
                <!-- /.input group -->
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label>To Date</label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    {!! Form::text('dateTo', null, array('placeholder' => 'Contract Period Date', 'class' => 'form-control pull-right datepicker', 'id'=>'txtToDateInput', 'onkeypress'=>'return false;')) !!}
                </div>
                <!-- /.input group -->
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            {{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="top-buffer">
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label>Section Name</label> 
                {!! Form::text('subject_section_name', null, array('class' => 'form-control', 'id'=>'txtSubjectSectionName', 'disabled')) !!}
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label>Subject Name</label> 
                {!! Form::text('subject_name', null, array('class' => 'form-control', 'id'=>'txtSubjectName', 'disabled')) !!}
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label>Viewded From</label> 
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    {!! Form::text('subjectName', null, array('class' => 'form-control', 'id'=>'txtRegisteredFrom', 'disabled')) !!}
                </div>
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label>Viewded To</label> 
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    {!! Form::text('subjectName', null, array('class' => 'form-control', 'id'=>'txtRegisteredTo', 'disabled')) !!}
                </div>
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <label>Event</label> 
                {!! Form::text('subjectName', null, array('class' => 'form-control', 'id'=>'txtTotalEvent', 'disabled')) !!}
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <label>View</label> 
                {!! Form::text('subjectName', null, array('class' => 'form-control', 'id'=>'txtTotalView', 'disabled')) !!}
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <label>Student</label> 
                {!! Form::text('subjectName', null, array('class' => 'form-control', 'id'=>'txtTotalStudent', 'disabled')) !!}
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <label>E/V</label> 
                {!! Form::text('subjectName', null, array('class' => 'form-control', 'id'=>'txtEventPerView', 'disabled')) !!}
            </div>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <label>Pause Ratio</label> 
                {!! Form::text('subjectName', null, array('placeholder' => 'Pause Ratio','class' => 'form-control', 'id'=>'txtPauseRatio', 'disabled')) !!}
            </div>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <label>Forward Ratio</label> 
                {!! Form::text('subjectName', null, array('placeholder' => 'Forward Ratio','class' => 'form-control', 'id'=>'txtForwardRatio', 'disabled')) !!}
            </div>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <label>Rewind Ratio</label> 
                {!! Form::text('subjectName', null, array('placeholder' => 'Rewind Ratio','class' => 'form-control', 'id'=>'txtRewindRatio', 'disabled')) !!}
            </div>
        </div>

        <div id="chart-container">FusionCharts will render here</div>

        <canvas id="MeSeStatusCanvas"></canvas>
    </div>
    <div class="col-md-8">
        <div class="col-md-12">
            <!-- LINE CHART -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 id="graphHeader" class="box-title">View Density</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                    </div>
                </div>
                <div class="box-body chart-responsive">
                    <div class="chart graph-height" id="line-chart-density"></div>
                </div>
                <!-- Loading (remove the following to stop the loading)-->
                <div class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

        <div class="col-md-12">
            <!-- LINE CHART -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 id="graphHeader" class="box-title">Pause</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                    </div>
                </div>
                <div class="box-body chart-responsive">
                    <div class="chart graph-height" id="line-chart-pause"></div>
                </div>
                <!-- Loading (remove the following to stop the loading)-->
                <div class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

        <div class="col-md-12">
            <!-- LINE CHART -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 id="graphHeader" class="box-title">Under Development</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                    </div>
                </div>
                <div class="box-body chart-responsive">
                    <div id="chart"></div>
                </div>
                <!-- Loading (remove the following to stop the loading)-->
                <div class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
{!! Form::close() !!}

@endsection 


@section('script') 
@parent

<script type="text/javascript">
    $(".select2").select2();
    $('.overlay').hide();
    var d3Data;

    //Date picker
    $('.datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        format: 'MM/DD/YYYY h:mm A'
    });

    // Loading Subjects's Contents 
    $('#ddlSubject').change(function(){
        var subject_number = $(this).val();
        var token = $("input[name='_token']").val();
        $.ajax({
            url: "{{ route('subjectContents') }}",
            method: 'POST',
            data: {subject_number:subject_number, _token:token},
            success: function(data) {
                $('#ddlContentNumber').html('');
                $('#ddlContentNumber').html(data.options);
            }
        });
    }); 

    $('#frmGraph').on('submit', function (e) {
        e.preventDefault();

        // Validation
        var error = new Array();
        var dataArray = $("#frmGraph").serializeArray();
        $(dataArray).each(function(i, field){
            if(field.value.length == 0){
                error.push(field.name);
            }
        });

        if(error.length > 0){
            swal("Need to fillup !", error.join("\n"));
            return false;
        }

        $('.overlay').show();
        clearData();
        $.ajax({
            url: "{{ route('graphData') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function (data) {
                $('.overlay').hide();

                //console.log(data);
                if(data.durationInSecond.length == 0)
                {
                    swal("Sorry!", "No data");
                    return;
                }
                
                document.getElementById('txtSubjectSectionName').value = data.contentInfo.subject_section_name;
                document.getElementById('txtSubjectName').value = data.contentInfo.subject_name;
                document.getElementById('txtRegisteredFrom').value = data.contentInfo.registered_from;
                document.getElementById('txtRegisteredTo').value = data.contentInfo.registered_to;

                document.getElementById('txtTotalEvent').value = data.contentInfo.eventCount;
                document.getElementById('txtTotalView').value = data.contentInfo.totalViewCount;
                document.getElementById('txtEventPerView').value = data.contentInfo.eventPerView;
                document.getElementById('txtPauseRatio').value = data.contentInfo.pauseRatio;
                document.getElementById('txtForwardRatio').value = data.contentInfo.forwardRatio;
                document.getElementById('txtRewindRatio').value = data.contentInfo.rewindRatio;
                document.getElementById('txtTotalStudent').value = data.contentInfo.totalStudentCount;

                densityLine.setData(data.durationInSecond);
                pauseLine.setData(data.durationInSecond);

                jsonArr = [];
                for (var i = 0; i < data.durationInSecond.length; i++) {
                    jsonArr.push({
                        x: data.durationInSecond[i].second,
                        y: data.durationInSecond[i].viewCount
                    });
                }
                sideBar2();
                //console.log(JSON.stringify(jsonArr));
                d3Data = [
                            [{'x':1,'y':0},{'x':2,'y':5},{'x':3,'y':10},{'x':4,'y':0},{'x':5,'y':6},{'x':6,'y':11},{'x':7,'y':9},{'x':8,'y':4},{'x':9,'y':11},{'x':10,'y':2}]
                        ];
                d3Load(d3Data);
                
            },
            error: function (data) {
                swal("Sorry!", "Something went wrong");
            }
        });

        // Density graph
        var densityLine = new Morris.Line({
            element: 'line-chart-density',
            resize: true,
            data: [0,0],
            xkey: 'second',
            ykeys: ['viewCount'],
            labels: ['View count'],
            lineColors: ['#3c8dbc'],
            hideHover: 'auto',
            parseTime: false,
            pointSize: 0,
            xLabelFormat: function(x) { return fmtMSS(x.label) }
        });

        // Pause graph
        var pauseLine = new Morris.Line({
            element: 'line-chart-pause',
            resize: true,
            data: [0,0],
            xkey: 'second',
            ykeys: ['pauseCount', 'forwardCount', 'rewindCount'],
            labels: ['Pause count', 'Forward count', 'Rewind count'],
            lineColors: ['#FF0000', '#0000CD', '#008000'],
            hideHover: 'auto',
            parseTime: false,
            pointSize: 0,
            xLabelFormat: function(x) { return fmtMSS(x.label) },
            lineWidth : 1
        });
    });

    function fmtMSS(s)
    {
        //return(s-(s%=60))/60+(9<s?':':':0')+s
        return s
    }

    function clearData()
    {
        document.getElementById('txtSubjectSectionName').value = '';
        document.getElementById('txtSubjectName').value = '';
        document.getElementById('txtRegisteredFrom').value = '';
        document.getElementById('txtRegisteredTo').value = '';

        document.getElementById('txtTotalEvent').value = '';
        document.getElementById('txtTotalView').value = '';
        document.getElementById('txtEventPerView').value = '';
        document.getElementById('txtPauseRatio').value = '';
        document.getElementById('txtForwardRatio').value = '';
        document.getElementById('txtRewindRatio').value = '';
        document.getElementById('txtTotalStudent').value = '';

        $("#line-chart-density").html("");
        $("#line-chart-pause").html("");

    }

    window.onload = function() {
        var startDate = new Date("2015-01-01");
        $("#txtFromDateInput").datepicker('setDate', startDate);

        var today = new Date();
        $("#txtToDateInput").datepicker('setDate', today.toString('yyyy-MM-dd'));
        clearData();
        //d3Load([]);
    };

    // D3
    //function d3Load(d3Data){

    //************************************************************
    // Data notice the structure
    //************************************************************
    
        d3Data = [
                    [{'x':1,'y':0},{'x':2,'y':5},{'x':3,'y':10},{'x':4,'y':0},{'x':5,'y':6},{'x':6,'y':11},{'x':7,'y':9},{'x':8,'y':4},{'x':9,'y':11},{'x':10,'y':2}],
                    [{'x':1,'y':30},{'x':2,'y':7},{'x':3,'y':3},{'x':4,'y':9},{'x':5,'y':-7},{'x':6,'y':4},{'x':7,'y':8},{'x':8,'y':3},{'x':9,'y':9},{'x':10,'y':3}]
                ];
        var colors = [
            'steelblue',
            'green',
            'red',
            'purple'
        ]
        
        
        //************************************************************
        // Create Margins and Axis and hook our zoom function
        //************************************************************
        var margin = {top: 20, right: 30, bottom: 30, left: 50},
            width = $("#chart").parent().width() - margin.left - margin.right,
            height = 250 - margin.top - margin.bottom;
            
        var x = d3.scale.linear()
            .domain([0, 12])
            .range([0, width]);
        
        var y = d3.scale.linear()
            .domain([-1, 16])
            .range([height, 0]);
            
        var xAxis = d3.svg.axis()
            .scale(x)
            .tickSize(-height)
            .tickPadding(10)	
            .tickSubdivide(true)	
            .orient("bottom");	
            
        var yAxis = d3.svg.axis()
            .scale(y)
            .tickPadding(10)
            .tickSize(-width)
            .tickSubdivide(true)	
            .orient("left");
            
        var zoom = d3.behavior.zoom()
            .x(x)
            .y(y)
            .scaleExtent([1, 10])
            .on("zoom", zoomed);	
            
            
        
            
            
        //************************************************************
        // Generate our SVG object
        //************************************************************	
        var svg = d3.select("#chart").append("svg")
            .call(zoom)
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
            .append("g")
            .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
        
        svg.append("g")
            .attr("class", "x axis")
            .attr("transform", "translate(0," + height + ")")
            .call(xAxis);
        
        svg.append("g")
            .attr("class", "y axis")
            .call(yAxis);
        
        svg.append("g")
            .attr("class", "y axis")
            .append("text")
            .attr("class", "axis-label")
            .attr("transform", "rotate(-90)")
            .attr("y", (-margin.left) + 10)
            .attr("x", -height/2)
            .text('View Count');	
        
        svg.append("clipPath")
            .attr("id", "clip")
            .append("rect")
            .attr("width", width)
            .attr("height", height);
            
            
            
            
            
        //************************************************************
        // Create D3 line object and draw data on our SVG object
        //************************************************************
        var line = d3.svg.line()
            .interpolate("linear")	
            .x(function(d) { return x(d.x); })
            .y(function(d) { return y(d.y); });		
            
        svg.selectAll('.line')
            .data(d3Data)
            .enter()
            .append("path")
            .attr("class", "line")
            .attr("clip-path", "url(#clip)")
            .attr('stroke', function(d,i){ 			
                return colors[i%colors.length];
            })
            .attr("d", line);		
            
            
            
            
        //************************************************************
        // Draw points on SVG object based on the data given
        //************************************************************
        var points = svg.selectAll('.dots')
            .data(d3Data)
            .enter()
            .append("g")
            .attr("class", "dots")
            .attr("clip-path", "url(#clip)");	
        
        points.selectAll('.dot')
            .data(function(d, index){ 		
                var a = [];
                d.forEach(function(point,i){
                    a.push({'index': index, 'point': point});
                });		
                return a;
            })
            .enter()
            .append('circle')
            .attr('class','dot')
            .attr("r", 2.5)
            .attr('fill', function(d,i){ 	
                return colors[d.index%colors.length];
            })	
            .attr("transform", function(d) { 
                return "translate(" + x(d.point.x) + "," + y(d.point.y) + ")"; }
            );
    //}
        
    
        
        
        
        
    //************************************************************
    // Zoom specific updates
    //************************************************************
    function zoomed() {
        svg.select(".x.axis").call(xAxis);
        svg.select(".y.axis").call(yAxis);   
        svg.selectAll('path.line').attr('d', line);  
    
        points.selectAll('circle').attr("transform", function(d) { 
            return "translate(" + x(d.point.x) + "," + y(d.point.y) + ")"; }
        );  
    }


    // Side Bar
    function sideBar()
    {
        FusionCharts.ready(function () {
            var topStores = new FusionCharts({
                type: 'bar2d',
                renderAt: 'chart-container',
                width: '400',
                height: '200',
                dataFormat: 'json',
                dataSource: {
                    "chart": {
                        "caption": "Top 5 Stores by Sales",
                        "subCaption": "Last month",
                        "yAxisName": "Sales (In USD)",
                        "paletteColors": "#0075c2",
                        "bgColor": "#ffffff",
                        "showBorder": "0",
                        "showCanvasBorder": "0",
                        "usePlotGradientColor": "0",
                        "plotBorderAlpha": "10",
                        "placeValuesInside": "1",
                        "valueFontColor": "#ffffff",
                        "showAxisLines": "1",
                        "axisLineAlpha": "25",
                        "divLineAlpha": "10",
                        "alignCaptionWithCanvas": "0",
                        "showAlternateVGridColor": "0",
                        "captionFontSize": "14",
                        "subcaptionFontSize": "14",
                        "subcaptionFontBold": "0",
                        "toolTipColor": "#ffffff",
                        "toolTipBorderThickness": "0",
                        "toolTipBgColor": "#000000",
                        "toolTipBgAlpha": "80",
                        "toolTipBorderRadius": "2",
                        "toolTipPadding": "5"
                    },
                    
                    "data": [
                        {
                            "label": "Pause(%)",
                            "value": "13"
                        }, 
                        {
                            "label": "Rewind(%)",
                            "value": "33"
                        }, 
                        {
                            "label": "Forward(%)",
                            "value": "53"
                        }
                    ]
                }
            })
            .render();
        });
    }

    // Side Bar 2
    function sideBar2(){
        var MeSeContext = document.getElementById("MeSeStatusCanvas").getContext("2d");

        MeSeContext.height = 50;
        var MeSeData = {
            labels: [
                "ME",
                "SE",
                "SE"
            ],
            datasets: [{
                label: "Test",
                data: [16, 5, 5],
                backgroundColor: ["#669911", "#119966","#669911"],
                hoverBackgroundColor: ["#66A2EB", "#FCCE56","#66A2EB"]
            }]
        };

        var MeSeChart = new Chart(MeSeContext, {
            type: 'horizontalBar',
            data: MeSeData,
            options: {
                scales: {
                    xAxes: [{
                        ticks: {
                            min: 0
                        }
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                }
            }
        });
    }
</script>
@stop