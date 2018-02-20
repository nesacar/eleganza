@extends('admin.index')

@section('header')
    {!! HTML::style('admin/plugins/select2/css/select2.min.css') !!}
    {!! HTML::style('admin/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') !!}
@endsection

@section('bredcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('home') }}">Home</a></li>
        <li><a href="{{ url('admin/newsletters') }}">Newsletteri</a></li>
        <li class="active">Pregled</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title"><i class="fa fa-envelope" style="margin-right: 5px"></i>Pregled Newsletter-a</h4>
                </div>
                <div class="panel-body">
                    @include('themes.'.$theme->slug.'.emails.newsletter2')
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
        var place = $('#place');
        var count = $('.number').val();
        var locale = $('#locale').val();
        if(count != '' && count > 0){
            $.get('{{ url("admin/newsletters/append") }}', {count: count, locale: locale}, function(data){ place.html(data); })
        }else{
            console.log('pogresan format');
        }
    });
@endsection