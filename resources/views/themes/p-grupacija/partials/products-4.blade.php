@if(count($posts1))
<div class="products">
    <article class="left">
        <a href="{{ \App\Post::getLink($posts1[0]->id, $home, $category->id) }}">
            <div class="image-holder">
                {!! HTML::image($posts1[0]->image) !!}
            </div>
        </a>
        <div class="text-holder">
            <h2><a href="{{ \App\Post::getLink($posts1[0]->id, $home, $category->id) }}">{!! \App\Post::getSpanTitle($posts1[0]->title) !!}</a></h2>
            <p>{{ $posts1[0]->short }}</p>
            <a href="{{ \App\Post::getLink($posts1[0]->id, $home, $category->id) }}">
                <div class="sh"></div>
            </a>
        </div>
    </article>
    <div class="clear"></div>
    @if(isset($posts1[1]))
    <article class="right">
        <a href="{{ \App\Post::getLink($posts1[1]->id, $home, $category->id) }}">
            <div class="image-holder">
                {!! HTML::image($posts1[1]->image) !!}
            </div>
        </a>
        <div class="text-holder">
            <h2><a href="{{ \App\Post::getLink($posts1[1]->id, $home, $category->id) }}">{!! \App\Post::getSpanTitle($posts1[1]->title) !!}</a></h2>
            <p>{{ $posts1[1]->short }}</p>
            <a href="{{ \App\Post::getLink($posts1[1]->id, $home, $category->id) }}">
                <div class="sh"></div>
            </a>
        </div>
    </article>
    <div class="clear"></div>
    @endif
    <article class="left">
        <a href="{{ \App\Post::getLink($posts2[0]->id, $home, $category->id) }}">
            <div class="image-holder">
                {!! HTML::image($posts2[0]->image) !!}
            </div>
        </a>
        <div class="text-holder">
            <h2><a href="{{ \App\Post::getLink($posts2[0]->id, $home, $category->id) }}">{!! \App\Post::getSpanTitle($posts2[0]->title) !!}</a></h2>
            <p>{{ $posts2[0]->short }}</p>
            <a href="{{ \App\Post::getLink($posts2[0]->id, $home, $category->id) }}">
                <div class="sh"></div>
            </a>
        </div>
    </article>
    <div class="clear"></div>
    @if(isset($posts2[1]))
        <article class="right">
            <a href="{{ \App\Post::getLink($posts2[1]->id, $home, $category->id) }}">
                <div class="image-holder">
                    {!! HTML::image($posts2[1]->image) !!}
                </div>
            </a>
            <div class="text-holder">
                <h2><a href="{{ \App\Post::getLink($posts2[1]->id, $home, $category->id) }}">{!! \App\Post::getSpanTitle($posts2[1]->title) !!}</a></h2>
                <p>{{ $posts2[1]->short }}</p>
                <a href="{{ \App\Post::getLink($posts2[1]->id, $home, $category->id) }}">
                    <div class="sh"></div>
                </a>
            </div>
        </article>
        <div class="clear"></div>
    @endif
</div>
@endif