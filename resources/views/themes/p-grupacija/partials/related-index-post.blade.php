<div class="container" >
    @if(count($posts1))
        <div class="products" style="margin-top: 0;">
            <?php $br=0; ?>
            @foreach($posts1 as $post)
                <?php $br++; ?>
                @if($br <= 2)
                    <article @if($br == 1)class="left"@else class="right"@endif>
                        <a href="#">
                            <div class="image-holder">
                                {!! HTML::image($post->image) !!}
                            </div>
                        </a>
                        <div class="text-holder" >
                            <h2><a href="#">{{ $post->title }}</a></h2>
                            <p>{{ $post->short }}</p>
                            <a href="#">
                                <div class="sh"></div>
                            </a>
                        </div>
                    </article>
                    <div class="clear"></div>
                @endif
            @endforeach
        </div>
    @endif
</div>