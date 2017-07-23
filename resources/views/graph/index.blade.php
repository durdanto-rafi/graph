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
            <label>Content Number</label> 
            {!! Form::text('contentNumber', null, array('placeholder' => 'Name','class' => 'form-control', 'id'=>'txtContentNumber', 'onkeypress'=>'return numberValidate(event);')) !!}
        </div>
    </div>

    <div class="col-xs-4 col-sm-4 col-md-4">
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

    <div class="col-xs-4 col-sm-4 col-md-4">
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
        <div class="form-group">
            <label id="lblMessage" />
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
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body chart-responsive">
                <div class="chart" id="line-chart" style="height: 400px;"></div>
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

    $('#frmGraph').on('submit', function (e) {
        e.preventDefault();
        $('.overlay').show();
        $("#line-chart").html("");
        
        $.ajax({
            url: "{{ route('graphData') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function (data) {
                $('.overlay').hide();
                morrisData = data.durationInSecond;
                graphHeader.innerText = 'View Density for '+ document.getElementById("txtContentNumber").value;;

                line.setData(data.durationInSecond);
            },
            error: function (data) {
                if (data.status === 422) {
                    toastr.error('Something went wrong !');
                }
            }
        });

        // LINE CHART
        var line = new Morris.Line({
            element: 'line-chart',
            resize: true,
            data: [0,0],
            xkey: 'second',
            ykeys: ['count'],
            labels: ['View count'],
            lineColors: ['#3c8dbc'],
            hideHover: 'auto',
            parseTime: false,
            pointSize: 0,
            xLabelFormat: function(x) { return x.label + ' sec' }
        });
    });
</script>
@stop