@extends('themes.'.$theme->slug.'.index')

@section('content')

    <div>
        <div class=container>
            <nav aria-label=breadcrumb>
                <ol class=breadcrumb>
                    <li class=breadcrumb-item><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current=page>Hvala na registraciji</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class=page-header>
        <div class="container page-header__container">
            <h2 class=page-header__title>Hvala na registraciji</h2>
            <p>
                Zahvaljujemo vam se na registraciji. Na vašu e-mail adresu će stići poruka s linkom na koji je potrebno kliknuti kako bismo verificirali valjanost upisane e-mail adrese i završili proces registracije.
            </p>
        </div>
    </div>

    <section class="container content">
        <div class="row">
            <div class="col-md-6 e-col--left">

            </div>

            <div class="col-md-6 e-col--right">

            </div>
        </div>
    </section>

@endsection