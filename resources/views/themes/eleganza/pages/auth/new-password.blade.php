@extends('themes.'.$theme->slug.'.index')

@section('content')

    <div>
        <div class=container>
            <nav aria-label=breadcrumb>
                <ol class=breadcrumb>
                    <li class=breadcrumb-item><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current=page>Nova lozinka</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class=page-header>
        <div class="container page-header__container">
            <h2 class=page-header__title>Nova lozinka</h2>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, alias sint. Repellat repellendus consectetur, incidunt non blanditiis debitis quisquam voluptatem iste laudantium quia,
                aspernatur distinctio asperiores expedita ut mollitia illum.
            </p>
        </div>
    </div>

    <section class="container content">
        <div class="row">
            <div class="col-md-6 e-col--left">
                {!! Form::open(['action' => ['RegistersController@newPasswordUpdate'], 'method' => 'POST', 'class' => 'e-form']) !!}
                    {!! Form::hidden('hash', $user->hash) !!}
                    <div class="e-form__section">
                        <h3 class="e-form__title">Nova lozinka</h3>
                        <div class="e-form__group">
                            <label for="password">Lozinka</label>
                            <input type="password" name="password" id="password" class="nl-input">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong style="color: red">{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="e-form__group">
                            <label for="password_confirmation-email">Potvrda lozinke</label>
                            <input type="password" name="password_confirmation" id="password_confirmation-email" class="nl-input">
                        </div>
                    </div>
                    <button class="e-btn e-btn--primary e-btn--block" type="submit">potvrdi</button>
                {!! Form::close() !!}
            </div>

            <div class="col-md-6 e-col--right">

            </div>
        </div>
    </section>

@endsection