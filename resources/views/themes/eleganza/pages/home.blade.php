@extends('themes.'.$theme->slug.'.index')

@section('header-style')
<link rel="stylesheet" href="{{ url('themes/eleganza/css/instashop.css') }}">
@endsection

@section('content')

    @if(!empty($hero))
        <div class="e-jumbotron">
            <div class="e-jumbotron__wrap">
                <div class="container e-jumbotron__content e-jumbotron__content--left">
                    <div class="e-jumbotron__cta e-jumbotron__cta--left">
                        <h2>{{ $hero->title }}</h2>
                        <a href="{{ url($hero->link) }}" class="e-cta with-shadow with-shadow">{{ $hero->button }}</a>
                        @if(!empty($hero2))
                            <a href="{{ url($hero2->link) }}" class="e-cta with-shadow with-shadow">{{ $hero2->button }}</a>
                        @endif
                    </div>
                </div>
            </div>
            {!! HTML::Image('themes/'.$theme->slug.'/img/home-1.png', '', array('class' => 'e-jumbotron__img')) !!}
        </div>
    @endif

    @if(!empty($home4))

        <div class="backdrop">
            <div class="container e-card-container kategorije">
                <div class="e-card-wrap">
                    <div class="nav-grid e-card">
                        @foreach($home4 as $box)

                            <div class="nav-grid__item">
                                <div class="nav-grid__item__wrap">
                                    <a href="{{ url($box->link) }}">
                                        <div class="nav-grid__item__content with-zoom">
                                            {!! HTML::Image($box->image, $box->title, array('class' => 'center')) !!}
                                            <div class="diamond center">
                                                <div class="diamond__shape diamond__shape--white"></div>
                                            </div>
                                            <h3 class="center">{!! $box->title !!}</h3>
                                        </div>
                                    </a>
                                </div>
                            </div>

                        @endforeach

                    </div>
                </div>
            </div>
        </div>

    @endif

    @if(!empty($home1))

        <div class="e-jumbotron">
            <div class="e-jumbotron__wrap">
                <div class="container e-jumbotron__content e-jumbotron__content--center">
                    <div class="e-jumbotron__cta e-jumbotron__cta--center">
                        <h2>{{ $home1->title }}</h2>
                        <a href="{{ $home1->link }}" class="e-cta with-shadow">{{ $home1->button }}</a>
                        @if(!empty($home12))
                            <a href="{{ $home12->link }}" class="e-cta with-shadow">{{ $home12->button }}</a>
                        @endif
                    </div>
                </div>
            </div>
            {!! HTML::Image($home1->image, $home1->title, array('class' => 'e-jumbotron__img')) !!}
        </div>

    @endif

    @include('themes.'.$theme->slug.'.partials.instagram-feed')

    @include('themes.'.$theme->slug.'.partials.best-sellers')

    @include('themes.'.$theme->slug.'.partials.newsletter')

    @if(!empty($posts))
    <div class="container novosti">
        <h3 class="e-subheading">novosti</h3>
        <div class="e-row">
            @foreach($posts as $post)
                <div class="e-col e-col--3">
                    <div class="e-blog">
                        <a href="{{ $post->getLink() }}">
                            <div class="e-blog__thumb e-image e-image--43">
                                {!! HTML::Image($post->image, $post->title) !!}
                                <div class="e-blog__title e-blog__title--small">
                                    <h4>{{ $post->title }}</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

@endsection

@section('instashop')
  @include('themes.'.$theme->slug.'.partials.instashop')
@endsection

@section('footer_scripts')
  <script>
    window.products = {!! $instaShops !!};
  </script>
  <script src="{{ url('themes/eleganza/js/instashop.js') }}"></script>
@endsection