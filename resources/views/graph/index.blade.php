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
                {!! Form::select('subject', ['' => 'Select'] + $subjects, null, ['class'=>'form-control', 'id'=>'ddlSubject']) !!}
                <!-- /.input group -->
            </div>
        </div>

        <div class="col-xs-12 col-sm-4 col-md-4">
            <div class="form-group">
                <label>Content</label>
                {!! Form::select('contentNumber', [], null, ['class'=>'form-control select2', 'style'=>'width: 100%;', 'id'=>'ddlContentNumber']) !!}
                <!-- /.input group -->
            </div>
        </div>

        <div class="col-xs-12 col-sm-4 col-md-4">
            <div class="form-group">
                <label>Test</label>
                {!! Form::select('subject', ['' => 'Select'] + $tests, null, ['class'=>'form-control', 'id'=>'ddlTest']) !!}
                <!-- /.input group -->
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-6">
            <label>Rank</label>
            <div class="form-group">
                <label>
                    <input type="checkbox" id="chkAll" /> All<br/>
                    @foreach ($ranks as $rank)
                        <input tabindex="1" type="checkbox" name="rank[]" id="chkGroup" value="{{$rank->rank_number}}"> {{$rank->name}} <br>
                    @endforeach
                </label>
            </div>
        </div>
          
          <!-- /.box -->

        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label>From Date</label>
                <div class="input-group date">
                    {!! Form::text('dateFrom', null, array('placeholder' => 'Contract Start Date', 'class' => 'form-control pull-right datepicker', 'id'=>'txtFromDateInput', 'onkeypress'=>'return false;')) !!}
                </div>
                <!-- /.input group -->
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label>To Date</label>
                <div class="input-group date">
                    {!! Form::text('dateTo', null, array('placeholder' => 'Contract Period Date', 'class' => 'form-control pull-right datepicker', 'id'=>'txtToDateInput', 'onkeypress'=>'return false;')) !!}
                </div>
                <!-- /.input group -->
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <div class="form-group">
            {{ Form::submit('Submit', array('class' => 'btn btn-primary btn-sm')) }}
        </div></div>

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
    <div class="col-xs-12 col-sm-8 col-md-8">
        <div class="col-xs-12 col-sm-12 col-md-12">
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
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <!-- LINE CHART -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 id="graphHeader" class="box-title">Events</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                    </div>
                </div>
                <div class="box-body chart-responsive">
                    <div class="chart graph-height" id="line-chart-pause"></div>
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
        $("[name='rank[]']").each(function (index, data) {
            if (data.checked) {
                rank.push(data.value);
            }
        });

        if(rank.length < 1 ){
            error.push('rank');   
        }

        if(error.length > 0){
            swal("Need to fillup !", error.join("\n"));
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
                drawEventsRatio(data.contentInfo.pauseRatio, data.contentInfo.forwardRatio, data.contentInfo.rewindRatio);
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                swal("Sorry!", err.Message);
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
        document.getElementById('txtTotalStudent').value = '';

        $("#line-chart-density").empty();
        $("#line-chart-pause").empty();

        drawEventsRatio(0,0,0);
    }

    window.onload = function() {
        var startDate = new Date("2015-01-01");
        $("#txtFromDateInput").datepicker('setDate', startDate);

        var today = new Date();
        $("#txtToDateInput").datepicker('setDate', today.toString('yyyy-MM-dd'));
        clearData();
    };  

    // Drawing Event's Ratio
    function drawEventsRatio(pause, froward, rewind){
        var MeSeContext = document.getElementById("canEventsRatio").getContext("2d");

        MeSeContext.height = 20;
        var MeSeData = {
            labels: [
                "Pause (%)",
                "Rewind (%)",
                "Forward (%)"
                
            ],
            datasets: [{
                data: [pause, rewind, froward],
                backgroundColor: ["#FF0000", "#669911", "#0000CD"],
                hoverBackgroundColor: ["#66A2EB", "#FCCE56", "#008000"]
            }]
        };

        var MeSeChart = new Chart(MeSeContext, {
            type: 'horizontalBar',
            data: MeSeData,
            options: {
                legend: {
                    display: false
                },
                animation: {
                    duration: 0
                },
                scales: {
                    xAxes: [{
                    }],
                    yAxes: [{
                        barPercentage: 0.4
                    }]
                }
            }
        });
    }
    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    });

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

    $("[name='rank[]']").click(function(event) {
        if($('#chkGroup').is(':checked'))
        {
            $('#chkAll').attr('checked', false);
        }
    });
</script>
@stop