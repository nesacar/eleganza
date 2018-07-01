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
                <a href="{{ url('info/trebas-pomoc/14') }}" class="e-btn e-btn--invert e-btn--block profile-link">
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
                @if(count($carts))
                <ul class="orders-list">
                    @foreach($carts as $cart)
                    <li class="orders-list__item container">
                        <div class="orders-list__header">
                            <div class="header-col">
                                <h6 class="header-col__name with-overline">datum narudžbe:</h6>
                                <p class="header-col__">{{ \Carbon\Carbon::parse($cart->created_at)->format('d M Y') }}</p>
                            </div>
                            <div class="header-col">
                                <h6 class="header-col__name with-overline">broj narudžbe:</h6>
                                <p class="header-col__">{{ $cart->id }}</p>
                            </div>
                            <div class="header-col">
                                <h6 class="header-col__name with-overline">vrijednost:</h6>
                                <p class="header-col__">{{ $cart->sum }} kn</p>
                            </div>
                        </div>
                        @if(count($cart->product)>0)
                        <ul class="orders-list__body">
                            <li class="orders-list__order">
                                <div class="e-thumbnail e-image e-image--11">
                                    {!! HTML::Image($cart->product->first()->image, $cart->product->first()->title) !!}
                                </div>
                                <a href="{{ url('moja-narudzbina/'.$cart->id) }}" class="e-btn e-btn--invert e-btn--fat">pogldedaj narudžbu</a>
                            </li>
                        </ul>
                        @endif
                    </li>
                    @endforeach
                </ul>
                @endif
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