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
                <div class="panel-heading clearfix" style="margin-bottom: 15px">
                    <h3 class="section-title"><i class="fa fa-area-chart"></i> Statistika za Newsletter: {{ $newsletter->title }}</h3>
                </div>
                <div class="panel-body">
                    <div class="widget">
                        <h3 class="section-title"><i class="fa fa-area-chart"></i> Statistika za korpu</h3>
                        <div class="col-sm-8">
                            <ul class="nav nav-pills">
                                <li class="active"><a href="{{ url('admin/statistics/day') }}">Danas</a></li>
                                <li><a href="{{ url('admin/statistics/month') }}">Ovog meseca</a></li>
                                <li><a href="{{ url('admin/statistics/year') }}">Ove godine</a></li>
                                <li><a href="{{ url('admin/statistics/lastDay') }}">Juče</a></li>
                                <li><a href="{{ url('admin/statistics/lastMonth') }}">Prošlog meseca</a></li>
                                <li><a href="{{ url('admin/statistics/lastYear') }}">Prošle godine</a></li>
                            </ul>
                        </div>
                        <div class="col-sm-4">
                            <ul class="nav nav-pills pull-right">
                                @if(isset($order) && $order)
                                    <li class="active"><a href="{{ url('admin/statistics/dayOrder') }}"> Porudžbine</a></li>
                                    <li><a href="{{ url('admin/statistics/day') }}"> Vrednost korpe</a></li>
                                @else
                                    <li><a href="{{ url('admin/statistics/dayOrder') }}"> Porudžbine</a></li>
                                    <li class="active"><a href="{{ url('admin/statistics/day') }}"> Vrednost korpe</a></li>
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
                                                @if(isset($order) && $order)
                                                    Broj porudžbina: {{ $sum }}
                                                @else
                                                    Ukupna suma: {{ $sum }} RSD
                                                @endif
                                                @if(false)
                                                    <span class="changed-icon"><i class="icon-caret-up"></i></span>
                                                    <span class="changed-value">+5.00%</span>
                                                @endif
                                            </div>
                                            @if($average == 0)
                                                @if(isset($order) && $order)
                                                    <div class="value-sub">Prosek je manji od jedne porudžbine po satu</div>
                                                @else
                                                    <div class="value-sub">Prosek je manji od jednog RSD po satu</div>
                                                @endif
                                            @else
                                                @if(isset($order) && $order)
                                                    <div class="value-sub">Prosek od {{ round($sum/24) }} porudžbine po satu</div>
                                                @else
                                                    <div class="value-sub">Prosek od {{ round($sum/24) }} RSD po satu</div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-4 col-sm-6">
                                        @if(isset($order) && $order)
                                            {!! Form::open(['action' => ['StatisticsController@searchOrder'], 'method' => 'POST', 'class' => 'form-inline form-period-selector']) !!}
                                        @else
                                            {!! Form::open(['action' => ['StatisticsController@searchCart'], 'method' => 'POST', 'class' => 'form-inline form-period-selector']) !!}
                                        @endif
                                        <label class="control-label">Vremenski period:</label><br>
                                        {!! Form::text('od', null, ['id' => 'od', 'class' => 'form-control input-sm', 'placeholder' => 'Od']) !!}
                                        {!! Form::text('do', null, ['id' => 'do', 'class' => 'form-control input-sm pokazi', 'placeholder' => 'Do']) !!}
                                        <input type="submit" value="Pretraga" class="form-control input-sm btn-success smanji">
                                        <a class="remove form-control input-sm btn-danger smanji" href="{{ url('admin/statistics/remove') }}">X</a>
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
    @for($i=0;$i<24;$i++)
        "{{ $i }}h",
    @endfor
    ],
    datasets: [
    {
    @if(isset($order) && $order)
        label: "Na čekanju porudžbina",
    @else
        label: "Na čekanju RSD",
    @endif
    fill: false,
    lineTension: 0.1,
    backgroundColor: "{{ \App\Cart::bojaHDEX(0) }}",
    borderColor: "{{ \App\Cart::bojaHDEX(0) }}",
    borderCapStyle: 'butt',
    borderDash: [],
    borderDashOffset: 0.0,
    borderJoinStyle: 'miter',
    pointBorderColor: "{{ \App\Cart::bojaHDEX(0) }}",
    pointBackgroundColor: "#fff",
    pointBorderWidth: 1,
    pointHoverRadius: 1,
    pointHoverBackgroundColor: "rgba(75,192,192,1)",
    pointHoverBorderColor: "rgba(220,220,220,1)",
    pointHoverBorderWidth: 2,
    pointRadius: 1,
    pointHitRadius: 10,
    @if(count($hold) > 0)
        data: [ @foreach($hold as $h) {{ $h }}, @endforeach ],
    @else
        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    @endif
    spanGaps: false,
    },
    {
    @if(isset($order) && $order)
        label: "Potvrđeno porudžbina",
    @else
        label: "Potvrđeno RSD",
    @endif
    fill: false,
    lineTension: 0.1,
    backgroundColor: "{{ \App\Cart::bojaHDEX(1) }}",
    borderColor: "{{ \App\Cart::bojaHDEX(1) }}",
    borderCapStyle: 'butt',
    borderDash: [],
    borderDashOffset: 0.0,
    borderJoinStyle: 'miter',
    pointBorderColor: "{{ \App\Cart::bojaHDEX(1) }}",
    pointBackgroundColor: "#fff",
    pointBorderWidth: 1,
    pointHoverRadius: 1,
    pointHoverBackgroundColor: "rgba(75,192,192,1)",
    pointHoverBorderColor: "rgba(220,220,220,1)",
    pointHoverBorderWidth: 2,
    pointRadius: 1,
    pointHitRadius: 10,
    @if(count($confirmed) > 0)
        data: [ @foreach($confirmed as $c) {{ $c }}, @endforeach ],
    @else
        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    @endif
    spanGaps: false,
    },
    {
    @if(isset($order) && $order)
        label: "Odbijeno porudžbina",
    @else
        label: "Odbijeno RSD",
    @endif
    fill: false,
    lineTension: 0.1,
    backgroundColor: "{{ \App\Cart::bojaHDEX(2) }}",
    borderColor: "{{ \App\Cart::bojaHDEX(2) }}",
    borderCapStyle: 'butt',
    borderDash: [],
    borderDashOffset: 0.0,
    borderJoinStyle: 'miter',
    pointBorderColor: "{{ \App\Cart::bojaHDEX(2) }}",
    pointBackgroundColor: "#fff",
    pointBorderWidth: 1,
    pointHoverRadius: 1,
    pointHoverBackgroundColor: "rgba(75,192,192,1)",
    pointHoverBorderColor: "rgba(220,220,220,1)",
    pointHoverBorderWidth: 2,
    pointRadius: 1,
    pointHitRadius: 10,
    @if(count($rejected) > 0)
        data: [ @foreach($rejected as $r) {{ $r }}, @endforeach ],
    @else
        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    @endif
    spanGaps: false,
    },
    {
    @if(isset($order) && $order)
        label: "Otkazano porudžbina",
    @else
        label: "Otkazano RSD",
    @endif
    fill: false,
    lineTension: 0.1,
    backgroundColor: "{{ \App\Cart::bojaHDEX(3) }}",
    borderColor: "{{ \App\Cart::bojaHDEX(3) }}",
    borderCapStyle: 'butt',
    borderDash: [],
    borderDashOffset: 0.0,
    borderJoinStyle: 'miter',
    pointBorderColor: "{{ \App\Cart::bojaHDEX(3) }}",
    pointBackgroundColor: "#fff",
    pointBorderWidth: 1,
    pointHoverRadius: 1,
    pointHoverBackgroundColor: "rgba(75,192,192,1)",
    pointHoverBorderColor: "rgba(220,220,220,1)",
    pointHoverBorderWidth: 2,
    pointRadius: 1,
    pointHitRadius: 10,
    @if(count($canceled) > 0)
        data: [ @foreach($canceled as $c) {{ $c }}, @endforeach ],
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