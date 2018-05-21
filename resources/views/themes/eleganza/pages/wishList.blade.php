@extends('themes.'.$theme->slug.'.index')

@section('header-style')
    {!! HTML::style('themes/'.$theme->slug.'/css/jquery.toastmessage.css') !!}
@endsection

@section('content')

    <div>
        <div class=container>
            <nav aria-label=breadcrumb>
                <ol class=breadcrumb>
                    <li class=breadcrumb-item><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current=page>Lista želja</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class=page-header>
        <div class="container page-header__container">
            <h2 class=page-header__title>Lista želja</h2>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, alias sint. Repellat repellendus consectetur, incidunt non blanditiis debitis quisquam voluptatem iste laudantium quia,
                aspernatur distinctio asperiores expedita ut mollitia illum.
            </p>
        </div>
    </div>

    <section class="container content">
        @if(!empty($products))
        <ul class="wisht-list">
            @foreach($products as $product)
                <li class="wish-list__item row">
                    <div class="col-lg-7 wish-list__item__wrap">
                        <div class="e-thumbnail e-image e-image--11">
                            <a href="{{ \App\Product::getProductLink($product->id) }}">{!! HTML::Image($product->image, $product->title) !!}</a>
                        </div>
                        <div class="wish-list__item__info">
                            <div>{{ $product->title }}</div>
                            <div>{{ $product->price_outlet }},00 kn</div>
                            <div class="wish-list__item__actions">
                                <button class="e-btn e-btn--fat e-btn--primary add" data-href="{{ url('add-to-cart-from-wishlist/'.$product->id) }}">dodaj u košaricu</button>
                                <button class="e-btn e-btn--fat e-btn--primary e-gray remove" data-href="{{ url('remove-from-wishlist/'.$product->id) }}">ukloni</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 wish-list__item__comment">
                        <textarea name="komentar" cols="30" rows="10"></textarea>
                        <button class="e-btn e-btn--primary">spremi komentar</button>
                    </div>
                </li>
            @endforeach
        </ul>
        @endif
    </section>

@endsection

@section('footer_scripts')
    {!! HTML::script('themes/'.$theme->slug.'/js/jquery-2.2.4.min.js') !!}
    {!! HTML::script('themes/'.$theme->slug.'/js/jquery.toastmessage.js') !!}
    <script>
        $(function () {
            $('.remove').click(function(e){
                e.preventDefault();
                var el = $(this);
                var link = el.attr('data-href');
                $.post(link, {_token: '{{ csrf_token() }}' }, function(data){
                    $().toastmessage('showSuccessToast', "proizvod je obrisan iz liste želja");
                    el.parent().parent().parent().parent().remove();
                });
            });

            $('.add').click(function(e){
                e.preventDefault();
                var el = $(this);
                var link = el.attr('data-href');
                $.post(link, {_token: '{{ csrf_token() }}' }, function(data){
                    if(data.message == 'done'){
                        $().toastmessage('showSuccessToast', "proizvod je prebačen u košaricu");
                        el.parent().parent().parent().parent().remove();
                    }else{
                        console.log('error');
                    }
                });
            });
        });
    </script>
@endsection