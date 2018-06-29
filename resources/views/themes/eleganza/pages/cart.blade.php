@extends('themes.'.$theme->slug.'.index')

@section('header-style')
    {!! HTML::style('themes/'.$theme->slug.'/css/jquery.toastmessage.css') !!}
@endsection

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

    @if(!empty($cart))
        {!! Form::open(['action' => ['CustomersController@cartUpdate'], 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'forma']) !!}
            <section class="container content">
                <div class="cart-section">
                    <div class=cart-nav>
                        <a href="{{ url('/') }}" class="e-btn e-btn--fat e-btn--invert">&lt; nastavi kupovinu</a>
                        @if(auth()->check())
                            @if(!empty($cart)) <a href=# class="e-btn e-btn--fat e-btn--primary submit">sigurna uplata</a> @endif
                        @else
                            <a href="{{ url('logovanje') }}" class="e-btn e-btn--fat e-btn--primary">prijavi se</a>
                        @endif
                    </div>
                </div>

                <div class="cart-section">
                    <div class="cart-header">
                        <div class="cart-header__label cart-header__label--artikal">artikal</div>
                        <div class="cart-header__label cart-header__label--opis">opis</div>
                        <div class="cart-header__label cart-header__label--kolicina">kolicina</div>
                        <div class="cart-header__label cart-header__label--cena">cijena artikla</div>
                        <div class="cart-header__label cart-header__label--total">sveukupnu</div>
                    </div>
                    <ul class="cart-list">
                        @foreach($cart as $product)
                            <li class="cart-list__item row">
                                <div class="col-lg-8 col-md-6 cart-list__item__cell">
                                    <div class=cart-list__item__img>
                                        <div class="e-thumbnail e-image e-image--11">
                                            <a href="{{ \App\Product::getProductLink($product->id) }}"> @if($product->options->has('brand')){!! HTML::Image($product->options->image, $product->name) !!}</a> @endif
                                            <input type="hidden" name="ids[]" value="{{ $product->id }}">
                                            <input type="hidden" name="rowIds[]" value="{{ $product->rowId }}">
                                        </div>
                                    </div>
                                    <div class=cart-list__item__about>
                                        <div class=cart-list__item__brand>@if($product->options->has('brand')) {{ $product->options->brand }} @endif</div>
                                        <div class=cart-list__item__model>{{ $product->name }}</div>
                                        <hr>
                                        <div class=e-form__cb-group>
                                            <div class=e-checkbox>
                                                <input id=gift type=checkbox class="e-checkbox__control gift" name="gift_{{ $product->id }}[]" value="1">
                                                <div class=e-checkbox__background>
                                                    <svg class=e-checkbox__checkmark viewBox="0 0 24 24"> <path class=e-checkbox__path fill=none stroke=white d="M1.73,12.91 8.1,19.28 22.79,4.59"></path> </svg>
                                                </div>
                                            </div>
                                            <label for=gift>Umotaj ovaj artikal kao poklon (+ hrk <span class="js-omot">16.41</span>)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 cart-list__item__cell">
                                    <div class=cart-list__item__count>
                                        <input class="nl-input count" type=number name=counts[] value=1 min="1" max="10"> <span class="remove" style="cursor:pointer;" data-href="{{ url('remove-from-cart/'.$product->id) }}">X</span>
                                    </div>
                                    <div class="cart-list__item__digit cart-list__item__price"> hrk <span class="js-price">{{ $product->price }}.00</span> </div>
                                    <div class="cart-list__item__digit cart-list__item__total"> hrk <span class="js-total">{{ $product->subtotal }}.00</span> </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                @if((!session()->has('coupon')))
                <div class="cart__promo cart-section">
                    <h3>promo kod</h3>
                    <div class="row">
                        <div class="col-lg-6">
                            <p>Ukoliko imate promotivan kod za popust, molimo da ga ovdje unesete:</p></div>
                        <div class="col-lg-6">
                            <div class="e-form__group">
                                <input type="text" name="code" class="nl-input nl-input--fat" placeholder="Unesite kod ovdje...">
                                <button class="e-btn e-btn--fat e-btn--primary" id="kupon" type="submit">potvrdi</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
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
                                                    <input type="radio" class="e-radio__control" name="radios1" id="radio1" name="dostava">
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
                                    <div>hrk <span id="ukupno">{{ \Cart::total() }}</span></div>
                                </div>
                                <div class="cart__receipt__line">
                                    <div>dostava</div>
                                    <div>hrk <span id="dostava">0.00</span></div>
                                </div>
                                <div class="cart__receipt__line">
                                    <div>popust</div>
                                    <div>hrk <span id="popust">0 %</span></div>
                                </div>
                                <div class="cart__receipt__line">
                                    <div>sveukupno</div>
                                    <div class="big">hrk <span id="sveukupno">{{ \Cart::total() }}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=cart-nav>
                    <a href=# class="e-btn e-btn--fat e-btn--invert">&lt; nastavi kupovinu</a>
                    @if(auth()->check())
                        @if(!empty($cart)) <a href=# class="e-btn e-btn--fat e-btn--primary submit">sigurna uplata</a> @endif
                    @else
                        <a href="{{ url('logovanje') }}" class="e-btn e-btn--fat e-btn--primary">prijavi se</a>
                    @endif
                </div>
            </section>
        {!! Form::close() !!}
    @else
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 style="margin-top: 50px">Vaša košarica je prazna.</h2>
                </div>
            </div>
        </div>
    @endif

    @include('themes.'.$theme->slug.'.partials.newsletter')

@endsection

@section('footer_scripts')
    {!! HTML::script('themes/'.$theme->slug.'/js/jquery-2.2.4.min.js') !!}
    {!! HTML::script('themes/'.$theme->slug.'/js/jquery.toastmessage.js') !!}
    <script>
        $(function () {
            $('.remove').click(function(e){
                e.preventDefault();
                var el = $(this);
                var link = el.attr('data-href');
                $.post(link, {_token: '{{ csrf_token() }}' }, function(data){
                    if(data == 'done'){
                        $().toastmessage('showSuccessToast', "proizvod je obrisan iz košarice");
                        el.parent().parent().parent().remove();
                    }else{
                        console.log('error');
                    }
                });
            });

            $('#kupon').click(function(e){
                e.preventDefault();
                var code = $(this).parent().find('input[type="text"]').val();
                console.log(code);
                $.post('{{ url('coupon') }}', {_token: '{{ csrf_token() }}', code: code }, function(data){
                    if(data == 'error'){
                        $().toastmessage('showWarningToast', "Kupon nije ispravan");
                    }else{
                        console.log(data.coupon);
                        $().toastmessage('showSuccessToast', "kupon je primenjen: " + data.coupon.discount + ' %');
                        $('#popust').text(data.coupon.discount + ' %');
                        $('.cart__promo').css({'display': 'none'});
                    }
                });
            });

            $('.submit').click(function (e) {
                e.preventDefault();
                $('#forma').submit();
            });

            if($('.cart-list__item').length > 0){
                cart();
                countChange();
                omotCheckbox();
            }

            function cart() {
                var sum=0;
                $('.cart-list__item').each(function(){
                    var el = $(this);
                    var price = parseFloat(el.find('.js-total').text());
                    sum += parseFloat(price.toFixed(2));
                });
                @if(!empty($discount))
                    $('#ukupno').text(sum);
                    var discount = parseInt('{{ $discount }}');
                    discount = (discount / 100) * sum;
                    sum = sum - discount;
                    $('#popust').text(parseFloat(discount.toFixed(2)));
                    $('#sveukupno').text(parseFloat(sum).toFixed(2));
                @else
                    $('#ukupno').text(sum);
                    $('#sveukupno').text(sum);
                @endif
            }

            function countChange() {
                $('.count').change(function(){
                    var li = $(this).parent().parent().parent();
                    var count = parseInt($(this).val());
                    var price = parseFloat(li.find('.js-price').text());
                    var omot = 0;
                    if(li.find('.gift').prop('checked')){
                        omot = parseFloat(li.find('.js-omot').text());
                    }
                    var sum = parseFloat(count * (price + omot)).toFixed(2);
                    li.find('.js-total').text(sum);

                    cart();
                });
            }

            function omotCheckbox() {
                $('.gift').click(function(){
                    var el = $(this);
                    var li = el.parent().parent().parent().parent().parent();
                    var count = parseInt(li.find('.count').val());
                    var price = parseFloat(li.find('.js-price').text());
                    var omot = 0;
                    if(el.prop('checked')){
                        omot = parseFloat(li.find('.js-omot').text());
                    }
                    var sum = parseFloat(count * (price + omot)).toFixed(2);
                    li.find('.js-total').text(sum);

                    cart();
                });
            }

        });
    </script>
@endsection