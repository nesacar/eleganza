@extends('admin.index')

@section('header')
    {!! HTML::style('admin/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') !!}
@endsection

@section('bredcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('home') }}">Home</a></li>
        <li><a href="{{ url('admin/coupons') }}">Kuponi</a></li>
        <li class="active">Izmena</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title"><i class="fa fa-cubes" style="margin-right: 5px"></i>Podaci o kuponu</h4>
                </div>
                <div class="panel-body">
                    @include('admin.partials.errors')
                    {!! Form::open(['action' => ['CouponsController@update', $coupon->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
                        <div class="form-group">
                            <label for="code" class="col-sm-2 control-label">Kod</label>
                            <div class="col-sm-10">
                                {!! Form::text('code', $coupon->code, array('class' => 'form-control', 'id' => 'code')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="discount" class="col-sm-2 control-label">Popust (%) <span class="crvena-zvezdica">*</span></label>
                            <div class="col-sm-10">
                                {!! Form::text('discount', $coupon->discount, array('class' => 'form-control', 'id' => 'discount')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="number" class="col-sm-2 control-label">Broj preostalih kupona <span class="crvena-zvezdica">*</span></label>
                            <div class="col-sm-10">
                                {!! Form::text('number', $coupon->number, array('class' => 'form-control', 'id' => 'number')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="publish_at" class="col-sm-2 control-label">Aktivno od <span class="crvena-zvezdica">*</span></label>
                            <div class="col-sm-10">
                                {!! Form::text('publish_at', $coupon->publish_at, array('class' => 'form-control', 'id' => 'publish_at')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="valid_at" class="col-sm-2 control-label">Aktivno do <span class="crvena-zvezdica">*</span></label>
                            <div class="col-sm-10">
                                {!! Form::text('valid_at', $coupon->valid_at, array('class' => 'form-control', 'id' => 'valid_at')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="top" class="col-sm-2 control-label">Upotrebljeno</label>
                            <div class="col-sm-10">
                                {!! Form::checkbox('publish', 1, $coupon->publish, ['class' => 'switch-state', 'data-on-color' => 'success', 'data-off-color' => 'danger', 'data-on-text' => 'DA', 'data-off-text' => 'NE', 'id' => 'top']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="forever" class="col-sm-2 control-label">Neograničeno</label>
                            <div class="col-sm-10">
                                {!! Form::checkbox('forever', 1, $coupon->forever, ['class' => 'switch-state', 'data-on-color' => 'success', 'data-off-color' => 'danger', 'data-on-text' => 'DA', 'data-off-text' => 'NE', 'id' => 'forever']) !!}
                            </div>
                        </div>
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

@section('footer')
    {!! HTML::script('admin/plugins/moment/moment.js') !!}
    {!! HTML::script('admin/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') !!}
@endsection

@section('footer_scripts')
    var br=0;

    $('.switch-state').bootstrapSwitch();

    $('#publish_at').datetimepicker({format: 'YYYY-MM-DD HH:mm'});

    $('#valid_at').datetimepicker({format: 'YYYY-MM-DD HH:mm'});

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