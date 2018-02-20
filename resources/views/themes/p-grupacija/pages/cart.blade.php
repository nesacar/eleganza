@extends('themes.'.$theme->slug.'.index')

@section('title')
    Pregled korpe | p-grupacija.hr
@endsection

@section('keywords'){{ $settings->keywords }}@endsection

@section('seo_social_stuff')
    <meta property="og:type" content="article"/>
    <meta property="og:site_name" content="{{ url('/') }}">
    <meta property="og:url" content="{{ url('korpa') }}">
    <meta property="og:image" content="{{ url('img/logo.png') }}">
@endsection

@section('content')

    <div class="col-md-12 skupi">
        <ol class="breadcrumb">
            <li>korpa</li>
        </ol>
        <div class="clear"></div>
        <ul class="kupujem">
            <li>Kupovina</li>
            <li>Molimo popunite tražena polja kako bi ste finalizovali narudžbinu</li>
        </ul>
    </div><!-- .col-md-12 -->

    {!! Form::open(['action' => 'PagesController@kupovina', 'method' => 'POST', 'id' => 'form-add-setting']) !!}
    <div id="neki">
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

        @if(count($errors) > 0)
            <div class="alert alert-danger samo-levo">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                Došlo je do greške.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(\Session::has('done'))
            <div class="alert alert-success samo-levo">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <p>{!! \Session::get('done') !!}</p>
            </div>
        @endif

        @if(\Session::has('korpa') && is_array(\Session::get('korpa')) && count(\Session::get('korpa')) > 0)
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
            <?php $sum=0; $ids = array(); $i=0; ?>
            @foreach(\Session::get('korpa') as $pr)
                <?php $p = \App\Product::find($pr); ?>
                <?php $sum += $p->price_small; $i++; ?>
                <li>
                    <input type="hidden" name="id[{{$i}}]" value="{{ $p->id }}">
                    <ul>
                        <li>{{ $p->title }}</li>
                        <li><a href="{{ \App\Product::getProductLink($p->id) }}">{!! HTML::image($p->image) !!}</a></li>
                        <li>{{ $p->price_small }} RSD</li>
                        <li><input type="text" name="col[{{$i}}]" value="1" class="cena-input" maxlength="1"></li>
                        <li><span class="cena-sum">{{ $p->price_small }} RSD</span></li>
                        <li><a href="{{ url('products/remove-from-cart/'.$p->id) }}" class="obrisi"><div class="shaa" data-toggle="tooltip" data-placement="right" title="Izbaci iz korpe"></div></a></li>
                    </ul>
                </li>
            @endforeach

        </ul>
        @else
            <div class="alert alert-info mardz-levo">
                Korpa je prazna.
            </div>
        @endif
        <a href="{{ url('shop/satovi') }}" class="nastavak">Nastavite kupovinu</a>
        <div class="clear"></div>
        <ul class="cena-suma">
            <li><span class="na-levoj">Cena sa PDV-om</span><span class="na-desnoj suma-uk">{{ $sum }} RSD</span></li>
            <li><span class="na-levoj">Stopa PDV-a</span><span class="na-desnoj">20%</span></li>
            @if(false)<li><span class="na-levoj">PDV iznos</span><span class="na-desnoj suma-uk-pdv">{{ $sum/5 }} RSD</span></li>
            <li><span class="na-levoj">Ukupno za naplatu:</span><span class="na-desnoj uku">{{ $sum + $sum/5 }} RSD</span></li>@endif
            <li><span class="na-levoj">Ukupno za naplatu:</span><span class="na-desnoj uku">{{ $sum }} RSD</span></li>
        </ul>
        <div class="clear"></div>
        @if(\Session::has('korpa') && is_array(\Session::get('korpa')) && count(\Session::get('korpa')) > 0)
            <input type="submit" class="kupuj" value="KUPI">
        @endif
    </div><!-- .col-md-8 -->
    </div><!-- #neki -->
    {!! Form::close() !!}

@endsection

@section('footer_scripts')

        $('.cena-input').keyup(function(){
            var lista = $('#neki');
            $.post('{{ url('listakupovine') }}', $('form#form-add-setting').serialize(), function(data){ lista.html(data); } );
        });

        $('.obrisi').click(function(e){
            e.preventDefault();
            var lista = $('#neki');
            var el = $(this);
            var link = el.attr('href');
            $.post(link, {_token: '{{ csrf_token() }}' }, function(data){
                el.parent().parent().parent().slideUp().remove();
            });
        });

@endsection
