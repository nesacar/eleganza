@extends('themes.'.$theme->slug.'.index')

@section('title')
    Kontakt informacije | p-grupacija.hr
@endsection

@section('keywords'){{ $settings->keywords }}@endsection

@section('seo_social_stuff')
    <meta property="og:type" content="article"/>
    <meta property="og:site_name" content="{{ url('/') }}">
    <meta property="og:url" content="{{ url('info/kontakt') }}">
    <meta property="og:image" content="{{ url('img/logo.png') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="prodajnaMestaCover">
                <div class="textholder">
                    <h2><a href="">KONTAKT</a></h2>
                </div>
                {!! HTML::image($theme->slug.'/img/servis_cover.jpg', 'Kontakt') !!}
            </div>
        </div>
    </div>

    @if(count($errors) > 0)
        <div class="alert alert-danger" style="margin-top: 20px">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            Došlo je do greške.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(\Session::has('message'))
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <p>{!! \Session::get('message') !!}</p>
        </div>
    @endif

    <div id="mapa">
        <div class="col-sm-12">
            {!! $settings->map !!}
        </div>
    </div>
    <div id="kontakt" style="">
        <div class="row">

            <div class="col-sm-6">
                <div class="kontakt">
                    <p>Za dodatne informacije o proizvodima kontaktirajte naš prodajni deo.</p>
                    <h2>P-Grupacija d.o.o.</h2>
                    <p>Omladinska 4</p>
                    <p>51000 Rijeka, Hrvatska</p>
                    <p>Tel: 051 227 012</p>
                    <p>Fax: 051 227 014</p>
                    <p>E-mail: <a href="mailto:info@pggrupa.rs" style="color: #F3AC3F">sales@p-grupacija.hr</a></p>

                </div>
            </div>

            <div class="col-sm-6">
                {!! Form::open(['action' => ['PagesController@kontakt_form'], 'method' => 'POST', 'class' => 'kontaktForma']) !!}
                    <input type="text" placeholder="Ime" name="name">
                    <input type="text" placeholder="Prezime" name="lastname">
                    <input type="text" placeholder="Vaša e-mail adresa" name="email">
                    <textarea placeholder="Vaša poruka..." name="message"></textarea>
                    <button type="submit" placeholder="">POŠALJI</button>
                {!! Form::close() !!}
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