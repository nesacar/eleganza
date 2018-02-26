@extends('themes.'.$theme->slug.'.index')

@section('content')

    @if(!empty($hero))
        <div class="e-jumbotron">
            <div class="e-jumbotron__wrap">
                <div class="container e-jumbotron__content e-jumbotron__content--left">
                    <div class="e-jumbotron__cta e-jumbotron__cta--left">
                        <h2>{{ $hero->title }}</h2>
                        <a href="{{ url($hero->link) }}" class="e-cta with-shadow with-shadow">{{ $hero->button }}</a>
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
                                    <a href="#">
                                        <div class="nav-grid__item__content with-zoom">
                                            {!! HTML::Image($box->image, $box->title, array('class' => 'center')) !!}
                                            <div class="diamond center">
                                                <div class="diamond__shape diamond__shape--white"></div>
                                            </div>
                                            <h3 class="center">{{ $box->title }}</h3>
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
                        <a href="#" class="e-cta with-shadow">{{ $home1->button }}</a>
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
                        <a href="{{ \App\Post::getPostLink($post) }}">
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