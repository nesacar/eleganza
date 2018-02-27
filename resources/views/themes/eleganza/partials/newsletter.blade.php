<div class=newsletter>
    <div class=newsletter__background></div>
    <div class="container newsletter__container">
        <div class="diamond diamond--big">
            <div class=diamond__shape></div>
        </div>
        <div class=newsletter__form>
            <p>Ne propusti naše posebne ponude, akcije i uštede, pretplati se na newsletter i ostvari kod za popust od 10%.</p>
            {!! Form::open(['action' => ['PagesController@subscribe'], 'method' => 'POST', 'class' => 'nl-form']) !!}
                <input class="nl-input nl-input--inverse" type=text name=name placeholder="Ime i Prezime">
                <input class="nl-input nl-input--inverse" type=text name=email placeholder=Email>
                <button class="e-btn e-btn--primary" type=submit>Prijavi se</button>
            {!! Form::close() !!}
        </div>
    </div>
</div>