@extends('themes.'.$theme->slug.'.index')

@section('title')
    Shop | {{ $category->title }} | p-grupacija.hr
@endsection

@section('keywords'){{ $settings->keywords }}@endsection

@section('seo_social_stuff')
    <meta property="og:type" content="article"/>
    <meta property="og:site_name" content="{{ url('/') }}">
    <meta property="og:url" content="{{ url(\App\Category::getShopLink($category->id)) }}">
    <meta property="og:image" content="{{ url('img/logo.png') }}">
@endsection

@section('content')

    @include('themes.'.$theme->slug.'.partials.featured-image')
    <div class="clear"></div>
    @include('themes.'.$theme->slug.'.partials.category-nav')
    @include('themes.'.$theme->slug.'.partials.category-products')

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
            $('#page').val(1);
            $('#moja').submit();

            @if(false)
            if ($(this).is(':checked')) {
                console.log('not checked');
                // not checked
                $('#page').val(0);
                var el = $(this);
                var value = el.val();
                el.parent().parent().parent().find(':checkbox').each(function(){
                $(this).prop('checked', false);
                });
                el.prop('checked', true);
                $.get('{{ url("products/ajaxsearch") }}', $('#moja').serialize(), function(data){ $('.category-products-3').html(data);} );
            } else {
                //checked
                console.log('checked');
                $('#page').val(0);
                var el = $(this);
                var value = el.val();
                el.parent().parent().parent().find(':checkbox').each(function(){
                $(this).prop('checked', false);
                });
                $.get('{{ url("products/ajaxsearch") }}', $('#moja').serialize(), function(data){ $('.category-products-3').html(data);} );
                };
            @endif
        });

        $('#param').select2({
            minimumResultsForSearch: -1
        });

        $('#param').change(function(){
            $('#page').val(0);
            if($(this).val() == 1){
                $.get('{{ url("products/ajaxsearch?sort=1") }}', $('#moja').serialize(), function(data){ $('.category-products-3').html(data);} );
            }else if($(this).val() == 2){
                $.get('{{ url("products/ajaxsearch?sort=2") }}', $('#moja').serialize(), function(data){ $('.category-products-3').html(data);} );
            }else if($(this).val() == 3){
                $.get('{{ url("products/ajaxsearch?sort=3") }}', $('#moja').serialize(), function(data){ $('.category-products-3').html(data);} );
            }else{
                $.get('{{ url("products/ajaxsearch?sort=4") }}', $('#moja').serialize(), function(data){ $('.category-products-3').html(data);} );
            }
        });

        var page = 2;
        $('.more').click(function(e){
            e.preventDefault();
            var el = $(this);
            var link = el.attr('href');
            $('#page').val(page);
            //console.log('promena page');
            $.get('{{ url("products/ajaxsearch?ajax=1") }}', $('#moja').serialize(), function(data){ if(data == 'empty'){ el.slideUp(); return; } $('#more-products').before(data); } );
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

    $('.shop-bar-flex').find('.img-holder').find('a').find('img').each(function() {
        var el = $(this);
        el.hover(function(){
            $(this).addClass('transition');
          
        }, function(){
            $(this).removeClass('transition');
          
        });
    });

    $('.squaredTwo2').find('input[type="checkbox"]').each(function(){
        if($(this).prop('checked')){
            $(this).parent().parent().parent().css({'display':'block'});
        }
    });

    $('.filters').find('.filter').each(function(){
        if($(this).find('input[type="checkbox"]').length == 0){
            $(this).remove();
        }
    });

    $('.filters').find('.filter').each(function(){
        if(!$(this).find('input[type="checkbox"]').is(':checked')){
            $(this).find('.clean').parent().parent().remove();
        }
    });

    $('.filter').each(function(){
        if($(this).find('input[type="checkbox"]').length == 0){
            $(this).remove();
        }
    });

    $('.filter').each(function(){
        if(!$(this).find('input[type="checkbox"]').is(':checked')){
            $(this).find('.clean').parent().parent().remove();
        }
    });
@endsection