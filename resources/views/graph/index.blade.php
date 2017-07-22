@extends('layouts.app')
@section('title', 'LMS Log Data')
 
@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Graph</h2>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    {!! Form::open(array('id'=>'frmGraph')) !!}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name</strong> 
                    {!! Form::text('contentNumber', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                </div>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <label>Contract Start Date</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        {!! Form::text('dateFrom', null, array('placeholder' => 'Contract Start Date', 'class' => 'form-control pull-right', 'id'=>'reservation')) !!}
                    </div>
                <!-- /.input group -->
                </div>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <label>Contract Period Date</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        {!! Form::text('contract_period_day', null, array('placeholder' => 'Contract Period Date', 'class' => 'form-control pull-right datepicker', 'id'=>'txtPeriodDate', 'onkeypress'=>'return false;')) !!}
                    </div>
                <!-- /.input group -->
                </div>
            </div>

           

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                {{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}
            </div>

             <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label id="lblMessage"/> 
                </div>
            </div>

            <div class="col-md-12">
                <!-- LINE CHART -->
                <div class="box box-info">
                    <div class="box-header with-border">
                    <h3 class="box-title">Line Chart</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    </div>
                    <div class="box-body chart-responsive">
                    <div class="chart" id="line-chart" style="height: 400px;"></div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    {!! Form::close() !!}

    <div class="row">
        <!-- /.col (LEFT) -->
        
        <!-- /.col (RIGHT) -->
      </div>

@endsection

@section('script') @parent
<script type="text/javascript">

    var morrisData = null;
    //Date picker
    $('.datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

    //Date range picker with time picker
    $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});

    window.onload = function() {
       loadRules();
    };

    $('#frmGraph').on('submit', function(e) {
        e.preventDefault();
        var contentNumber = 5533;
        var dateFrom = '2016-03-01 0:00:00';
        var dateTo = '2016-08-31 0:00:00';
        var token = $("input[name='_token']").val();
        $.ajax({
            url: "{{ route('graphData') }}",
            method: 'POST',
            data: {contentNumber:contentNumber, dateFrom:dateFrom, dateTo:dateTo, _token:token},
            success: function(data) {
                morrisData = data.durationInSecond;
                console.log(morrisData);

                // LINE CHART
                var line = new Morris.Line({
                    element: 'line-chart',
                    resize: true,
                    data: morrisData,
                    xkey: 'second',
                    ykeys: ['count'],
                    labels: ['Item 1'],
                    lineColors: ['#3c8dbc'],
                    hideHover: 'auto',
                    xLabels: "30sec"
                });
                
            },
            error: function( data ) {
                if ( data.status === 422 ) {
                    toastr.error('Something went wrong !');
                }
            }
        });
    });
    
    
</script>
@stop