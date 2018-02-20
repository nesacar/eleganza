@extends('themes.'.$theme->slug.'.index')

@section('title')
    {{ $product->title }} | p-grupacija.hr
@endsection

@section('keywords'){{ $settings->keywords }}@endsection

@section('seo_social_stuff')
    <meta property="og:title" content="{!! $product->title !!}">
    <meta property="og:description" content="{!! $product->short !!}">
    <meta property="og:image" content="{{ url($product->image) }}">
    <meta property="og:url" content="{{ url(\App\Product::getProductLink($product->id)) }}">
@endsection

@section('content')
    <div class="container">
        <div class="col-md-4 col-sm-6 prva-trecina">
            @include('themes.'.$theme->slug.'.partials.product-bredcrumb')
            <ul class="product-left-side">
                <li>{{ $product->title }}</li>
                <li>{{ $product->code }}</li>
                @if(isset($tag) && $tag)

                @else
               <!--  <li>@if($settings->price) {{ $product->price_small }} RSD @endif</li> -->
                @endif
            </ul>
           
            <div class="clear"></div>
            <div class="sakrij-ovo">
                @if(count($product->images)>0)
                <ul class="product-list thumbnails">
                    <?php $br=0; ?>
                        <li>
                            <a href="{{ url($product->image) }}" data-standard="{{ url($product->image) }}">
                                <img src="{{ url($product->tmb) }}" alt="{{ $product->title }}" style="width: 75px; height: 108px;">
                            </a>
                        </li>
                    @foreach($product->images as $i)
                        <?php $br++; ?>
                        @if($br < 5)
                            <li>
                                <a href="{{ url($i->file_path) }}" data-standard="{{ url($i->file_path) }}">
                                    <img src="{{ url($i->file_path) }}" alt="{{ $product->title }}" style="width: 75px; height: 108px;">
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <div class="klizac">
                    {!! HTML::image($theme->slug.'/img/kockica.png', '', array('class' => 'njegova-strelica')) !!}
                </div>
                @endif
                @if(count($product->attribute))
                <ul class="product-tagovi">
                    <li>Tagovi: </li>
                    @foreach($product->attribute as $a)
                        <li><a href="{{ url('atribut/'.$a->title.'/'.$a->id) }}">{{ $a->title }} </a></li>
                    @endforeach
                </ul>
                @endif

                @include('themes.'.$theme->slug.'.partials.addthis-buttons')
               
            </div>

        </div>
        <div class="col-md-4 col-sm-6 druga-trecina">
 
            <div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails" id="art">
     
                <a href="{{ url($product->image) }}" >

                    <img  src="{{ url($product->image) }}" alt="{{ $product->title }}" class="big-product">
                    @if(false){!! HTML::image($product->image, $product->slug, array('class' => 'big-product')) !!}@endif
                </a>
            </div>
            <div class="pokazi-ovo">
                @if(count($product->images)>0)
                    <ul class="product-list thumbnails">
                        <?php $br=0; ?>
                            <li>
                                <a href="{{ url($product->image) }}" data-standard="{{ url($product->image) }}">
                                    <img src="{{ url($product->image) }}" alt="{{ $product->title }}" style="width: 75px; height: 108px;">
                                </a>
                            </li>
                        @foreach($product->images as $i)
                            <?php $br++; ?>
                            @if($br < 5)
                                <li>
                                    <a href="{{ url($i->file_path) }}" data-standard="{{ url($i->file_path) }}">
                                        <img src="{{ url($i->file_path) }}" alt="{{ $product->title }}" style="width: 75px; height: 108px;">
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                <div class="klizac">
                    {!! HTML::image($theme->slug.'/img/kockica.png', '', array('class' => 'njegova-strelica')) !!}
                </div>
                @endif
            </div>



        </div>
   
<div class="col-md-4 col-sm-12 specifikacije">
            {!! $product->body !!}
            @if($product->body2 != '')
                <div class="informacione">
                    <div class="sha"></div>
                    <div class="details">Detaljne informacije</div>
                </div>
            @endif
            
                
            <p class="price-right">@if($settings->price) {{ $product->price_small }} RSD @endif</p>
            
             <div class="dugmence">
                @if(true)
                    @if(isset($tag) && $tag)

                    @else
                        @if(\App\Product::productInSession($product->id))
                            <a href="{{ url('admin/products/removetosession/'.$product->id) }}" class="dodavanje"><div class="cart-button active">Ukloni iz korpe</div></a>
                        @else
                            <a href="{{ url('admin/products/addtosession/'.$product->id) }}" class="dodavanje"><div class="cart-button">Dodaj u korpu</div></a>
                        @endif
                        @if(false)<a href="#"><div class="cart-star"><i class="fa fa-star" aria-hidden="true"></i></div></a>@endif
                    @endif
                @endif
            </div>
        </div>
        <div class="hidden-lg hidden-md">
        @if(count($product->attribute))
            <ul class="product-tagovi ">
                <li>Tagovi: </li>
                @foreach($product->attribute as $a)
                    <li><a href="{{ url('atribut/'.$a->title.'/'.$a->id) }}">{{ $a->title }} </a></li>
                @endforeach
            </ul>
        @endif
        @include('themes.'.$theme->slug.'.partials.addthis-buttons')
      
        </div>
        </div>
    </div><!-- .container -->
    @if($product->body2 != '')
    <div class="container infomanija">
        <div class="col-md-12">
            {!! $product->body2 !!}


                 @if(count($product->attribute))
                     <ul class="product-tagovi ">
                         <li>Tagovi: </li>
                         @foreach($product->attribute as $a)
                             <li><a href="{{ url('atribut/'.$a->title.'/'.$a->id) }}">{{ $a->title }} </a></li>
                         @endforeach
                     </ul>
                 @endif
                 @include('themes.'.$theme->slug.'.partials.addthis-buttons')
        </div>

    </div><!-- .container -->
    @endif
    <div class="container">
        <div class="col-md-12 slicni">
            slični proizvodi
        </div>
    </div><!-- .container -->
    <div class="container">
        <div class="category-products-2" >
            @if(count($related))
                <ul>
                    @foreach($related as $r)
                    <li>
                        <ul>
                            <?php $cat = \App\Product::getLastCategoryObject($r->id); ?>
                            <?php $brend = \App\Product::getBrendObject($r->id); ?>
                            <li>@if(isset($brend->id) && count($brend))<a href="{{ url(\App\Category::getShopLink($brend->id)) }}">{{ \App\Product::getBrend($r->id) }}</a>@endif</li>
                            <li><a href="{{ url(\App\Category::getShopLink($cat->id)) }}">{{ \App\Product::getLastCategory($r->id) }}</a></li>
                            <li>{{ $r->code }}</li>
                            <li><a href="{{ url(\App\Product::getProductLink($r->id)) }}">{!! HTML::image($r->image) !!}</a></li>
                            <li>{{ $r->title }}</li>
                            <li>@if($settings->price) {{ $r->price_small }} RSD @endif</li>
                           @if(false)
                            <li>
                                <div class="sh">
                                    <div class="levom"></div>
                                    @if(false)<i class="fa fa-shopping-cart" aria-hidden="true"></i>@endif
                                    @if(false)<i class="fa fa-star" aria-hidden="true"></i>@endif
                                </div>
                            </li>
                          @endif
                        </ul>
                    </li>
                    @endforeach
                </ul>
                @endif
        </div>
    </div>
    <div class="container">
        @if(count($product->post))
            <div class="products" style="margin-top: 0;">
                <?php $br=0; ?>
                @foreach($product->post as $post)
                @php $br++; $link = \App\Post::getPostLink($post); @endphp
                @if($br <= 2)
                <article @if($br == 1)class="left"@else class="right"@endif>
                    <a href="{{ $link }}">
                        <div class="image-holder">
                            {!! HTML::image($post->image) !!}
                        </div>
                    </a>
                    <div class="text-holder" >
                        <h2><a href="{{ $link }}">{!! \App\Post::getSpanTitle($post->title) !!}</a></h2>
                        <p>{{ $post->short }}</p>
                        <a href="{{ $link }}">
                            <div class="sh"></div>
                        </a>
                    </div>
                </article>
                <div class="clear"></div>
                @endif
                @endforeach
            </div>
        @else
            @if(count($rel_posts) > 0)
                <div class="products" style="margin-top: 0;">
                <?php $br=0; ?>
                @foreach($rel_posts as $rel)
                        @php $br++; $link = \App\Post::getPostLink($rel); @endphp
                    <article class="@if($br%2==1) left @else right @endif">
                        <a href="{{ $link }}">
                            <div class="image-holder">
                                {!! HTML::image($rel->image) !!}
                            </div>
                        </a>
                        <div class="text-holder" >
                            <h2><a href="{{ $link }}">{!! \App\Post::getSpanTitle($rel->title) !!}</a></h2>
                            <p>{{ $rel->short }}</p>
                            <a href="{{ $link }}">
                                <div class="sh"></div>
                            </a>
                        </div>
                    </article>
                    <div class="clear"></div>
                @endforeach
                </div>
            @endif
        @endif
    </div>

@endsection

@section('footer_scripts')

    /*
    

    $('.thumbnails').on('click', 'a', function(e) {
    var $this = $(this);

    e.preventDefault();

    // Use EasyZoom's `swap` method
    api1.swap($this.data('standard'), $this.attr('href'));
    }); */

    $('.product-list li').click(function(){
        var levo = $(this).position().left;
        $('.njegova-strelica').animate({left: levo + 28}, 500);
    });

    $('.sha').click(function(){
        $('.infomanija').slideToggle();
    });

    $('.details').click(function(){
        $('.infomanija').slideToggle();
    });
    $('.details').hover(function(){
        $('.sha').toggleClass('hover');
    },function(){
        $('.sha').toggleClass('hover');
    });

   
    $('.thumbnails').on('click', 'a', function(e) {
        var $this = $(this);
        e.preventDefault();
        var easyzoom = $('.easyzoom').easyZoom();
        var api1 = easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');
        api1.swap($this.data('standard'), $this.attr('href'));
    });

    zoom();

    $(window).resize(function(){
        zoom();
    });

    function zoom(){
        var w2 = $(window).width();
      
        if(w2 < 768){
            $('#art').removeClass('easyzoom ');
            
           
          
        }else{
           var easyzoom = $('.easyzoom').easyZoom();
            @if(count($product->images)>0)
           var api1 = easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');
           @endif
        }
    }

    $('.dodavanje').click(function(e){
        e.preventDefault();
        var el = $(this);
        var link = el.attr('href');
        if(el.find('.cart-button').hasClass('active')){
        $.post(link, {_token: '{{ csrf_token() }}' }, function(data){ if(data == 'error'){ return; } el.find('.cart-button').removeClass('active'); el.attr('href', data); el.find('.cart-button').text('Dodaj u korpu'); });
        }else{
        $.post(link, {_token: '{{ csrf_token() }}' }, function(data){ if(data == 'error'){ return; } el.find('.cart-button').addClass('active'); el.attr('href', data); el.find('.cart-button').text('Ukloni iz korpe'); });
        }
    });

@endsection