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

@include('themes.'.$theme->slug.'.partials.mobile-menu')

@include('themes.'.$theme->slug.'.partials.top-bar')

@include('themes.'.$theme->slug.'.partials.header')

@yield('content')

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

@yield('footer_scripts')

</body>
</html>
