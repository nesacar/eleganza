@extends('admin.index')

@section('bredcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('home') }}">Home</a></li>
        <li class="active">Šabloni</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title"><i class="fa fa-th-large rokni-desno" aria-hidden="true" ></i>Šabloni</h3>
                    <div class="panel-control">
                        <a href="{{ url('admin/blocks/create') }}" data-toggle="tooltip" data-placement="top" title="" class="panel-reload" data-original-title="Kreiraj šablon"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="panel-header-stats">
                        @if(count($blocks) > 0)
                            <div class="row">
                                <div class="col-md-1">
                                    <b>ID</b>
                                </div>
                                <div class="col-md-5">
                                    <b>Naziv</b>
                                </div>
                                <div class="col-md-3">
                                    <b>Publikovano</b>
                                </div>
                                <div class="col-md-3">
                                    <b class="pull-right">Uredi</b>
                                </div>
                            </div>
                            <hr>
                            @foreach($blocks as $b)
                                <div class="row @if($b->publish == 0) crvena @endif">
                                    <div class="col-md-1 vcenter">
                                        {{ $b->id }}
                                    </div>
                                    <div class="col-md-5 vcenter">
                                        {{ $b->title }}
                                    </div>
                                    <div class="col-md-3">
                                        {!! Form::checkbox('publish', 1, $b->publish, ['id' => $b->id, 'name' => 'primary[]', 'class' => 'switch-state', 'data-on-color' => 'success', 'data-off-color' => 'danger', 'data-on-text' => 'DA', 'data-off-text' => 'NE']) !!}
                                    </div>
                                    <div class="col-md-3">
                                        <div class="btn-group pull-right" role="group" aria-label="...">
                                            <a  type="button" class="btn btn-success" href="{{ URL::action('BlocksController@edit', $b->id) }}">uredi</a>
                                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="glyphicon glyphicon-triangle-bottom"></i></button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                <li><a href="{{ URL::action('BlocksController@delete', $b->id) }}" onclick="return confirm('Da li ste sigurni da hoćete da obrišete ovaj šablon?')" title="Obrišite osobinu">obriši</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>Nema dostupnih šablona</p>
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
        var link = 'blocks/publish/' + id;
        $.get(link, {id: id, val:data}, function($stat){ if($stat=='da'){ save(); $('#'+id).parent().parent().parent().parent().toggleClass('crvena'); }else{ error(); } });
    });

    function save(){
        toastr["success"]("Izmenjeno");
    }
    function error(){
        toastr["error"]("Došlo je do greške");
    }

@endsection