@if(count($product_posts))
<div class="products-slider">
    <article class="left">
        <div class="image-holder">
            <a href="{{ \App\Post::getLink($product_posts[0]->id, $home, $category->id) }}">{!! HTML::image($product_posts[0]->image) !!}</a>
            <div class="caption">
                <h3><a href="{{ \App\Post::getLink($product_posts[0]->id, $home, $category->id) }}">{!! \App\Post::getSpanTitle($product_posts[0]->title) !!}</a></h3>
                <a href="{{ \App\Post::getLink($product_posts[0]->id, $home, $category->id) }}">
                    <div class="sh"></div>
                </a>
            </div>
        </div>
        @if(count($product_posts[0]->product))
        <div class="slider-bar">
            <ul class="bxslider">
                @foreach($product_posts[0]->product as $p)
                <li>
                    <a href="{{ \App\Product::getProductLink($p->id) }}">{!! HTML::image($p->image) !!}</a>
                    <div class="caption2">
                        <ul>
                            <li>{{ \App\Product::getBrend($p->id) }}</li>
                            <li>{{ \App\Product::getLastCategory($p->id) }}</li>
                            <li>{{ $p->title }}</li>
                        </ul>
                        <a href="{{ \App\Product::getProductLink($p->id) }}"><div class="sh"></div></a>
                    </div>
                </li>
                @endforeach
            </ul>
        </div><!-- .slider-bar -->
        @endif
    </article> <!-- .left -->
    <div class="clear"></div>
    @if(isset($product_posts[1]))
    <article class="right">
        <div class="image-holder">
            <a href="{{ \App\Post::getLink($product_posts[1]->id, $home, $category->id) }}">{!! HTML::image($product_posts[1]->image) !!}</a>
            <div class="caption">
                <h3><a href="{{ \App\Post::getLink($product_posts[1]->id, $home, $category->id) }}">{!! \App\Post::getSpanTitle($product_posts[1]->title) !!}</a></h3>
                <a href="{{ \App\Post::getLink($product_posts[1]->id, $home, $category->id) }}">
                    <div class="sh"></div>
                </a>
            </div>
        </div>
        @if(count($product_posts[0]->product))
        <div class="slider-bar">
            <ul class="bxslider">
                @foreach($product_posts[1]->product as $p)
                <li>
                    <a href="{{ \App\Product::getProductLink($p->id) }}">{!! HTML::image($p->image) !!}</a>
                    <div class="caption3">
                        <ul>
                            <li>{{ \App\Product::getBrend($p->id) }}</li>
                            <li>{{ \App\Product::getLastCategory($p->id) }}</li>
                            <li>{{ $p->title }}</li>
                        </ul>
                        <a href="{{ \App\Product::getProductLink($p->id) }}"><div class="sh"></div></a>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        @endif
    </article> <!-- .right -->
    <div class="clear"></div>
    @endif
</div>
@endif