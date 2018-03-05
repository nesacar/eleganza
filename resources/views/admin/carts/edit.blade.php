@extends('admin.index')

@section('header')
    {!! HTML::style('admin/plugins/select2/css/select2.min.css') !!}
    {!! HTML::style('admin/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') !!}
@endsection

@section('bredcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('home') }}">Home</a></li>
        <li><a href="{{ url('admin/carts') }}">Korpe</a></li>
        <li class="active">Pregled</li>
    </ol>
@endsection

@section('content')

    <div class="row">
        @include('admin.partials.errors')
        <div class="col-md-4">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title"><i class="fa fa-shopping-basket" style="margin-right: 5px"></i>Podaci o korpi</h4>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="property_id" class="col-sm-3 control-label">Ime</label>
                        <div class="col-sm-9">
                            <p>{{ $cart->customer->name }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="extra" class="col-sm-3 control-label">Prezime</label>
                        <div class="col-sm-9">
                            <p>{{ $cart->customer->lastname }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="order" class="col-sm-3 control-label">E-mail</label>
                        <div class="col-sm-9">
                            <p>{{ $cart->customer->email }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="publish" class="col-sm-3 control-label">Telefon</label>
                        <div class="col-sm-9">
                            <p>{{ $cart->customer->phone }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="publish" class="col-sm-3 control-label">Adresa</label>
                        <div class="col-sm-9">
                            <p>{{ $cart->customer->address }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="publish" class="col-sm-3 control-label">Grad</label>
                        <div class="col-sm-9">
                            <p>{{ $cart->customer->town }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="publish" class="col-sm-3 control-label">Poštanski broj</label>
                        <div class="col-sm-9">
                            <p>{{ $cart->customer->postcode }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="publish" class="col-sm-3 control-label">Poručeno</label>
                        <div class="col-sm-9">
                            <p>{{ \Carbon\Carbon::parse($cart->created_at)->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" class="col-sm-3 control-label">Plaćeno</label>
                        <div class="col-sm-9">
                            <p>@if($cart->status) Da @else Ne @endif</p>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- .col-md-4 -->
        <div class="col-md-8">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title">Porudžbina</h4>
                </div>
                <div class="panel-body">
                    @if(count($cart->product) > 0)
                        <div class="row">
                            <div class="col-md-1">
                                <b>ID</b>
                            </div>
                            <div class="col-md-4">
                                <b>Naziv</b>
                            </div>
                            <div class="col-md-2">
                                <b>Šifra</b>
                            </div>
                            <div class="col-md-1">
                                <b>Slika</b>
                            </div>
                            <div class="col-md-2">
                                <b>Cena</b>
                            </div>
                            <div class="col-md-2">
                                <b>Kategorija</b>
                            </div>
                        </div>
                        <hr>
                        @foreach($cart->product as $p)
                            <div class="row @if($p->publish == 0) crvena @endif">
                                <div class="col-md-1 ima-padding">
                                    {{ $p->id }}
                                </div>
                                <div class="col-md-4 ima-padding">
                                    {{ $p->title }}
                                </div>
                                <div class="col-md-2 ima-padding">
                                    {{ $p->code }}
                                </div>
                                <div class="col-md-1">
                                    @if($p->tmb != null || $p->tmb != '')
                                        {!! HTML::image($p->tmb, '', ['class' => 'thumb']) !!}
                                    @elseif($p->image != null || $p->image != '')
                                        {!! HTML::image($p->image, '', ['class' => 'thumb']) !!}
                                    @endif
                                </div>
                                <div class="col-md-2 ima-padding">
                                    {{ $p->price_small }} RSD
                                </div>
                                <div class="col-md-2 ima-padding">
                                    {{ \App\Product::getLastCategory($p->id) }}
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>Korpa je prazna</p>
                    @endif
                </div>
            </div><!-- .col-md-8 -->
        </div><!-- .col-md-8 -->
    </div>
    <div class="row">
        <div class="col-md-12">

        </div>
    </div><!-- .row -->

@endsection

@section('footer')
    {!! HTML::script('admin/plugins/moment/moment.js') !!}
    {!! HTML::script('admin/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') !!}
    {!! HTML::script('admin/ckeditor/ckeditor.js') !!}
    {!! HTML::script('admin/plugins/select2/js/select2.min.js') !!}
@endsection

@section('footer_scripts')

    $('.switch-state').bootstrapSwitch();

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var sw = $('.switch-state');


    sw.bootstrapSwitch();

    $('#publish_at').datetimepicker({format: 'YYYY-MM-DD HH:mm'});

    $("#tag").select2({
        'placeholder': 'Izaberi tag',
        'tags': 'true'
    });

    $("#tag2").select2({
        'placeholder': 'Izaberi tag',
        'tags': 'true'
    });

    $('.remove').click(function(e){
        e.preventDefault();
        var link = $(this).attr('href');
        var img = $(this).attr('data-img');
        var place = $(this).parent();
        if (confirm('Da li ste sigurni da hoćete da obrišete ovu sliku?')) {
            $.post(link, { _token: '{{ csrf_token() }}', img: img }, function(data){ place.html(data); });
        }
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