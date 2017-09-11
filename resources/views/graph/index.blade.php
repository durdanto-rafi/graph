@extends('layouts.app') 
@section('title', 'LMS log data graph') 
@section('content')


@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif 

{!! Form::open(array('id'=>'frmGraph')) !!}
    <div class="col-xs-12 col-sm-4 col-md-4">
        <div class="col-xs-12 col-sm-4 col-md-4">
            <div class="form-group">
                <label>Subject</label>
                {!! Form::select('Subject', ['' => 'Select'] + $subjects, null, ['class'=>'form-control', 'id'=>'ddlSubject']) !!}
                <!-- /.input group -->
            </div>
        </div>

        <div class="col-xs-12 col-sm-4 col-md-4">
            <div class="form-group">
                <label>Content</label>
                {!! Form::select('Content', [], null, ['class'=>'form-control select2', 'style'=>'width: 100%;', 'id'=>'ddlContentNumber']) !!}
                <!-- /.input group -->
            </div>
        </div>

        <div class="col-xs-12 col-sm-4 col-md-4">
            <div class="form-group">
                <label>Test</label>
                {!! Form::select('Test', ['' => 'Select'] + $tests, null, ['class'=>'form-control', 'id'=>'ddlTest']) !!}
                <!-- /.input group -->
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-6">
            <label>Rank</label>
            <div class="form-group">
                <label>
                    <input tabindex="1" type="checkbox" id="chkAll" /> All<br/>
                    @foreach ($ranks as $rank)
                        <input tabindex="1" type="checkbox" name="rank" id="chkGroup" value="{{$rank->rank_number}}"> {{$rank->name}} <br>
                    @endforeach
                </label>
            </div>
        </div>
          
          <!-- /.box -->

        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label>From Date</label>
                <div class="input-group date">
                    {!! Form::text('DateFrom', null, array('placeholder' => 'Contract Start Date', 'class' => 'form-control pull-right datepicker', 'id'=>'txtFromDateInput', 'onkeypress'=>'return false;')) !!}
                </div>
                <!-- /.input group -->
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label>To Date</label>
                <div class="input-group date">
                    {!! Form::text('DateTo', null, array('placeholder' => 'Contract Period Date', 'class' => 'form-control pull-right datepicker', 'id'=>'txtToDateInput', 'onkeypress'=>'return false;')) !!}
                </div>
                <!-- /.input group -->
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <div class="form-group">
                {{ Form::submit('Submit', array('class' => 'btn btn-primary btn-sm')) }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <!-- LINE CHART -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Content Information</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
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
                                {!! Form::text('subjectName', null, array('class' => 'form-control', 'id'=>'txtRegisteredFrom', 'disabled')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label>Viewded To</label> 
                            <div class="input-group date">
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

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="canEventsRatio"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
          <!-- /.box -->
        </div>
    </div>
    <div class="col-xs-12 col-sm-8 col-md-8">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <!-- LINE CHART -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">View Density</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <canvas id="canViewDensity" ></canvas>
                        <div class="text-center">
                            <button id="btnResetZoomViewDensity" class="btn btn-primary btn-xs" onclick="return false;" > Reset zoom </button>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
          <!-- /.box -->
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <!-- LINE CHART -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Events</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <canvas id="canEvents"></canvas>
                        <div class="text-center">
                            <button id="btnResetZoomEvents" class="btn btn-primary btn-xs" onclick="return false;" > Reset zoom </button>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
          <!-- /.box -->
        </div>

    </div>
    <!-- Loading (remove the following to stop the loading)-->
    <div class="overlay">
        <i class="fa fa-refresh fa-spin"></i>
    </div>
{!! Form::close() !!}

@endsection 

@section('script') 
@parent
<script type="text/javascript">
    $(".select2").select2();
    $('.overlay').hide();

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
        clearData();

        // Validation
        var error = new Array();
        var dataArray = $("#frmGraph").serializeArray();
        //console.log(dataArray);
        $(dataArray).each(function(i, field){
            if(field.value.length == 0){
                error.push(field.name);
            }
        });

        // Getting checked rank data
        var rank = new Array();
        $("[name='rank']").each(function (index, data) {
            if (data.checked) {
                rank.push(data.value);
            }
        });

        if(rank.length < 1 ){
            error.push('Rank');   
        }

        if(error.length > 0){
            swal("Need to fillup !", error.join("\n"), "error");
            return false;
        }

        $('.overlay').show();

        var test = $("#ddlTest").val();
        var subject = $("#ddlSubject").val();
        var contentNumber = $("#ddlContentNumber").val();
        var dateFrom = $("#txtFromDateInput").val();
        var dateTo = $("#txtToDateInput").val();
        var token = $("input[name='_token']").val();

        $.ajax({
            url: "{{ route('graphData') }}",
            method: 'POST',
            data: {'test':test, 'subject':subject, 'contentNumber':contentNumber, 'rank':rank, 'dateFrom':dateFrom, 'dateTo':dateTo, _token:token},
            success: function (data) {
                $('.overlay').hide();

                if(data.contentInfo.totalViewCount.length == 0){
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
                document.getElementById('txtTotalStudent').value = data.contentInfo.totalStudentCount;

                
                // Updating View Density data to chart
                viewDensityData.labels = data.contentInfo.duration;
                viewDensityData.datasets.forEach(function (dataset) {
                    if(dataset.label == 'Blocks'){
                        dataset.data = data.contentInfo.blocksForViewDensity;
                    }
                    if(dataset.label == 'View Density'){
                        dataset.data = data.contentInfo.indexedViewCount;
                    }
                });
                window.viewDensityChart.update();

               
                // Updating Events data to chart
                eventsData.labels = data.contentInfo.duration;
                eventsData.datasets.forEach(function (dataset) {
                    if(dataset.label == 'Blocks'){
                        dataset.data = data.contentInfo.blocksForEvents;
                    }
                    if(dataset.label == 'Pause'){
                        dataset.data = data.contentInfo.indexedPauseCount;
                    }
                    if(dataset.label == 'Rewind'){
                        dataset.data = data.contentInfo.indexedRewindCount;
                    }
                    if(dataset.label == 'Forward'){
                        dataset.data = data.contentInfo.indexedForwardCount;
                    }
                });
                window.eventsChart.update();

                // Updating Events Ratio data to chart
                var eventsRatio = [parseFloat(data.contentInfo.pauseRatio), parseFloat(data.contentInfo.rewindRatio), parseFloat(data.contentInfo.forwardRatio)];
                var eventsRatioColor = [window.chartColors.red, window.chartColors.green, window.chartColors.blue];
                
                eventsRatioData.datasets[0].data = eventsRatio;
                window.eventsRatioChart.update();
                //drawEventsRatio(data.contentInfo.pauseRatio, data.contentInfo.forwardRatio, data.contentInfo.rewindRatio);
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                swal("Sorry!", err.Message);
            }
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
        document.getElementById('txtTotalStudent').value = '';

        //drawEventsRatio(0,0,0);
    }

    window.onload = function() {
        var startDate = new Date("2015-01-01");
        $("#txtFromDateInput").datepicker('setDate', startDate);

        var today = new Date();
        $("#txtToDateInput").datepicker('setDate', today.toString('yyyy-MM-dd'));
        clearData();


        //View Density chart initialization
        var ctxViewDensity = document.getElementById("canViewDensity").getContext("2d");
        window.viewDensityChart = new Chart(ctxViewDensity, {
            type: 'bar',
            data: viewDensityData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                pan: {
                    enabled: true,
                    mode: 'y',
                },
                zoom: {
                    enabled: true,                      
                    mode: 'y',
                }
            }
        });

        //Events chart initialization
        var ctxEvents = document.getElementById("canEvents").getContext("2d");
        window.eventsChart = new Chart(ctxEvents, {
            type: 'bar',
            data: eventsData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                pan: {
                    enabled: true,
                    mode: 'y',
                },
                zoom: {
                    enabled: true,                      
                    mode: 'y',
                }
            }
        });

         //Events Ratio chart initialization
        var ctxEventsRatio = document.getElementById("canEventsRatio").getContext("2d");
        window.eventsRatioChart = new Chart(ctxEventsRatio, {
            type: 'horizontalBar',
            data: eventsRatioData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: false
                }
            }
        });

    };  

    $('#chkAll').click(function(event) {
        if(this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function() {
                this.checked = true;
            });
        }
        else {
            $(':checkbox').each(function() {
                this.checked = false;
            });
        }
    });

    $("[name='rank']").click(function(event) {
        if($('#chkGroup').is(':checked'))
        {
            $('#chkAll').attr('checked', false);
        }
    });


    // View Density 
    var viewDensityData = {
        labels: [],
        datasets: [{
            type: 'line',
            label: 'View Density',
            borderColor: window.chartColors.sky,
            borderWidth: 2,
            fill: true,
            data: [],
            pointRadius: 0,
            pointHoverBackgroundColor: 'red'
        }, {
            type: 'bar',
            label: 'Blocks',
            borderColor: window.chartColors.purple,
            backgroundColor: window.chartColors.purple,
            data: [],
            borderWidth: 2
        }]
    };

    $('#btnResetZoomViewDensity').click(function () {
        window.viewDensityChart.resetZoom();
    });


    // Events 
    var eventsData = {
        labels: [],
        datasets: [{
            type: 'line',
            label: 'Pause',
            borderColor: window.chartColors.red,
            backgroundColor: window.chartColors.red,
            borderWidth: 2,
            fill: false,
            data: [],
            pointRadius: 0,
            pointHoverBackgroundColor: 'red'
        }, {
            type: 'line',
            label: 'Rewind',
            borderColor: window.chartColors.green,
            backgroundColor: window.chartColors.green,
            borderWidth: 2,
            fill: false,
            data: [],
            pointRadius: 0,
            pointHoverBackgroundColor: 'red'
        }, {
            type: 'line',
            label: 'Forward',
            borderColor: window.chartColors.blue,
            backgroundColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false,
            data: [],
            pointRadius: 0,
            pointHoverBackgroundColor: 'red'
        }, {
            type: 'bar',
            label: 'Blocks',
            borderColor: window.chartColors.purple,
            backgroundColor: window.chartColors.purple,
            data: [],
            borderWidth: 2
        }]
    };

    $('#btnResetZoomEvents').click(function () {
        window.eventsChart.resetZoom();
    });

    //Event Ratio
    var eventsRatioData = {
        labels: [
            "Pause (%)",
            "Rewind (%)",
            "Forward (%)"
        ],
        datasets: [{
            data: [],
            backgroundColor: [window.chartColors.red, window.chartColors.green, window.chartColors.blue]
        }]
    };

</script>
@stop