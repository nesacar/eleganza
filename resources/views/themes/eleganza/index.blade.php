<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="pinterest" content="nopin">
    <title>Eleganza</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700&amp;subset=latin-ext" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Fjalla+One&amp;subset=latin-ext" rel="stylesheet">
    {!! HTML::style('themes/'.$theme->slug.'/css/style.css') !!}
</head>
<body>

<div class="mobile-drawer-holder mobile-drawer-holder--temporary" id=jsMobileMenu>
    <aside class="e-drawer e-drawer--left"> <ul class=mobile-nav-list>
            <li class=mobile-nav-list__item>
                <div class="e-list__item e-list__item--big">
                    <a href=#>satovi</a>
                    <span class=e-collapse-toggler data-toggle=collapse href=#collapseExample1 role=button aria-expanded=false aria-controls=collapseExample1>&plus;</span>
                </div>
                <div class=collapse id=collapseExample1>
                    <ul class=mobile-nav>
                        <li class=mobile-nav-list__item>
                            <div class="e-list__item e-list__item--big">
                                <a href=#>something...</a>
                            </div>
                        </li>
                        <li class=mobile-nav-list__item>
                            <div class="e-list__item e-list__item--big">
                                <a href=#>something...</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>
            <li class=mobile-nav-list__item>
                <div class="e-list__item e-list__item--big">
                    <a href=#>nakit</a>
                    <span class=e-collapse-toggler data-toggle=collapse href=#collapseExample2 role=button aria-expanded=false aria-controls=collapseExample2>&plus;</span>
                </div>
                <div class=collapse id=collapseExample2>
                    <ul class=mobile-nav>
                        <li class=mobile-nav-list__item>
                            <div class="e-list__item e-list__item--big">
                                <a href=#>something...</a>
                            </div>
                        </li>
                        <li class=mobile-nav-list__item>
                            <div class="e-list__item e-list__item--big">
                                <a href=#>something...</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>
            <li class=mobile-nav-list__item>
                <div class="e-list__item e-list__item--big">
                    <a href=#>modni dodaci</a>
                </div>
            </li>
            <li class=mobile-nav-list__item>
                <div class="e-list__item e-list__item--big">
                    <a href=#>kitchen</a>
                </div>
            </li>
            <li class=mobile-nav-list__item>
                <div class="e-list__item e-list__item--big">
                    <a href=#>akcija</a>
                </div>
            </li>
        </ul>
    </aside>
</div>
<div class=top-bar>
    <div class="container top-bar__wrapper" style=position:relative>
        <div class=e-search id=jsSearch>
            <button class="icon-btn icon-btn--primary" data-e-controls=#jsSearch> <i class="fas fa-times"></i> </button>
            <form action=GET>
                <input placeholder=Pretraživanje type=text name=search id=search>
                <button class="icon-btn icon-btn--primary" type=submit> <i class="fas fa-search"></i> </button>
            </form>
        </div>
        <div class=top-bar__box>
            <div class=top-bar__link data-e-select>
                <div class=e-select__icon></div>
                <div class=e-select>
                    <select>
                        <option value=cro>hrvatski</option>
                        <option value=uk>english</option>
                    </select>
                </div>
            </div>
            <div class=top-bar__link>
                <div class=e-select>
                    <select>
                        <option value=eur>eur</option>
                        <option value=kn>hrk</option>
                    </select>
                </div>
            </div>
            <a class=top-bar__link href=#>
                <span>lista želja</span> <i class="fas fa-heart"></i> </a>
        </div>
        <div class=top-bar__box>
            <a class=top-bar__link href=#> <span>prijavi se</span> <i class="fas fa-user-circle"></i> </a>
            <a class=top-bar__link href=#> <span>košarica</span> <i class="fas fa-shopping-cart"></i> </a>
            <div class=top-bar__link data-e-controls=#jsSearch>
                <span>pretraži</span> <i class="fas fa-search"></i>
            </div>
        </div>
    </div>
</div>
<header class=header id=jsHeader>
    <div class=menu-toggler id=jsMenuToggler data-e-controls=#jsMobileMenu>
        <div class=nav-icon>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <h1 class=logo>
        <a href=index.html>eleganza</a>
    </h1>
    <ul class=nav-list>
        <li class=nav-list__item>
            <a href=# class="nav-list__item__link with-arrow"> satovi </a>
            <div class=nav-list__item__submenu>
                <div class="container submenu">
                    <div class=submenu__col>
                        <div class=submenu__title>brendovi</div>
                        <ul class=submenu__list>
                            <li class=submenu__list__item> <a href=#>Rebecca</a> </li>
                            <li class=submenu__list__item> <a href=#>Majorica</a> </li>
                            <li class=submenu__list__item> <a href=#>Borboletta</a>
                            </li>
                        </ul>
                    </div>
                    <div class=submenu__col>
                        <div class=submenu__title>kategorije</div>
                        <ul class=submenu__list>
                            <li class=submenu__list__item>
                                <a href=#>Nausnice</a>
                            </li>
                            <li class=submenu__list__item>
                                <a href=#>Narukvice</a>
                            </li>
                            <li class=submenu__list__item>
                                <a href=#>Ogrlice</a>
                            </li>
                            <li class=submenu__list__item>
                                <a href=#>Prstenje</a>
                            </li>
                            <li class=submenu__list__item>
                                <a href=#>Privjesci</a>
                            </li>
                        </ul>
                    </div>
                    <div class=submenu__col>
                        <div class="e-image e-image--custom">
                            {!! HTML::Image('themes/'.$theme->slug.'/img/nakit.jpg', '') !!}
                        </div>
                    </div>
                    <div class=submenu__col>
                        <div class="e-image e-image--custom">
                            {!! HTML::Image('themes/'.$theme->slug.'/img/satovi.jpg', '') !!}
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class=nav-list__item> <a href=# class=nav-list__item__link> nakit </a> </li>
        <li class=nav-list__item> <a href=# class=nav-list__item__link> modni dodaci </a> </li>
        <li class=nav-list__item> <a href=# class=nav-list__item__link> <i class="far fa-heart"></i> kitchen </a> </li>
        <li class=nav-list__item> <a href=# class="nav-list__item__link with-arrow"> satovi </a>
            <div class=nav-list__item__submenu>
                <div class="container submenu">
                    <div class=submenu__col>
                        <div class=submenu__title>satovi</div>
                        <div class="e-image e-image--43">
                            {!! HTML::Image('themes/'.$theme->slug.'/img/nakit.jpg', '') !!}
                        </div>
                    </div>
                    <div class=submenu__col>
                        <div class=submenu__title>nakit</div>
                        <div class="e-image e-image--43">
                            {!! HTML::Image('themes/'.$theme->slug.'/img/satovi.jpg', '') !!}
                        </div>
                    </div>
                    <div class=submenu__col>
                        <div class=submenu__title>modni dodaci</div>
                        <div class="e-image e-image--43">
                            {!! HTML::Image('themes/'.$theme->slug.'/img/nakit.jpg', '') !!}
                        </div>
                    </div>
                    <div class=submenu__col>
                        <div class=submenu__title>kitchen</div>
                        <div class="e-image e-image--43">
                            {!! HTML::Image('themes/'.$theme->slug.'/img/satovi.jpg', '') !!}
                        </div>
                    </div>

                </div>
            </div>
        </li>
    </ul>
</header>

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

<div class=newsletter> <div class=newsletter__background></div> <div class="container newsletter__container"> <div class="diamond diamond--big"> <div class=diamond__shape></div> </div> <div class=newsletter__form> <p>Ne propusti naše posebne ponude, akcije i uštede, pretplati se na newsletter i ostvari kod za popust od 10%.</p> <form class=nl-form action=POST> <input class="nl-input nl-input--inverse" type=text name=name placeholder="Ime i Prezime"> <input class="nl-input nl-input--inverse" type=text name=email placeholder=Email> <button class="e-btn e-btn--primary" type=submit>Prijavi se</button> </form> </div> </div> </div>


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

<div class=benefits>
    <div class=container>
        <ul class=benefits__list>
            <li class=benefits__list__item> <i class="fas fa-truck"></i> <span>BESPLATNA DOSTAVA ZA PROIZVODE IZNAD 500 KN</span> </li>
            <li class=benefits__list__item> <i class="fas fa-lock"></i> <span>GARANCIJE SIGURNE KUPNJE</span> </li>
            <li class=benefits__list__item> <i class="fas fa-redo-alt"></i> <span>povrat i zamjene</span> </li>
        </ul>
    </div>
</div>
<footer class=footer>
    <div class=container>
        <div class=row>
            <div class="col-md-3 col-sm-6 footer__col">
                <h4 class=footer__col__title>kontakt</h4>
                <ul class=footer__list>
                    <li class=footer__list__item> Tel: 051 227 012 </li>
                    <li class=footer__list__item> Fax: 051 227 014 </li>
                    <li class=footer__list__item> <a href=mailto:sales@p-grupacija.hr>E-mail: sales@p-grupacija.hr</a> </li>
                </ul>
            </div>
            <div class="col-md-3 col-sm-6 footer__col">
                <ul class=footer__list>
                    <li class=footer__list__item><a href=#>O Nama</a></li>
                    <li class=footer__list__item><a href=#>Blog</a></li>
                    <li class=footer__list__item><a href=#>Kontakt</a></li>
                    <li class=footer__list__item><a href=#>Pitanja i odgovori</a></li>
                </ul>
            </div>
            <div class="col-md-3 col-sm-6 footer__col">
                <h4 class=footer__col__title>korisnička podrška</h4>
                <ul class=footer__list>
                    <li class=footer__list__item><a href=#>Opći uveti poslovanja</a></li>
                    <li class=footer__list__item><a href=#>Dostava</a></li>
                    <li class=footer__list__item><a href=#>Povrat i zamjene</a></li>
                    <li class=footer__list__item><a href=#>Načini plaćanja</a></li>
                    <li class=footer__list__item><a href=#>Privatnost i sigurnost</a></li>
                    <li class=footer__list__item><a href=#>Zaštita osobnih podataka</a></li>
                </ul>
            </div>
            <div class="col-md-3 col-sm-6 footer__col">
                <h4 class=footer__col__title>društvene mreže</h4>
                <ul class=social-list>
                    <li class=social-list__item> <a href=# target=_blank rel=noopener aria-label=Facebook> <i class="fab fa-facebook-f"></i> </a> </li>
                    <li class=social-list__item> <a href=# target=_blank rel=noopener aria-label=Twitter> <i class="fab fa-twitter"></i> </a> </li>
                    <li class=social-list__item> <a href=# target=_blank rel=noopener aria-label=Instagram> <i class="fab fa-instagram"></i> </a> </li>
                    <li class=social-list__item> <a href=# target=_blank rel=noopener aria-label=YouTube> <i class="fab fa-youtube"></i> </a> </li>
                </ul>
            </div>
            <div class=col-12>
                <div class=e-cards-list>
                    {!! HTML::Image('themes/'.$theme->slug.'/img/amex.png', 'amex') !!}
                    {!! HTML::Image('themes/'.$theme->slug.'/img/maestro.png', 'maestro') !!}
                    {!! HTML::Image('themes/'.$theme->slug.'/img/master.png', 'master') !!}
                    {!! HTML::Image('themes/'.$theme->slug.'/img/visa.png', 'visa') !!}
                    {!! HTML::Image('themes/'.$theme->slug.'/img/discover.png', 'discover') !!}
                    {!! HTML::Image('themes/'.$theme->slug.'/img/diners.png', 'diners') !!}
                </div>
            </div>
        </div>
    </div>
</footer>
<div class=sub-footer>
    <div class="container sub-footer__container">
        <div>radionica</div>
        <div class=copy> <span>2018</span> P-grupacija. Sva prava zadržana. </div>
    </div>
</div>
{!! HTML::script('themes/'.$theme->slug.'/js/app.bundle.js') !!}
</body>
</html>
