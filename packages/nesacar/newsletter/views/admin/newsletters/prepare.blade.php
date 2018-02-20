@extends('admin.index')

@section('header')
    {!! HTML::style('admin/plugins/select2/css/select2.min.css') !!}
    {!! HTML::style('admin/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') !!}
@endsection

@section('bredcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('home') }}">Home</a></li>
        <li><a href="{{ url('admin/newsletters') }}">Newsletteri</a></li>
        <li class="active">Priprema</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title"><i class="fa fa-envelope" style="margin-right: 5px"></i>Podaci o Newsletteru</h4>
                </div>
                <div class="panel-body">
                    @include('admin.partials.errors')
                    {!! Form::open(['action' => ['NewslettersController@prepareUpdate'], 'method' => 'POST', 'class' => 'form-horizontal']) !!}
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Naziv</label>
                            <div class="col-sm-10">
                                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="language_id" class="col-sm-2 control-label">Jezik</label>
                            <div class="col-sm-10">
                                {!! Form::select('language_id', $languages, null, array('class' => 'form-control', 'id' => 'locale')) !!}
                            </div>
                        </div>
                        <hr>
                        @for($i=0;$i<5;$i++)
                        <div class="form-group">
                            <label for="number" class="col-sm-2 control-label">Broj tema u Newsletter-u</label>
                            <div class="col-sm-10">
                                @if($setting->blog && $setting->shop)
                                    {!! Form::select('type[]', [0 => 'Prazno', 1 => 'Proizvodi', 2 => 'Baneri', 3 => 'Članci'], null, array('class' => 'form-control')) !!}
                                @elseif($setting->shop)
                                    {!! Form::select('type[]', [0 => 'Prazno', 1 => 'Proizvodi', 2 => 'Baneri'], null, array('class' => 'form-control')) !!}
                                @elseif($setting->blog)
                                    {!! Form::select('type[]', [0 => 'Prazno', 3 => 'Članci'], null, array('class' => 'form-control')) !!}
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="number" class="col-sm-2 control-label">Broj tema u Newsletter-u</label>
                            <div class="col-sm-10">
                                {!! Form::text('number[]', null, array('class' => 'form-control number')) !!}
                            </div>
                        </div>
                        @endfor
                        <div class="form-group">
                            <label for="send" class="col-sm-2 control-label"></label>
                            <div class="col-sm-10">
                                <input type="submit" class="btn btn-success" value="Potvrdi">
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
    {!! HTML::script('admin/plugins/select2/js/select2.min.js') !!}
@endsection

@section('footer_scripts')

    $('.switch-state').bootstrapSwitch();

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var sw = $('.switch-state');


    sw.bootstrapSwitch();


    $('#publish_at').datetimepicker({format: 'YYYY-MM-DD HH:mm'});

    $(".tag").select2({
        'placeholder': 'Izaberi tag',
        'tags': 'true'
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

    $('.potvrdi').click(function(e){
        e.preventDefault();
        var place = $('.place');
        var count = $('.number').val();
        var locale = $('#locale').val();
        if(count != '' && count > 0){
            $.get('{{ url("admin/newsletters/append") }}', {count: count, locale: locale}, function(data){ place.html(data); })
        }else{
            console.log('pogresan format');
        }
    });
@endsection