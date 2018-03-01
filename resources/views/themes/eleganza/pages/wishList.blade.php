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
        @if(!empty($cookie))
        <ul class="wisht-list">
            @foreach($cookie as $c)
                @php $product = \App\Product::find($c['id']); @endphp
                @if(isset($product))
                    <li class="wish-list__item row">
                        <div class="col-lg-7 wish-list__item__wrap">
                            <div class="e-thumbnail e-image e-image--11">
                                <img src=product.jpg />
                            </div>
                            <div class="wish-list__item__info">
                                <div>movado - movado edge</div>
                                <div>{{ $product->price_outlet }},00 kn</div>
                                <div class="wish-list__item__actions">
                                    <button class="e-btn e-btn--fat e-btn--primary">dodaj u košaricu</button>
                                    <button class="e-btn e-btn--fat e-btn--primary e-gray">ukloni</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 wish-list__item__comment">
                            <textarea name="komentar" cols="30" rows="10"></textarea>
                            <button class="e-btn e-btn--primary">spremi komentar</button>
                        </div>
                    </li>
                @endif
            @endforeach

            <li class="wish-list__item row">
                <div class="col-lg-7 wish-list__item__wrap">
                    <div class="e-thumbnail e-image e-image--11">
                        <img src=product.jpg />
                    </div>
                    <div class="wish-list__item__info">
                        <div>movado - movado edge</div>
                        <div>4300,00 kn</div>
                        <div class="wish-list__item__actions">
                            <button class="e-btn e-btn--fat e-btn--primary">dodaj u košaricu</button>
                            <button class="e-btn e-btn--fat e-btn--primary e-gray">ukloni</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 wish-list__item__comment">
                    <textarea name="komentar" cols="30" rows="10"></textarea>
                    <button class="e-btn e-btn--primary">spremi komentar</button>
                </div>
            </li>

            <li class="wish-list__item row">
                <div class="col-lg-7 wish-list__item__wrap">
                    <div class="e-thumbnail e-image e-image--11">
                        <img src=product-2.jpg />
                    </div>
                    <div class="wish-list__item__info">
                        <div>movado - movado edge</div>
                        <div>4300,00 kn</div>
                        <div class="wish-list__item__actions">
                            <button class="e-btn e-btn--fat e-btn--primary">dodaj u košaricu</button>
                            <button class="e-btn e-btn--fat e-btn--primary e-gray">ukloni</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 wish-list__item__comment">
                    <textarea name="komentar" cols="30" rows="10"></textarea>
                    <button class="e-btn e-btn--primary">spremi komentar</button>
                </div>
            </li>

        </ul>
        @endif
    </section>

@endsection