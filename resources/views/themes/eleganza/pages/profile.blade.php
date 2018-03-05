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
                <a href="#" class="e-btn e-btn--invert e-btn--block profile-link">
                    <i class="fas fa-user"></i>
                    Moj profil
                </a>
                <a href="#" class="e-btn e-btn--invert e-btn--block profile-link">
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
                <a href="#" class="e-btn e-btn--invert e-btn--block profile-link">
                    <i class="far fa-clone"></i>
                    Gdje je moja narudžbina?
                </a>
                <a href="{{ url('info/povrat-i-zamjene/9') }}" class="e-btn e-btn--invert e-btn--block profile-link">
                    <i class="far fa-clone"></i>
                    Kako izvršiti povrat?
                </a>
                <a href="{{ url('logout') }}" class="e-btn e-btn--invert e-btn--block profile-link">
                    <i class="fas fa-sign-out-alt"></i>
                    Odjava
                </a>
            </div>
        </div>
    </section>

@endsection