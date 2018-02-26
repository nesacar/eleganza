@extends('themes.'.$theme->slug.'.index')

@section('content')
    <div>
        <div class=container>
            <nav aria-label=breadcrumb>
                <ol class=breadcrumb>
                    <li class=breadcrumb-item><a href=#>Home</a></li>
                    <li class=breadcrumb-item><a href=#>Something</a></li>
                    <li class="breadcrumb-item active" aria-current=page>Library</li>
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
        <div class="mobile-drawer-holder filters-holder" id=jsFilters>
            {!! Form::open(['method' => 'GET', 'class' => 'e-drawer e-drawer--right filters-drawer', 'id' => 'moja']) !!}
                {!! Form::hidden('category_id', $category->id) !!}
                {!! Form::hidden('page', 0, array('id' => 'page')) !!}

                @include('themes.'.$theme->slug.'.partials.filters')

                <button class="e-btn e-btn--primary e-btn--block filters__submit-btn">primeni</button>

        </div>

        @if(count($products)>0)
        <div class="products-container">
            <div class=results-header>
                <div class="e-select e-select--with-carrot">
                    <label for=order-by>Sortiraj po: </label>
                    <select id=order-by name="sort">
                        @if(request('sort') == 3)
                            <option value=2>Cijena: manja prema veća</option>
                            <option value=3 selected>Cijena: veća prema manjoj</option>
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
                {{ $products->appends(\Illuminate\Support\Facades\Input::all())->links( "pagination::bootstrap-4") }}

            </div>
            <ul class="product-list">
                @foreach($products as $product)
                    <li class="product-item product-list__item with-shadow">
                        <a href="{{ \App\Product::getProductLink($product->id) }}">
                            <div class=product-item__img-box>
                                {!! HTML::Image($product->image, $product->title) !!}
                                <ul class=product-item__actions>
                                    <li class="icon-btn icon-btn--inverse"> <i class="fas fa-shopping-cart"></i> </li>
                                    <li class="icon-btn icon-btn--inverse"> <i class="fas fa-heart"></i> </li>
                                    <li class="icon-btn icon-btn--inverse"> <i class="fas fa-search"></i> </li>
                                </ul>
                            </div>
                            <div class=product-item__info-box>
                                <span class=product-item__brand>@if(isset($product->brand)) {{ $product->brand->title }} @endif</span>
                                <h2 class=product-item__name>{{ $product->title }}</h2>
                                @if($product->discount != null && $product->discount > 0)
                                    <span class=product-item__price>{{ $product->price_outlet }}</span>
                                @else
                                    <span class=product-item__price>{{ $product->price_small }}</span>
                                @endif
                            </div>
                            <button class="e-btn e-btn--primary e-btn--block">saznaj više</button>
                        </a>
                        @if($product->discount != null && $product->discount > 0)
                            <div class="status status--sale">popust {{ $product->discount }}</div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
        @endif

    </section>
    <!-- ./Page content -->

    <button class="e-btn e-btn--primary e-fab filter-toggler" data-e-controls="#jsFilters">
        <i class="fas fa-filter"></i>
    </button>

    @include('themes.'.$theme->slug.'.partials.newsletter')

@endsection

@section('footer_scripts')
    {!! HTML::script('themes/'.$theme->slug.'/js/jquery-2.2.4.min.js') !!}
    <script>
        $(function () {
            $('input[type="checkbox"]').click(function(){
                $('#page').val(1);
                $('#moja').submit();
            });

            $('.clean').parent().parent().parent().remove();

            $('select[name="sort"]').change(function(){
                $('#page').val(1);
                $('#moja').submit();
            });

            $('select[name="limit"]').change(function(){
                $('#page').val(1);
                $('#moja').submit();
            });
        });
    </script>
@endsection