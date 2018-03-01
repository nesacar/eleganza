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
        <div class="row">
            <div class="col-md-6 e-col--left">
                <form class="e-form" action="POST">
                    <div class="e-form__section">
                        <h3 class="e-form__title">nastavi kupnju kao gost</h3>
                        <p class="e-form__description">Upiši email adresu na koju ćemo ti poslati potvrdu narudžbe i obavjesti vezane uz kupnju te klikni "NASTAVI KAO GOST"</p>
                        <div class="e-form__group">
                            <label for="reg-email">Upiši svoj email</label>
                            <input type="text" name="reg-email" id="reg-email" class="nl-input">
                        </div>
                    </div>
                    <button class="e-btn e-btn--primary e-btn--block" type="submit">nastavi kao gost</button>
                </form>
            </div>

            <div class="col-md-6 e-col--right">
                <form class="e-form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class=e-form__section>
                        <h3 class=e-form__title>već imaš korisnički račun?</h3>
                        <p class=e-form__description>Prijavi se putem emaila za brzu kupnju</p>
                        <div class=e-form__group>
                            <label for=log-email>Email</label>
                            <input type=email name=email id=log-email class=nl-input>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong style="color: red">Kombinacija emaila i lozinke nije isptavna</strong>
                                </span>
                            @endif
                        </div>
                        <div class=e-form__group>
                            <label for=log-pass>Lozinka</label>
                            <input type=password name=password id=log-pass class=nl-input>
                        </div>
                        <div class=e-form__cb-group>
                            <div class=e-checkbox>
                                <input id=zapamti type=checkbox class=e-checkbox__control>
                                <div class=e-checkbox__background> <svg class=e-checkbox__checkmark viewBox="0 0 24 24">
                                        <path class=e-checkbox__path fill=none stroke=white d="M1.73,12.91 8.1,19.28 22.79,4.59"></path>
                                    </svg>
                                </div>
                            </div>
                            <label for=zapamti>Zapamti me na ovom računalu</label>
                        </div>
                    </div>
                    <button class="e-btn e-btn--primary e-btn--block" type=submit>prijavi se</button>
                </form>
                <div class=login>
                    <div class=login__help>
                        <p><a href="{{ url('register') }}">Otvori novi korisnički račun</a></p>
                        <p>Zaboravio/la si lozinku? <a href=#>Zatraži novu lozinku</a></p>
                    </div>
                    <div class=login__alt>
                        <h4>prijava putem društvenih mreža</h4>
                        <ul class=login__social-list>
                            <li class=login__social-list__item> <a href=#> <div class="icon-btn icon-btn--primary rounded"> <i class="fab fa-facebook-f"></i> </div> <span>Facebook</span> </a> </li>
                            <li class=login__social-list__item> <a href=#> <div class="icon-btn icon-btn--primary rounded"> <i class="fab fa-google-plus-g"></i> </div> <span>Google+</span> </a> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection