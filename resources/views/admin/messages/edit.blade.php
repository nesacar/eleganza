@extends('admin.index')

@section('bredcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('home') }}">Home</a></li>
        <li><a href="{{ url('admin/messages') }}">Poruke</a></li>
        <li class="active">Izmena</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title"><i class="fa fa-picture-o" style="margin-right: 5px"></i>Podaci o poruci</h4>
                </div>
                <div class="panel-body">
                    @include('admin.partials.errors')
                    {!! Form::open(['action' => ['MessagesController@update', $message->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
                        <div class="form-group">
                            <label for="product_id" class="col-sm-2 control-label">Product ID <span class="crvena-zvezdica">*</span></label>
                            <div class="col-sm-10">
                                {!! Form::text('product_id', $message->product_id, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email <span class="crvena-zvezdica">*</span></label>
                            <div class="col-sm-10">
                                {!! Form::text('email', $message->email, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Ime <span class="crvena-zvezdica">*</span></label>
                            <div class="col-sm-10">
                                {!! Form::text('name', $message->name, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-sm-2 control-label">Telefon <span class="crvena-zvezdica">*</span></label>
                            <div class="col-sm-10">
                                {!! Form::text('phone', $message->phone, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message" class="col-sm-2 control-label">Poruka <span class="crvena-zvezdica">*</span></label>
                            <div class="col-sm-10">
                                {!! Form::textarea('message', $message->message, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="seen" class="col-sm-2 control-label">Pogledano</label>
                            <div class="col-sm-10">
                                {!! Form::checkbox('seen', 1, $message->seen, ['class' => 'switch-state', 'data-on-color' => 'success', 'data-off-color' => 'danger', 'data-on-text' => 'DA', 'data-off-text' => 'NE', 'id' => 'active']) !!}
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="submit" class="btn btn-success pull-right" value="Izmeni">
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
        var link = '{{ url("admin/messages/publish") }}/' + id;
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