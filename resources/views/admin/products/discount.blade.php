@extends('admin.index')

@section('header')
    {!! HTML::style('admin/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') !!}
@endsection

@section('bredcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('home') }}">Home</a></li>
        <li class="active">Proizvodi</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">

                <div class="panel-heading clearfix">
                    <h3 class="panel-title"><i class="glyphicon glyphicon-gift" aria-hidden="true" style="margin-right: 5px"></i>Grupni popusti</h3>
                    <div class="panel-control">
                        <a href="{{ url('admin/products/discount') }}" data-toggle="tooltip" data-placement="top" title="" class="panel-reload" data-original-title="Grupni popusti"><i class="fa fa-line-chart"></i></a>
                        @if(auth()->user()->id)<a href="{{ url('admin/products/table') }}" data-toggle="tooltip" data-placement="top" title="" class="panel-reload" data-original-title="Brzi unos"><i class="fa fa-table"></i></a>@endif
                        <a href="{{ url('admin/products/create') }}" data-toggle="tooltip" data-placement="top" title="" class="panel-reload" data-original-title="Kreiraj proizvod"><i class="fa fa-plus"></i></a>
                    </div>
                </div>

                <hr>

                <div class="row" style="background-color: white">
                    {!! Form::open(['action' => 'ProductsController@discount', 'method' => 'GET', 'id' => 'form-add-setting']) !!}
                        <div class="col-md-12">
                            <div class="col-sm-3">
                                <input type="text" name="title" placeholder="Pretraga..." id="title" class="form-control input-sm" value="@if(Session::get('title')){{Session::get('title')}}@endif">
                            </div>
                            <div class="col-sm-3">
                                {!! \App\Category::getSortCategorySelectAdmin(request('category_id')) !!}
                            </div>
                            <div class="col-sm-2">
                                {!! Form::select('brand_id', $brandIds, request('brand_id'), array('class' => 'sele')) !!}
                            </div>
                            <div class="col-sm-2">
                            </div>
                            <div class="col-sm-23">
                                <div class="btn-group" role="group">
                                    <input type="submit" value="Pretraga" id="submit" class="btn btn-success btn-block">
                                    @if(false) <a class="btn btn-danger" href="{{ url('admin/products/clear') }}">X</a> @endif
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
                <div class="panel-body" id="app">
                    <div class="panel-header-stats">
                        @if(count($products) > 0)
                            <div class="row">
                                <div class="col-md-2">
                                    <b class="all" data-trigger="0">--</b>
                                </div>
                                <div class="col-md-2">
                                    <b>ID</b>
                                </div>
                                <div class="col-md-2">
                                    <b>Naziv</b>
                                </div>
                                <div class="col-md-2">
                                    <b>Šifra</b>
                                </div>
                                <div class="col-md-2">
                                    <b>Slika</b>
                                </div>
                                <div class="col-md-2">
                                    <b>Cena</b>
                                </div>
                            </div>
                            <hr>
                            {!! Form::open(['action' => 'ProductsController@discountUpdate', 'method' => 'POST', 'id' => 'form-add-setting']) !!}
                            @foreach($products as $p)
                                <div class="row @if($p->publish == 0) crvena @endif">
                                    <div class="col-md-2 ima-padding">
                                        {!! Form::checkbox('all[]', $p->id, null) !!}
                                    </div>
                                    <div class="col-md-2 ima-padding">
                                        {{ $p->id }}
                                    </div>
                                    <div class="col-md-2 ima-padding">
                                        {{ $p->{'title:hr'} }}
                                    </div>
                                    <div class="col-md-2 ima-padding">
                                        {{ $p->code }}
                                    </div>
                                    <div class="col-md-2">
                                        @if($p->tmb != null || $p->tmb != '')
                                            {!! HTML::image($p->tmb, '', ['class' => 'thumb']) !!}
                                        @elseif($p->image != null || $p->image != '')
                                            {!! HTML::image($p->image, '', ['class' => 'thumb']) !!}
                                        @else
                                            <image-upload :product_id="{{ $p->id }}"></image-upload>
                                        @endif
                                    </div>
                                    <div class="col-md-2 ima-padding">
                                        {{ $p->price_small }} RSD
                                    </div>
                                </div>
                            @endforeach
                            <div class="row" style="margin-top: 100px">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="discount" class="col-sm-2 control-label">Popust</label>
                                        <div class="col-sm-10">
                                            {!! Form::text('discount', request('discount'), array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="submit" value="Primeni" class="btn btn-success">
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    {!! str_replace('/?', '?', $products->render()) !!}
                                </div>
                            </div>
                        @else
                            <p>Nema dostupnih proizvoda</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    {!! HTML::script('admin/plugins/moment/moment.js') !!}
    {!! HTML::script('admin/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') !!}
    {!! HTML::script('js/app.js') !!}
@endsection

@section('footer_scripts')



    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var sw = $('.switch-state');


    sw.bootstrapSwitch();

    sw.on('switchChange.bootstrapSwitch', function (e, data) {

    $('#myswitch').bootstrapSwitch('state', !data, true);
        var id = $(this).attr('id');
        var link = 'products/publish/' + id;
        $.get(link, {id: id, val:data}, function($stat){ if($stat=='da'){ save(); $('#'+id).parent().parent().parent().parent().toggleClass('crvena'); }else{ error(); } });
    });

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

    function save(){
        toastr["success"]("Izmenjeno");
    }
    function error(){
        toastr["error"]("Došlo je do greške");
    }

    function resetSearchFilter(){
        window.location.href = "{{ url('admin/products/clear') }}";
    }

    function reset(){
        $('#title').val(''); $('#od').val(''); $('#do').val(''); $('#kategorija').val(0);
    }

    $('.all').click(function(){
        var trigger = $(this).attr('data-trigger');
        console.log(trigger);
        if(trigger == 0){
            $(this).prop('data-trigger', 1);
            $('input[type="checkbox"]').each(function(){
                $(this).attr('checked', 1);
            });
        }else{
            $(this).prop('data-trigger', 0;
            $('input[type="checkbox"]').each(function(){
                $(this).attr('checked', 0);
            });
        }
    });

@endsection