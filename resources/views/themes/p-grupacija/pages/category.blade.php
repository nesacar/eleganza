@extends('themes.'.$theme->slug.'.index')

@section('title')
    @if($home)
    Tag Heuer | Početna strana | p-grupacija.hr
    @else
    {{ $category->title }} | p-grupacija.hr
    @endif
@endsection

@section('keywords'){{ $settings->keywords }}@endsection

@section('seo_social_stuff')
    @if($home)
    <meta property="og:type" content="article"/>
    <meta property="og:site_name" content="{{ url('/') }}">
    @else
    <meta property="og:type" content="article"/>
    <meta property="og:site_name" content="{{ url('/') }}">
    <meta property="og:url" content="{{ url($category->slug) }}">
    <meta property="og:image" content="{{ url('img/logo.png') }}">
    @endif
@endsection

@section('content')

    @include('themes.'.$theme->slug.'.partials.slider')
    @if($category->id == 2)
        @include('themes.'.$theme->slug.'.partials.collections')
    @else
        @include('themes.'.$theme->slug.'.partials.shop-bar')
    @endif
    @include('themes.'.$theme->slug.'.partials.category-posts')
    <div class="more-posts" style="clear: both">prikaži još</div>
    {!! HTML::image($theme->slug.'/img/more-arrow.png', 'more', array('class' => 'more-more')) !!}
    <div style="clear: both"></div>
    @if(true)
        @include('themes.'.$theme->slug.'.partials.shop-bar2')
    @endif
@endsection

@section('footer_scripts')
    var page=1;
    $('.more-more').click(function(e){
        page++;
        var el = $(this);
        var cat = {{ $category->id }};
        e.preventDefault();
        $.post('{{ url('admin/pages/more') }}', {_token: '{{ csrf_token() }}' , cat: cat, page: page}, function(data){ if(data == 'empty'){ el.slideUp(); return; } $('.more-posts').before(data); });
    });

    $('.shop-bar-2').find('.img-holder').find('a').find('img').each(function() {
        var el = $(this);
        el.hover(function(){
            $(this).addClass('transition');
        }, function(){
            $(this).removeClass('transition');
        });
    });

  
@endsection