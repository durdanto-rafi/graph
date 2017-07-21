@extends('layouts.app') @section('title', 'LMS Log Data') @section('content')

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

<div class="row">
    <!-- /.col (LEFT) -->
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
    <!-- /.col (RIGHT) -->
</div>

@endsection @section('script') @parent
<script type="text/javascript">
    $(function () {
        "use strict";

        // LINE CHART
        var line = new Morris.Line({
            element: 'line-chart',
            resize: true,
            data: [{
                    y: '2011 Q1',
                    item1: 2666
                },
                {
                    y: '2011 Q2',
                    item1: 2778
                },
                {
                    y: '2011 Q3',
                    item1: 4912
                },
                {
                    y: '2011 Q4',
                    item1: 3767
                },
                {
                    y: '2012 Q1',
                    item1: 6810
                },
                {
                    y: '2012 Q2',
                    item1: 5670
                },
                {
                    y: '2012 Q3',
                    item1: 4820
                },
                {
                    y: '2012 Q4',
                    item1: 15073
                },
                {
                    y: '2013 Q1',
                    item1: 10687
                },
                {
                    y: '2013 Q2',
                    item1: 8432
                }
            ],
            xkey: 'y',
            ykeys: ['item1'],
            labels: ['Item 1'],
            lineColors: ['#3c8dbc'],
            hideHover: 'auto'
        });
    });
</script>
@stop