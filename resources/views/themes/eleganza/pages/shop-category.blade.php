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

                    @if($s1 != null) @if($s1->id != $category->id)
                        <li class=breadcrumb-item><a
                                    href={{ url(\App\Category::getCategoryLink($s1, 'hr')) }}>{{ $s1->title }}</a>
                        </li> @else
                        <li class="breadcrumb-item active" aria-current=page>{{ $s1->title }}</li> @endif @endif

                    @if($s2 != null) @if($s2->id != $category->id)
                        <li class=breadcrumb-item><a
                                    href={{ url(\App\Category::getCategoryLink($s2, 'hr')) }}>{{ $s2->title }}</a>
                        </li> @else
                        <li class="breadcrumb-item active" aria-current=page>{{ $s2->title }}</li> @endif @endif

                    @if($s3 != null) @if($s3->id != $category->id)
                        <li class=breadcrumb-item><a
                                    href={{ url(\App\Category::getCategoryLink($s3, 'hr')) }}>{{ $s3->title }}</a>
                        </li> @else
                        <li class="breadcrumb-item active" aria-current=page>{{ $s3->title }}</li> @endif @endif

                    @if($s4 != null) @if($s4->id != $category->id)
                        <li class=breadcrumb-item><a
                                    href={{ url(\App\Category::getCategoryLink($s4, 'hr')) }}>{{ $s4->title }}</a>
                        </li> @else
                        <li class="breadcrumb-item active" aria-current=page>{{ $s4->title }}</li> @endif @endif

                </ol>

            </nav>

        </div>

    </div>



    <div class=page-header>

        <div class="container page-header__container">

            <h2 class=page-header__title>{{ $category->title }}</h2>

            {!! $category->desc !!}

        </div>

    </div>



    <!-- Page content -->

    <section class="container content products-content">

        <div class="mobile-drawer-holder filters-holder" id=jsFilters data-e-is-overlay=true>

            {!! Form::open(['method' => 'GET', 'class' => 'e-drawer e-drawer--right filters-drawer', 'id' => 'moja', 'data-e-is-surface' => true]) !!}

            {!! Form::hidden('category_id', $category->id) !!}

            {!! Form::hidden('page', 0, array('id' => 'page')) !!}



            @include('themes.'.$theme->slug.'.partials.filters')


            <button class="e-btn e-btn--primary e-btn--block filters__submit-btn" id="primeni">primjeni</button>


        </div>


        @if(count($data['products'])>0)

            <div class="products-container">

                <div class=results-header>

                    <div class="e-select e-select--with-carrot">

                        <label for=order-by>Sortiraj po: </label>

                        <select id=order-by name="sort">

                            <option value=0>Prikaži po</option>

                            @if(request('sort') == 3)

                                <option value=2>Cijena: manja prema veća</option>

                                <option value=3 selected>Cijena: veća prema manjoj</option>

                            @elseif(request('sort') == 2)

                                <option value=2 selected>Cijena: manja prema veća</option>

                                <option value=3>Cijena: veća prema manjoj</option>

                            @else

                                <option value=2>Cijena: manja prema veća</option>

                                <option value=3>Cijena: veća prema manjoj</option>

                            @endif

                        </select>

                    </div>

                    <div class="e-select e-select--with-carrot">

                        <label for=how-many>Prikaži: </label>

                        <select id=how-many name="limit">

                            @if(request('limit') == 18)

                                <option value=9>9</option>

                                <option value=18 selected>18</option>

                            @else

                                <option value=9>9</option>

                                <option value=18>18</option>

                            @endif

                        </select>

                    </div>

                    {!! Form::close() !!}

                    {{ $data['products']->appends(\Illuminate\Support\Facades\Input::all())->links( "pagination::bootstrap-4") }}


                </div>

                @if(!empty($data['products']))

                <ul class="product-list">

                    @foreach($data['products'] as $product)

                        @component('themes.'.$theme->slug.'.components.product', ['product' => $product])

                        @endcomponent

                    @endforeach

                </ul>

                @endif
                <div class="results-header">

                    {{ $data['products']->appends(\Illuminate\Support\Facades\Input::all())->links( "pagination::bootstrap-4") }}
                </div>

            </div>

        @endif


    </section>

    <!-- ./Page content -->



    <button class="e-btn e-btn--primary e-fab filter-toggler js-emitter"
      data-event="slider:layout"
      data-e-controls="#jsFilters"
    >

        <i class="fas fa-filter"></i>

    </button>



    @include('themes.'.$theme->slug.'.partials.newsletter')



@endsection



@section('footer_scripts')

    {!! HTML::script('themes/'.$theme->slug.'/js/jquery-2.2.4.min.js') !!}

    {!! HTML::script('themes/'.$theme->slug.'/js/jquery.toastmessage.js') !!}

    <script>

        $(function () {


            $('input[type="checkbox"]').click(function () {

                $('#page').val(1);

                $('#moja').submit();

            });


            $('.clean').parent().parent().parent().remove();


            $('select[name="sort"]').change(function () {

                $('#page').val(1);

                $('#moja').submit();

            });


            $('select[name="limit"]').change(function () {

                $('#page').val(1);

                $('#moja').submit();

            });


            $('#primeni').click(function (e) {

                e.preventDefault();

                $('#page').val(1);

                $('#moja').submit();

            });


            $('.filter').not('.cijena').not('.promjer').each(function () {

                var count = $(this).find('input[type="checkbox"]').length;

                if (count == 0) {

                    $(this).remove();

                }

            });


            $('.addWish').click(function (e) {

                e.preventDefault();

                var link = $(this).attr('href');

                $.post(link, {_token: '{{ csrf_token() }}'}, function (data) {

                    $().toastmessage('showSuccessToast', "proizvod je dodat u listu želja");

                });

            });


            $('.addCart').click(function (e) {

                e.preventDefault();

                var link = $(this).attr('href');

                $.post(link, {_token: '{{ csrf_token() }}'}, function (data) {

                    $().toastmessage('showSuccessToast', "proizvod je dodat u košaricu");

                });

            });

        });

    </script>

@endsection