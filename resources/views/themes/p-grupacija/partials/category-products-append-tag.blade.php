@if(count($products))
    <ul>
        @foreach($products as $p)
            <li>
                <ul>
                    <li><a href="#">{{ \App\Product::getBrend($p->id) }}</a></li>
                    <li><a href="#">{{ \App\Product::getLastCategory($p->id) }}</a></li>
                    <li>
                        <a href="{{ url(\App\Product::getProductTagLink($p->id)) }}">
                            <img src="{{ url(\Image::url($p->image ,212,307,array('crop'))) }}" alt="{{ $p->title }}">
                        </a>
                    </li>
                    <li>{{ $p->title }}</li>
                    <li>{{ $p->code }}</li>
                    <li>
                        <a href="{{ url(\App\Product::getProductTagLink($p->id)) }}"><div class="sh3"></div></a>
                    </li>
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
<script>
    var page = 1;
    $('.some-more').click(function(e){
        e.preventDefault();
        var el = $(this);
        $('#page').val(page);
        console.log('promena page2');
        $.post('{{ url("products/ajaxsearchtag?ajax=1") }}', $('#moja').serialize(), function(data){ if(data == 'empty'){ el.slideUp(); return false; } $('.more-products').before(data); } );
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
</script>