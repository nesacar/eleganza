<div class="category-nav">
    <div class="side-title-first">
        Kategorije <i class="strelica nema"></i>
    </div>

    @if(false)
        <ul class="main-nav">
            @if(isset($categories))
                @foreach($categories as $cat)
                    @if($category->id == $cat->id)
                        <?php $child = \App\Category::where('parent', $category->id)->where('publish', 1)->orderby('order', 'ASC')->get(); ?>
                        @if(isset($child))
                            <li class="topic">
                                <a href="{{ url('shop/'.\App\Category::getShopLink($cat->id)) }}" class="active">{{ $cat->title }}</a>
                                <ul class="open sek">
                                    @foreach($child as $ch)
                                        <li><a href="{{ url('shop/'.\App\Category::getShopLink($ch->id)) }}" class="nivo3">{{ $ch->title }}</a><span class="num">{{ $ch->product()->where('amount', '>', 0)->count() }}</span></li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li><a href="#" class="">{{ $cat->title }}</a><span class="num">5</span></li>
                        @endif
                    @else
                        @if(false)
                            <li class="topic"><a href="{{ url('shop/'.\App\Category::getShopLink($cat->id)) }}" class="nivo1">{{ $cat->title }}</a><span class="num">{{ $cat->product()->where('amount', '>', 0)->count() }}</span></li>
                        @endif
                    @endif
                @endforeach
                <?php $brends = \App\Category::getCategoryBrend($category->id); ?>
                @foreach($brends as $brend)
                    <li><a href="{{ url('shop/'.$brend->slug) }}" class="">{{ $brend->title }}</a><span class="num">{{ $brend->product()->where('amount', '>', 0)->count() }}</span></li>
                @endforeach
            @endif
        </ul>
    @endif
    {!! \App\Category::getShopCategories($category->id, false, false, true) !!}

    {!! Form::hidden('category_id', $category->id) !!}
    {!! Form::hidden('page', 0, array('id' => 'page')) !!}
    @if(count($category->osobina) > 0)

        <div class="filters">
            <div class="side-title">
                Filteri <i class="strelica nema"></i>
            </div>
            <?php $br=0; ?>
            @foreach($category->osobina as $oso)
                <?php $br++; ?>
                @if(count($oso->attribute) > 0)
                    <div class="filter @if($br==1) prvi @endif">
                        <div class="category-filter">
                            <span class="text">{{ $oso->title }}</span> <i class="strelica" aria-hidden="true"></i>
                        </div>
                        <ul @if(\App\Cart::checkFilterNav($oso->attribute, $category->id)) style="display: block" @endif>
                            @foreach($oso->attribute as $a)
                                @if($a->publish == 1 && in_array($a->title, $filters))
                                    <li>
                                        <div class="squaredTwo2">
                                            <input type="checkbox" value="{{ $a->id }}" id="{{ $a->title }}" name="filter[]" @if(\App\Cart::checkFilterNav($oso->attribute, $category->id, $a->id)) checked @endif />
                                            <label for="{{ $a->title }}"></label>
                                            <a href="#" style="float: left">{{ $a->title }}</a><a href="#"><i class="close-filter" aria-hidden="true"></i></a>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div><!-- .filter -->
                @endif
            @endforeach
        </div>

    @else
        nema fltera za ovu kategoriju
    @endif

</div><!-- .category-nav -->

<div class="category-products">
@if(count($products))
    <ul>
        @foreach($products as $p)
            <li>
                <ul>
                    <li><a href="{{ url(\App\Product::getProductLink($p->id)) }}">{{ \App\Product::getBrend($p->id) }}</a></li>
                    <li><a href="{{ url(\App\Product::getProductLink($p->id)) }}">{{ \App\Product::getLastCategory($p->id) }}</a></li>
                    <li><a href="{{ url(\App\Product::getProductLink($p->id)) }}">{!! HTML::image($p->image) !!}</a></li>
                    <li><a href="{{ url(\App\Product::getProductLink($p->id)) }}">{{ $p->title }}</a></li>
                    <li><a href="{{ url(\App\Product::getProductLink($p->id)) }}">{{ $p->code }}</a></li>
                    @if($settings->price)
                    <li>{{ $p->price_small }} RSD</li>
                    @endif
                  @if(false)
                    <li>
                        <div class="sh">
                            <div class="levom"></div>
                            @if(\App\Product::productInSession($p->id))
                                <a href="{{ url('admin/products/removetosession/'.$p->id) }}" class="dodavanje"><i class="fa fa-shopping-cart active" data-toggle="tooltip" data-placement="top" title="Izbaci iz korpe"></i></a>
                            @else
                                <a href="{{ url('admin/products/addtosession/'.$p->id) }}" class="dodavanje"><i class="fa fa-shopping-cart" data-toggle="tooltip" data-placement="top" title="Dodaj u korpu"></i></a>
                            @endif
                            @if(false)<i class="fa fa-star" aria-hidden="true"></i>@endif
                        </div>
                    </li>
                    @endif
                </ul>
            </li>
        @endforeach
        <li class="more-products" style="clear: both"></li>
    </ul>
    <a class="some-more" href="#">
        {!! HTML::image('img/more-arrow.png', 'more') !!}
    </a>
    @else
        Nema proizvoda za traženu kategoriju
    @endif
</div><!-- .category-products -->

<script>
    var page = 1;
    $('.some-more').click(function(e){
        e.preventDefault();
        var el = $(this);
        $('#page').val(page);
        console.log('promena page2');
        $.post('{{ url("products/ajaxsearch?ajax=1") }}', $('#moja').serialize(), function(data){ if(data == 'empty'){ el.slideUp(); return false; } $('.more-products').before(data); } );
        page++;
        return false;
    });

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

    $('.strelica').click(function(){
        $(this).parent().parent().find('ul').slideToggle();
    });

    $('input[type="checkbox"]').click(function(){
        $('#page').val(0);
        $.post('{{ url("products/ajaxsearch") }}', $('#moja').serialize(), function(data){ $('.za-ajax').html(data);} );
    });
</script>