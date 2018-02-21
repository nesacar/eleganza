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

    <!-- Page content -->
    <section class="container content products-content">
        <div class="mobile-drawer-holder filters-holder" id=jsFilters>
            <form class="e-drawer e-drawer--right filters-drawer">
                <div class=filters>
                    <div class=filters__header>osnovni filter</div>
                    <div class=filters__body>
                        <div class=filter>
                            <h4 class=filter__name>cijena</h4>
                            <div class=e-slider>
                                <div data-is-slider=true id=jsPriceSlider></div>
                                <div class=e-slider__labels>
                                    <span class="e-slider__label e-slider__label--kn" data-label-for=min data-for-slider=jsPriceSlider></span> - <span class="e-slider__label e-slider__label--kn" data-label-for=max data-for-slider=jsPriceSlider></span>
                                </div>
                            </div>
                        </div>
                        <div class=filter>
                            <h4 class=filter__name>filter name</h4>
                            <ul class=filter-list>
                                <li class=filter-list__item>
                                    <div class=e-list__item>
                                        <div class=e-checkbox>
                                            <input id=cb-1 type=checkbox class=e-checkbox__control>
                                            <div class=e-checkbox__background>
                                                <svg class=e-checkbox__checkmark viewBox="0 0 24 24"> <path class=e-checkbox__path fill=none stroke=white d="M1.73,12.91 8.1,19.28 22.79,4.59"></path> </svg>
                                            </div>
                                        </div>
                                        <label for=cb-1>filter value1</label>
                                        <span class=e-collapse-toggler data-toggle=collapse href=#collapseExample3 role=button aria-expanded=false aria-controls=collapseExample3>&plus;</span>
                                    </div>
                                    <div class=collapse id=collapseExample3>
                                        <ul class=filter-list>
                                            <li class=filter-list__item>
                                                <div class=e-list__item>
                                                    <div class=e-checkbox>
                                                        <input id=cb-2 type=checkbox class=e-checkbox__control>
                                                        <div class=e-checkbox__background>
                                                            <svg class=e-checkbox__checkmark viewBox="0 0 24 24"> <path class=e-checkbox__path fill=none stroke=white d="M1.73,12.91 8.1,19.28 22.79,4.59"></path> </svg>
                                                        </div>
                                                    </div>
                                                    <label for=cb-2>filter value2</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class=filter-list__item>
                                    <div class=e-list__item>
                                        <div class=e-checkbox>
                                            <input id=cb-3 type=checkbox class=e-checkbox__control>
                                            <div class=e-checkbox__background>
                                                <svg class=e-checkbox__checkmark viewBox="0 0 24 24"> <path class=e-checkbox__path fill=none stroke=white d="M1.73,12.91 8.1,19.28 22.79,4.59"></path> </svg>
                                            </div>
                                        </div>
                                        <label for=cb-3>filter value3</label>
                                        <span class=e-collapse-toggler data-toggle=collapse href=#collapseExample4 role=button aria-expanded=false aria-controls=collapseExample4>&plus;</span>
                                    </div>
                                    <div class=collapse id=collapseExample4>
                                        <ul class=filter-list>
                                            <li class=filter-list__item>
                                                <div class=e-list__item>
                                                    <div class=e-checkbox>
                                                        <input id=cb-4 type=checkbox class=e-checkbox__control>
                                                        <div class=e-checkbox__background>
                                                            <svg class=e-checkbox__checkmark viewBox="0 0 24 24"> <path class=e-checkbox__path fill=none stroke=white d="M1.73,12.91 8.1,19.28 22.79,4.59"></path> </svg>
                                                        </div>
                                                    </div>
                                                    <label for=cb-4>filter value4</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class=filter>
                            <h4 class=filter__name>promjer kucista</h4>
                            <div class=e-slider>
                                <div data-is-slider=true id=jsHousingSlider></div>
                                <div class=e-slider__labels>
                                    <span class="e-slider__label e-slider__label--mm" data-label-for=min data-for-slider=jsHousingSlider></span> - <span class="e-slider__label e-slider__label--mm" data-label-for=max data-for-slider=jsHousingSlider></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="e-btn e-btn--primary e-btn--block filters__submit-btn">primeni</button>
            </form>
        </div>

        <div class="products-container">
            <div class=results-header> <div class="e-select e-select--with-carrot"> <label for=order-by>Sortiraj po: </label> <select id=order-by> <option value=rastuce>Cijena: veća prema manjoj</option> <option value=opadajuce>Cijena: manja prema veća</option> </select> </div> <div class="e-select e-select--with-carrot"> <label for=how-many>Prikaži: </label> <select id=how-many> <option value=9>9</option> <option value=18>18</option> </select> </div> <ul class="e-pagination pagination"> <li class="page-item e-page-item disabled"><a href=# class="page-link e-page-link">&lt;</a></li> <li class="page-item e-page-item active"><a href=# class="page-link e-page-link">1</a></li> <li class="page-item e-page-item"><a href=# class="page-link e-page-link">2</a></li> <li class="page-item e-page-item"><a href=# class="page-link e-page-link">3</a></li> <li class="page-item e-page-item"><a href=# class="page-link e-page-link">...</a></li> <li class="page-item e-page-item"><a href=# class="page-link e-page-link">34</a></li> <li class="page-item e-page-item"><a href=# class="page-link e-page-link">&gt;</a></li> </ul> </div>
            <ul class="product-list">

                <li class="product-item product-list__item with-shadow"> <a href=#> <div class=product-item__img-box> {!! HTML::Image('themes/'.$theme->slug.'/img/product.jpg', '') !!} <ul class=product-item__actions> <li class="icon-btn icon-btn--inverse"> <i class="fas fa-shopping-cart"></i> </li> <li class="icon-btn icon-btn--inverse"> <i class="fas fa-heart"></i> </li> <li class="icon-btn icon-btn--inverse"> <i class="fas fa-search"></i> </li> </ul> </div> <div class=product-item__info-box> <span class=product-item__brand>item brand</span> <h2 class=product-item__name>item name</h2> <span class=product-item__price>1234</span> </div> <button class="e-btn e-btn--primary e-btn--block">saznaj više</button> </a> <div class="status status--sale">popust 30%</div> </li>
                <li class="product-item product-list__item with-shadow"> <a href=#> <div class=product-item__img-box> {!! HTML::Image('themes/'.$theme->slug.'/img/product.jpg', '') !!} <ul class=product-item__actions> <li class="icon-btn icon-btn--inverse"> <i class="fas fa-shopping-cart"></i> </li> <li class="icon-btn icon-btn--inverse"> <i class="fas fa-heart"></i> </li> <li class="icon-btn icon-btn--inverse"> <i class="fas fa-search"></i> </li> </ul> </div> <div class=product-item__info-box> <span class=product-item__brand>item brand</span> <h2 class=product-item__name>item name</h2> <span class=product-item__price>1234</span> </div> <button class="e-btn e-btn--primary e-btn--block">saznaj više</button> </a> <div class="status status--sale">popust 30%</div> </li>
                <li class="product-item product-list__item with-shadow"> <a href=#> <div class=product-item__img-box> {!! HTML::Image('themes/'.$theme->slug.'/img/product.jpg', '') !!} <ul class=product-item__actions> <li class="icon-btn icon-btn--inverse"> <i class="fas fa-shopping-cart"></i> </li> <li class="icon-btn icon-btn--inverse"> <i class="fas fa-heart"></i> </li> <li class="icon-btn icon-btn--inverse"> <i class="fas fa-search"></i> </li> </ul> </div> <div class=product-item__info-box> <span class=product-item__brand>item brand</span> <h2 class=product-item__name>item name</h2> <span class=product-item__price>1234</span> </div> <button class="e-btn e-btn--primary e-btn--block">saznaj više</button> </a> <div class="status status--sale">popust 30%</div> </li>
                <li class="product-item product-list__item with-shadow"> <a href=#> <div class=product-item__img-box> {!! HTML::Image('themes/'.$theme->slug.'/img/product.jpg', '') !!} <ul class=product-item__actions> <li class="icon-btn icon-btn--inverse"> <i class="fas fa-shopping-cart"></i> </li> <li class="icon-btn icon-btn--inverse"> <i class="fas fa-heart"></i> </li> <li class="icon-btn icon-btn--inverse"> <i class="fas fa-search"></i> </li> </ul> </div> <div class=product-item__info-box> <span class=product-item__brand>item brand</span> <h2 class=product-item__name>item name</h2> <span class=product-item__price>1234</span> </div> <button class="e-btn e-btn--primary e-btn--block">saznaj više</button> </a> <div class="status status--sale">popust 30%</div> </li>

            </ul>
        </div>
    </section>
    <!-- ./Page content -->

    <button class="e-btn e-btn--primary e-fab filter-toggler" data-e-controls="#jsFilters">
        <i class="fas fa-filter"></i>
    </button>

    @include('themes.'.$theme->slug.'.partials.newsletter')

@endsection