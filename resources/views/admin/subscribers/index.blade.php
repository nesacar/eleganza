@extends('admin.index')

@section('bredcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('home') }}">Home</a></li>
        <li class="active">Pretplatnici</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">Pretplatnici</h3>
                    <div class="panel-control">
                        <a href="{{ url('admin/subscribers/create') }}" data-toggle="tooltip" data-placement="top" title="" class="panel-reload" data-original-title="Kreiraj pretplatnika"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="panel-header-stats">
                        {!! Form::open(['action' => ['SubscribersController@search'], 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'formica']) !!}
                        <div class="col-sm-6">{!! Form::text('text', \Session::get('sub_email'), array('class' => 'sele')) !!}</div>
                        <div class="col-sm-6"><input type="submit" value="Pretaga" class="btn btn-success"></div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="panel-body">
                    <div class="panel-header-stats">
                        @if(count($subscribers) > 0)
                            <div class="row">
                                <div class="col-md-3">
                                    <b>Naziv</b>
                                </div>
                                <div class="col-md-3">
                                    <b>Blokiran</b>
                                </div>
                                <div class="col-md-2">
                                    <b>Jezik</b>
                                </div>
                                <div class="col-md-2">
                                    <b>Prijavljen</b>
                                </div>
                                <div class="col-md-2">
                                    <b class="pull-right">Uredi</b>
                                </div>
                            </div>
                            <hr>
                            @foreach($subscribers as $s)
                                <div class="row @if($s->block == 1) crvena @endif">
                                    <div class="col-md-3 vcenter">
                                        {{ $s->email }}
                                    </div>
                                    <div class="col-md-3 vcenter-2">
                                        {!! Form::checkbox('publish', 1, $s->block, ['id' => $s->id, 'name' => 'primary[]', 'class' => 'switch-state', 'data-on-color' => 'success', 'data-off-color' => 'danger', 'data-on-text' => 'DA', 'data-off-text' => 'NE']) !!}
                                    </div>
                                    <div class="col-md-2 vcenter">
                                        {{ $s->locale }}
                                    </div>
                                    <div class="col-md-2 vcenter">
                                        {{ \Jenssegers\Date\Date::parse($s->created_at)->format('d/m/Y H:m:s') }}
                                    </div>
                                    <div class="col-md-2">
                                        <div class="btn-group pull-right" role="group" aria-label="...">
                                            <a  type="button" class="btn btn-success" href="{{ URL::action('SubscribersController@edit', $s->id) }}">uredi</a>
                                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="glyphicon glyphicon-triangle-bottom"></i></button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                <li><a href="{{ URL::action('SubscribersController@delete', $s->id) }}" onclick="return confirm('Da li ste sigurni da hoćete da obrišete ovog pretplatnika?')" title="Obrišite radno vreme">obriši</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    {!! str_replace('/?', '?', $subscribers->render()) !!}
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <p>Nema pretplatnika</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var sw = $('.switch-state');


    sw.bootstrapSwitch();

    sw.on('switchChange.bootstrapSwitch', function (e, data) {

    $('#myswitch').bootstrapSwitch('state', !data, true);
        var id = $(this).attr('id');
        var link = 'subscribers/publish/' + id;
        $.get(link, {id: id, val:data}, function($stat){ if($stat=='da'){ save(); $('#'+id).parent().parent().parent().parent().toggleClass('crvena'); }else{ error(); } });
    });

    @if(Session::has('done'))
        toastr["success"]("{{ Session::get('done') }}");
    @endif

    @if(Session::has('error'))
        toastr["error"]("{{ Session::get('error') }}");
    @endif

    function save(){
        toastr["success"]("Izmenjeno");
    }

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

@endsection