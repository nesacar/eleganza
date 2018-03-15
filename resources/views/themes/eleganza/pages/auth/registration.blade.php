@extends('themes.'.$theme->slug.'.index')

@section('content')

    <div>
        <div class=container>
            <nav aria-label=breadcrumb>
                <ol class=breadcrumb>
                    <li class=breadcrumb-item><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current=page>Registracija</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class=page-header>
        <div class="container page-header__container">
            <h2 class=page-header__title>Registracija</h2>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, alias sint. Repellat repellendus consectetur, incidunt non blanditiis debitis quisquam voluptatem iste laudantium quia,
                aspernatur distinctio asperiores expedita ut mollitia illum.
            </p>
        </div>
    </div>

    <section class="container content">
        <div class="row">
            <div class="col-md-6 e-col--left">
                <form class="e-form" method="POST" action="{{ route('user-register') }}">
                    {{ csrf_field() }}
                    <div class="e-form__section">
                        <h3 class="e-form__title">registracija korisnika</h3>
                        <div class="e-form__group">
                            <label for="reg-email">Email</label>
                            <input type="text" name="email" id="reg-email" class="nl-input">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong style="color: red">{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="e-form__group">
                            <label for="reg-pass">Lozinka</label>
                            <input type="password" name="password" id="reg-pass" class="nl-input">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong style="color: red">{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="e-form__group">
                            <label for="reg-pass-conf">Potvrda lozinke</label>
                            <input type="password" name="password_confirmation" id="reg-pass-conf" class="nl-input">
                        </div>
                    </div>
                    <div class="e-form__section">
                        <h3 class="e-form__title">osobni podaci</h3>
                        <div class="row">
                            <div class="col-sm-6 e-form__group">
                                <label for="ime">Ime</label>
                                <input type="text" name="name" id="ime" class="nl-input">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                    <strong style="color: red">{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-sm-6 e-form__group">
                                <label for="prezime">Prezime</label>
                                <input type="text" name="lastname" id="prezime" class="nl-input">
                                @if ($errors->has('lastname'))
                                    <span class="help-block">
                                    <strong style="color: red">{{ $errors->first('lastname') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="e-form__section">
                        <h3 class="e-form__title">podaci za dostavu</h3>
                        <div class="row">
                            <div class="col-sm-6 e-form__group">
                                <label for="adresa">Adresa</label>
                                <input type="text" name="address" id="adresa" class="nl-input">
                                @if ($errors->has('address'))
                                    <span class="help-block">
                                    <strong style="color: red">{{ $errors->first('address') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-sm-6 e-form__group">
                                <label for="telefon">Telefon</label>
                                <input type="text" name="phone" id="telefon" class="nl-input">
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                    <strong style="color: red">{{ $errors->first('phone') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-sm-12 e-form__group">
                                <label for="mjesto">Mjesto i poštanski broj</label>
                                <input type="text" name="town" id="mjesto" class="nl-input">
                                @if ($errors->has('town'))
                                    <span class="help-block">
                                    <strong style="color: red">{{ $errors->first('town') }}</strong>
                                </span>
                                @endif
                            </div>
                            {{--<div class="col-sm-6 e-form__group">--}}
                                {{--<label for="postanski-broj">Poštanski broj</label>--}}
                                {{--<input type="text" name="postcode" id="postanski-broj" class="nl-input">--}}
                                {{--@if ($errors->has('postcode'))--}}
                                    {{--<span class="help-block">--}}
                                    {{--<strong style="color: red">{{ $errors->first('postcode') }}</strong>--}}
                                {{--</span>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        </div>
                    </div>
                    @if(false)
                    <div class="e-form__section">
                        <div class="e-form__cb-group">
                            <div class="e-checkbox">
                                <input id="newsletter" type="checkbox" class="e-checkbox__control">
                                <div class="e-checkbox__background">
                                    <svg class="e-checkbox__checkmark" viewBox="0 0 24 24">
                                        <path class="e-checkbox__path" fill="none" stroke="white" d="M1.73,12.91 8.1,19.28 22.79,4.59"></path>
                                    </svg>
                                </div>
                            </div>
                            <label for="newsletter">Zapamti me na ovom računalu</label>
                        </div>
                    </div>
                    @endif
                    <button class="e-btn e-btn--primary e-btn--block" type="submit">potvrdi registraciju</button>
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
                            <input type=text name=email id=log-email class=nl-input>
                        </div>
                        <div class=e-form__group>
                            <label for=log-pass>Lozinka</label>
                            <input type=password name=password id=log-pass class=nl-input>
                        </div>
                        @if(false)
                        <div class=e-form__cb-group>
                            <div class=e-checkbox>
                                <input id=zapamti type=checkbox class=e-checkbox__control>
                                <div class=e-checkbox__background>
                                    <svg class=e-checkbox__checkmark viewBox="0 0 24 24"> <path class=e-checkbox__path fill=none stroke=white d="M1.73,12.91 8.1,19.28 22.79,4.59"></path> </svg>
                                </div>
                            </div>
                            <label for=zapamti>Zapamti me na ovom računalu</label>
                        </div>
                        @endif
                    </div>
                    <button class="e-btn e-btn--primary e-btn--block" type=submit>prijavi se</button>
                </form>
                <div class=login>
                    <div class=login__help>
                        @if(false)
                        <p><a href=#>Otvori novi korisnički račun</a></p>
                        @endif
                        <p>Zaboravio/la si lozinku? <a href="{{ url('password/forget') }}">Zatraži novu lozinku</a></p>
                    </div>
                    <div class=login__alt>
                        @if(false)
                        <h4>prijava putem društvenih mreža</h4>
                        <ul class=login__social-list>
                            <li class=login__social-list__item>
                                <a href=#>
                                    <div class="icon-btn icon-btn--primary rounded">
                                        <i class="fab fa-facebook-f"></i>
                                    </div>
                                    <span>Facebook</span>
                                </a>
                            </li>
                            <li class=login__social-list__item>
                                <a href=#>
                                    <div class="icon-btn icon-btn--primary rounded">
                                        <i class="fab fa-google-plus-g"></i>
                                    </div>
                                    <span>Google+</span>
                                </a>
                            </li>
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection