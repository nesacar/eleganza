<div class="footer">
    <div class="col-sm-4 col-xs-6 dodatak" style="margin-bottom: 20px;">
        {!! HTML::image($theme->slug.'/img/P-Grupacija_logo.png', 'logo', array('class' => 'footer-logo')) !!}
        <ul>
            <li>P-Grupacija d.o.o.</li>
            <li>Omladinska 4</li>
            <li>51000 Rijeka, Hrvatska</li>
            <li>Tel: 051 227 012</li>
            <li>Fax: 051 227 014</li>
            <li>E-mail: sales@p-grupacija.hr</li>
        </ul>
    </div>
    <div class="col-sm-4 col-sm-push-4 col-xs-6 dodatak">
        <ul class="links">
            @if(count($info))
                @foreach($info as $i)
                    <li><a href="{{ url($i->link) }}">{{ $i->title }}</a></li>
                @endforeach
            @endif
        </ul>
    </div>
    <div class="col-sm-4 col-sm-pull-4 col-xs-12 letter">
        {!! Form::open(['action' => ['SubscribersController@subscribe'], 'method' => 'POST']) !!}
            {!! Form::text('email', null, ['placeholder' => 'Prijavite se za Newsletter']) !!}
        {!! Form::close() !!}
        <p>Pročitajte uslove korišćenja i pravila privatnosti <a href="#">ovde</a></p>
        <p class="icon">
            <a href="{{ $settings->instagram }}" style="text-decoration: none" target="_blank">
                <i class="fa fa-instagram"></i>
            </a>
            <a href="{{ $settings->facebook }}" style="text-decoration: none" target="_blank">
                <i class="fa fa-facebook-official"></i>
            </a>
        </p>
    </div>
</div>