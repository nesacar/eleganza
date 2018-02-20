@extends('admin.index')

@section('bredcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('home') }}">Home</a></li>
        <li><a href="{{ url('admin/banners') }}">Baneri</a></li>
        <li class="active">Kreiranje</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title"><i class="fa fa-picture-o" style="margin-right: 5px"></i>Podaci o baneru</h4>
                </div>
                <div class="panel-body">
                    @include('admin.partials.errors')
                    {!! Form::open(['action' => ['BannersController@store'], 'method' => 'POST', 'class' => 'form-horizontal', 'files' => true]) !!}
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Naziv <span class="crvena-zvezdica">*</span></label>
                            <div class="col-sm-10">
                                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="link" class="col-sm-2 control-label">Link <span class="crvena-zvezdica">*</span></label>
                            <div class="col-sm-10">
                                {!! Form::text('link', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="width" class="col-sm-2 control-label">Širina <span class="crvena-zvezdica">*</span></label>
                            <div class="col-sm-10">
                                {!! Form::text('width', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="height" class="col-sm-2 control-label">Visina <span class="crvena-zvezdica">*</span></label>
                            <div class="col-sm-10">
                                {!! Form::text('height', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image" class="col-sm-2 control-label">Slika</label>
                            <div class="col-sm-10">
                                {!! Form::file('image') !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="publish" class="col-sm-2 control-label">Publikovano</label>
                            <div class="col-sm-10">
                                {!! Form::checkbox('publish', 1, false, ['class' => 'switch-state', 'data-on-color' => 'success', 'data-off-color' => 'danger', 'data-on-text' => 'DA', 'data-off-text' => 'NE', 'id' => 'active']) !!}
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="submit" class="btn btn-success pull-right" value="Dodaj">
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div><!-- .row -->

@endsection

@section('footer_scripts')
    var br=0;

    $('.switch-state').bootstrapSwitch();

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var sw = $('.odgovori').find('.switch-state');


    sw.bootstrapSwitch();

    sw.on('switchChange.bootstrapSwitch', function (e, data) {

    $('#myswitch').bootstrapSwitch('state', !data, true);
        var id = $(this).attr('id');
        var link = '{{ url("admin/banners/publish") }}/' + id;
        $.get(link, {id: id, val:data}, function($stat){ if($stat=='da'){ save(); $('#'+id).parent().parent().parent().parent().toggleClass('crvena'); }else{ error(); } });
    });

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


    @if (Session::has('done'))
        toastr["success"]("{{ Session::get('done') }}");

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
    @endif
@endsection