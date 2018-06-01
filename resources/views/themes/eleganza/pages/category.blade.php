@extends('themes.'.$theme->slug.'.index')

@section('content')
    <div>
        <div class=container>
            {!! $category->getBreadcrumb() !!}
        </div>
    </div>

    <div class=page-header>
        <div class="container page-header__container">
            <h2 class=page-header__title>{{ $category->title }}</h2>
            <p>{{ $category->desc }}</p>
        </div>
    </div>

    @if(count($posts)>0)
    <section class="container content">
        <div class="e-row">
            @foreach($posts as $post)
                <div class="e-col">
                    <div class="e-blog">
                        <a href="{{ \App\Post::getPostLink($post) }}">
                            <div class="e-blog__thumb e-image e-image--169 with-zoom">
                                {!! HTML::Image($post->image, $post->title) !!}
                                <div class="e-blog__title">
                                    <h2>{{ $post->title }}</h2>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    @include('themes.'.$theme->slug.'.partials.newsletter')

@endsection