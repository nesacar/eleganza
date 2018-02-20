@extends('themes.'.$theme->slug.'.index')

@section('title')
    O nama | p-grupacija.hr
@endsection

@section('keywords'){{ $settings->keywords }}@endsection

@section('seo_social_stuff')
    <meta property="og:type" content="article"/>
    <meta property="og:site_name" content="{{ url('/') }}">
    <meta property="og:url" content="{{ url('info/o-nama') }}">
    <meta property="og:image" content="{{ url('img/logo.png') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="prodajnaMestaCover">
                <div class="textholder">
                    <h2><a href="">o <span>nama</span></a></h2>
                </div>
                {!! HTML::image($theme->slug.'/img/servis_cover.jpg', 'O nama') !!}
            </div>
            <div class="about">

                <p>Već više od 20 godina službeni smo uvoznik, predstavnik i distributer ekskluzivnih luksuznih svjetskih brendova satova, nakita, modnih dodataka i mobitela kao što su : <a href="#">TAG Heuer watches & phones</a>, <a href="#">Movado</a>, <a href="#">Victorinox SA</a>, <a href="#">Luminox</a>, <a href="#">Mondaine</a>, <a href="#">Bogner</a>, <a href="#">Caran d’Ache</a>, <a href="#">Scatola del Tempo</a>.</p>

                <p> Veliku pažnju posvećujemo stalnom praćenju svijeta urarske industrije, te modnog i poslovnog accesoriessa, a razvijenom prodajnom mrežom prisutni smo u gotovo svakom dijelu Hrvatske.</p>

                <p>Obratite nam se s povjerenjem.</p>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    function centriraj(){
        var w = $('.prodajnaMestaCover').width();
        var h = $('.prodajnaMestaCover').height();

        var w2 = $('.textholder').width();
        var h2 = $('.textholder').height();

        $('.textholder').css({'top': (h - h2)/2, 'left': (w - w2)/2, 'margin-left': 0});
    }
    centriraj();
    setTimeout(function(){
        centriraj();
    }, 1500);

    $(window).resize(function(){
        centriraj();
    });
@endsection