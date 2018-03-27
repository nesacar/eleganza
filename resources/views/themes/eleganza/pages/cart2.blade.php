@extends('themes.'.$theme->slug.'.index')

@section('header-style')
    {!! HTML::style('themes/'.$theme->slug.'/css/jquery.toastmessage.css') !!}
@endsection

@section('content')

    <div>
        <div class=container>
            <nav aria-label=breadcrumb>
                <ol class=breadcrumb>
                    <li class=breadcrumb-item><a href="{{ url('cart') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current=page>Košarica</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class=page-header>
        <div class="container page-header__container">
            <h2 class=page-header__title>Košarica</h2>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, alias sint. Repellat repellendus consectetur, incidunt non blanditiis debitis quisquam voluptatem iste laudantium quia,
                aspernatur distinctio asperiores expedita ut mollitia illum.
            </p>
        </div>
    </div>

    @if(count($products)>0)
        {!! Form::open(['action' => ['CustomersController@cartUpdate'], 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'forma']) !!}
            <section class="container content" id="app">

                <cart :auth="{{ auth()->check() }}"></cart>

            </section>
        {!! Form::close() !!}
    @else
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 style="margin-top: 50px">Vaša košarica je prazna.</h2>
                </div>
            </div>
        </div>
    @endif

    @include('themes.'.$theme->slug.'.partials.newsletter')

@endsection

@section('footer_scripts')
    {!! HTML::script('js/app.js') !!}
    {!! HTML::script('themes/'.$theme->slug.'/js/jquery-2.2.4.min.js') !!}
    {!! HTML::script('themes/'.$theme->slug.'/js/jquery.toastmessage.js') !!}
    <script>
        $(function () {
            {{--$('.remove').click(function(e){--}}
                {{--e.preventDefault();--}}
                {{--var el = $(this);--}}
                {{--var link = el.attr('data-href');--}}
                {{--$.post(link, {_token: '{{ csrf_token() }}' }, function(data){--}}
                    {{--if(data == 'done'){--}}
                        {{--$().toastmessage('showSuccessToast', "proizvod je obrisan iz košarice");--}}
                        {{--el.parent().parent().parent().remove();--}}
                    {{--}else{--}}
                        {{--console.log('error');--}}
                    {{--}--}}
                {{--});--}}
            {{--});--}}

            {{--$('#kupon').click(function(e){--}}
                {{--e.preventDefault();--}}
                {{--var code = $(this).parent().find('input[type="text"]').val();--}}
                {{--console.log(code);--}}
                {{--$.post('{{ url('coupon') }}', {_token: '{{ csrf_token() }}', code: code }, function(data){--}}
                    {{--if(data == 'done'){--}}
                        {{--location.reload();--}}
                    {{--}else{--}}
                        {{--$().toastmessage('showWarningToast', "Kupon nije ispravan");--}}
                    {{--}--}}
                {{--});--}}
            {{--});--}}

//            $('.submit').click(function (e) {
//                e.preventDefault();
//                $('#forma').submit();
//            });

            {{--if($('.cart-list__item').length > 0){--}}
                {{--cart();--}}
                {{--countChange();--}}
                {{--omotCheckbox();--}}
            {{--}--}}

            {{--function cart() {--}}
                {{--var sum=0;--}}
                {{--$('.cart-list__item').each(function(){--}}
                    {{--var el = $(this);--}}
                    {{--var price = parseFloat(el.find('.js-total').text());--}}
                    {{--sum += parseFloat(price.toFixed(2));--}}
                {{--});--}}
                {{--@if(!empty($discount))--}}
                    {{--$('#ukupno').text(sum);--}}
                    {{--var discount = parseInt('{{ $discount }}');--}}
                    {{--discount = (discount / 100) * sum;--}}
                    {{--sum = sum - discount;--}}
                    {{--$('#popust').text(parseFloat(discount.toFixed(2)));--}}
                    {{--$('#sveukupno').text(parseFloat(sum).toFixed(2));--}}
                {{--@else--}}
                    {{--$('#ukupno').text(sum);--}}
                    {{--$('#sveukupno').text(sum);--}}
                {{--@endif--}}
            {{--}--}}

            {{--function countChange() {--}}
                {{--$('.count').change(function(){--}}
                    {{--var li = $(this).parent().parent().parent();--}}
                    {{--var count = parseInt($(this).val());--}}
                    {{--var price = parseFloat(li.find('.js-price').text());--}}
                    {{--var omot = 0;--}}
                    {{--if(li.find('.gift').prop('checked')){--}}
                        {{--omot = parseFloat(li.find('.js-omot').text());--}}
                    {{--}--}}
                    {{--var sum = parseFloat(count * (price + omot)).toFixed(2);--}}
                    {{--li.find('.js-total').text(sum);--}}

                    {{--cart();--}}
                {{--});--}}
            {{--}--}}

            {{--function omotCheckbox() {--}}
                {{--$('.gift').click(function(){--}}
                    {{--var el = $(this);--}}
                    {{--var li = el.parent().parent().parent().parent().parent();--}}
                    {{--var count = parseInt(li.find('.count').val());--}}
                    {{--var price = parseFloat(li.find('.js-price').text());--}}
                    {{--var omot = 0;--}}
                    {{--if(el.prop('checked')){--}}
                        {{--omot = parseFloat(li.find('.js-omot').text());--}}
                    {{--}--}}
                    {{--var sum = parseFloat(count * (price + omot)).toFixed(2);--}}
                    {{--li.find('.js-total').text(sum);--}}

                    {{--cart();--}}
                {{--});--}}
            {{--}--}}

        });
    </script>
@endsection