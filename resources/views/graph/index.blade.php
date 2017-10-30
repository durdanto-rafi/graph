@extends('layouts.app') @section('title', 'LMS log data graph') @section('content') @if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif {!! Form::open(array('id'=>'frmGraph')) !!}
<div class="col-xs-12 col-sm-4 col-md-4">
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <label>Subject</label>
                {!! Form::select('Subject', ['' => 'Select'] + $subjects, null, ['class'=>'form-control', 'id'=>'ddlSubject']) !!}
                <!-- /.input group -->
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <label>Content</label>
                {!! Form::select('Content', [], null, ['class'=>'form-control select2', 'style'=>'width: 100%;', 'id'=>'ddlContentNumber'])
                !!}
                <!-- /.input group -->
            </div>
        </div>

        {{--
        <div class="col-xs-12 col-sm-4 col-md-4">
            <div class="form-group">
                <label>Test</label>
                {!! Form::select('Test', ['' => 'Select'] + $tests, null, ['class'=>'form-control', 'id'=>'ddlTest']) !!}
                <!-- /.input group -->
            </div>
        </div> --}}
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-4">
            <label>Rank</label>
            <br/>
            <input type="checkbox" onClick="toggle(this)" id="chkAll" /> All
            <br/> @foreach ($ranks as $rank)
            <input type="checkbox" class="chkRank" name="rank" value="{{$rank->rank_number}}"> {{$rank->name}}
            <br> @endforeach
        </div>

        <div class="col-xs-12 col-sm-4 col-md-4">
            <label>Growth</label>
            <div class="form-group">
                <label>
                    <input name="growth" type="radio" value="1" id="chkOver" /> Over 3
                    <br/>
                    <input name="growth" type="radio" value="2" id="chkLittle" /> Change little
                    <br/>
                    <input name="growth" type="radio" value="3" id="chkUnder" /> Under 3
                    <br/>
                </label>
            </div>
        </div>

        <!-- /.box -->
        <div class="row">
            <div class="col-xs-6 col-sm-4 col-md-4">
                <div class="form-group">
                    <label>From Date</label>
                    <div class="input-group date">
                        {!! Form::text('DateFrom', null, array('placeholder' => 'Contract Start Date', 'class' => 'form-control pull-right datepicker',
                        'id'=>'txtFromDateInput', 'onkeypress'=>'return false;')) !!}
                    </div>
                    <!-- /.input group -->
                </div>
            </div>

            <div class="col-xs-6 col-sm-4 col-md-4">
                <div class="form-group">
                    <label>To Date</label>
                    <div class="input-group date">
                        {!! Form::text('DateTo', null, array('placeholder' => 'Contract Period Date', 'class' => 'form-control pull-right datepicker',
                        'id'=>'txtToDateInput', 'onkeypress'=>'return false;')) !!}
                    </div>
                    <!-- /.input group -->
                </div>
            </div>
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
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label>Section Name</label>
                        {!! Form::text('subject_section_name', null, array('class' => 'form-control', 'id'=>'txtSubjectSectionName', 'disabled'))
                        !!}
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
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li>
                    <a href="#density" data-toggle="tab">View Density</a>
                </li>
                <li>
                    <a href="#password" data-toggle="tab">EVent Density / Event Count * 100</a>
                </li>
                <li class="active">
                    <a href="#audio" data-toggle="tab">AI</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane" id="density">
                    <div class="chart">
                        <canvas id="canViewDensity"></canvas>
                        <div class="text-center">
                            <button id="btnResetZoomViewDensity" class="btn btn-primary btn-xs" onclick="return false;"> Reset zoom </button>
                        </div>
                    </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="password">
                    <div class="chart">
                        <canvas id="canViewDensityPerCount"></canvas>
                        <div class="text-center">
                            <button id="btnResetZoomDensityPerView" class="btn btn-primary btn-xs" onclick="return false;"> Reset zoom </button>
                        </div>
                    </div>
                </div>
                <!-- /.tab-pane -->
                <div class="active tab-pane" id="audio">
                    <div class="chart">
                        <canvas id="overlay"></canvas>
                        <canvas id="canAudio"></canvas>
                        <div class="text-center">
                            {{--  <button id="btnTranscribe" class="btn btn-primary btn-xs" onclick="return false;"> Transcribe </button>
                            <button id="btnConvert" class="btn btn-primary btn-xs" onclick="return false;"> Convert </button>  --}}
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    Speech
                                    <label class="input-toggle">
                                        {{ Form::checkbox('switch', 1, null, array('id'=>'swFunction') ) }}
                                        <span></span> 
                                    </label> 
                                    Handwriting
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- /.nav-tabs-custom -->
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <!-- LINE CHART -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Events</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="chart">
                    <canvas id="canEvents"></canvas>
                    <div class="text-center">
                        <button id="btnResetZoomEvents" class="btn btn-primary btn-xs" onclick="return false;"> Reset zoom </button>
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

<div class="modal fade" id="modalTranscribe" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="modalHeader" class="modal-title  text-center"></h4>
            </div>
            <div class="modal-body">
                <p id='transcribedData'></p>
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- /.Progress modal -->
<div class="modal fade" id="modalProgress" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="box box-solid">
                        <div class="box-header with-border text-center">
                            <h3 class="box-title">Speech to Text Transcription</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <p id='progressData'></p>
                            <div class="progress progress-sm active">
                                <div id='progressBar' class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                    aria-valuemax="100" style="width: 1%">
                                    <span  class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                    <!-- /.box -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- /.Image Modal -->
<div class="modal fade" id="modalImage" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="modalHeader" class="modal-title  text-center"></h4>
            </div>
            <div class="modal-body">
                <img class="img-responsive pad" id="pic" />
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-default pull-right" id="btnOCR">Try OCR</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
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
    $('#ddlSubject').change(function () {
        $('.overlay').show();
        var subject_number = $(this).val();
        var token = $("input[name='_token']").val();
        
        $.ajax({
            url: "{{ route('subjectContents') }}",
            method: 'POST',
            data: { subject_number: subject_number, _token: token },
            success: function (data) {
                $('#ddlContentNumber').html('');
                $('#ddlContentNumber').html(data.options);
                $('.overlay').hide();
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
        $(dataArray).each(function (i, field) {
            if (field.value.length == 0) {
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


        if (rank.length < 1) {
            error.push('Rank');
        }

        var growth;
        var radios = document.getElementsByName('growth');
        for (var i = 0, length = radios.length; i < length; i++) {
            if (radios[i].checked) {
                growth = radios[i].value;
                break;
            }
        }

        if (growth == undefined) {
            error.push('Growth');
        }

        if (error.length > 0) {
            swal("Need to fillup !", error.join("\n"), "error");
            return false;
        }

        $('.overlay').show();

        var test = 0;
        var subject = $("#ddlSubject").val();
        var contentNumber = $("#ddlContentNumber").val();
        var dateFrom = $("#txtFromDateInput").val();
        var dateTo = $("#txtToDateInput").val();
        var token = $("input[name='_token']").val();

        $.ajax({
            url: "{{ route('graphData') }}",
            method: 'POST',
            data: { 'test': test, 'subject': subject, 'contentNumber': contentNumber, 'rank': rank, 'dateFrom': dateFrom, 'dateTo': dateTo, 'growth': growth, _token: token },
            success: function (data) {
                $('.overlay').hide();

                if (data.contentInfo.totalViewCount.length == 0) {
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
                    if (dataset.label == 'Blocks') {
                        dataset.data = data.contentInfo.blocksForViewDensity;
                    }
                    if (dataset.label == 'View Density') {
                        dataset.data = data.contentInfo.indexedViewCount;
                    }
                });
                window.viewDensityChart.update();


                // Updating Events data to chart
                eventsData.labels = data.contentInfo.duration;
                eventsData.datasets.forEach(function (dataset) {
                    if (dataset.label == 'Blocks') {
                        dataset.data = data.contentInfo.blocksForEvents;
                    }
                    if (dataset.label == 'Pause') {
                        dataset.data = data.contentInfo.indexedPauseCount;
                    }
                    if (dataset.label == 'Rewind') {
                        dataset.data = data.contentInfo.indexedRewindCount;
                    }
                    if (dataset.label == 'Forward') {
                        dataset.data = data.contentInfo.indexedForwardCount;
                    }
                });
                window.eventsChart.update();


                // Updating Events Ratio data to chart
                var eventsRatio = [parseFloat(data.contentInfo.pauseRatio), parseFloat(data.contentInfo.rewindRatio), parseFloat(data.contentInfo.forwardRatio)];
                var eventsRatioColor = [window.chartColors.red, window.chartColors.green, window.chartColors.blue];

                eventsRatioData.datasets[0].data = eventsRatio;
                eventsRatioData.labels = ["Pause (" + parseFloat(data.contentInfo.pauseRatio) + "%)", "Rewind (" + parseFloat(data.contentInfo.rewindRatio) + "%)", "Forward (" + parseFloat(data.contentInfo.forwardRatio) + "%)"];
                window.eventsRatioChart.update();


                // Updating View Density data Per Count to chart
                viewDensityPerCountData.labels = data.contentInfo.duration;
                viewDensityPerCountData.datasets.forEach(function (dataset) {
                    if (dataset.label == 'Blocks') {
                        dataset.data = data.contentInfo.blocksForViewDensity;
                    }
                    if (dataset.label == 'View Density Per Count') {
                        dataset.data = data.contentInfo.indexedViewDensityPerCount;
                    }
                });
                window.viewDensityPerCountChart.update();

                // Updating audio data to chart
                audioGraphData.labels = data.contentInfo.duration;
                audioGraphData.datasets.forEach(function (dataset) {
                    if (dataset.label == 'Blocks') {
                        dataset.data = data.contentInfo.blocksForViewDensity;
                    }
                    if (dataset.label == 'View Density') {
                        dataset.data = data.contentInfo.indexedViewCount;
                    }
                });
                window.audioChart.update();
            },
            error: function (xhr, status, error) {
                swal("Sorry!", JSON.parse(xhr.responseText));
            }
        });
    });

    function fmtMSS(s) {
        return (s - (s %= 60)) / 60 + (9 < s ? ':' : ':0') + s
    }

    function clearData() {
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

    var ocrData;
    window.onload = function () {
        var startDate = new Date("2015-01-01");
        $("#txtFromDateInput").datepicker('setDate', startDate);

        var today = new Date();
        $("#txtToDateInput").datepicker('setDate', today.toString('yyyy-MM-dd'));
        clearData();


        //View Density chart initialization
        var canvasViewDensity = document.getElementById('canViewDensity');
        var ctxViewDensity = canvasViewDensity.getContext("2d");
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

        function chartClickEvent(event, array){
            var active = window.viewDensityChart.getElementAtEvent(event);
            console.log(active[0]._datasetIndex);
        }

        //canvasViewDensity.addEventListener('click', (event) => console.log(window.viewDensityChart.getBarsAtEvent(event)));
        

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
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero: true,
                            max: 100
                        }
                    }]
                }
            }
        });

        //View Density Per count chart initialization
        var ctxViewDensityPerCount = document.getElementById("canViewDensityPerCount").getContext("2d");
        window.viewDensityPerCountChart = new Chart(ctxViewDensityPerCount, {
            type: 'bar',
            data: viewDensityPerCountData,
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


        var options = {
            type: 'bar',
            data: audioGraphData,
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
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            reverse: false
                        }
                    }]
                }
            }
        }

        //Audio chart initialization
        var canAudio = document.getElementById('canAudio');
        var ctxAudio = canAudio.getContext("2d");
        window.audioChart = new Chart(ctxAudio, options);

       

        // Different Canvas
        var overlay = document.getElementById('overlay');
        var startIndex = 0;
        overlay.width = canAudio.width;
        overlay.height = canAudio.height;
        var selectionContext = overlay.getContext('2d');
        var selectionRect = {
            w: 0,
            startX: 0,
            startY: 0
        };
        var drag = false;
        canAudio.addEventListener('pointerdown', function(event) {
            const points = window.audioChart.getElementsAtEventForMode(event, 'index', {
                intersect: false
            });
            startIndex = points[0]._index;
            const rect = canAudio.getBoundingClientRect();
            selectionRect.startX = event.clientX - rect.left;
            selectionRect.startY = window.audioChart.chartArea.top;
            drag = true;
            // save points[0]._index for filtering
        });
        canAudio.addEventListener('pointermove', function(event) {

            const rect = canAudio.getBoundingClientRect();
            if (drag) {
                const rect = canAudio.getBoundingClientRect();
                selectionRect.w = (event.clientX - rect.left) - selectionRect.startX;
                selectionContext.globalAlpha = 0.5;
                selectionContext.clearRect(0, 0, canAudio.width, canAudio.height);
                selectionContext.fillRect(selectionRect.startX,
                    selectionRect.startY,
                    selectionRect.w,
                    window.audioChart.chartArea.bottom - window.audioChart.chartArea.top);
            } else {
                selectionContext.clearRect(0, 0, canAudio.width, canAudio.height);
                var x = event.clientX - rect.left;
                if (x > window.audioChart.chartArea.left) {
                    selectionContext.fillRect(x,
                        window.audioChart.chartArea.top,
                        1,
                        window.audioChart.chartArea.bottom - window.audioChart.chartArea.top);
                }
            }
        });
        canAudio.addEventListener('pointerup', function(event) {
            const points = window.audioChart.getElementsAtEventForMode(event, 'index', {
                intersect: false
            });
            drag = false;
            //console.log('implement filter between ' + options.data.labels[startIndex] + ' and ' + options.data.labels[points[0]._index]);
            var token = $("input[name='_token']").val();
            var contentNumber = $("#ddlContentNumber").val();
            var swFunction = document.getElementById('swFunction').checked;
            var route = swFunction ? "{{ route('image-to-text') }}" : "{{ route('speech-to-text') }}";

            $.ajax({
                url: route,
                method: 'POST',
                data: { 'startTime': options.data.labels[startIndex], 'endTime': options.data.labels[points[0]._index], 'contentNumber': contentNumber, _token: token },
                success: function (data) {
                    //console.log(document.getElementById('swFunction').checked);
                
                    if(swFunction){
                        ocrData =  drawText(1600, 900, data.penData);
                        var img = document.getElementById('pic');
                        img.src = ocrData;
                        $('#modalImage').modal('show');
                    }
                    else{
                        // Speech to text
                        var sentenceFlag = null;
                        var sentences = new Array();
                        if(sentences.length > 0){
                            sentenceFlag = data.words[0].transcript_number;
                        }
                        var sentenceWord = '';
                        data.words.forEach(function (word) {
                            if(sentenceFlag === word.transcript_number){
                                sentenceWord += word.word_kanji + ' ';
                            }
                            else{
                                sentences.push(sentenceWord);
                                sentenceWord = '';
                                sentenceFlag = word.transcript_number;
                            }
                            
                        });
                        $('#transcribedData').html(sentences.join("。"));
                        $('.overlay').hide();
                        $('#modalHeader').html("Transcribed audio with B&M AI Engine (" + options.data.labels[startIndex] + " - " + options.data.labels[points[0]._index] + ")");
                        //$('#transcribedData').html(data.kanji.join(" "));
                        $('#modalTranscribe').modal('show');
                    }
                }
            });
        });

    };

    $('#chkAll').click(function (event) {
        toggle(this);
    });

    function toggle(source) {
        checkboxes = document.getElementsByName('rank');
        for (var i = 0, n = checkboxes.length; i < n; i++) {
            checkboxes[i].checked = source.checked;
        }
    }

    function setRank(state) {
        $("input[name='rank']").each(function () {
            if (this.checked) {
                this.checked = !state;
            }
        });
    }

    $("[name='rank']").click(function (event) {
        $('#chkAll').attr('checked', false);
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

    // View Density per Total count
    var viewDensityPerCountData = {
        labels: [],
        datasets: [{
            type: 'line',
            label: 'View Density Per Count',
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

    $('#btnResetZoomDensityPerView').click(function () {
        window.viewDensityPerCountChart.resetZoom();
    });

    // View Density 
    var audioGraphData = {
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

    $('#btnTranscribe').click(function () {
        $('#modalProgress').modal('show');
        var interval = null;
        interval = setInterval(function(){
            $.get("{{ route('progress') }}", function (data) {
                //console.log(data);
                $('#progressBar').css("width", data[0]+"%");
                $('#progressData').html(data[1] + ', Processing ' + data[0]+"%");
                if(data[0] == 100)
                {
                    //clearInterval(interval);
                }
            });
        }, 10000);
        

        var token = $("input[name='_token']").val();
        var contentNumber = $("#ddlContentNumber").val();
        $.ajax({
            url: "{{ route('transcribe') }}",
            method: 'POST',
            data: { _token: token, contentNumber: contentNumber },
            success: function (data) {
                $('#modalProgress').modal('hide');
            },
            error: function(){
                clearInterval(interval);
            }
        });
    });

    $('#btnConvert').click(function () {
        $('.overlay').show();
        var token = $("input[name='_token']").val();
        var contentNumber = $("#ddlContentNumber").val();
        $.ajax({
            url: "{{ route('convert') }}",
            method: 'POST',
            data: { _token: token, contentNumber: contentNumber },
            success: function (data) {
                $('.overlay').hide();
                if (data.message == 'success') {
                    swal("Success !", "Converted uploaded to cloud storage", "success");
                }
                else {
                    swal("Error !", "TB content not found !", "warning");
                }
            }
        });
    });


    function drawText( width, height, frames ) {
        //frames = {
        //    x : number;
        //    y : number;
        //    p : number;
        //};
        var ALL_CLEAR = 255 ;
        var ERASER    =   0 ;
        var FREE_HAND =   1 ;

        var mode;
        var lineWidth ;
        var eraserWidth;
        var eraserHeight;
        var cache;
        var canvas;
        var ctx;


        canvas = document.createElement('canvas');
        canvas.width = width;
        canvas.height = height;
        ctx = canvas.getContext('2d');

        cache = null;

        frames.forEach( function( frame ){
            switch (frame.p){
                case 3 :
                    mode = ALL_CLEAR;
                    return;

                case -5    : // フリーハンド 赤マジック細
                case 5     : // フリーハンド 赤矢印細
                case 505   : // フリーハンド 赤チョーク細
                case -8    : // フリーハンド 青マジック細
                case 8     : // フリーハンド 青矢印細
                case 508   : // フリーハンド 青チョーク細
                case -11   : // フリーハンド 黒マジック細
                case 11    : // フリーハンド 黒矢印細
                case 511   : // フリーハンド 黒チョーク細
                case -14   : // フリーハンド 緑マジック細
                case 14    : // フリーハンド 緑矢印細
                case 514   : // フリーハンド 緑チョーク細
                case -17   : // フリーハンド 黄マジック細
                case 17    : // フリーハンド 黄矢印細
                case 517   : // フリーハンド 黄チョーク細
                case -20   : // フリーハンド 白マジック細
                case 20    : // フリーハンド 白矢印細
                case 520   : // フリーハンド 白チョーク細
                case -23   : // フリーハンド 桃マジック細
                case 23    : // フリーハンド 桃矢印細
                case 523   : // フリーハンド 桃チョーク細
                    mode = FREE_HAND;
                    lineWidth =  1;
                    break;

                case -1    : // フリーハンド 赤マジック普通
                case 1     : // フリーハンド 赤矢印普通
                case 501   : // フリーハンド 赤チョーク普通
                case -6    : // フリーハンド 青マジック普通
                case 6     : // フリーハンド 青矢印普通
                case 506   : // フリーハンド 青チョーク普通
                case -9    : // フリーハンド 黒マジック普通
                case 9     : // フリーハンド 黒矢印普通
                case 509   : // フリーハンド 黒チョーク普通
                case -12   : // フリーハンド 緑マジック普通
                case 12    : // フリーハンド 緑矢印普通
                case 512   : // フリーハンド 緑チョーク普通
                case -15   : // フリーハンド 黄マジック普通
                case 15    : // フリーハンド 黄矢印普通
                case 515   : // フリーハンド 黄チョーク普通
                case -18   : // フリーハンド 白マジック普通
                case 18    : // フリーハンド 白矢印普通
                case 518   : // フリーハンド 白チョーク普通
                case -21   : // フリーハンド 桃マジック普通
                case 21    : // フリーハンド 桃矢印普通
                case 521   : // フリーハンド 桃チョーク普通
                    mode = FREE_HAND;
                    lineWidth =  2;
                    break;

                case -4    : // フリーハンド 赤マジック太
                case 4     : // フリーハンド 赤矢印太
                case 504   : // フリーハンド 赤チョーク太
                case -7    : // フリーハンド 青マジック太
                case 7     : // フリーハンド 青矢印太
                case 507   : // フリーハンド 青チョーク太
                case -10   : // フリーハンド 黒マジック太
                case 10    : // フリーハンド 黒矢印太
                case 510   : // フリーハンド 黒チョーク太
                case -13   : // フリーハンド 緑マジック太
                case 13    : // フリーハンド 緑矢印太
                case 513   : // フリーハンド 緑チョーク太
                case -16   : // フリーハンド 黄マジック太
                case 16    : // フリーハンド 黄矢印太
                case 516   : // フリーハンド 黄チョーク太
                case -19   : // フリーハンド 白マジック太
                case 19    : // フリーハンド 白矢印太
                case 519   : // フリーハンド 白チョーク太
                case -22   : // フリーハンド 桃マジック太
                case 22    : // フリーハンド 桃矢印太
                case 522   : // フリーハンド 桃チョーク太
                    mode = FREE_HAND;
                    lineWidth =  4;
                    break;

                case 2201  : // 消しゴム大 カーソルのみ
                case 200   : // 消しゴム大 消す
                case 2111  : // 黒板消し大 カーソルのみ
                case 2101  : // 黒板消し大 消す
                    mode = ERASER;
                    eraserWidth = 62;
                    eraserHeight = 38;
                    break;

                case 2200  : // 消しゴム小 カーソルのみ
                case 2     : // 消しゴム小 消す
                case 2110  : // 黒板消し小 カーソルのみ
                case 2100  : // 黒板消し小 消す
                    mode = ERASER;
                    eraserWidth = 31;
                    eraserHeight = 19;
                    break;

                case 3202  : // 極小消しゴム太 カーソルのみ
                case 3102  : // 極小消しゴム大 消す
                    mode = ERASER;
                    eraserWidth  = 16;
                    eraserHeight = 16;
                    break;

                case 3201  : // 極小消しゴム中 カーソルのみ
                case 3101  : // 極小消しゴム中 消す
                    mode = ERASER;
                    eraserWidth  = 8;
                    eraserHeight = 8;
                    break;

                case 3200  : // 極小消しゴム小 カーソルのみ
                case 3100  : // 極小消しゴム小 消す
                    mode = ERASER;
                    eraserWidth  = 4;
                    eraserHeight = 4;
                    break;

                default :
                    mode = null;
                    cache = null;
                    return;
            }

            switch (mode){
                case ALL_CLEAR :{
                    ctx.clearRect( 0, 0, canvas.width, canvas.height);
                    cache = null;
                } break;

                case FREE_HAND : {
                    if ( null !== cache ){
                        if ( cache.p === frame.p ){
                            ctx.beginPath();
                            ctx.lineWidth = lineWidth;
                            ctx.moveTo(cache.x, cache.y);
                            ctx.lineTo(frame.x, frame.y);
                            ctx.stroke();
                        }
                    }
                    cache = frame;
                } break;

                case ERASER : {
                    if ( null !== cache ){
                        if ( cache.p === frame.p ){
                            switch( true ){
                                case ( cache.x === frame.x && cache.y === frame.y ) : {
                                    ctx.clearRect( frame.x, frame.y, eraserWidth, eraserHeight );
                                } break;

                                //動いた時
                                case ( cache.x === frame.x && cache.y > frame.y ) : {
                                    // 上に動いた時
                                    ctx.clearRect( frame.x, frame.y, eraserWidth, cache.y - frame.y + eraserHeight );
                                    break;
                                }

                                case ( cache.x < frame.x && cache.y > frame.y ) : {
                                    // 右上に動いた時
                                    ctx.save();

                                    ctx.beginPath();

                                    ctx.moveTo( frame.x, frame.y );
                                    ctx.lineTo( frame.x + eraserWidth, frame.y );
                                    ctx.lineTo( frame.x + eraserWidth, frame.y + eraserHeight );
                                    ctx.lineTo( cache.x + eraserWidth, cache.y + eraserHeight );
                                    ctx.lineTo( cache.x, cache.y + eraserHeight );
                                    ctx.lineTo( cache.x, cache.y );
                                    ctx.closePath();

                                    ctx.clip();

                                    ctx.clearRect(
                                        cache.x,
                                        frame.y,
                                        frame.x - cache.x + eraserWidth,
                                        cache.y - frame.y + eraserHeight
                                    );

                                    ctx.restore();
                                    break;
                                }

                                case ( cache.x < frame.x && cache.y === frame.y ) : {
                                    // 右に動いた時
                                    ctx.clearRect(
                                        cache.x,
                                        cache.y,
                                        frame.x - cache.x + eraserWidth,
                                        eraserHeight
                                    );
                                    break;
                                }

                                case ( cache.x < frame.x && cache.y < frame.y ) : {
                                    // 右下に動いた時
                                    ctx.save();
                                    ctx.beginPath();

                                    ctx.moveTo( cache.x, cache.y );
                                    ctx.lineTo( cache.x + eraserWidth, cache.y );
                                    ctx.lineTo( frame.x + eraserWidth, frame.y );
                                    ctx.lineTo( frame.x + eraserWidth, frame.y + eraserHeight );
                                    ctx.lineTo( frame.x, frame.y + eraserHeight );
                                    ctx.lineTo( cache.x, cache.y + eraserHeight );
                                    ctx.closePath();

                                    ctx.clip();

                                    ctx.clearRect(
                                        cache.x,
                                        cache.y,
                                        frame.x - cache.x + eraserWidth,
                                        frame.y - cache.y + eraserHeight
                                    );

                                    ctx.restore();
                                    break;
                                }

                                case ( cache.x === frame.x && cache.y < frame.y ) : {
                                    // 下に動いた時
                                    ctx.clearRect(
                                        cache.x,
                                        cache.y,
                                        eraserWidth,
                                        frame.y - cache.y + eraserHeight
                                    );
                                    break;
                                }

                                case ( cache.x > frame.x && cache.y < frame.y ) : {
                                    // 左下に動いた時
                                    ctx.save();
                                    ctx.beginPath();

                                    ctx.moveTo( cache.x, cache.y );
                                    ctx.lineTo( cache.x + eraserWidth, cache.y );
                                    ctx.lineTo( cache.x + eraserWidth, cache.y + eraserHeight );
                                    ctx.lineTo( frame.x + eraserWidth, frame.y + eraserHeight );
                                    ctx.lineTo( frame.x, frame.y + eraserHeight );
                                    ctx.lineTo( frame.x, frame.y );
                                    ctx.closePath();

                                    ctx.clip();

                                    ctx.clearRect(
                                        frame.x,
                                        cache.y,
                                        cache.x - frame.x + eraserWidth,
                                        frame.y - cache.y + eraserHeight
                                    );

                                    ctx.restore();
                                    break;
                                }

                                case ( cache.x > frame.x && cache.y === frame.y ) : {
                                    // 左に動いた時
                                    ctx.clearRect(
                                        frame.x,
                                        frame.y,
                                        cache.x - frame.x + eraserWidth,
                                        eraserHeight
                                    );
                                    break;
                                }

                                case ( cache.x > frame.x && cache.y > frame.y ) : {
                                    // 左上に動いた時
                                    ctx.save();
                                    ctx.beginPath();

                                    ctx.moveTo( frame.x, frame.y );
                                    ctx.lineTo( frame.x + eraserWidth, frame.y );
                                    ctx.lineTo( cache.x + eraserWidth, cache.y );
                                    ctx.lineTo( cache.x + eraserWidth, cache.y + eraserHeight );
                                    ctx.lineTo( cache.x, cache.y + eraserHeight );
                                    ctx.lineTo( frame.x, frame.y + eraserHeight );
                                    ctx.closePath();

                                    ctx.clip();

                                    ctx.clearRect(
                                        frame.x,
                                        frame.y,
                                        cache.x - frame.x + eraserWidth,
                                        cache.y - frame.y + eraserHeight
                                    );

                                    ctx.restore();
                                    break;
                                }
                            }
                        }
                    }
                    cache = frame;
                } break;
            }
        } );

        return canvas.toDataURL('image/png');
    }

    $('#btnOCR').click(function () {
        var token = $("input[name='_token']").val();
        $.ajax({
            url: "{{ route('ocr') }}",
            method: 'POST',
            data: { _token: token, ocrData: ocrData },
            success: function (data) {
                console.log(data);
            }
        });
    });



</script> @stop