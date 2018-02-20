@extends('themes.'.$theme->slug.'.index')

@section('title')
    Kontakt informacije | p-grupacija.hr
@endsection

@section('keywords'){{ $settings->keywords }}@endsection

@section('seo_social_stuff')
    <meta property="og:type" content="article"/>
    <meta property="og:site_name" content="{{ url('/') }}">
    <meta property="og:url" content="{{ url('info/hvala') }}">
    <meta property="og:image" content="{{ url('img/logo.png') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12" style="min-height: 600px">
            <h1>{{ $settings->tnx }}</h1>
        </div>
    </div>
    @endsection

@section('footer_scripts')

@endsection