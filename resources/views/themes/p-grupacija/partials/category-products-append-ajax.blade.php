@if(count($products))
        @foreach($products as $p)
            <li>
                <ul>
                    <li><a href="{{ url(\App\Product::getProductLink($p->id)) }}">{{ \App\Product::getBrend($p->id) }}</a></li>
                    <li><a href="{{ url(\App\Product::getProductLink($p->id)) }}">{{ $p->code }}</a></li>
                    <li><a href="{{ url(\App\Product::getProductLink($p->id)) }}">{{ \App\Product::getLastCategory($p->id) }}</a></li>
                    <li>
                        <a href="{{ url(\App\Product::getProductLink($p->id)) }}">
                            <img class="img-zoom" src="{{ url(\Image::url($p->image ,212,307,array('crop'))) }}" alt="{{ $p->title }}">
                        </a>
                    </li>
                    <li><a href="{{ url(\App\Product::getProductLink($p->id)) }}">{{ $p->title }}</a></li>
                    @if($settings->price)
                    <li>{{ $p->price_small }} RSD</li>
                    @endif
                  @if(false)
                    <li>
                        <div class="sh">
                            <a href="{{ url(\App\Product::getProductLink($p->id)) }}"><div class="levom"></div></a>
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
        <div class="here" style="clear: both"></div>
@endif
<script>
    <?php if($empty){ ?>
    $('.more').slideUp()
    $('.some-more').slideUp();
    <?php } ?>
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

$('.category-products-3').find('.img-zoom').each(function () {
  var el = $(this);
 el.hover(function() {
  el.addClass('transition2');
}, function(){
  el.removeClass('transition2');
});

});
</script>