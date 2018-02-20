@extends('themes.'.$theme->slug.'.index')

@section('title')
    @if($home)
        {{ $settings->title }}
    @else
        {{ $category->title }} | p-grupacija.hr
    @endif
@endsection

@section('keywords'){{ $settings->keywords }}@endsection

@section('seo_social_stuff')
    <meta property="og:type" content="article"/>
    <meta property="og:site_name" content="{{ url('/') }}">
    <meta property="og:url" content="{{ url(\App\Category::getShopLink($category->id)) }}">
    <meta property="og:image" content="{{ url('img/logo.png') }}">
@endsection

@section('content')

    @include('partials.slider')
    <div class="clear"></div>
    @include('partials.category-nav')
    @include('partials.category-products')
    @include('partials.related-index-post')
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
            $.post('{{ url("products/ajaxsearch") }}', $('#moja').serialize(), function(data){ $('.category-products-3').html(data);} );
        } else {
            //checked
            $('#page').val(0);
            var el = $(this);
            var value = el.val();
            el.parent().parent().parent().find(':checkbox').each(function(){
            $(this).prop('checked', false);
            });
            $.post('{{ url("products/ajaxsearch") }}', $('#moja').serialize(), function(data){ $('.category-products-3').html(data);} );
            };
        });

        $('#param').select2({
            minimumResultsForSearch: -1
        });

        $('#param').change(function(){
            $('#page').val(0);
            if($(this).val() == 1){
                $.post('{{ url("products/ajaxsearch?sort=1") }}', $('#moja').serialize(), function(data){ $('.category-products-3').html(data);} );
            }else if($(this).val() == 2){
                $.post('{{ url("products/ajaxsearch?sort=2") }}', $('#moja').serialize(), function(data){ $('.category-products-3').html(data);} );
            }else if($(this).val() == 3){
                $.post('{{ url("products/ajaxsearch?sort=3") }}', $('#moja').serialize(), function(data){ $('.category-products-3').html(data);} );
            }else{
                $.post('{{ url("products/ajaxsearch?sort=4") }}', $('#moja').serialize(), function(data){ $('.category-products-3').html(data);} );
            }
        });

        var page = 1;
        $('.more').click(function(e){
            e.preventDefault();
            var el = $(this);
            var link = el.attr('href');
            $('#page').val(page);
            //console.log('promena page');
            $.post('{{ url("products/ajaxsearch?ajax=1") }}', $('#moja').serialize(), function(data){ if(data == 'empty'){ el.slideUp(); return; } $('#more-products').before(data); } );
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