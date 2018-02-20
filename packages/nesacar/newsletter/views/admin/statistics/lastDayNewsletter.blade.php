@extends('admin.index')

@section('header')
    {!! HTML::style('admin/plugins/select2/css/select2.min.css') !!}
    {!! HTML::style('admin/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') !!}
@endsection

@section('bredcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('home') }}">Home</a></li>
        <li><a href="{{ url('admin/newsletters/'.$newsletter->id.'/edit') }}">Newsletteri</a></li>
        <li class="active">Statistika Newslettera</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-body">
                    <div class="widget">
                        <h3 class="section-title"><i class="fa fa-area-chart"></i> Statistika za Newsletter: {{ $newsletter->title }}</h3>
                        <div class="col-sm-8">
                            <ul class="nav nav-pills">
                                <li><a href="{{ url('admin/statistics/'.$newsletter->id.'/dayNewsletter') }}">Danas</a></li>
                                <li><a href="{{ url('admin/statistics/'.$newsletter->id.'/monthNewsletter') }}">Ovog meseca</a></li>
                                <li><a href="{{ url('admin/statistics/'.$newsletter->id.'/yearNewsletter') }}">Ove godine</a></li>
                                <li @if(!$search) class="active" @endif><a href="{{ url('admin/statistics/'.$newsletter->id.'/lastDayNewsletter') }}">Juče</a></li>
                                <li><a href="{{ url('admin/statistics/'.$newsletter->id.'/lastMonthNewsletter') }}">Prošlog meseca</a></li>
                                <li><a href="{{ url('admin/statistics/'.$newsletter->id.'/lastYearNewsletter') }}">Prošle godine</a></li>
                            </ul>
                        </div>
                        <div class="col-sm-4">
                            <ul class="nav nav-pills pull-right">
                                @if(false)
                                    <li class="active"><a href="#"> Porudžbine</a></li>
                                    <li><a href="#"> Vrednost korpe</a></li>
                                @endif
                            </ul>
                        </div>
                        <div style="clear: both;"></div>
                        <div class="widget-content-white">
                            <div class="shadowed-bottom bottom-margin">
                                <div class="row">
                                    <div class="col-lg-6 col-md-8 col-sm-6 bordered">
                                        <div class="value-block value-bigger changed-up some-left-padding">
                                            <div class="value-self">
                                                {!! Form::open(['action' => ['StatisticsController@searchSubscribers'], 'method' => 'POST', 'id' => 'formica']) !!}
                                                {!! Form::hidden('start', $start_date) !!}
                                                {!! Form::hidden('end', $end_date) !!}
                                                {!! Form::hidden('newsletter', $newsletter->id) !!}
                                                <span class="klik">
                                                @if($sum%10==1)
                                                        {{ $sum }} klik
                                                    @elseif($sum%10<5)
                                                        {{ $sum }} klika
                                                    @else
                                                        {{ $sum }} klikova
                                                    @endif
                                                    </span>
                                                @if(false)
                                                    <span class="changed-icon"><i class="icon-caret-up"></i></span>
                                                    <span class="changed-value">+5.00%</span>
                                                @endif
                                                {!! Form::close() !!}
                                            </div>
                                            @if($average == 0)
                                                <div class="value-sub">Prosek je manji od jednog klika po satu</div>
                                            @elseif($average%10<4)
                                                <div class="value-sub">Prosek od {{ round($sum/24) }} klika po satu</div>
                                            @else
                                                <div class="value-sub">Prosek od {{ round($sum/24) }} klikova po satu</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-4 col-sm-6">
                                        {!! Form::open(['action' => ['StatisticsController@searchNewsletter'], 'method' => 'POST', 'class' => 'form-inline form-period-selector']) !!}
                                        {!! Form::hidden('newsletter', $newsletter->id) !!}
                                        <label class="control-label">Vremenski period:</label><br>
                                        @if(\Session::get('search_od') || \Session::get('search_do'))
                                            {!! Form::text('od', \Session::get('search_od'), ['id' => 'od', 'class' => 'form-control input-sm', 'placeholder' => 'Od']) !!}
                                            {!! Form::text('do', \Session::get('search_do'), ['id' => 'do', 'class' => 'form-control input-sm', 'placeholder' => 'Do']) !!}
                                        @else
                                            {!! Form::text('od', null, ['id' => 'od', 'class' => 'form-control input-sm', 'placeholder' => 'Od']) !!}
                                            {!! Form::text('do', null, ['id' => 'do', 'class' => 'form-control input-sm pokazi', 'placeholder' => 'Do']) !!}
                                        @endif
                                        <input type="submit" value="Pretraga" class="form-control input-sm btn-success smanji">
                                        <a class="remove form-control input-sm btn-danger smanji" href="{{ url('admin/statistics/'.$newsletter->id.'/dayNewsletter') }}">X</a>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                            <div class="padded">
                                <canvas id="myChart" width="400" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .row -->

@endsection

@section('footer')
    {!! HTML::script('admin/plugins/moment/moment.js') !!}
    {!! HTML::script('admin/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') !!}
    {!! HTML::script('admin/plugins/select2/js/select2.min.js') !!}
    {!! HTML::script('admin/plugins/charts/Chart.min.js') !!}
@endsection

@section('footer_scripts')

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $('#od').datetimepicker({format: 'YYYY-MM-DD HH:mm'});
    $('#do').datetimepicker({format: 'YYYY-MM-DD HH:mm'});

    $('.klik').click(function(){
    $('#formica').submit();
    });

    var ctx = document.getElementById("myChart");

    var data = {
    labels: [
    @for($i=$hour+1;$i<24;$i++)
        "{{ $i }}h",
    @endfor
    @for($i=0;$i<=$hour;$i++)
        "{{ $i }}h",
    @endfor
    ],
    datasets: [
    {
    label: "Broj klikova",
    fill: false,
    lineTension: 0.1,
    backgroundColor: "rgba(75,192,192,0.4)",
    borderColor: "rgba(75,192,192,1)",
    borderCapStyle: 'butt',
    borderDash: [],
    borderDashOffset: 0.0,
    borderJoinStyle: 'miter',
    pointBorderColor: "rgba(75,192,192,1)",
    pointBackgroundColor: "#fff",
    pointBorderWidth: 1,
    pointHoverRadius: 1,
    pointHoverBackgroundColor: "rgba(75,192,192,1)",
    pointHoverBorderColor: "rgba(220,220,220,1)",
    pointHoverBorderWidth: 2,
    pointRadius: 1,
    pointHitRadius: 10,
    @if(count($clicks) > 0)
        data: [ @foreach($clicks as $c) {{ $c }}, @endforeach ],
    @else
        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    @endif
    spanGaps: false,
    }
    ]
    };

    var options = [{
    responsive: true
    }];

    var myLineChart = new Chart.Line(ctx, {
    data: data,
    options: options
    });

    @if (Session::has('save'))
        $.notify({
        message: '{{ \Session::get('save') }}'
        },{
        type: 'success'
        });
    @endif

    function save(){
    $.notify({
    message: 'Izmenjeno'
    },{
    type: 'success'
    });
    }
    @if (Session::has('error'))
        $.notify({
        message: '{{ \Session::get('error') }}'
        },{
        type: 'danger'
        });
    @endif
@endsection