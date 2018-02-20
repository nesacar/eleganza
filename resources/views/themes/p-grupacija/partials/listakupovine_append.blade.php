<div class="col-md-4 skupi">
    <div class="adresa-polje">
        Adresa dostave
    </div>
    <div class="sivo-polje kupi-forma">
        {!! Form::text('name', null, ['placeholder' => 'Ime']) !!}
        {!! Form::text('lastname', null, ['placeholder' => 'Prezime']) !!}
        {!! Form::text('email', null, ['placeholder' => 'E-mail']) !!}
        {!! Form::text('phone', null, ['placeholder' => 'Telefon']) !!}
        {!! Form::text('address', null, ['placeholder' => 'Adresa']) !!}
        {!! Form::text('town', null, ['placeholder' => 'Grad']) !!}
        {!! Form::text('postcode', null, ['placeholder' => 'Poštanski broj']) !!}
        <div class="squaredTwo">
            {!! Form::checkbox('newsletter', 1, null, ['id' => 'squaredTwo5']) !!}
            <label for="squaredTwo5"></label>
            <p>Prijavi me za Newsletter</p>
        </div>
    </div>

    <div class="adresa-polje guraj">
        Način plaćanja
    </div>
    <div class="sivo-polje">
        <div class="squaredTwo">
            {!! Form::radio('nacin', 0, null, ['id' => 'squaredTwo6', 'checked' => true]) !!}
            <label for="squaredTwo6"></label>
            <p>Virmansko plaćanje.</p>
        </div>
        @if(false)
        <div class="squaredThree">
            {!! Form::radio('nacin', 1, null, ['id' => 'squaredThree7']) !!}
            <label for="squaredThree7"></label>
            <p>Online plaćanje.</p>
        </div>
        @endif
    </div>

</div><!-- .col-md-4 -->

<div class="col-md-8 skupi">
@if(count($products))
    <ul class="lista-kupovine">
        <li>
            <ul>
                <li>Naziv</li>
                <li></li>
                <li>Cena</li>
                <li style="text-align: center">Količina</li>
                <li style="text-align: right">Ukupna cena</li>
                <li></li>
            </ul>
        </li>
        @for($i=1;$i<=count($products);$i++)
            <li>
                <input type="hidden" name="id[{{ $i }}]" value="{{ $products[$i]->id }}">
                <ul>
                    <li>{{ $products[$i]->title }}</li>
                    <li><a href="{{ \App\Product::getProductLink( $products[$i]->id) }}">{!! HTML::image($products[$i]->image) !!}</a></li>
                    <li>{{ $products[$i]->price_small }} RSD</li>
                    <li><input type="text" name="col[{{ $i }}]" value="{{ $cols[$i] }}" class="cena-input" maxlength="1"></li>
                    <li><span class="cena-sum">{{ $products[$i]->price_small * $cols[$i] }} RSD</span></li>
                    <li><a href="{{ url('products/remove-from-cart/'.$products[$i]->id) }}" class="obrisi"><div class="shaa" data-toggle="tooltip" data-placement="right" title="Izbaci iz korpe"></div></a></li>
                </ul>
            </li>
        @endfor
    </ul>
@else
    <div class="alert alert-info mardz-levo">
        Korpa je prazna.
    </div>
@endif
<a href="#" class="nastavak">Nastavite kupovinu</a>
<div class="clear"></div>
<ul class="cena-suma">
    <li><span class="na-levoj">Cena bez PDV-a</span><span class="na-desnoj suma-uk">{{ $sum }} RSD</span></li>
    <li><span class="na-levoj">Stopa PDV-a</span><span class="na-desnoj">20%</span></li>
    @if(false)
    <li><span class="na-levoj">PDV iznos</span><span class="na-desnoj suma-uk-pdv">{{ $sum/5 }} RSD</span></li>
    <li><span class="na-levoj">Ukupno za naplatu:</span><span class="na-desnoj uku">{{ $sum + $sum/5 }} RSD</span></li>
    @else
    <li><span class="na-levoj">Ukupno za naplatu:</span><span class="na-desnoj uku">{{ $sum }} RSD</span></li>
    @endif
</ul>
<div class="clear"></div>
<input type="submit" class="kupuj" value="KUPI">
</div><!-- .col-md-8 -->

<script>
    $('.cena-input').keyup(function(){
        var lista = $('#neki');
        $.post('{{ url('listakupovine') }}', $('form#form-add-setting').serialize(), function(data){ lista.html(data); } );
    });

    $('.obrisi').click(function(e){
        e.preventDefault();
        var el = $(this);
        var lista = $('#neki');
        var link = el.attr('href');
        $.post(link, {_token: '{{ csrf_token() }}' }, function(data){
            el.parent().parent().parent().slideUp().remove();
            $.post('{{ url('listakupovine') }}', $('form#form-add-setting').serialize(), function(data){ lista.html(data); } );
        });
    });

    $('[data-toggle="tooltip"]').tooltip();
</script>