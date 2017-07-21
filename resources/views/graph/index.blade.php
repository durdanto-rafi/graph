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

@endsection

@section('script') @parent
<script type="text/javascript">

    window.onload = function() {
       loadRules();
    };
     
    $(function () {
        "use strict";
    
        var morrisData = JSON.parse({!! $durationInSecond !!});
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
        hideHover: 'auto'
    });


    function loadRules() {
        var exam_type_id = $('#ddlExamType').val();
        var token = $("input[name='_token']").val();
        $.ajax(
        {
            url: "{{ route('examTypeRules') }}",
            method: 'POST',
            data: {exam_type_id:exam_type_id, _token:token},          
            success: function(data) 
            {
                var row = [];
                $.each(data.rules, function(i, rule) 
                {
                    var showRoute = '{{ route("rule.show", ":id") }}';
                    var editRoute = '{{ route("rule.edit", ":id") }}';

                    showRoute = showRoute.replace(':id', rule.id);
                    editRoute = editRoute.replace(':id', rule.id);

                    row.push("<tr>");
                    row.push("<td>" + (i + 1) + "</td>");          
                    row.push("<td>" + rule.name + "</td>");
                    row.push("<td>" + ( rule.deactivated === 0 ? "<i class='fa fa-check-square-o' aria-hidden='true'></i>" : "<i class='fa fa-times' aria-hidden='true'></i>" ) + "</td>");
                    row.push("<td> <a class='btn btn-info' href=" + showRoute + ">Show</a>");
                    {{-- row.push(" <a class='btn btn-primary' href=" + editRoute + ">Edit</a>"); --}}
                    row.push(" <a class='btn btn-danger' id='btnDelete' value='{{ csrf_token() }}' data-id='"+ rule.id +"' >Delete</a></td>");
                    row.push("</tr>");
                });
                $('#tblRules').html(row.join(""));
            }
        });
    }
</script>
@stop