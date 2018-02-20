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

    @include('partials.slider')
    @include('partials.collections-flex')
    @include('partials.products')
    @include('partials.products-slider')
    @include('partials.products2')
    @include('partials.shop-bar2')
    @if(!$home)
        <a href="#">
          
            {!! HTML::image('img/more-arrow.png', 'more', array('class' => 'more-more')) !!}
        </a>
    @endif

@endsection

@section('footer_scripts')

@endsection