<div class="category-products-3">
    @if(count($products))
        <ul>
            @foreach($products as $p)
            <li>
                <ul>
                    @php $link = url(\App\Product::getProductLink($p->id)); @endphp
                    <li><a href="{{ $link }}">{{ \App\Product::getBrend($p->id) }}</a></li>
                    <li><a href="{{ $link }}">{{ $p->code }}</a></li>
                    <li><a href="{{ $link }}">{{ \App\Product::getLastCategory($p->id) }}</a></li>
                    <li>
                        <a href="{{ $link }}">
                            <img class="img-zoom" src="{{ url($p->tmb) }}" alt="{{ $p->title }}">
                        </a>
                    </li>
                    <li><a href="{{ $link }}">{{ $p->title }}</a></li>
                    @if($settings->price)
                    <li>{{ $p->price_small }} RSD</li>
                    @endif
                   @if(false)
                       <li>
                        <div class="sh">
                            <a href="{{ $link }}"><div class="levom"></div></a>
                            @if(false)
                                @if(\App\Product::productInSession($p->id))
                                    <a href="{{ url('admin/products/removetosession/'.$p->id) }}" class="dodavanje"><i class="fa fa-shopping-cart active" data-toggle="tooltip" data-placement="top" title="Izbaci iz korpe"></i></a>
                                @else
                                    <a href="{{ url('admin/products/addtosession/'.$p->id) }}" class="dodavanje"><i class="fa fa-shopping-cart" data-toggle="tooltip" data-placement="top" title="Dodaj u korpu"></i></a>
                                @endif
                            @endif
                            @if(false)<i class="fa fa-star" aria-hidden="true"></i>@endif
                        </div>
                    </li>
                    @endif
                </ul>
            </li>
            @endforeach
            <li id="more-products" style="clear: both"></li>
        </ul>
    @else
        Nema proizvoda za traženu kategoriju
    @endif
</div><!-- .category-products -->
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            {!! str_replace('/?', '?', $products->appends(\Illuminate\Support\Facades\Input::all())->render()) !!}
        </div>
    </div>
</div>
@if(false)
    <a class="more" href="{{ url('products/more/'.$category->id.'/ajax') }}">
        Prikaži još
        {!! HTML::image($theme->slug.'/img/more-arrow.png', 'more') !!}
    </a>
@endif