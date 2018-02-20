@extends('themes.'.$theme->slug.'.index')

@section('title')
    Članci vezani za tag: {{ $tag->title }} | p-grupacija.hr
@endsection

@section('keywords'){{ $settings->keywords }}@endsection

@section('seo_social_stuff')
    <meta property="og:type" content="article"/>
    <meta property="og:site_name" content="{{ url('/') }}">
    <meta property="og:url" content="{{ url('pretraga') }}">
    <meta property="og:image" content="{{ url('img/logo.png') }}">
@endsection

@section('content')

<h2 class="pretragaNaslov">Članci vezani za tag: <span>{{ $tag->title }}</span></h2>

<div class="pretraga">

    @if(count($posts))
        @foreach($posts as $post)
            @php $link = \App\Post::getPostLink($post); @endphp
            <article class="pretragaTekst">
                <div class="image-holder"><a href="{{ $link }}"> {!! HTML::image($post->image) !!}</a></div>
                <div class="pretragatxt">
                    <a href="{{ $link }}"> <h2>{!! \App\Post::getSpanTitle($post->title) !!}</h2></a>
                    <p>{{ $post->short }}</p>
                    <a href="{{ $link }}"><div class="sh"></div></a>
                </div>
                <div class="clear"></div>
            </article>
        @endforeach
    @endif

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                {!! str_replace('/?', '?', $posts->appends(request()->input())->links('vendor.pagination.bootstrap-4')) !!}
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer_scripts')

    @if(false)
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
    @endif
@endsection
