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
                        <div class="widget">
                            <h3 class="section-title"><i class="fa fa-area-chart"></i> Statistika</h3>
                            <div class="col-sm-8">
                                <ul class="nav nav-pills">
                                    <li class="active"><a href="#">Dan</a></li>
                                    <li><a href="#">Mesec</a></li>
                                    <li><a href="#">Godina</a></li>
                                    <li><a href="#">Dan-1</a></li>
                                    <li><a href="#">Mesec-1</a></li>
                                    <li><a href="#">Godina-1</a></li>
                                </ul>
                            </div>
                            <div class="col-sm-4">
                                <ul class="nav nav-pills pull-right">
                                    <li class="active"><a href="#"> Porudžbine</a></li>
                                    <li><a href="#"> Vrednost korpe</a></li>
                                </ul>
                            </div>
                            <div style="clear: both;"></div>
                            <div class="widget-content-white">
                                <div class="shadowed-bottom bottom-margin">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-5 col-sm-6 bordered">
                                            <div class="value-block value-bigger changed-up some-left-padding">
                                                <div class="value-self">
                                                    45.540 RSD
                                                    @if(false)
                                                        <span class="changed-icon"><i class="icon-caret-up"></i></span>
                                                        <span class="changed-value">+5.00%</span>
                                                    @endif
                                                </div>
                                                <div class="value-sub">Prosek od 4.458 po danu</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-3 visible-md visible-lg bordered">
                                            <div class="value-block text-center">
                                                <div class="value-self">520</div>
                                                <div class="value-sub">Ukupne prodaje</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-4 col-sm-6">
                                            <form class="form-inline form-period-selector">
                                                <label class="control-label">Vremenski period:</label><br>
                                                <input id="od" type="text" placeholder="od" class="form-control input-sm">
                                                <input id="do" type="text" placeholder="do" class="form-control input-sm">
                                                <input type="submit" value="Primeni" class="form-control input-sm btn-success">
                                            </form>
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
    var sw = $('.switch-state');
    sw.bootstrapSwitch();

    sw.on('switchChange.bootstrapSwitch', function (e, data) {

    $('#myswitch').bootstrapSwitch('state', !data, true);
    var id = $(this).attr('id');
    var link = 'posts/publish/' + id;
    $.get(link, {id: id, val:data}, function($stat){ if($stat=='da'){ save(); $('#'+id).parent().parent().parent().parent().toggleClass('crvena'); }else{ error(); } });
    });

    $('#od').datetimepicker({format: 'YYYY-MM-DD HH:mm'});
    $('#do').datetimepicker({format: 'YYYY-MM-DD HH:mm'});

    var ctx = document.getElementById("myChart");

    var data = {
    labels: ["Januar", "Februar", "Mart", "April", "Maj", "Jun", "Jul", "Avgust", "Septembar", "Oktobar", "Novembar", "Decembar"],
    datasets: [
    {
    label: "Vrednost porudžbine",
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
    pointHoverRadius: 5,
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
    function error(){
    $.notify({
    message: 'Proizvod nije pronadjen.'
    },{
    type: 'danger'
    });
    }
@endsection