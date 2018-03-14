@if(count($products)>0)
<div class="container">
    <h3 class="e-subheading">best sellers</h3>
    <div class="owl-carousel" data-is-carousel="true">
        @foreach($products as $product)
            <div class="product-item no-mragin">
                <a href="{{ \App\Product::getProductLink($product->id) }}">
                    <div class="product-item__img-box">
                        {!! HTML::Image($product->image, $product->title) !!}
                    </div>
                    <div class="product-item__info-box">
                        @if(!empty($product->brand))
                            <span class="product-item__brand">{{ $product->brand->title }}</span>
                        @endif
                        <h2 class="product-item__name">{{ $product->title }}</h2>
                        <span class="product-item__price">{{ $product->price_outlet }}</span>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endif