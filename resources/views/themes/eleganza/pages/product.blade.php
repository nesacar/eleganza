@extends('themes.'.$theme->slug.'.index')

@section('header-style')
    {!! HTML::style('themes/'.$theme->slug.'/css/jquery.toastmessage.css') !!}
@endsection

@section('content')

    <div>
        <div class=container>
            <nav aria-label=breadcrumb>
                <ol class=breadcrumb>
                    <li class=breadcrumb-item><a href="{{ url('/') }}">Home</a></li>
                    @if($s1 != null) @if($s1->id != $category->id) <li class=breadcrumb-item><a href={{ url(\App\Category::getCategoryLink($s1, 'hr')) }}>{{ $s1->title }}</a></li> @endif @endif
                    @if($s2 != null) @if($s2->id != $category->id) <li class=breadcrumb-item><a href={{ url(\App\Category::getCategoryLink($s2, 'hr')) }}>{{ $s2->title }}</a></li> @endif @endif
                    @if($s3 != null) @if($s3->id != $category->id) <li class=breadcrumb-item><a href={{ url(\App\Category::getCategoryLink($s3, 'hr')) }}>{{ $s3->title }}</a></li> @endif @endif
                    @if($s4 != null) @if($s4->id != $category->id) <li class=breadcrumb-item><a href={{ url(\App\Category::getCategoryLink($s4, 'hr')) }}>{{ $s4->title }}</a></li> @endif @endif
                    <li class="breadcrumb-item active" aria-current=page>{{ $product->title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class=page-header>
        <div class="container page-header__container">
            <h2 class=page-header__title>{{ $product->title }}</h2>
            <p>{{ $product->short }}</p>
        </div>
    </div>

    <section class="container content">
        <div class="row">

            <div class="col-xl-8 col-md-6 product-image">
                <div class="row owl-e-host">

                    <div class="col-xl-3">
                        <div class="owl-thumbs" data-slider-id="image-box">
                            <div class="e-image e-image--11 e-owl-thumbnail owl-thumb-item">
                                {!! HTML::Image($product->image, $product->title) !!}
                            </div>
                            @if(count($images)>0)
                                @foreach($images as $image)
                                    <div class="e-image e-image--11 e-owl-thumbnail owl-thumb-item">
                                        {!! HTML::Image($image->file_path, $product->title) !!}
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="col-xl-9" style="position: relative;">
                        <div class="product-image-box owl-carousel" data-slider-id="image-box" id="jsImageBox">
                            <div class="e-image e-image--11 product-image-box__image">
                                {!! HTML::Image($product->image, $product->title, array('data-zoom' => url($product->image))) !!}
                            </div>
                            @if(count($images)>0)
                                @foreach($images as $image)
                                    <div class="e-image e-image--11 product-image-box__image">
                                        {!! HTML::Image($image->file_path, $product->title, array('data-zoom' => url($image->file_path))) !!}
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="pane-container" id="jsPaneContainer"></div>
                </div>

                @if(!empty($product->body2))
                <div class="row">
                    <div class="col-xl-9 offset-xl-3">
                        {!! $product->body2 !!}
                    </div>
                </div>
                @endif
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="product-info">
                    <div class="product-info__section">
                        <h3 class="product__name">{{ $product->title }}</h3>
                        <div class="product__id product__hint-text">{{ $product->code }}</div>
                    </div>
                    <hr>
                    <div class="product-info__section product__price-box">
                        @if($product->price_outlet != $product->price_small)
                            <span class="product__price product__price--current">{{ $product->price_outlet }} kn</span>
                            <span class="product__price product__price--actual">{{ $product->price_small }} kn</span>
                        @else
                            <span class="product__price product__price--current">{{ $product->price_small }} kn</span>
                        @endif
                        @if($product->discount > 0)
                        <span class="product__price product__price--discount product__hint-text">popust {{ $product->discount }}%</span>
                        @endif
                        <p class="product__hint-text">dodatnih 5% popusta na online placanje</p>
                    </div>
                    <div class="product-info__section">
                        <button class="e-btn e-btn--primary e-btn--fat e-btn--block addCart" data-href="{{ url('add-to-cart/'.$product->id) }}">
                            dodaj u košaricu
                        </button>
                        <button class="e-btn e-btn--primary e-btn--fat e-btn--block addWish" data-href="{{ url('add-to-wishlist/'.$product->id) }}">
                            dodaj u listu zelja
                        </button>
                    </div>
                    <div class="product-info__section product__alt-colors">
                        <p class="product__hint-text">proizvod je dostupan i u drugim bojama</p>
                        <ul class="product__alt-colors__list">
                            <li class="e-image e-image--11">
                                <a href="#">
                                    {!! HTML::Image('themes/'.$theme->slug.'/img/product.jpg', '') !!}
                                </a>
                            </li>
                            <li class="e-image e-image--11">
                                <a href="#">
                                    {!! HTML::Image('themes/'.$theme->slug.'/img/product.jpg', '') !!}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <hr>
                    <div class="product-info__section product__attrs">
                        <h3>karakteristike</h3>
                        @if(!empty($product->body))
                            {!! $product->body !!}
                        @else
                            <ul class="product__attrs-list">
                                @if(!empty($product->brand))
                                <li class="product-attr">
                                    <span class="product-attr__key">Brend:</span>
                                    <span class="product-attr__value">{{ $product->brand->title }}</span>
                                </li>
                                @endif
                                <li class="product-attr">
                                    <span class="product-attr__key">Kolekcija:</span>
                                    <span class="product-attr__value">{{ \App\Product::getLastCategory($product->id) }}</span>
                                </li>
                                @if(count($attributes))
                                    @foreach($attributes as $attribute)
                                        <li class="product-attr">
                                            <span class="product-attr__key">{{ $attribute->property }}:</span>
                                            <span class="product-attr__value">{{ $attribute->title }}</span>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        @if(count($related)>0)
        <div class="content similar">
            <h2>slični proizvodi</h2>
            <ul class="similar-list">
                @foreach($related as $p)
                    <li class="product-item similar-list__item with-shadow">
                        <a href="{{ \App\Product::getProductLink($p->id) }}">
                            <div class="product-item__img-box">
                                {!! HTML::Image($p->image, $p->title) !!}
                            </div>
                            <div class="product-item__info-box">
                                <h2 class="product-item__name">{{ $p->title }}</h2>
                                <span class="product-item__price">{{ $p->price_small }}</span>
                            </div>
                            <button class="e-btn e-btn--primary e-btn--block">saznaj više</button>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        @endif
    </section>

    @include('themes.'.$theme->slug.'.partials.newsletter')

@endsection

@section('footer_scripts')
    {!! HTML::script('themes/'.$theme->slug.'/js/jquery-2.2.4.min.js') !!}
    {!! HTML::script('themes/'.$theme->slug.'/js/jquery.toastmessage.js') !!}
    <script>
        $(function () {

            $('.addWish').click(function(e){
                e.preventDefault();
                var link = $(this).attr('data-href');
                $.post(link, {_token: '{{ csrf_token() }}' }, function(data){
                    $().toastmessage('showSuccessToast', "proizvod je dodat u listu želja");
                });
            });

            $('.addCart').click(function(e){
                e.preventDefault();
                var link = $(this).attr('data-href');
                $.post(link, {_token: '{{ csrf_token() }}' }, function(data){
                    $().toastmessage('showSuccessToast', "proizvod je dodat u košaricu");
                });
            });
        });
    </script>
@endsection