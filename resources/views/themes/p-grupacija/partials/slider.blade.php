<div class="slider-box">
    @if(count($sliders))
    <ul class="bxslider top-one">
        @foreach($sliders as $s)
        <li>
            @php $link = \App\Post::getPostLink($s); @endphp
            <a href="{{ $link }}">{!! HTML::Image($s->tmb, $s->title, array('style' => 'width:')) !!}</a>
            <div @if($s->side) class="caption-left" @else class="caption" @endif>
                <a href="{{ $link }}"><h2>{!! \App\Post::getSpanTitle($s->title) !!}</h2></a>
                @if(false)<p>{{ $s->short }}</p>@endif
                <a href="{{ $link }}"><span class="caption-arrow"></span></a>
            </div>
        </li>
        @endforeach
    </ul>
    @endif
</div><!-- .slider-box -->