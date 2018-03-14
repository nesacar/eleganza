@extends('themes.'.$theme->slug.'.index')

@section('content')

    <div>
        <div class=container>
            <nav aria-label=breadcrumb>
                <ol class=breadcrumb>
                    <li class=breadcrumb-item><a href="{{ url('/') }}">Home</a></li>
                    <li class=breadcrumb-item><a href="{{ url('blog') }}">Blog</a></li>
                    <li class="breadcrumb-item active" aria-current=page>{{ $post->title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="container content blog-post">
        <div class="blog-post__cover">
            {!! HTML::Image($post->image, $post->title) !!}
        </div>
        <h1 class="blog-post__title">otkrij novu rebecca swing kolekciju</h1>
        <div class="blog-post__date">
            Objavljeno: <span>{{ \Jenssegers\Date\Date::parse($post->publish_at)->format('d F Y') }}</span>
        </div>
        {!! $post->body !!}
    </section>

    @if(count($related)>0)
    <div class="container novosti">
        <h3 class=e-subheading>novosti</h3>
        <div class=e-row>
            @foreach($related as $item)
                <div class="e-col e-col--3">
                    <div class=e-blog>
                        <a href={{ \App\Post::getPostLink($item) }}>
                            <div class="e-blog__thumb e-image e-image--43">
                                {!! HTML::Image($item->image, $item->title) !!}
                                <div class="e-blog__title e-blog__title--small">
                                    <h4>{{ $item->title }}</h4>
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

@section('footer_scripts')
    {!! HTML::script('themes/'.$theme->slug.'/js/jquery-2.2.4.min.js') !!}
    {!! HTML::script('themes/'.$theme->slug.'/js/jquery.toastmessage.js') !!}
    <script>
        @if(Session::has('done'))
             $().toastmessage('showSuccessToast', "{{ Session::get('done') }}");
        @endif
    </script>
@endsection