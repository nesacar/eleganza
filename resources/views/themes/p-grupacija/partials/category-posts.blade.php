@if(count($posts))
<?php $br=0; ?>
<div class="products" @if(isset($ajax) && $ajax) style="margin-top: -20px" @endif>
    @foreach($posts as $p)
    @php $br++; $link = \App\Post::getPostLink($p); @endphp
    <?php if($br%2==0){ $class = "right"; }else{ $class = "left"; } ?>
    <article class="{{ $class }}">
        <a href="{{ $link }}">
            <div class="image-holder">
                {!! HTML::image($p->image) !!}
            </div>
        </a>
        <div class="text-holder">
            <h2><a href="{{ $link }}">{!! \App\Post::getSpanTitle($p->title) !!}</a></h2>
            <p>{{ $p->short }}</p>
            <a href="{{ $link }}">
                <div class="sh"></div>
            </a>
        </div>
    </article>
    <div class="clear"></div>
    @endforeach
</div>
@endif
<script>
    var w = $(window).width();
    imageMask(w);
    function imageMask(w){
        if(w > 768){
            $('.left .image-holder').each(function(){
                $(this).hover(
                        function(){
                            var w = $(this).css('width');
                            var h = $(this).css('height');
                            $(this).find('img').parent().append('<div class="mask-holder" style="width: '+w+';height:'+h+'"></div>');
                        },
                        function(){
                            $(this).find('.mask-holder').remove();
                        }
                );
            });

            $('.right .image-holder').each(function(){
                $(this).hover(
                        function(){
                            var w = $(this).css('width');
                            var h = $(this).css('height');
                            $(this).find('img').parent().append('<div class="mask-holder" style="width: '+w+';height:'+h+'"></div>');
                        },
                        function(){
                            $(this).find('.mask-holder').remove();
                        }
                );
            });
        }
    }
</script>