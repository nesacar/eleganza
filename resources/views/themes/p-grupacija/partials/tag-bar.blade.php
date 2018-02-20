<div class="tag-heuer-shop-bar">
    <div class="tag-slajfna">
        <a href="{{ url('tag-heuer/satovi') }}">{!! HTML::image(url('img/TH_Logo_neg.png')) !!}</a>
    </div>
    @if(count($children) > 0)
        <div class="tag-slajfna2">
        @foreach($children as $c)
                <h2><a href="{{ url('tag-heuer/'.\App\Category::getTagLink($c->id)) }}">{{ $c->title }}</a></h2>
        @endforeach
        </div>
        @foreach($children as $c)
            <div class="col-md-4 muski">
            <?php $ch = \App\Category::where('parent', $c->id)->orderby('order', 'ASC')->get(); ?>
                @if(count($ch) > 0)
                    <ul class="th-satovi">
                    @foreach($ch as $some)
                        <li><h3><a href="{{ url('tag-heuer/'.\App\Category::getTagLink($some->id)) }}">{{ $some->title }}</a></h3></li>
                    @endforeach
                    </ul>
                @endif
            </div>
        @endforeach
    <div style="clear: both"></div>
    @endif
</div><div style="clear: both"></div>