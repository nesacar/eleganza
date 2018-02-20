@if(count($collections) > 0)
<div class="shop-bar-2 up-30">
    @if($category->id == 14)
        <h2>Asortiman proizvoda</h2>
    @else
        <h2><a href="{{ url('shop/satovi/tag-heuer') }}"> {{ $category->title }} kolekcije  </a></h2>
    @endif
    @foreach($collections as $c)
        <div class="col-md-2 col-sm-4">
           <h3> <a href="{{ 'shop/'.\App\Category::getShopLink($c->id) }}" > {{ $c->title }} </a></h3> 
            <div class="img-holder">
                <a href="{{ 'shop/'.\App\Category::getShopLink($c->id) }}"><img src="{{ url(\Image::url($c->collection ,208,300,array('crop'))) }}" alt="{{ $c->title }}"></a>
            </div>
            @if(false)<a href="{{ 'shop/'.\App\Category::getShopLink($c->id) }}"><div class="sh" ></div></a>@endif
        </div>
    @endforeach
    @foreach($collections as $c)
        <h4 class="samo-naslovi"><a href="{{ 'shop/'.\App\Category::getShopLink($c->id) }}">{{ $c->title }}</a></h4>
    @endforeach
    <div class="clear"></div>
</div>
@endif