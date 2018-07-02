@php
    // hack :)
    $theme = (object)['slug' => 'eleganza'];
@endphp

@extends('themes.'.$theme->slug.'.index')

@section('header-style')
    <link rel="stylesheet" href="{{ url('themes/eleganza/css/instashop.css') }}">
@endsection

@section('header-style')
    {!! HTML::style('themes/'.$theme->slug.'/css/jquery.toastmessage.css') !!}
@endsection

@section('content')
    <div class="container">
        <h1 class="e-subheading py-4">#instashop</h1>

        @if(!empty($instaShops))
            <div class="instashop-list js-grid">
                @foreach($instaShops as $i=>$item)
                    @php
                        $base = 'e-image instashop-thumbnail with-zoom';
                        $img_className = ($i % 2 == 0)
                          ? $base.' e-image--11'
                          : $base.' e-image--43';
                    @endphp

                    <div class="instashop-image js-grid-cell">
                        <div class="{{$img_className}}"
                             data-id="{{ $item->id }}">
                            {!! HTML::Image($item->image, $item->title) !!}
                            <div class="instashop-overlay">
                                <div class="instashop-overlay__action">
                                    <i class="fab fa-instagram"></i>
                                    <span>shop the look</span>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
        @endif
    </div>
@endsection

@section('instashop')
    @include('themes.'.$theme->slug.'.partials.instashop')
@endsection

@section('footer_scripts')
    <script>window.products = {!! $instaShops !!};</script>
    <script src="{{ url('themes/eleganza/js/instashop.js') }}"></script>
@endsection