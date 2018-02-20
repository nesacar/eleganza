@if(count($collections) > 0)
<div class="shop-bar-flex up-30">
    @if($category->id == 14 || (isset($home) && $home))
        <h2>Asortiman proizvoda</h2>
    @else
        <h2><a href="{{ url('shop/satovi/tag-heuer') }}"> {{ $category->title }} kolekcije  </a></h2>
    @endif
    @foreach($collections as $c)
        <div class="shop-bar-item">
           <h3> <a href="{{ 'shop/'.\App\Category::getShopLink($c->id) }}" > {{ $c->title }} </a></h3>
            <div class="img-holder">
                <a href="{{ 'shop/'.\App\Category::getShopLink($c->id) }}">{!! HTML::Image($c->collection, $c->title) !!}</a>
           
            </div>
            @if(false)<a href="{{ 'shop/'.\App\Category::getShopLink($c->id) }}"><div class="sh" ></div></a>@endif
        </div>
          
    @endforeach
   
    @foreach($collections as $c)
      
           <h4 class="samo-naslovi"><a href="{{ 'shop/'.\App\Category::getShopLink($c->id) }}">{{ $c->title}}</a></h4>
    @endforeach
</div>
<div class="clear"></div>
<div class="down-20"></div>
@endif