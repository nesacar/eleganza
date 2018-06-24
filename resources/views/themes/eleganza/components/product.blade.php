<li class="product-item product-list__item with-shadow">
    <ul class=product-item__actions>
        <li class="icon-btn icon-btn--inverse"><a href="{{ url('add-to-cart/'.$product->id) }}" class="addCart" style="z-index: 1;"><i class="fas fa-shopping-cart"></i></a> </li>
        <li class="icon-btn icon-btn--inverse"> <a href="{{ url('add-to-wishlist/'.$product->id) }}" class="addWish" style="z-index: 1;"><i class="fas fa-heart"></i></a> </li>
        <li class="icon-btn icon-btn--inverse"> <a href="{{ $product->getLink() }}" style="z-index: 1;"><i class="fas fa-search"></i></a> </li>
    </ul>
    <a href="{{ $product->getLink() }}">
        <div class=product-item__img-box>
            <img src="{{ url(\Imagecache::get($product->image, '315x420')->src) }}" alt="{{ $product->title }}">
            {{--{!! HTML::Image($product->image, $product->title) !!}--}}
        </div>
        <div class=product-item__info-box>
            <span class=product-item__brand>@if(isset($product->brand)) {{ $product->brand->title }} @endif</span>
            <h2 class=product-item__name>{{ $product->title }}</h2>
            @if($product->discount != null && $product->discount > 0)
                <span class=product-item__price>{{ $product->price_outlet }}</span>
            @else
                <span class=product-item__price>{{ $product->price_small }}</span>
            @endif
        </div>
        <button class="e-btn e-btn--primary e-btn--block">saznaj više</button>
    </a>
    @if($product->discount != null && $product->discount > 0)
        <div class="status status--sale">popust {{ $product->discount }}</div>
    @elseif(\App\Product::isNewProduct($product))
        <div class="status status--sale">novo</div>
    @endif
</li>