@component('mail::message')
Porudžbina sa sajta P-Grupacija.hr

<p>Ime: {{ $cart->customer->name }}</p>
<p>Prezime: {{ $cart->customer->lastname }}</p>
<p>E-mail: {{ $cart->customer->email }}</p>
<p>Telefon: {{ $cart->customer->phone }}</p>
<p>Adresa: {{ $cart->customer->address }}</p>
<p>Grad: {{ $cart->customer->town }}</p>
<p>Poštanski broj: {{ $cart->customer->postcode }}</p>

<br>

<h3>Korpa</h3>

@foreach($cart->product as $product)

    Naziv modela: {{ $product->{'title:sr'} }}
    Šifra modela: {{ $product->code }}

@endforeach

<p>Ukupna suma: {{ $cart->sum }}</p>

Hvala,<br>
{{ config('app.name') }}
@endcomponent
