@extends('themes.'.$theme->slug.'.index')

@section('title')
    Tag Heuer | {{ $category->title }} | p-grupacija.hr
@endsection

@section('keywords'){{ $settings->keywords }}@endsection

@section('seo_social_stuff')
    <meta property="og:type" content="article"/>
    <meta property="og:site_name" content="{{ url('/') }}">
    <meta property="og:url" content="{{ url(\App\Category::getShopLink($category->id)) }}">
    <meta property="og:image" content="{{ url('img/logo.png') }}">
@endsection

@section('content')

    @include('partials.featured-image')
    <div class="clear"></div>
    {!! Form::open(['action' => 'PagesController@ajaxsearchtag', 'method' => 'POST', 'class' => 'moja', 'id' => 'moja']) !!}
    {!! Form::hidden('category_id', $category->id) !!}
    {!! Form::hidden('page', 0, array('id' => 'page')) !!}
    <div class="clear"></div>

    <div class="col-md-12">
        <div class="na-levo">
            @if($category->slug == 'tag-heuer')
                <ol class="breadcrumb">
                    <li><a href="{{ url('tag-heuer') }}">Tag Heuer</a></li>
                    <li class="active">Satovi</li>
                </ol>
            @else
                @if(isset($s5))
                    <ol class="breadcrumb">
                        <li><a href="{{ url('tag-heuer') }}">Tag Heuer</a></li>
                        <li><a href="{{ url('tag-heuer/satovi') }}">Satovi</a></li>
                        <li><a href="{{ url('tag-heuer/'.$s1->slug) }}">{{ $s1->title }}</a></li>
                        <li><a href="{{ url('tag-heuer/'.$s1->slug.'/'.$s2->slug) }}">{{ $s2->title }}</a></li>
                        <li><a href="{{ url('tag-heuer/'.$s1->slug.'/'.$s2->slug.'/'.$s3->slug) }}">{{ $s3->title }}</a></li>
                        <li><a href="{{ url('tag-heuer/'.$s1->slug.'/'.$s2->slug.'/'.$s3->slug.'/'.$s4->slug) }}">{{ $s4->title }}</a></li>
                        <li class="active">{{ $s5->title }}</li>
                    </ol>
                @elseif(isset($s4))
                    <ol class="breadcrumb">
                        <li><a href="{{ url('tag-heuer') }}">Tag Heuer</a></li>
                        <li><a href="{{ url('tag-heuer/satovi') }}">Satovi</a></li>
                        <li><a href="{{ url('tag-heuer/'.$s1->slug) }}">{{ $s1->title }}</a></li>
                        <li><a href="{{ url('tag-heuer/'.$s1->slug.'/'.$s2->slug) }}">{{ $s2->title }}</a></li>
                        <li><a href="{{ url('tag-heuer/'.$s1->slug.'/'.$s2->slug.'/'.$s3->slug) }}">{{ $s3->title }}</a></li>
                        <li class="active">{{ $s4->title }}</li>
                    </ol>
                @elseif(isset($s3))
                    <ol class="breadcrumb">
                        <li><a href="{{ url('tag-heuer') }}">Tag Heuer</a></li>
                        <li><a href="{{ url('tag-heuer/satovi') }}">Satovi</a></li>
                        <li><a href="{{ url('tag-heuer/'.$s1->slug) }}">{{ $s1->title }}</a></li>
                        <li><a href="{{ url('tag-heuer/'.$s1->slug.'/'.$s2->slug) }}">{{ $s2->title }}</a></li>
                        <li class="active">{{ $s3->title }}</li>
                    </ol>
                @elseif(isset($s2))
                    <ol class="breadcrumb">
                        <li><a href="{{ url('tag-heuer') }}">Tag Heuer</a></li>
                        <li><a href="{{ url('tag-heuer/satovi') }}">Satovi</a></li>
                        <li><a href="{{ url('tag-heuer/'.$s1->slug) }}">{{ $s1->title }}</a></li>
                        <li class="active">{{ $s2->title }}</li>
                    </ol>
                @elseif(isset($s1))
                    <ol class="breadcrumb">
                        <li><a href="{{ url('tag-heuer') }}">Tag Heuer</a></li>
                        <li><a href="{{ url('tag-heuer/satovi') }}">Satovi</a></li>
                        <li class="active">{{ $s1->title }}</li>
                    </ol>
                @endif
            @endif
        </div>
        <div class="na-desno" >
            <select name="sort" id="param" class="js-example-basic-single">
                <option value="0">Prikaži po</option>
                <option value="1">Datumu dodavanja</option>
                <option value="2">Popularnosti</option>
                <option value="3">A - Z</option>
                <option value="4">Z - A</option>
            </select>
        </div>
        <div class="clear"></div>
        {!! Form::close() !!}
    </div>
    <div class="pretraga pretra">
        @if(count($products))
            <ul>
                @foreach($products as $product)
                    <li>
                        <ul>
                            <li><a href="#">{{ \App\Product::getBrend($product->id) }}</a></li>
                            <li><a href="#">{{ \App\Product::getLastCategory($product->id) }}</a></li>
                            <li><a href="{{ url(\App\Product::getProductTagLink($product->id)) }}">{!! HTML::image($product->image) !!}</a></li>
                            <li>{{ $product->title }}</li>
                            <li>{{ $product->code }}</li>
                            <li>
                                <a href="{{ url(\App\Product::getProductTagLink($product->id)) }}"><div class="sh3"></div></a>
                            </li>
                        </ul>
                    </li>
                @endforeach
                    <li id="more-products" style="clear: both"></li>
            </ul>
            <a class="more" href="{{ url('products/moretag/'.$category->id.'/ajax') }}" style="margin-bottom: 20px;">
                {!! HTML::image('img/more-arrow.png', 'more') !!}
            </a>
        @endif
        <div style="clear: both;"></div>
    </div>

@endsection

@section('footer_scripts')


    @if(count($topCat))

        $('.strelica').click(function(){
            $(this).parent().parent().find('ul').slideToggle();
        });

        $('#submit').click(function(){
            $('form#form-add-setting').submit(function(){
                return false;
            });
        });

        $('input[type="checkbox"]').click(function(){


        if ($(this).is(':checked')) {
            // not checked
            $('#page').val(0);
            var el = $(this);
            var value = el.val();
            el.parent().parent().parent().find(':checkbox').each(function(){
            $(this).prop('checked', false);
            });
            el.prop('checked', true);
            $.post('{{ url("products/ajaxsearchtag") }}', $('#moja').serialize(), function(data){ $('.category-products').html(data);} );
        } else {
            //checked
            $('#page').val(0);
            var el = $(this);
            var value = el.val();
            el.parent().parent().parent().find(':checkbox').each(function(){
            $(this).prop('checked', false);
            });
            $.post('{{ url("products/ajaxsearchtag") }}', $('#moja').serialize(), function(data){ $('.category-products').html(data);} );
            };
        });

        $('#param').select2({
            minimumResultsForSearch: -1
        });

        $('#param').change(function(){
            $('#page').val(0);
            if($(this).val() == 1){
                $.post('{{ url("products/ajaxsearchtag?sort=1") }}', $('#moja').serialize(), function(data){ $('.pretraga').html(data);} );
            }else if($(this).val() == 2){
                $.post('{{ url("products/ajaxsearchtag?sort=2") }}', $('#moja').serialize(), function(data){ $('.pretraga').html(data);} );
            }else if($(this).val() == 3){
                $.post('{{ url("products/ajaxsearchtag?sort=3") }}', $('#moja').serialize(), function(data){ $('.pretraga').html(data);} );
            }else{
                $.post('{{ url("products/ajaxsearchtag?sort=4") }}', $('#moja').serialize(), function(data){ $('.pretraga').html(data);} );
            }
        });

        var page = 1;
        $('.more').click(function(e){
            e.preventDefault();
            var el = $(this);
            var link = el.attr('href');
            $('#page').val(page);
            console.log('promena tag page');
            $.post('{{ url("products/ajaxsearchtag?ajax=1") }}', $('#moja').serialize(), function(data){ if(data == 'empty'){ el.slideUp(); return; } $('#more-products').before(data); } );
            page++;
            return false;
        });

        $('.dodavanje').click(function(e){
            e.preventDefault();
            var el = $(this);
            var link = el.attr('href');
            if(el.find('i').hasClass('active')){
                $.post(link, {_token: '{{ csrf_token() }}' }, function(data){ if(data == 'error'){ return; } el.find('i').removeClass('active'); el.attr('href', data); });
            }else{
                $.post(link, {_token: '{{ csrf_token() }}' }, function(data){ if(data == 'error'){ return; } el.find('i').addClass('active'); el.attr('href', data); });
            }
        });


    @endif
@endsection