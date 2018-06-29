@extends('themes.'.$theme->slug.'.index')

@section('content')

    <div>
        <div class=container>
            <nav aria-label=breadcrumb>
                <ol class=breadcrumb>
                    <li class=breadcrumb-item><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current=page>Moj profil</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class=page-header>
        <div class="container page-header__container">
            <h2 class=page-header__title>Moj profil</h2>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, alias sint. Repellat repellendus consectetur, incidunt non blanditiis debitis quisquam voluptatem iste laudantium quia,
                aspernatur distinctio asperiores expedita ut mollitia illum.
            </p>
        </div>
    </div>

    <section class="container content">
        <h2 class="profile-title">Pozdrav, Eleganza</h2>
        <div class="row">
            <div class="col-md-5">
                @if(false)
                    <a href="#" class="e-btn e-btn--invert e-btn--block profile-link">
                        <i class="fas fa-user"></i>
                        Moj profil
                    </a>
                @endif
                <a href="{{ url('moje-narudzbine') }}" class="e-btn e-btn--invert e-btn--block profile-link">
                    <i class="fas fa-archive"></i>
                    Moje narudžbine
                </a>
                <a href="{{ url('info/nacini-placanja/10') }}" class="e-btn e-btn--invert e-btn--block profile-link">
                    <i class="fas fa-credit-card"></i>
                    Načini plaćanja
                </a>
                @if(false)
                <a href="#" class="e-btn e-btn--invert e-btn--block profile-link">
                    <i class="fas fa-users"></i>
                    Društvene mreže
                </a>
                @endif
                <a href="#" class="e-btn e-btn--invert e-btn--block profile-link">
                    <i class="fas fa-question-circle"></i>
                    Trebaš pomoć?
                </a>
                @if(false)
                <a href="#" class="e-btn e-btn--invert e-btn--block profile-link">
                    <i class="far fa-clone"></i>
                    Gdje je moja narudžbina?
                </a>
                @endif
                <a href="{{ url('info/povrat-i-zamjene/9') }}" class="e-btn e-btn--invert e-btn--block profile-link">
                    <i class="far fa-clone"></i>
                    Kako izvršiti povrat?
                </a>
                <a href="{{ url('logout') }}" class="e-btn e-btn--invert e-btn--block profile-link">
                    <i class="fas fa-sign-out-alt"></i>
                    Odjava
                </a>
            </div>
            <div class="col-md-7">
                <div class="container order">
                    <div class="order__content section-spacer">
                        <div class="order__header section-spacer">
                            <h2 class="e-subheading">detalji narudžbe</h2>
                            <p>zahvaljujemo vam na vašoj narudžbi.<br/>Detalje pogledajte u nastavku.</p>
                        </div>
                        <div class="order__body section-spacer">
                            <dir class="order__details">
                                <h3 class="order__subheading section-spacer with-overline">Detalji narudžbe:</h3>

                                @if(count($cart->product)>0)
                                <ul class="section-spacer">
                                    @foreach($cart->product as $product)
                                    <li class="row section-spacer">
                                        <div class="col-sm-6">
                                            <a href="{{ url(\App\Product::getProductLink($product->id, 'hr')) }}" target="_blank">{!! HTML::Image($product->image, $product->title, array('class' => 'order__img')) !!}</a>
                                        </div>
                                        <div class="col-sm-6 order__ids">
                                            <div>{{ $product->title }}</div>
                                            <div>{{ $product->code }}</div>
                                            <div>Količina: {{ $product->pivot->size }}</div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif

                                <div class="section-spacer">
                                    <div class="product-attr">
                                        <span class="product-attr__key">Broj narudžbe:</span>
                                        <span class="product-attr__value">{{ $cart->id }}</span>
                                    </div>
                                    <div class="product-attr">
                                        <span class="product-attr__key">Datum narudžbe:</span>
                                        <span class="product-attr__value">{{ \Carbon\Carbon::parse($cart->created_at)->format('d M Y h:m:s') }}</span>
                                    </div>
                                    <div class="product-attr">
                                        <span class="product-attr__key">Način plaćanja:</span>
                                        <span class="product-attr__value">Placanje prilikokm preuzimanja</span>
                                    </div>
                                    <div class="product-attr">
                                        <span class="product-attr__key">Način dostave:</span>
                                        <span class="product-attr__value">DHL</span>
                                    </div>
                                </div>

                                <div class="section-spacer">
                                    <div class="product-attr">
                                        <span class="product-attr__key">Email:</span>
                                        <span class="product-attr__value">{{ $cart->customer->email }}</span>
                                    </div>
                                    <div class="product-attr">
                                        <span class="product-attr__key">Telefon:</span>
                                        <span class="product-attr__value">{{ $cart->customer->phone }}</span>
                                    </div>
                                </div>

                            </dir>

                            <dir class="order__address">
                                <h3 class="order__subheading section-spacer with-overline">Adresa za dostavu:</h3>

                                <div class="section-spacer">
                                    <div>{{ $cart->customer->name }}</div>
                                    <div>{{ $cart->customer->address }}</div>
                                    <div>{{ $cart->customer->town }}</div>
                                    <div>Hrvatska</div>
                                </div>
                            </dir>
                        </div>
                    </div>

                    <div class="order__receipt">
                        <div class="order__receipt-detail">
                            <div>Cijena sa PDV-om</div><div>{{ $cart->sum }} KHR</div>
                        </div>
                        <div class="order__receipt-detail">
                            <div>Poštarina</div><div>0 KHR</div>
                        </div>
                        <div class="order__receipt-detail">
                            <div>Naknada za plaćanje pouzećem</div><div>0 KHR</div>
                        </div>
                        @if($cart->discount > 0)
                        <div class="order__receipt-detail">
                            <div>Kupon sa PDV-a ({{ $cart->discount }}% Disc.)</div><div>{{ ($cart->discount / 100) * $cart->sum }}KHR</div>
                        </div>
                        @endif
                        @if(false)
                        <div class="order__receipt-detail">
                            <div>PDV (20%)</div><div>{{ $cart->sum * 0.2 }}KHR</div>
                        </div>
                        @endif
                        <div class="order__receipt-detail order__receipt-detail--total">
                            <div>Ukupno</div><div>{{ $cart->sum }}KHR</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

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