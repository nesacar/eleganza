@extends('themes.'.$theme->slug.'.index')

@section('content')
    <div class="e-jumbotron">
        <div class="e-jumbotron__wrap">
            <div class="container e-jumbotron__content e-jumbotron__content--left">
                <div class="e-jumbotron__cta e-jumbotron__cta--left">
                    <h2>besplatna dostava za sve gaga milano satove</h2>
                    <a href="#" class="e-cta with-shadow with-shadow">izaberi svoj gaga milano sat</a>
                </div>
            </div>
        </div>
        {!! HTML::Image('themes/'.$theme->slug.'/img/home-1.png', '', array('class' => 'e-jumbotron__img')) !!}
    </div>

    <div class="backdrop">
        <div class="container e-card-container kategorije">
            <div class="e-card-wrap">
                <div class="nav-grid e-card">

                    <div class="nav-grid__item">
                        <div class="nav-grid__item__wrap">
                            <a href="#">
                                <div class="nav-grid__item__content with-zoom">
                                    {!! HTML::Image('themes/'.$theme->slug.'/img/satovi.jpg', '', array('class' => 'center')) !!}
                                    <div class="diamond center">
                                        <div class="diamond__shape diamond__shape--white"></div>
                                    </div>
                                    <h3 class="center">satovi</h3>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="nav-grid__item">
                        <div class="nav-grid__item__wrap">
                            <a href="#">
                                <div class="nav-grid__item__content with-zoom">
                                    {!! HTML::Image('themes/'.$theme->slug.'/img/nakit.jpg', '', array('class' => 'center')) !!}
                                    <div class="diamond center">
                                        <div class="diamond__shape diamond__shape--white"></div>
                                    </div>
                                    <h3 class="center">nakit</h3>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="nav-grid__item">
                        <div class="nav-grid__item__wrap">
                            <a href="#">
                                <div class="nav-grid__item__content with-zoom">
                                    {!! HTML::Image('themes/'.$theme->slug.'/img/dodaci.jpg', '', array('class' => 'center')) !!}
                                    <div class="diamond center">
                                        <div class="diamond__shape diamond__shape--white"></div>
                                    </div>
                                    <h3 class="center">modni dodaci</h3>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="nav-grid__item">
                        <div class="nav-grid__item__wrap">
                            <a href="#">
                                <div class="nav-grid__item__content with-zoom">
                                    {!! HTML::Image('themes/'.$theme->slug.'/img/cuisine.jpg', '', array('class' => 'center')) !!}
                                    <div class="diamond center">
                                        <div class="diamond__shape diamond__shape--white"></div>
                                    </div>
                                    <h3 class="center">cuisine</h3>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="e-jumbotron">
        <div class="e-jumbotron__wrap">
            <div class="container e-jumbotron__content e-jumbotron__content--center">
                <div class="e-jumbotron__cta e-jumbotron__cta--center">
                    <h2>ekskluzivna kolekcija movado edge by yves behar</h2>
                    <a href="#" class="e-cta with-shadow">istrazi sve movado edge modele</a>
                </div>
            </div>
        </div>
        {!! HTML::Image('themes/'.$theme->slug.'/img/home-2.jpg', '', array('class' => 'e-jumbotron__img')) !!}
    </div>

    <div class="backdrop">
        <div class="container e-card-container instashop">
            <div class="e-card-wrap">
                <div class="instashop__wrap e-card">
                    <h3 class="e-subheading">#instashop</h3>
                    <p>Pokazite nam kako nosite proizvode iz nase kolekcije. #ELEGANZA</p>

                    <div class="instashop-list">
                        <div class="instashop-list__item">
                            <div class="instashop-image">
                                <div class="e-image e-image--11 instashop-thumbnail with-zoom">
                                    {!! HTML::Image('themes/'.$theme->slug.'/img/satovi.jpg', '') !!}
                                    <div class="instashop-overlay">
                                        <div class="instashop-overlay__action">
                                            <i class="fab fa-instagram"></i>
                                            <span>shop the look</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="instashop-image">
                                <div class="e-image e-image--43 instashop-thumbnail with-zoom">
                                    {!! HTML::Image('themes/'.$theme->slug.'/img/satovi.jpg', '') !!}
                                    <div class="instashop-overlay">
                                        <div class="instashop-overlay__action">
                                            <i class="fab fa-instagram"></i>
                                            <span>shop the look</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="instashop-list__item">
                            <div class="instashop-image">
                                <div class="e-image e-image--43 instashop-thumbnail with-zoom">
                                    {!! HTML::Image('themes/'.$theme->slug.'/img/satovi.jpg', '') !!}
                                    <div class="instashop-overlay">
                                        <div class="instashop-overlay__action">
                                            <i class="fab fa-instagram"></i>
                                            <span>shop the look</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="instashop-image">
                                <div class="e-image e-image--11 instashop-thumbnail with-zoom">
                                    {!! HTML::Image('themes/'.$theme->slug.'/img/satovi.jpg', '') !!}
                                    <div class="instashop-overlay">
                                        <div class="instashop-overlay__action">
                                            <i class="fab fa-instagram"></i>
                                            <span>shop the look</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="instashop-list__item">
                            <div class="instashop-image">
                                <div class="e-image e-image--11 instashop-thumbnail with-zoom">
                                    {!! HTML::Image('themes/'.$theme->slug.'/img/satovi.jpg', '') !!}
                                    <div class="instashop-overlay">
                                        <div class="instashop-overlay__action">
                                            <i class="fab fa-instagram"></i>
                                            <span>shop the look</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="instashop-image">
                                <div class="e-image e-image--43 instashop-thumbnail with-zoom">
                                    {!! HTML::Image('themes/'.$theme->slug.'/img/satovi.jpg', '') !!}
                                    <div class="instashop-overlay">
                                        <div class="instashop-overlay__action">
                                            <i class="fab fa-instagram"></i>
                                            <span>shop the look</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <h3 class="e-subheading">best sellers</h3>
        <div class="owl-carousel" data-is-carousel="true">

            <div class="product-item no-mragin">
                <a href="#">
                    <div class="product-item__img-box">
                        {!! HTML::Image('themes/'.$theme->slug.'/img/product.jpg', '') !!}
                    </div>
                    <div class="product-item__info-box">
                        <span class="product-item__brand">item brand</span>
                        <h2 class="product-item__name">item name</h2>
                        <span class="product-item__price">1234</span>
                    </div>
                </a>
            </div>

            <div class="product-item no-mragin">
                <a href="#">
                    <div class="product-item__img-box">
                        {!! HTML::Image('themes/'.$theme->slug.'/img/product.jpg', '') !!}
                    </div>
                    <div class="product-item__info-box">
                        <span class="product-item__brand">item brand</span>
                        <h2 class="product-item__name">item name</h2>
                        <span class="product-item__price">1234</span>
                    </div>
                </a>
            </div>
            <div class="product-item no-mragin">
                <a href="#">
                    <div class="product-item__img-box">
                        {!! HTML::Image('themes/'.$theme->slug.'/img/product.jpg', '') !!}
                    </div>
                    <div class="product-item__info-box">
                        <span class="product-item__brand">item brand</span>
                        <h2 class="product-item__name">item name</h2>
                        <span class="product-item__price">1234</span>
                    </div>
                </a>
            </div>
            <div class="product-item no-mragin">
                <a href="#">
                    <div class="product-item__img-box">
                        {!! HTML::Image('themes/'.$theme->slug.'/img/product.jpg', '') !!}
                    </div>
                    <div class="product-item__info-box">
                        <span class="product-item__brand">item brand</span>
                        <h2 class="product-item__name">item name</h2>
                        <span class="product-item__price">1234</span>
                    </div>
                </a>
            </div>
            <div class="product-item no-mragin">
                <a href="#">
                    <div class="product-item__img-box">
                        {!! HTML::Image('themes/'.$theme->slug.'/img/product.jpg', '') !!}
                    </div>
                    <div class="product-item__info-box">
                        <span class="product-item__brand">item brand</span>
                        <h2 class="product-item__name">item name</h2>
                        <span class="product-item__price">1234</span>
                    </div>
                </a>
            </div>

        </div>
    </div>

    @include('themes.'.$theme->slug.'.partials.newsletter')


    <div class="container novosti">
        <h3 class="e-subheading">novosti</h3>
        <div class="e-row">

            <div class="e-col e-col--3">
                <div class="e-blog">
                    <a href="#">
                        <div class="e-blog__thumb e-image e-image--43">
                            {!! HTML::Image('themes/'.$theme->slug.'/img/blog-bg-1.jpg', '') !!}
                            <div class="e-blog__title e-blog__title--small">
                                <h4>gaga milano osvojio je nagradu watchpro satovi 2017. godine</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="e-col e-col--3">
                <div class="e-blog">
                    <a href="#">
                        <div class="e-blog__thumb e-image e-image--43">
                            {!! HTML::Image('themes/'.$theme->slug.'/img/blog-bg-1.jpg', '') !!}
                            <div class="e-blog__title e-blog__title--small">
                                <h4>gaga milano osvojio je nagradu watchpro satovi 2017. godine</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="e-col e-col--3">
                <div class="e-blog">
                    <a href="#">
                        <div class="e-blog__thumb e-image e-image--43">
                            {!! HTML::Image('themes/'.$theme->slug.'/img/blog-bg-1.jpg', '') !!}
                            <div class="e-blog__title e-blog__title--small">
                                <h4>gaga milano osvojio je nagradu watchpro satovi 2017. godine</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection