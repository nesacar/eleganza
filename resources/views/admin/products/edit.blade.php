@extends('admin.index')

@section('bredcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('home') }}">Home</a></li>
        <li><a href="{{ url('admin/products') }}">Proizvodi</a></li>
        <li class="active">Izmena</li>
    </ol>
@endsection

@section('content')

    <div class="row">
        @include('admin.partials.errors')
        <div class="col-md-8">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title"><i class="fa fa-gift" style="margin-right: 5px"></i>Podaci o proizvodu</h4>
                    <div class="panel-control">
                        <a href="{{ url('admin/products/create') }}" data-toggle="tooltip" data-placement="top" title="" class="panel-reload" data-original-title="Kreiraj proizvod"><i class="fa fa-plus"></i></a>
                        <a href="{{ url('admin/products/'.$product->id.'/clone') }}" data-toggle="tooltip" data-placement="top" title="" class="panel-reload" data-original-title="Kloniraj proizvod"><i class="fa fa-clone"></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    {!! Form::open(['action' => ['ProductsController@update', $product->id], 'method' => 'PUT', 'class' => 'form-horizontal', 'files' => true]) !!}
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">Naziv</label>
                        <div class="col-sm-10">
                            {!! Form::text('title', $product->title, array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="short" class="col-sm-2 control-label">SEO opis</label>
                        <div class="col-sm-10">
                            {!! Form::textarea('short', $product->short, array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="body" class="col-sm-2 control-label">Karakteristike</label>
                        <div class="col-sm-10">
                            {!! Form::textarea('body', $product->body, array('class' => 'form-control', 'id' => 'body1')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="body2" class="col-sm-2 control-label">Opciono</label>
                        <div class="col-sm-10">
                            {!! Form::textarea('body2', $product->body2, array('class' => 'form-control', 'id' => 'body2')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="publish_at" class="col-sm-2 control-label">Vidljivo od datuma <span class="crvena-zvezdica">*</span></label>
                        <div class="col-sm-10">
                            {!! Form::text('publish_at', $product->publish_at, array('class' => 'form-control', 'id' => 'publish_at')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="brand_id" class="col-sm-2 control-label">Brend</label>
                        <div class="col-sm-10">
                            {!! Form::select('brand_id', $brands, $product->brand_id, array('class' => 'sele')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="set_id" class="col-sm-2 control-label">Asortiman</label>
                        <div class="col-sm-10">
                            {!! Form::select('set_id', $sets, $product->set_id, array('class' => 'sele')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="code" class="col-sm-2 control-label">Šifra proizvoda</label>
                        <div class="col-sm-10">
                            {!! Form::text('code', $product->code, array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        @if($product->image != null && $product->image != '')
                            <div class="place">
                                <img src="{{ url($product->image) }}" alt="{{ $product->title }}" style="width: 80px; height: auto; margin-bottom: 10px">
                                <a class="btn btn-danger remove" href="{{ url('admin/products/'.$product->id.'/deleteimg') }}">Obriši sliku</a>
                            </div>
                        @else
                            <label for="image" class="col-sm-2 control-label">Uvodna slika</label>
                            <div class="col-sm-10">
                                {!! Form::file('image') !!}
                            </div>
                        @endif
                    </div>
                    @if(false)
                    <div class="form-group">
                        @if($product->tmb != null && $product->tmb != '')
                            <div class="place">
                                <img src="{{ url($product->tmb) }}" alt="{{ $product->title }}" style="display: block; margin: 0 auto 10px auto;"> <br>
                                <a class="btn btn-danger remove" href="{{ url('admin/products/'.$product->id.'/deleteimgtmb') }}">Obriši sliku</a>
                            </div>
                        @else
                            <label for="image" class="col-sm-2 control-label">Mala slika</label>
                            <div class="col-sm-10">
                                {!! Form::file('tmb') !!}
                            </div>
                        @endif
                    </div>
                    @endif
                    @if($setting->colorDependence)
                    <div class="form-group">
                        <label for="color" class="col-sm-2 control-label">Boja</label>
                        <div class="col-sm-10">
                            {!! Form::select('color', $colors, $product->color, array('class' => 'sele')) !!}
                        </div>
                    </div>
                    @endif
                    @if($setting->materialDependence)
                        <div class="form-group">
                            <label for="material" class="col-sm-2 control-label">Boja</label>
                            <div class="col-sm-10">
                                {!! Form::select('material', $materials, $product->material, array('class' => 'sele')) !!}
                            </div>
                        </div>
                    @endif
                    <h3>Cene</h3>
                    <hr>
                    <div class="form-group">
                        <label for="price_small" class="col-sm-2 control-label">Maloprodajna cena <span class="crvena-zvezdica">*</span></label>
                        <div class="col-sm-10">
                            {!! Form::text('price_small', $product->price_small, array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="discount" class="col-sm-2 control-label">Popust</label>
                        <div class="col-sm-10">
                            {!! Form::text('discount', $product->discount, array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price_outlet" class="col-sm-2 control-label">Outlet cena</label>
                        <div class="col-sm-10">
                            {!! Form::text('price_outlet', $product->price_outlet, array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <h3>Dostupnost</h3>
                    <hr>
                    <div class="form-group">
                        <label for="publish" class="col-sm-2 control-label">Vidljivo na sajtu</label>
                        <div class="col-sm-10">
                            {!! Form::checkbox('publish', 1, $product->publish, ['class' => 'switch-state', 'data-on-color' => 'success', 'data-off-color' => 'danger', 'data-on-text' => 'DA', 'data-off-text' => 'NE', 'id' => 'publish']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="primary" class="col-sm-2 control-label">Istaknut proizvod</label>
                        <div class="col-sm-10">
                            {!! Form::checkbox('featured', 1, $product->featured, ['class' => 'switch-state', 'data-on-color' => 'success', 'data-off-color' => 'danger', 'data-on-text' => 'DA', 'data-off-text' => 'NE', 'id' => 'featured']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="amount" class="col-sm-2 control-label">Dostupna količina</label>
                        <div class="col-sm-10">
                            {!! Form::text('amount', $product->amount, array('class' => 'form-control', 'id' => 'amount')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category_id" class="col-sm-2 control-label">Kategorije <span class="crvena-zvezdica">*</span></label>
                        <div class="col-sm-10">
                            {!! \App\Category::getSortCategoryCheckbox(false, $catids) !!}
                        </div>
                    </div>
                    @if(false)
                        <div class="form-group">
                            <label for="prod" class="col-sm-2 control-label">Povezani proizvodi</label>
                            <div class="col-sm-10">
                                {!! Form::select('prod[]', $products, null, ['id' => 'prod', 'class' => 'form-control', 'multiple']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category_id" class="col-sm-2 control-label">Povezane kategorije</label>
                            <div class="col-sm-10">
                                {!! Form::select('cats[]', $cats, null, ['id' => 'cats', 'class' => 'form-control', 'multiple']) !!}
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="submit" class="btn btn-success pull-right" value="Izmeni generalno">
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                @if(false)
                <div class="panel panel-white">
                    <div class="col-sm-12">
                        <h3>Slike kategorije</h3>
                        @if(count($category->image)>0)
                            <ul class="brands">
                                @foreach($category->image as $image)
                                    <li><img src="{{ url($image->file_path) }}" class="thumb"><i class="fa fa-remove clear" data-id="{{ $image->id }}"></i></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="col-sm-12" style="margin-bottom: 10px">
                        <h3>Upload slika za galeriju (1200x650)</h3>
                        @include('admin.categories.dropzone')
                    </div>
                    <div style="clear: both"></div>
                </div>
                @endif
            </div>
        </div><!-- .col-md-8 -->
        <div class="col-md-4">

            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title">Atributi</h4>
                </div>
                <div class="panel-body">
                    {!! Form::open(['action' => ['ProductsController@updateAttribute', $product->id], 'method' => 'POST', 'class' => 'form-horizontal']) !!}
                        @if(!empty($set) && count($set->property)>0)

                            @if($set->id == 4)
                                <div class="col-sm-6">
                                    <h3>Promjer kućišta (mm)</h3>
                                    {!! Form::text('diameter', $product->diameter, array('class' => 'form-control')) !!}
                                </div>
                                <div class="col-sm-6">
                                    <h3>Vodootpornost (m)</h3>
                                    {!! Form::text('water', $product->water, array('class' => 'form-control')) !!}
                                </div>
                            @endif

                            @foreach($set->property as $property)
                                <div class="col-sm-6">
                                    <h3>{{ $property->title }}</h3>
                                    @if(count($property->attribute)>0)
                                        @foreach($property->attribute as $attribute)
                                            @if(in_array($attribute->id, $attributeIds))
                                                <p>{!! Form::checkbox('attributes[]', $attribute->id, true) !!} {{ $attribute->title }}</p>
                                            @else
                                                <p>{!! Form::checkbox('attributes[]', $attribute->id, false) !!} {{ $attribute->title }}</p>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            @endforeach
                        @endif
                        <hr>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="submit" class="btn btn-success pull-right" value="Izmeni filtere">
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div><!-- .panel-white -->
        </div><!-- .col-md-8 -->
    </div>
    <div class="row">
        <div class="col-md-12">

        </div>
    </div><!-- .row -->

@endsection

@section('footer')
    {!! HTML::script('admin/ckeditor/ckeditor.js') !!}
@endsection

@section('footer_scripts')


        window.onload = function () {
            CKEDITOR.replace('body1', {
                "filebrowserBrowseUrl": "{!! url('filemanager/show') !!}"
            });
            CKEDITOR.replace('body2', {
                "filebrowserBrowseUrl": "{!! url('filemanager/show') !!}"
            });
        };

    var br=0;

    $('.switch-state').bootstrapSwitch();

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var sw = $('.odgovori').find('.switch-state');


    sw.bootstrapSwitch();

    sw.on('switchChange.bootstrapSwitch', function (e, data) {

    $('#myswitch').bootstrapSwitch('state', !data, true);
        var id = $(this).attr('id');
        var link = '{{ url("admin/products/publish") }}/' + id;
        $.get(link, {id: id, val:data}, function($stat){ if($stat=='da'){ save(); $('#'+id).parent().parent().parent().parent().toggleClass('crvena'); }else{ error(); } });
    });

    $('.remove').click(function(e){
        e.preventDefault();
        var link = $(this).attr('href');
        var img = $(this).attr('data-img');
        var place = $(this).parent();
        if (confirm('Da li ste sigurni da hoćete da obrišete ovu sliku?')) {
            $.get(link, { _token: '{{ csrf_token() }}', img: img }, function(data){ place.html(data); });
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

    $('.clear').click(function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var place = $(this).parent();
        $.post('{{ url("admin/images/delete") }}', { _token: '{{ csrf_token() }}', id: id }, function(data){ if(data == 'yes'){ place.fadeOut(); }else{ console.log(data); } })
    });

    /*$('input[type="submit"]:not(".lang")').hover(function(){
        $(this).parent().parent().parent().parent().parent().addClass('active');
    }, function(){
        $(this).parent().parent().parent().parent().parent().removeClass('active');
    });

    $('.lang').hover(function(){
        $(this).parent().parent().parent().parent().parent().parent().parent().addClass('active');
    }, function(){
        $(this).parent().parent().parent().parent().parent().parent().parent().removeClass('active');
    });*/
@endsection