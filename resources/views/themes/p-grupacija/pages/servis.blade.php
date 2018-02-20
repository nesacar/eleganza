@extends('themes.'.$theme->slug.'.index')

@section('title')
    Servis | p-grupacija.hr
@endsection

@section('keywords'){{ $settings->keywords }}@endsection

@section('seo_social_stuff')
    <meta property="og:type" content="article"/>
    <meta property="og:site_name" content="{{ url('/') }}">
    <meta property="og:url" content="{{ url('info/servis/15') }}">
    <meta property="og:image" content="{{ url('img/logo.png') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="prodajnaMestaCover">
                <div class="textholder text-servis">
                    <h2><a href="#">ovlašćeni <span>servis</span></a></h2>
                </div>
                {!! HTML::image($theme->slug.'/img/servis_cover.jpg', 'Servis') !!}
            </div>
    
            <div class="col-md-4 servis">
                <h3>MARLI</h3>
                <p>info@marli.hr</p>
                <p>Vlaška 13, 10000 Zagreb</p>
                <p>Tel: 01 435 683</p>
            </div>

            <div class="col-md-4 servis">

                <h3>URAR BUTUČI</h3>
                <p>Vlaška 13, 10000 Zagreb</p>
                <p>Tel: 01 4816 659</p>
                <p>Mob: 095 526 6546</p>
                
            </div>

            <div class="col-md-4 servis">
                <h3>URARSTVO SAMARDŽIĆ</h3>
                <p>Tratinska 18, 10000 Zagreb</p>
                <p>Tel: +385 01 3822 011</p>
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