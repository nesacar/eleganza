@extends('themes.'.$theme->slug.'.index')

@section('content')

    <div>
        <div class=container>
            <nav aria-label=breadcrumb>
                <ol class=breadcrumb>
                    <li class=breadcrumb-item><a href=#>Home</a></li>
                    <li class=breadcrumb-item><a href=#>Something</a></li>
                    <li class="breadcrumb-item active" aria-current=page>Library</li>
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
                        <span class="product__price product__price--current">7200 kn</span>
                        <span class="product__price product__price--actual">7138 kn</span>
                        <span class="product__price product__price--discount product__hint-text">popust 10%</span>
                        <p class="product__hint-text">dodatnih 5% popusta na online placanje</p>
                    </div>
                    <div class="product-info__section">
                        <button class="e-btn e-btn--primary e-btn--fat e-btn--block">
                            dodaj u košaricu
                        </button>
                        <button class="e-btn e-btn--primary e-btn--fat e-btn--block">
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
                        <ul class="product__attrs-list">
                            <li class="product-attr">
                                <span class="product-attr__key">Brend:</span>
                                <span class="product-attr__value">MOVADO</span>
                            </li>
                            <li class="product-attr">
                                <span class="product-attr__key">Kolekcija:</span>
                                <span class="product-attr__value">EDGE</span>
                            </li>
                            <li class="product-attr">
                                <span class="product-attr__key">Materijal kucista:</span>
                                <span class="product-attr__value">celik</span>
                            </li>
                            <li class="product-attr">
                                <span class="product-attr__key">Boja brojcanika:</span>
                                <span class="product-attr__value">plava</span>
                            </li>
                            <li class="product-attr">
                                <span class="product-attr__key">Materijal remena:</span>
                                <span class="product-attr__value">koza</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

        <div class="content similar">
            <h2>slični proizvodi</h2>
            <ul class="similar-list">

                <li class="product-item similar-list__item with-shadow">
                    <a href="#">
                        <div class="product-item__img-box">
                            {!! HTML::Image('themes/'.$theme->slug.'/img/product.jpg', '') !!}
                        </div>
                        <div class="product-item__info-box">
                            <h2 class="product-item__name">item name</h2>
                            <span class="product-item__price">1234</span>
                        </div>
                        <button class="e-btn e-btn--primary e-btn--block">saznaj više</button>
                    </a>
                </li>

                <li class="product-item similar-list__item with-shadow">
                    <a href="#">
                        <div class="product-item__img-box">
                            {!! HTML::Image('themes/'.$theme->slug.'/img/product.jpg', '') !!}
                        </div>
                        <div class="product-item__info-box">
                            <h2 class="product-item__name">item name</h2>
                            <span class="product-item__price">1234</span>
                        </div>
                        <button class="e-btn e-btn--primary e-btn--block">saznaj više</button>
                    </a>
                </li>
                <li class="product-item similar-list__item with-shadow">
                    <a href="#">
                        <div class="product-item__img-box">
                            {!! HTML::Image('themes/'.$theme->slug.'/img/product.jpg', '') !!}
                        </div>
                        <div class="product-item__info-box">
                            <h2 class="product-item__name">item name</h2>
                            <span class="product-item__price">1234</span>
                        </div>
                        <button class="e-btn e-btn--primary e-btn--block">saznaj više</button>
                    </a>
                </li>
                <li class="product-item similar-list__item with-shadow">
                    <a href="#">
                        <div class="product-item__img-box">
                            {!! HTML::Image('themes/'.$theme->slug.'/img/product.jpg', '') !!}
                        </div>
                        <div class="product-item__info-box">
                            <h2 class="product-item__name">item name</h2>
                            <span class="product-item__price">1234</span>
                        </div>
                        <button class="e-btn e-btn--primary e-btn--block">saznaj više</button>
                    </a>
                </li>

            </ul>
        </div>
    </section>

    @include('themes.'.$theme->slug.'.partials.newsletter')

@endsection