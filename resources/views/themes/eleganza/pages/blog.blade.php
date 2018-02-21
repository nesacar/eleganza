@extends('themes.'.$theme->slug.'.index')

@section('content')
    <div>
        <div class=container>
            <nav aria-label=breadcrumb>
                <ol class=breadcrumb>
                    <li class=breadcrumb-item><a href=#>Home</a></li>
                    <li class=breadcrumb-item><a href=#>Something</a></li>
                    <li class="breadcrumb-item active" aria-current=page>Library</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class=page-header>
        <div class="container page-header__container">
            <h2 class=page-header__title>Page title</h2>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, alias sint. Repellat repellendus consectetur, incidunt non blanditiis debitis quisquam voluptatem iste laudantium quia,
                aspernatur distinctio asperiores expedita ut mollitia illum.
            </p>
        </div>
    </div>

    <section class="container content">
        <div class="e-row">
            <div class="e-col">
                <div class="e-blog">
                    <a href="#">
                        <div class="e-blog__thumb e-image e-image--169 with-zoom">
                            {!! HTML::Image('themes/'.$theme->slug.'/img/blog-bg-1.jpg', '') !!}
                            <div class="e-blog__title">
                                <h2>gaga milano osvojio je nagradu watchpro satovi 2017. godine</h2>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="e-col">
                <div class="e-blog">
                    <a href="#">
                        <div class="e-blog__thumb e-image e-image--169 with-zoom">
                            {!! HTML::Image('themes/'.$theme->slug.'/img/blog-bg-2.jpg', '') !!}
                            <div class="e-blog__title">
                                <h2>gaga milano osvojio je nagradu watchpro satovi 2017. godine</h2>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="e-col">
                <div class="e-blog">
                    <a href="#">
                        <div class="e-blog__thumb e-image e-image--169 with-zoom">
                            {!! HTML::Image('themes/'.$theme->slug.'/img/blog-bg-3.jpg', '') !!}
                            <div class="e-blog__title">
                                <h2>gaga milano osvojio je nagradu watchpro satovi 2017. godine</h2>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="e-col">
                <div class="e-blog">
                    <a href="#">
                        <div class="e-blog__thumb e-image e-image--169 with-zoom">
                            {!! HTML::Image('themes/'.$theme->slug.'/img/blog-bg-4.jpg', '') !!}
                            <div class="e-blog__title">
                                <h2>gaga milano osvojio je nagradu watchpro satovi 2017. godine</h2>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    @include('themes.'.$theme->slug.'.partials.newsletter')

@endsection