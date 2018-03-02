@extends('themes.'.$theme->slug.'.index')

@section('content')

    <div>
        <div class=container>
            <nav aria-label=breadcrumb>
                <ol class=breadcrumb>
                    <li class=breadcrumb-item><a href="{{ url('cart') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current=page>Košarica</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class=page-header>
        <div class="container page-header__container">
            <h2 class=page-header__title>Košarica</h2>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, alias sint. Repellat repellendus consectetur, incidunt non blanditiis debitis quisquam voluptatem iste laudantium quia,
                aspernatur distinctio asperiores expedita ut mollitia illum.
            </p>
        </div>
    </div>

    <section class="container content">
        <div class="cart-section">
            <div class=cart-nav>
                <a href="{{ url('/') }}" class="e-btn e-btn--fat e-btn--invert">&lt; nastavi kupovinu</a>
                @if(count($products)>0)
                <a href=# class="e-btn e-btn--fat e-btn--primary">sigurna uplata</a>
                @endif
            </div>
        </div>

        @if(count($products)>0)
        <div class="cart-section">
            <div class="cart-header">
                <div class="cart-header__label cart-header__label--artikal">artikal</div>
                <div class="cart-header__label cart-header__label--opis">opis</div>
                <div class="cart-header__label cart-header__label--kolicina">kolicina</div>
                <div class="cart-header__label cart-header__label--cena">cijena artikla</div>
                <div class="cart-header__label cart-header__label--total">sveukupnu</div>
            </div>
            <ul class="cart-list">
                @foreach($products as $product)
                <li class="cart-list__item row">
                    <div class="col-lg-8 col-md-6 cart-list__item__cell">
                        <div class=cart-list__item__img>
                            <div class="e-thumbnail e-image e-image--11">
                                <a href="{{ \App\Product::getProductLink($product->id) }}">{!! HTML::Image($product->image, $product->title) !!}</a>
                            </div>
                        </div>
                        <div class=cart-list__item__about>
                            <div class=cart-list__item__brand>@if(isset($product->brand)) {{ $product->brand->title }} @endif</div>
                            <div class=cart-list__item__model>{{ $product->title }}</div>
                            <hr>
                            <div class=e-form__cb-group>
                                <div class=e-checkbox>
                                    <input id=gift type=checkbox class=e-checkbox__control>
                                    <div class=e-checkbox__background>
                                        <svg class=e-checkbox__checkmark viewBox="0 0 24 24"> <path class=e-checkbox__path fill=none stroke=white d="M1.73,12.91 8.1,19.28 22.79,4.59"></path> </svg>
                                    </div>
                                </div>
                                <label for=gift>Umotaj ovaj artikal kao poklon <span>(+ hrk 16.41)</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 cart-list__item__cell">
                        <div class=cart-list__item__count>
                            <input class=nl-input type=text name=count value=1> <span class="remove" style="cursor:pointer;" data-href="{{ url('remove-from-cart/'.$product->id) }}">X</span>
                        </div>
                        <div class="cart-list__item__digit cart-list__item__price"> hrk {{ $product->price_outlet }}.00 </div>
                        <div class="cart-list__item__digit cart-list__item__total"> hrk {{ $product->price_outlet }}.00 </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="cart__promo cart-section">
            <h3>promo kod</h3>
            <div class="row">
                <div class="col-lg-6">
                    <p>Ukoliko imate promotivan kod za popust, molimo da ga ovdje unesete:</p></div>
                <div class="col-lg-6">
                    <div class="e-form__group">
                        <input type="text" class="nl-input nl-input--fat" placeholder="Unesite kod ovdje...">
                        <button class="e-btn e-btn--fat e-btn--primary">potvrdi</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="cart__details cart-section">
            <h3>dostava</h3>
            <div class="row">
                <div class="col-lg-6">
                    <div class="cart__dostava">
                        <h4>brza pošta</h4>
                        <div class="cart__radio-list">

                            <div class="cart__radio-list__item">
                                <div class="cart__radio-list__option">
                                    <div class="cart__radio-list__radio">

                                        <div class="e-radio">
                                            <input type="radio" class="e-radio__control" name="radios1" id="radio1">
                                            <div class="e-radio__background">
                                                <div class="e-radio__circle--outer"></div>
                                                <div class="e-radio__circle--inner"></div>
                                            </div>
                                        </div>
                                        <label for="radio1">UPS</label>

                                    </div>
                                    <div>Dostava paketa do 1.2.2019.</div>
                                </div>
                                <div class="cart__radio-list__value">besplatno</div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="cart__receipt">
                        <div class="cart__receipt__line">
                            <div>ukupno</div>
                            <div>hrk 678.90</div>
                        </div>
                        <div class="cart__receipt__line">
                            <div>dostava</div>
                            <div>hrk 0.00</div>
                        </div>
                        <div class="cart__receipt__line">
                            <div>popust</div>
                            <div>hrk 0.00</div>
                        </div>
                        <div class="cart__receipt__line">
                            <div>sveukupno</div>
                            <div class="big">hrk 678.90</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class=cart-nav> <a href=# class="e-btn e-btn--fat e-btn--invert">&lt; nastavi kupovinu</a> <a href=# class="e-btn e-btn--fat e-btn--primary">sigurna uplata</a> </div>
        @else
            <h2>Vaša košarica je prazna.</h2>
        @endif
    </section>

    @include('themes.'.$theme->slug.'.partials.newsletter')

@endsection

@section('footer_scripts')
    {!! HTML::script('themes/'.$theme->slug.'/js/jquery-2.2.4.min.js') !!}
    <script>
        $(function () {
            $('.remove').click(function(e){
                e.preventDefault();
                var el = $(this);
                var link = el.attr('data-href');
                $.post(link, {_token: '{{ csrf_token() }}' }, function(data){
                    if(data == 'done'){
                        el.parent().parent().parent().remove();
                    }else{
                        console.log('error');
                    }
                });
            });
        });
    </script>
@endsection