@extends('themes.'.$theme->slug.'.index')

@section('title')
   Atribut | p-grupacija.hr
@endsection

@section('keywords'){{ $settings->keywords }}@endsection

@section('seo_social_stuff')
    <meta property="og:type" content="article"/>
    <meta property="og:site_name" content="{{ url('/') }}">
    <meta property="og:url" content="{{ url('pretraga') }}">
    <meta property="og:image" content="{{ url('img/logo.png') }}">
@endsection

@section('content')

<h2 class="pretragaNaslov">Proizvodi sa atributom: <span>{{ $attribut->title }}</span></h2>

<div class="pretraga">
    @if(count($products))
    <ul>
        @foreach($products as $product)
            @php $link = url(\App\Product::getProductLink($product->id)); @endphp
            <li>
                <ul>
                    <li><a href="#">{{ \App\Product::getBrend($product->id) }}</a></li>
                    <li><a href="#">{{ \App\Product::getLastCategory($product->id) }}</a></li>
                    <li><a href="{{ $link }}">{!! HTML::Image($product->tmb, $product->title) !!}</a></li>
                    <li>{{ $product->title }}</li>
                    <li>{{ $product->code }}</li>
                    <li>@if($settings->price) {{ $product->price_small }} RSD @endif</li>

                    <li>
                        @if(false)
                        <div class="sh">
                            <div class="levom"></div>
                            @if(\App\Product::productInSession($product->id))
                                <a href="{{ url('admin/products/removetosession/'.$product->id) }}" class="dodavanje"><i class="fa fa-shopping-cart active" data-toggle="tooltip" data-placement="top" title="Izbaci iz korpe"></i></a>
                            @else
                                <a href="{{ url('admin/products/addtosession/'.$product->id) }}" class="dodavanje"><i class="fa fa-shopping-cart" data-toggle="tooltip" data-placement="top" title="Dodaj u korpu"></i></a>
                            @endif
                            @if(false)<i class="fa fa-star" aria-hidden="true"></i>@endif
                        </div>
                        @endif
                    </li>
                </ul>
            </li>
        @endforeach
        @if(false)
            <div class="more-posts" style="clear: both"></div>
            {!! HTML::image('img/more-arrow.png', 'more', array('class' => 'more-more')) !!}
            <div style="clear: both"></div>
        @else
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        {!! str_replace('/?', '?', $products->render()) !!}
                    </div>
                </div>
            </div>
        @endif
    </ul>
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


    var page=1;
    $('.more-more').click(function(e){
    page++;
    var el = $(this);
    e.preventDefault();
    $.post('{{ url('atributeajax/'.$attribut->title) }}', {_token: '{{ csrf_token() }}' , page: page}, function(data){ if(data == 'empty'){ el.slideUp(); return; } $('.more-posts').before(data); });
    });
    @endif
@endsection
