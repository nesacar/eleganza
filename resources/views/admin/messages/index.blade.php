@extends('admin.index')

@section('bredcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('home') }}">Home</a></li>
        <li class="active">Poruke</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">Poruke</h3>
                    <div class="panel-control">
                        <a href="{{ url('admin/messages/create') }}" data-toggle="tooltip" data-placement="top" title="" class="panel-reload" data-original-title="Kreiraj poruku"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="panel-header-stats">
                        @if(count($messages) > 0)
                            <div class="row">
                                <div class="col-md-3">
                                    <b>Proizvod</b>
                                </div>
                                <div class="col-md-3">
                                    <b>email</b>
                                </div>
                                <div class="col-md-3">
                                    <b>Kreirano</b>
                                </div>
                                <div class="col-md-3">
                                    <b class="pull-right">Akcija</b>
                                </div>
                            </div>
                            <hr>
                            @foreach($messages as $m)
                                <div class="row @if($m->seen == 0) crvena @endif">
                                    <div class="col-md-3 vcenter">
                                        {{ $m->product->{'title:hr'} }}
                                    </div>
                                    <div class="col-md-3 vcenter">
                                        {{ $m->email }}
                                    </div>
                                    <div class="col-md-3 vcenter">
                                        {{ $m->created_at }}
                                    </div>
                                    <div class="col-md-3">
                                        <div class="btn-group pull-right" role="group" aria-label="...">
                                            <a type="button" class="btn btn-success" href="{{ URL::action('MessagesController@edit', $m->id) }}">pregled</a>
                                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="glyphicon glyphicon-triangle-bottom"></i></button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                <li><a href="{{ URL::action('MessagesController@delete', $m->id) }}" onclick="return confirm('Da li ste sigurni da hoćete da obrišete ovu poruku?')" title="Obrišite poruku">obriši</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    {!! str_replace('/?', '?', $messages->render()) !!}
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <p>Nema poruka</p>
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
        var link = 'banners/publish/' + id;
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