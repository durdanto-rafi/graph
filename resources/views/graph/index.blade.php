@extends('layouts.app') 
@section('title', 'LMS log data graph') 
@section('content')


@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif 

{!! Form::open(array('id'=>'frmGraph')) !!}
    <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <label>Subject</label>
                {!! Form::select('subject_number', ['' => '- Select -'] + $subjects, null, ['class'=>'form-control', 'id'=>'ddlSubject']) !!}
                <!-- /.input group -->
            </div>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <label>Content Number</label>
                {!! Form::select('contentNumber', [], null, ['class'=>'form-control select2', 'style'=>'width: 100%;', 'id'=>'ddlContentNumber']) !!}
                <!-- /.input group -->
            </div>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <label>Rank</label>
                {!! Form::select('rank_number', ['' => '- Select -'] + $ranks, null, ['class'=>'form-control', 'id'=>'ddlRank']) !!}
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
                    {!! Form::text('dateFrom', null, array('placeholder' => 'Contract Start Date', 'class' => 'form-control pull-right datepicker', 'onkeypress'=>'return false;')) !!}
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
                    {!! Form::text('dateTo', null, array('placeholder' => 'Contract Period Date', 'class' => 'form-control pull-right datepicker', 'id'=>'txtPeriodDate', 'onkeypress'=>'return false;')) !!}
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
                <label>Subject Section Name</label> 
                {!! Form::text('subject_section_name', null, array('placeholder' => 'Subject Section Name','class' => 'form-control', 'id'=>'txtSubjectSectionName', 'disabled')) !!}
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label>Subject Name</label> 
                {!! Form::text('subject_name', null, array('placeholder' => 'Subject Name','class' => 'form-control', 'id'=>'txtSubjectName', 'disabled')) !!}
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label>Registered From</label> 
                {!! Form::text('subjectName', null, array('placeholder' => 'Registered From','class' => 'form-control', 'id'=>'txtRegisteredFrom', 'disabled')) !!}
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label>Registered To</label> 
                {!! Form::text('subjectName', null, array('placeholder' => 'Registered To','class' => 'form-control', 'id'=>'txtRegisteredTo', 'disabled')) !!}
            </div>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <label>Total Number of Event</label> 
                {!! Form::text('subjectName', null, array('placeholder' => 'Total Number of Event','class' => 'form-control', 'id'=>'txtTotalEvent', 'disabled')) !!}
            </div>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <label>Total Number of View</label> 
                {!! Form::text('subjectName', null, array('placeholder' => 'Total Number of View','class' => 'form-control', 'id'=>'txtTotalView', 'disabled')) !!}
            </div>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <label>Average events per view</label> 
                {!! Form::text('subjectName', null, array('placeholder' => 'Average events per view','class' => 'form-control', 'id'=>'txtEventPerView', 'disabled')) !!}
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

        </br></br></br>
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
        $('.overlay').show();
        $("#line-chart-density").html("");
        $("#line-chart-pause").html("");

        clearData();
        $.ajax({
            url: "{{ route('graphData') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function (data) {
                $('.overlay').hide();
                console.log(data);
                if(data.durationInSecond.length == 0)
                {
                    swal("Sorry!", "Invalid content number");
                    return;
                }
                

                //document.getElementById('txtContentName').value = data.contentInfo.contents_name;
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

                densityLine.setData(data.durationInSecond);
                pauseLine.setData(data.durationInSecond);
            },
            error: function (data) {
                swal("Sorry!", "Connection error");
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
        //document.getElementById('txtContentName').value = '';
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
    }

    window.onload = function() {
        clearData();
    };
</script>
@stop