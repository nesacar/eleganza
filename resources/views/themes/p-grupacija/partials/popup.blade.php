<div class="newsletter-popup">
    {!! Form::open(['action' => ['PagesController@subscribe'], 'method' => 'POST', 'class' => 'prijava']) !!}
    {!! Form::text('email', '', array('class' => 'nws', 'placeholder' => 'PRIJAVITE SE ZA NEWSLETTER')) !!}
    <input type="submit" value="Send" class="snd">
    <div class="close-btn"></div>
    {!! Form::close() !!}
</div>