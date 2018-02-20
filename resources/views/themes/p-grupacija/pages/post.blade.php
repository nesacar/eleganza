@extends('themes.'.$theme->slug.'.index')

@section('title')
    {{ $post->title }} | p-grupacija.hr
@endsection

@section('keywords'){{ $settings->keywords }}@endsection

@section('seo_social_stuff')
    <meta property="og:type" content="article"/>
    <meta property="og:site_name" content="{{ url('/') }}">
    <meta property="og:url" content="{{ url(\App\Post::getLink($post->id, false, $pcategory->id)) }}">
    <meta property="og:image" content="{{ url($post->image) }}">
@endsection

@section('content')

<div class="container">

    <div class="col-sm-8 mainText">
        <div class="col-sm-12">
            <ol class="breadcrumb">
                <li><a href="{{ url($pcategory->slug) }}">{{ $pcategory->title }}</a>
                <li class="active">{{ $post->title }}
            </ol>
            <h2 class="textNaslov">{!! \App\Post::getSpanTitle($post->title) !!}</h2>
            <p class="textPodnaslov">@if(false)I.N.O.X. Titanium model postaje obeležje ikoničnog identiteta…@endif</p>
        </div>
        {!! $post->body !!}
        @if(count($tags)>0)
            <ul class="tags">
                <li><span>Tagovi:</span></li>
                @foreach($tags as $t)
                    <li><a href="{{ url('tagovi/'.$t->slug.'/'.$t->id) }}">{{ $t->title }} </a></li>
                @endforeach
            </ul>
        @endif
        @include('themes.'.$theme->slug.'.partials.addthis-buttons')

    </div>
    <div class="col-sm-4 razmakLevo">
        @if(count($products))
        <div class="slider-bar2">
            <ul class="bxslider">
                @foreach($products as $p)
                <li>
                    <a href="{{ url(\App\Product::getProductLink($p->id)) }}">{!! HTML::image($p->image, $p->title) !!}</a>
                    <div class="caption2">
                        <ul>
                            <li>{{ \App\Product::getBrend($p->id) }}</li>
                            <li>{{ \App\Product::getLastCategory($p->id) }}</li>
                            <li>{{ $p->title }}</li>
                        </ul>
                        <a href="#"><div class="sh"></div></a>
                    </div>
                </li>
               @endforeach
            </ul>
        </div><!-- .slider-bar2 -->
        @endif

        @if(count($related) && $related)
        <div class="procitajJos">
            <h3>pročitaj još</h3>
        </div>

        @foreach($related as $r)
        <div class="vesti">
            <p class="datum">{{ date('d. m. Y.', strtotime($r->publish_at)) }}</p>
            <h4><a href="{{ \App\Post::getPostLink($r) }}">{!! \App\Post::getSpanTitle($r->title) !!}</a></h4>
            <p>{{ $r->short }}</p>
        </div><!-- .vesti -->
        @endforeach
        @endif

    </div>
    <div class="col-sm-12">
        @include('themes.'.$theme->slug.'.partials.shop-bar')
    </div>

</div><!-- .container -->

@endsection

@section('footer_scripts')

@endsection

