@extends('themes.'.$theme->slug.'.index')

@section('content')

    <div>
        <div class=container>
            <nav aria-label=breadcrumb>
                <ol class=breadcrumb>
                    <li class=breadcrumb-item><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current=page>Zaboravljena lozinka</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class=page-header>
        <div class="container page-header__container">
            <h2 class=page-header__title>Zaboravljena lozinka</h2>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, alias sint. Repellat repellendus consectetur, incidunt non blanditiis debitis quisquam voluptatem iste laudantium quia,
                aspernatur distinctio asperiores expedita ut mollitia illum.
            </p>
        </div>
    </div>

    <section class="container content">
        <div class="row">
            <div class="col-md-6 e-col--left">
                {!! Form::open(['action' => ['RegistersController@passwordForgetUpdate'], 'method' => 'POST', 'class' => 'e-form']) !!}
                    <div class="e-form__section">
                        <h3 class="e-form__title">Promena lozinke</h3>
                        <p class="e-form__description">Upiši email adresu na koju ćemo ti poslati potvrdni link za novu lozinku."</p>
                        <div class="e-form__group">
                            <label for="reg-email">Upiši svoj email</label>
                            <input type="text" name="email" id="reg-email" class="nl-input">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong style="color: red">{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <button class="e-btn e-btn--primary e-btn--block" type="submit">nastavi kao gost</button>
                {!! Form::close() !!}
            </div>

            <div class="col-md-6 e-col--right">

            </div>
        </div>
    </section>

@endsection