@extends('themes.'.$theme->slug.'.index')

@section('header-style')
    {!! HTML::style('themes/'.$theme->slug.'/css/jquery.toastmessage.css') !!}
@endsection

@section('content')

    <div>
        <div class=container>
            @if(!empty($breadcrumb))
                {!! $breadcrumb !!}
            @endif
        </div>
    </div>

    {{-- <div class=page-header>
        <div class="container page-header__container">
            <h2 class=page-header__title>{{ $product->title }}</h2>
            <p>{{ $product->short }}</p>
        </div>
    </div> --}}

    <section class="container content">
        <div class="row">

            <div class="col-xl-8 col-md-6 product-image">
                <div class="row owl-e-host">

                    <div class="col-xl-3">
                        <div class="owl-thumbs" data-slider-id="image-box">
                            <div class="e-image e-image--11 e-owl-thumbnail owl-thumb-item">
                                <img src="{{ url(\Imagecache::get($product->image, '50x73')->src) }}" alt="{{ $product->title }}">
                            </div>
                            @if(count($images)>0)
                                @foreach($images as $image)
                                    <div class="e-image e-image--11 e-owl-thumbnail owl-thumb-item">
                                        <img src="{{ url(\Imagecache::get($image->file_path, '50x73')->src) }}" alt="{{ $product->title }}">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="col-xl-9" style="position: relative;">
                        <div class="product-image-box owl-carousel" data-slider-id="image-box" id="jsImageBox">
                            <div class="e-image e-image--11 product-image-box__image">
                                @if(!empty($product->image))
                                    {!! HTML::Image($product->image, $product->title, array('data-zoom' => url($product->image))) !!}
                                @endif
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
                            <span class="product__price product__price--discount product__hint-text">popust {{ $product->discount }}
                                %</span>
                        @endif
                        <p class="product__hint-text">dodatnih 5% popusta na online placanje</p>
                    </div>
                    <div class="product-info__section">
                        @if($product->amount > 0)
                            <button class="e-btn e-btn--primary e-btn--fat e-btn--block addCart"
                                    data-href="{{ url('add-to-cart/'.$product->id) }}">
                                dodaj u košaricu
                            </button>
                        @else
                            <button class="e-btn e-btn--primary e-btn--fat e-btn--block"
                                    data-e-controls="#jsModalOrder">
                                rezerviši
                            </button>
                        @endif
                        <button class="e-btn e-btn--primary e-btn--fat e-btn--block addWish"
                                data-href="{{ url('add-to-wishlist/'.$product->id) }}">
                            dodaj u listu zelja
                        </button>
                    </div>
                    @if(!empty($similar) && count($similar)>0)
                        <div class="product-info__section product__alt-colors">
                            <p class="product__hint-text">proizvod je dostupan i u drugim bojama</p>
                            <ul class="product__alt-colors__list">
                                @foreach($similar as $item)
                                    <li class="e-image e-image--11">
                                        <a href="{{ $item->getLink() }}">
                                            {!! HTML::Image($item->image, $item->title) !!}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <hr>
                    @endif
                    <div class="product-info__section product__attrs">
                        <h3>karakteristike</h3>
                        <ul class="product__attrs-list js-v-grid">
                            <li class="product-attr js-v-grid-item">
                                <div class="js-v-grid-item_content">
                                    @php $collection = $product->getCollection(); @endphp
                                    @if(!empty($collection))
                                        <b>Kolekcija:</b> {{ $collection }}
                                    @endif
                                    <span>{{ \App\Product::getLastCategory($product->id) }}</span>
                                </div>
                            </li>
                            @if(count($attributes))
                                @foreach($attributes as $attribute)
                                    <li class="product-attr js-v-grid-item">
                                        <div class="js-v-grid-item_content">
                                            <b>{{ \App\Helper::removeBrackets($attribute->property) }}:</b>
                                            <span>{{ $attribute->title }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>

                    </div>
                </div>
            </div>

        </div>

        @if(!empty($product->body))
            <div class="container">
                <div class="row">
                    {!! $product->body !!}
                </div>
            </div>
        @endif

        @if(count($related)>0)
            <div class="content similar">
                <h2>slični proizvodi</h2>
                <ul class="similar-list">
                    @foreach($related as $p)
                        <li class="product-item similar-list__item with-shadow">
                            <a href="{{ $p->getLink() }}">
                                <div class="product-item__img-box">
                                    <img src="{{ url(\Imagecache::get($p->image, '173x231')->src) }}" alt="{{ $p->title }}">
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

@section('modal')
    @if($product->amount == 0)
        @include('themes.'.$theme->slug.'.partials.modal')
    @endif
@endsection

@section('footer_scripts')
    {!! HTML::script('themes/'.$theme->slug.'/js/jquery-2.2.4.min.js') !!}
    {!! HTML::script('themes/'.$theme->slug.'/js/jquery.toastmessage.js') !!}
    <script>
        $(function () {

            $('.addWish').click(function (e) {
                e.preventDefault();
                var link = $(this).attr('data-href');
                $.post(link, {_token: '{{ csrf_token() }}'}, function (data) {
                    $().toastmessage('showSuccessToast', "proizvod je dodat u listu želja");
                });
            });

            $('.addCart').click(function (e) {
                e.preventDefault();
                var link = $(this).attr('data-href');
                $.post(link, {_token: '{{ csrf_token() }}'}, function (data) {
                    $().toastmessage('showSuccessToast', "proizvod je dodat u košaricu");
                });
            });

            @if(\Session::has('done'))
                $().toastmessage('showSuccessToast', "{{ \Session::get('done') }}");
            @endif
        });
    </script>
@endsection