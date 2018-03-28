<aside class="modal" id="jsModalOrder" data-e-is-overlay="true" role="dialog">
    <div class="modal__dialog" data-e-is-surface="true">
        <div class="modal__header">
            <button
                    class="icon-btn icon-btn--primary"
                    data-e-controls="#jsModalOrder"
            >
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal__body">
            <p>Zahvaljujemo vam se na interesu za <span>IME PROIZVODA</span>. Molimo vas da upišete svoje podatke kako bi vas mogli kontaktirati i dogovoriti narudžbu proizboda.</p>
            {!! Form::open(['action' => ['MessagesController@add'], 'method' => 'POST', 'class' => 'nl-form modal__form']) !!}
                {!! Form::hidden('product_id', $product->id) !!}
                {!! Form::text('name', null, array('class' => 'nl-input nl-input--inverse nl-input--modal', 'placeholder' => 'Ime i prezime')) !!}
                {!! Form::text('email', null, array('class' => 'nl-input nl-input--inverse nl-input--modal', 'placeholder' => 'Email adresa')) !!}
                {!! Form::text('phone', null, array('class' => 'nl-input nl-input--inverse nl-input--modal', 'placeholder' => 'Broj telefona')) !!}
                <button class="e-btn e-btn--secondary" type="submit">pošalji narudžbu</button>
            {!! Form::close() !!}
        </div>
        <div class="modal__footer">
            <p>Hvala vam. Kontaktirat ćemo vas u najkraćem mogućem roku!</p>
        </div>
    </div>
</aside>