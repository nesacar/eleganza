<div class="col-md-12">
    @include('themes.'.$theme->slug.'.partials.breadcrumb')
    {!! Form::open(['method' => 'GET', 'class' => 'moja', 'id' => 'moja']) !!}
    <div class="na-desno">
        <select name="sort" id="param" class="js-example-basic-single">
            <option value="0">Prikaži po</option>
            <option value="1">Datumu dodavanja</option>
            <option value="2">Popularnosti</option>
            <option value="3">Rastućoj ceni</option>
            <option value="4">Opadajućoj ceni</option>
        </select>
    </div>
    <div class="clear"></div>
</div>
<div class="category-nav">
    <div class="side-title-first">
        Kategorije <i class="strelica nema"></i>
    </div>

    {!! \App\Category::getShopCategories($category->id, false, false, true) !!}

    {!! Form::hidden('category_id', $category->id) !!}
    {!! Form::hidden('page', 0, array('id' => 'page')) !!}
    @if(count($category->property) > 0 && false)

        <div class="filters">
            <div class="side-title">
                Filteri <i class="strelica nema"></i>
            </div>
            <?php $br=0; ?>

            @foreach($category->property as $oso)
               <?php $br++; ?>
               @if(count($oso->attribute) > 0)
               <div class="filter @if($br==1) prvi @endif">
                   <div class="category-filter">
                       <span class="text">{{ $oso->title }}</span> <i class="strelica" aria-hidden="true"></i>
                   </div>
                   <ul @if(\App\Cart::checkFilterNav($oso->attribute, $category->id)) style="display: block" @endif>
                       @foreach($oso->attribute->sortBy('title') as $a)
                       @if($a->publish == 1 && in_array($a->title, $filters))
                       <li>
                           <div class="squaredTwo2">
                               <input type="checkbox" value="{{ $a->id }}" id="{{ $a->title }}" name="filters[]" @if(in_array($a->id, $filters)) checked @endif />
                               <label for="{{ $a->title }}"></label>
                               <a href="#" style="float: left">{{ $a->title }}</a><a href="#"><i class="close-filter" aria-hidden="true"></i></a>
                           </div>
                       </li>
                       @endif
                       @endforeach
                   </ul>
               </div><!-- .filter -->
               @endif
            @endforeach

        </div>

    @else
        <?php
        if(count($products)>0){ $first = $products[0]; }else{ $first = null; }
        ?>
        <div class="filters">
            <div class="side-title">
                Filteri <i class="strelica nema"></i>
            </div>
            <?php $br=0; ?>

            @foreach($props as $oso)
                @php $br++; $atts = \App\Attribute::getFilteredAttributes($oso->id, $category->id); @endphp
                @if(count($atts) > 0)
                    <div class="filter @if($br==1) prvi @endif">
                        <div class="category-filter">
                            <span class="text">{{ $oso->title }}</span> <i class="strelica" aria-hidden="true"></i>
                        </div>
                        <ul @if(\App\Cart::checkFilterNav($oso->attribute, $category->id)) style="display: block" @endif>
                            @foreach($atts as $a)
                                @if($a->publish == 1)
                                    <li>
                                        <div class="squaredTwo2">
                                            @if(in_array($a->id, $filters))
                                                {!! Form::checkbox('filters[]', $a->id, true, array('id' => $a->id)) !!}
                                                <label for="{{ $a->id }}"></label>
                                                <a href="#" style="float: left">{{ $a->title }}</a><a href="#"><i class="close-filter" aria-hidden="true"></i></a>
                                            @else
                                                @if(in_array($a->id, $filteri))
                                                    {!! Form::checkbox('filters[]', $a->id, false, array('id' => $a->id)) !!}
                                                    <label for="{{ $a->id }}"></label>
                                                    <a href="#" style="float: left">{{ $a->title }}</a><a href="#"><i class="close-filter" aria-hidden="true"></i></a>
                                                @else
                                                    {!! Form::checkbox('filters[]', $a->id, false, array('id' => $a->id)) !!}
                                                    <label for="{{ $a->id }}" class="clean"></label>
                                                    <a href="#" style="float: left">{{ $a->title }}</a><a href="#"><i class="close-filter" aria-hidden="true"></i></a>
                                                @endif
                                            @endif
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div><!-- .filter -->
                @endif
            @endforeach

        </div>

    @endif
    {!! Form::close() !!}
</div><!-- .category-nav -->