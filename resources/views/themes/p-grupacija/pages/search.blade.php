@extends('themes.'.$theme->slug.'.index')

@section('title')
    Pretraga | p-grupacija.hr
@endsection

@section('keywords'){{ $settings->keywords }}@endsection

@section('seo_social_stuff')
    <meta property="og:type" content="article"/>
    <meta property="og:site_name" content="{{ url('/') }}">
    <meta property="og:url" content="{{ url('pretraga') }}">
    <meta property="og:image" content="{{ url('img/logo.png') }}">
@endsection

@section('content')

<h2 class="pretragaNaslov">Rezultati pretrage za termin: <span>{{ $text }}</span></h2>

<div class="pretraga">
    @if(count($products))
    <ul>
        @foreach($products as $product)
            @php $link = url(\App\Product::getProductLink($product->id)); @endphp
            <li>
                <ul>
                    <li><a href="#">{{ \App\Product::getBrend($product->id) }}</a></li>
                    <li><a href="#">{{ \App\Product::getLastCategory($product->id) }}</a></li>
                    <li><a href="{{ $link }}">{!! HTML::image($product->tmb) !!}</a></li>
                    <li>{{ $product->title }}</li>
                    <li>{{ $product->code }}</li>
                    <li>@if($settings->price) {{ $product->price_small }} RSD @endif</li>
                  @if(false)
                    <li>
                        <div class="sh">
                            <a href="{{ $link }}"><div class="levom"></div></a>
                            @if(false)
                                @if(\App\Product::productInSession($product->id))
                                    <a href="{{ url('admin/products/removetosession/'.$product->id) }}" class="dodavanje"><i class="fa fa-shopping-cart active" data-toggle="tooltip" data-placement="top" title="Izbaci iz korpe"></i></a>
                                @else
                                    <a href="{{ url('admin/products/addtosession/'.$product->id) }}" class="dodavanje"><i class="fa fa-shopping-cart" data-toggle="tooltip" data-placement="top" title="Dodaj u korpu"></i></a>
                                @endif
                            @endif
                            @if(false)<i class="fa fa-star" aria-hidden="true"></i>@endif
                        </div>
                    </li>
                  @endif
                </ul>
            </li>
        @endforeach
    </ul>
    @endif

    @if(count($posts))
        @foreach($posts as $post)
            @php $link = \App\Post::getPostLink($post); @endphp
            <article class="pretragaTekst">
                <div class="image-holder"><a href="{{ $link }}"> {!! HTML::image($post->image) !!}</a></div>
                <div class="pretragatxt">
                    <h2><a href="{{ $link }}"> {!! \App\Post::getSpanTitle($post->title) !!}</a></h2>
                    <p>{{ $post->short }}</p>
                    <a href="{{ $link }}"><div class="sh"></div></a>
                </div>
                <div class="clear"></div>
            </article>
        @endforeach
    @endif
</div>

@endsection

@section('footer_scripts')
    @if(false)
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
@endsection
