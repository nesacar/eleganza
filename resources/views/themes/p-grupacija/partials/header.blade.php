<header>
    <ul class="left-menu">
        @if(count($leftTopMenu))
            @foreach($leftTopMenu as $l)
            <li><a href="{{ url($l->link) }}" class="trig @if(isset($active)) @if($l->link == $active) active @endif @endif" id="{{ $l->link }}">{{ $l->title }}</a></li>
            @endforeach
        @endif
    </ul>
    <div class="logo">
        <a href="{{ url('/') }}">{!! HTML::image($theme->slug.'/img/P-Grupacija_logo.png', 'P Grupacija') !!}</a>
    </div>
    <ul class="right-menu">
        @if(count($rightTopMenu))
            @foreach($rightTopMenu as $r)
                <li class="hide-1080"><a href="{{ url($r->link) }}">{{ $r->title }}</a></li>
            @endforeach
        @endif
        @if(false)
        <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i></a></li>
        <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
        @endif
        <li><a href="{{ url('korpa') }}"><i class="fa fa-shopping-bag" aria-hidden="true"></i></a></li>
    </ul>
</header>