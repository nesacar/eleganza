@if(count($products))
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
</script>