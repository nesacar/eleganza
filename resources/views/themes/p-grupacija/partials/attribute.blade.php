
@if(count($products))
    @foreach($products as $product)
    <li>
        <ul>
            <li><a href="#">{{ \App\Product::getBrend($product->id) }}</a></li>
            <li><a href="#">{{ \App\Product::getLastCategory($product->id) }}</a></li>
            <li><a href="{{ url(\App\Product::getProductLink($product->id)) }}"><img src="{{ url(\Image::url($product->image ,176,254,array('crop'))) }}" alt="{{ $product->title }}"></a></li>
            <li>{{ $product->title }}</li>
            <li>{{ $product->code }}</li>
            <li>{{ $product->price_small }} RSD</li>

            <li>
                <div class="sh">
                    <div class="levom"></div>
                    @if(\App\Product::productInSession($product->id))
                        <a href="{{ url('admin/products/removetosession/'.$product->id) }}" class="dodavanje"><i class="fa fa-shopping-cart active" data-toggle="tooltip" data-placement="top" title="Izbaci iz korpe"></i></a>
                    @else
                        <a href="{{ url('admin/products/addtosession/'.$product->id) }}" class="dodavanje"><i class="fa fa-shopping-cart" data-toggle="tooltip" data-placement="top" title="Dodaj u korpu"></i></a>
                    @endif
                    @if(false)<i class="fa fa-star" aria-hidden="true"></i>@endif
                </div>
            </li>
        </ul>
    </li>
    @endforeach
@endif
<script>
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
</script>

