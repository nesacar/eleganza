@extends('admin.index')

@section('bredcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('home') }}">Home</a></li>
        <li class="active">Kuponi</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title"><i class="fa fa-money rokni-desno" aria-hidden="true" ></i>Kuponi</h3>
                    <div class="panel-control">
                        <a href="{{ url('admin/coupons/create') }}" data-toggle="tooltip" data-placement="top" title="" class="panel-reload" data-original-title="Kreiraj kupon"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="panel-header-stats">
                        @if(count($coupons) > 0)
                            <div class="row">
                                <div class="col-md-1">
                                    <b>ID</b>
                                </div>
                                <div class="col-md-3">
                                    <b>Kod</b>
                                </div>
                                <div class="col-md-2">
                                    <b>Aktivno od</b>
                                </div>
                                <div class="col-md-2">
                                    <b>Aktivno do</b>
                                </div>
                                <div class="col-md-2">
                                    <b>Upotrebljeno</b>
                                </div>
                                <div class="col-md-2">
                                    <b class="pull-right">Uredi</b>
                                </div>
                            </div>
                            <hr>
                            @foreach($coupons as $c)
                                <div class="row @if($c->publish == 1) zelena2 @endif">
                                    <div class="col-md-1 vcenter">
                                        {{ $c->id }}
                                    </div>
                                    <div class="col-md-3 vcenter">
                                        {{ $c->code }}
                                    </div>
                                    <div class="col-md-2 vcenter">
                                        @if($c->forever)
                                            neograničeno
                                        @else
                                            {{ \Carbon\Carbon::parse($c->publish_at)->format('d-m-Y h:m:s') }}
                                        @endif
                                    </div>
                                    <div class="col-md-2 vcenter">
                                        @if($c->forever)
                                            neograničeno
                                        @else
                                            {{ \Carbon\Carbon::parse($c->valid_at)->format('d-m-Y h:m:s') }}
                                        @endif
                                    </div>
                                    <div class="col-md-2">
                                        {!! Form::checkbox('publish', 1, $c->publish, ['id' => $c->id, 'name' => 'primary[]', 'class' => 'switch-state', 'data-on-color' => 'success', 'data-off-color' => 'danger', 'data-on-text' => 'DA', 'data-off-text' => 'NE']) !!}
                                    </div>
                                    <div class="col-md-2">
                                        <div class="btn-group pull-right" role="group" aria-label="...">
                                            <a  type="button" class="btn btn-success" href="{{ URL::action('CouponsController@edit', $c->id) }}">uredi</a>
                                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="glyphicon glyphicon-triangle-bottom"></i></button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                <li><a href="{{ URL::action('CouponsController@delete', $c->id) }}" onclick="return confirm('Da li ste sigurni da hoćete da obrišete ovaj kupon?')" title="Obrišite atribut">obriši</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    {!! str_replace('/?', '?', $coupons->render()) !!}
                                </div>
                            </div>
                        @else
                            <p>Nema dostupnih kupona</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')

    $('.switch-state').bootstrapSwitch();

    @if(Session::has('done'))
        toastr["success"]("{{ Session::get('done') }}");
    @endif

    @if(Session::has('error'))
        toastr["error"]("{{ Session::get('error') }}");
    @endif

    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var sw = $('.switch-state');


    sw.bootstrapSwitch();

    sw.on('switchChange.bootstrapSwitch', function (e, data) {

    $('#myswitch').bootstrapSwitch('state', !data, true);
        var id = $(this).attr('id');
        var link = 'coupons/publish/' + id;
        $.get(link, {id: id, val:data}, function($stat){ if($stat=='da'){ save(); $('#'+id).parent().parent().parent().parent().toggleClass('zelena2'); }else{ error(); } });
    });

    function save(){
        toastr["success"]("Izmenjeno");
    }
    function error(){
        toastr["error"]("Došlo je do greške");
    }

@endsection