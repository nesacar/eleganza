@extends('themes.'.$theme->slug.'.index')

@section('title')
    @if($home)
        {{ $settings->title }}
    @else
        {{ $category->title }} | p-grupacija.hr
    @endif
@endsection

@section('keywords'){{ $settings->keywords }}@endsection

@section('seo_social_stuff')
    <meta property="og:type" content="article"/>
    <meta property="og:site_name" content="{{ url('/') }}">
    <meta property="og:url" content="{{ url('shop') }}">
    <meta property="og:image" content="{{ url('img/logo.png') }}">
@endsection

@section('content')
    <div class="col-md-12">
        @if(true)
            @php $spanTitle0 = \App\Post::getSpanTitle($stock[0]->title); @endphp
            <div class="example-animation">
                <div data-lazy-background="{{ url($stock[0]->image) }}">
                    <h3 data-pos="['40%', '100%', '40%', '40%']" data-duration="700" data-effect="move">
                        <a href="{{ $stock[0]->link }}">{!! $spanTitle0 !!}</a>
                        <span></span>
                    </h3>
                </div>
                @if(false)
                <div data-lazy-background="{{ url($stock[0]->image) }}">
                    <h3 data-pos="['40%', '100%', '40%', '40%']" data-duration="700" data-effect="move">
                        <a href="{{ $stock[0]->link }}">{!! $spanTitle0 !!}</a>
                        <span></span>
                    </h3>
                </div>
                @endif
            </div><!-- .example-animation -->
        @else
        <a href="{{ $stock[0]->link }}">{!! HTML::image($stock[0]->image) !!}</a>
        <h2><a href="{{ $stock[0]->link }}">{!! $spanTitle0 !!}</a></h2>
        <a href="{{ $stock[0]->link }}"><div class="sh"></div></a>
        @endif
    </div>
    <div class="col-md-6 half-box-left">
        <div class="example-animation" style="margin-bottom: 0;">
            <div data-lazy-background="{{ $stock[1]->image }}">
                <h3 data-pos="['50%', '100%', '67.8%', '56.4%']" data-duration="700" data-effect="move">
                    <a href="#">{!! \App\Post::getSpanTitle($stock[1]->title) !!}</a>
                    <span></span>
                </h3>
            </div>
        </div><!-- .example-animation -->
        <!-- <a href="{{ $stock[1]->link }}">{!! HTML::image($stock[1]->image) !!}</a>
        <h2><a href="{{ $stock[1]->link }}">{!! \App\Post::getSpanTitle($stock[1]->title) !!}</a></h2>
        <a href="{{ $stock[1]->link }}"><div class="sh"></div></a> -->
    </div>
    <div class="col-md-6 half-box-right">
        <div class="example-animation" style="margin-bottom: 0;">
            <div data-lazy-background="{{ $stock[2]->image }}">
              <iframe id="ytplayer" width="529" height="300" src="https://www.youtube.com/embed/L4jx17IZIU0?autoplay=1&loop=1&cc_load_policy=1&controls=0&enablejsapi=1" volume="0" frameborder="0" allowfullscreen></iframe>
            <h4 data-pos="['50%', '100%', '13%', '7.5%']" data-duration="700" data-effect="move">
                <a href="{{ $stock[2]->link }}">{!! \App\Post::getSpanTitle($stock[2]->title) !!}</a>
                <span></span>
            </h4>
        </div>
    </div>
        <!-- .example-animation -->
       <!--  <a href="{{ $stock[2]->link }}">{!! HTML::image($stock[2]->image) !!}</a>
        <h2><a href="{{ $stock[2]->link }}">{!! \App\Post::getSpanTitle($stock[2]->title) !!}</a></h2>
        <a href="{{ $stock[2]->link }}"><div class="sh"></div></a> -->
    </div>
    <div class="col-md-12" style="height: 5px"></div>
    <div style="clear: both"></div>
    @include('themes.'.$theme->slug.'.partials.collections-flex')
    <div class="col-md-12 full-box">
        <a href="{{ $stock[3]->link }}">{!! HTML::image($stock[3]->image) !!}</a>
        <h2><a href="{{ $stock[3]->link }}">{!! \App\Post::getSpanTitle($stock[3]->title) !!}</a></h2>
        <a href="{{ $stock[3]->link }}"><div class="sh"></div></a>
    </div>

    @include('themes.'.$theme->slug.'.partials.products-4')

@endsection

@section('footer')
    {!! HTML::script($theme->slug.'/js/jquery.devrama.slider.js') !!}
@endsection

@section('footer_scripts')

    hoverImage(www);

    @if(false)
        @if(count($topCat))

            centrirajSh();
            setTimeout(function(){ centrirajSh(); }, 2000);


            $(window).resize(function(){
            var www = $(window).width();
            centrirajSh();
            if(www < 991){

            }else{
            hoverImage(www);
            }
            });

        @endif
    @endif

    function centrirajSh(){

        var FF = !(window.mozInnerScreenX == null);
        if(FF) {
            @if(true)
            $('.full-box').each(function(){
                var full = $(this);
                var h2 = full.find('h2');
                var left = (full.width() - h2.width()) / 2;
                var top = (full.height() - h2.height()) / 2;
                h2.css({'left': left, 'top': top});

                var sh = full.find('.sh');
                var paddings = 20;
                sh.css({'left': h2.position().left + h2.width() + paddings, 'top': h2.position().top + h2.height()});
            });
            @endif
        } else {
            @if(true)
            $('.full-box').each(function(){
                var full = $(this);
                var h2 = full.find('h2');
                var left = (full.width() - h2.width()) / 2;
                var top = (full.height() - h2.height()) / 2;
                h2.css({'left': left, 'top': top});

                var sh = full.find('.sh');
                var paddings = 20;
                sh.css({'left': h2.position().left + h2.width() + paddings, 'top': h2.position().top + h2.height()});
            });
            @endif
        }
    }

    function hoverImage(www){
    $('.full-box').each(function(){
        $(this).hover(
            function(){
            var w = $(this).css('width');
            var h = $(this).css('height');
            $(this).find('img').parent().append('<div class="mask-holder" style="width: '+w+';height:'+h+'"></div>');
        },
        function(){
            setTimeout(function() {
                $(this).find('.mask-holder').remove();
            }, 1000);
            }
        );
    });

    $('.half-box-left').each(function(){
        $(this).hover(
            function(){
                var w = $(this).css('width');
                var h = $(this).css('height');
                $(this).find('img').parent().append('<div class="mask-holder" style="width: '+w+';height:'+h+'"></div>');
            },
            function(){
               setTimeout(function() {
                    $(this).find('.mask-holder').remove();
                }, 1000);
            }
        );
    });

    $('.half-box-right').each(function(){
        $(this).hover(
            function(){
                var w = $(this).css('width');
                var h = $(this).css('height');
                $(this).find('img').parent().append('<div class="mask-holder" style="width: '+w+';height:'+h+'"></div>');
            },
            function(){
               setTimeout(function() {
                    $(this).find('.mask-holder').remove();
                }, 1000);
            }
        );
    });
    }

         var tag = document.createElement('script');

        tag.src = "//www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        var player;

        function onYouTubeIframeAPIReady() {
            player = new YT.Player('ytplayer', {
                events: {
                    'onReady': onPlayerReady
                }
            });
        }

        function onPlayerReady() {
            player.playVideo();
            // Mute!
            player.mute();
        }


    $('.example-animation').DrSlider(); //Yes! that's it!

@endsection