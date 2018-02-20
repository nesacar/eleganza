@extends('admin.index')

@section('bredcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('home') }}">Home</a></li>
        <li class="active">Newsletteri</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">Newsletteri</h3>
                    <div class="panel-control">
                        <a href="{{ url('admin/newsletters/create') }}" data-toggle="tooltip" data-placement="top" title="" class="panel-reload" data-original-title="Kreiraj newsletter"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="panel-header-stats">
                        @if(count($newsletters) > 0)
                            <div class="row">
                                <div class="col-md-3">
                                    <b>Naziv</b>
                                </div>
                                <div class="col-md-3">
                                    <b>Jezik</b>
                                </div>
                                <div class="col-md-3">
                                    <b>Poslato</b>
                                </div>
                                <div class="col-md-3">
                                    <b class="pull-right">Uredi</b>
                                </div>
                            </div>
                            <hr>
                            @foreach($newsletters as $n)
                                <div class="row @if($n->last_send == null) crvena @endif">
                                    <div class="col-md-3 vcenter">
                                        {{ $n->title }}
                                    </div>
                                    <div class="col-md-3 vcenter">
                                        {{ $n->language->fullname }}
                                    </div>
                                    <div class="col-md-3 vcenter">
                                        @if($n->last_send != null) {{ \Carbon\Carbon::parse($n->last_send)->format('d/m/Y') }} @else Nije poslato @endif
                                    </div>
                                    <div class="col-md-3">
                                        <div class="btn-group pull-right" role="group" aria-label="...">
                                            <a type="button" class="btn btn-success" href="{{ URL::action('NewslettersController@preview', $n->id) }}" target="_blank">pregled</a>
                                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="glyphicon glyphicon-triangle-bottom"></i></button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                <li><a href="{{ URL::action('NewslettersController@edit', $n->id) }}">uredi</a></li>
                                                <li><a href="{{ URL::action('NewslettersController@send', $n->id) }}">pošalji</a></li>
                                                <li><a href="{{ url('admin/statistics/'.$n->id.'/yearNewsletter') }}">statistika</a></li>
                                                <li><a href="{{ URL::action('NewslettersController@delete', $n->id) }}" onclick="return confirm('Da li ste sigurni da hoćete da obrišete ovaj Newsletter?')" title="Obrišite članak">obriši</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    {!! str_replace('/?', '?', $newsletters->render()) !!}
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
        var link = 'posts/publish/' + id;
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