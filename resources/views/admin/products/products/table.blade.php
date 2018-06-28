@extends('admin.index')

@section('header')
    {!! HTML::style('admin/plugins/select2/css/select2.min.css') !!}
    {!! HTML::style('admin/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') !!}
@endsection

@section('bredcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('home') }}">Home</a></li>
        <li><a href="{{ url('admin/products') }}">Proizvodi</a></li>
        <li class="active">Kreiranje</li>
    </ol>
@endsection

@section('content')
    <div class="row" id="app">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title"><i class="glyphicon glyphicon-gift" style="margin-right: 5px"></i>Podaci o proizvodu</h4>
                </div>
                <div class="panel-body">
                    @include('admin.partials.errors')
                    <excel-table></excel-table>
                </div>
            </div>
        </div>
    </div><!-- .row -->
@endsection

@section('footer')
    {!! HTML::script('admin/plugins/select2/js/select2.min.js') !!}
    {!! HTML::script('admin/js/jquery.mjs.nestedSortable.js') !!}
    {!! HTML::script('admin/plugins/moment/moment.js') !!}
    {!! HTML::script('admin/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') !!}
    {!! HTML::script('admin/ckeditor/ckeditor.js') !!}
    {!! HTML::script('js/app.js') !!}
@endsection

@section('footer_scripts')

    @if(false)
    window.onload = function () {
        CKEDITOR.replace('body', {
            "filebrowserBrowseUrl": "{!! url('filemanager/show') !!}"
        });
    };
    @endif

    var br=0;

    $('#publish_at').datetimepicker({
        format: 'YYYY-MM-DD HH:mm'
    });

    $('.switch-state').bootstrapSwitch();

    $("#prod").select2({
    'placeholder': 'Izaberi proizvod',
    'tags': 'true'
    });

    $("#cats").select2({
    'placeholder': 'Izaberi kategoriju',
    'tags': 'true'
    });

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

    $('input[name=discount]').change(function(){
    var popust = $(this).val();
    var cena = $('input[name=price_small]').val();
    if(cena == ''){
    $('input[name=price_small]').val(0);
    }
    var nova = cena - (cena * popust/100);
    $('input[name=price_outlet]').val(nova);
    });
@endsection