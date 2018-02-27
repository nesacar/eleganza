<div class=filters>
    <div class=filters__header>osnovni filter</div>
    <div class=filters__body>
        <div class=filter>
            <h4 class=filter__name>cijena</h4>
            <div class=e-slider>
                @if(request('max-price') > 0)
                    <div data-is-slider=true data-min-value={{ request('min-price') }} data-max-value={{ request('max-price') }} data-value-range={{ $max->price_small }} id=jsPriceSlider></div>
                @else
                    <div data-is-slider=true data-min-value=0 data-max-value={{ $max->price_small }} data-value-range={{ $max->price_small }} id=jsPriceSlider></div>
                @endif
                <div class=e-slider__labels>
                    <input type=text name=min-price class=hidden data-label-for=min data-for-slider=jsPriceSlider readonly=readonly />
                    <span class="e-slider__label e-slider__label--kn" data-label-for=min data-for-slider=jsPriceSlider></span>
                    -
                    <input type=text name=max-price class=hidden data-label-for=max data-for-slider=jsPriceSlider readonly=readonly />
                    <span class="e-slider__label e-slider__label--kn" data-label-for=max data-for-slider=jsPriceSlider></span>
                </div>
            </div>
        </div>
        @if(count($props)>0)
            @foreach($props as $prop)
                @php $atts = \App\Attribute::getFilteredAttributes($prop->id, $category->id); @endphp
                <div class=filter>
                    <h4 class=filter__name>{{ $prop->title }}</h4>
                    <ul class=filter-list>
                        @foreach($atts as $a)
                            @if($a->publish == 1)
                                <li class=filter-list__item>
                                    <div class=e-list__item>
                                        <div class=e-checkbox>
                                            @if(in_array($a->id, $filters))
                                                {!! Form::checkbox('filters[]', $a->id, true, array('id' => 'cb-' . $a->id, 'class' => 'e-checkbox__control')) !!}
                                            @else
                                                @if(in_array($a->id, $filteri))
                                                    {!! Form::checkbox('filters[]', $a->id, false, array('id' => 'cb-' . $a->id, 'class' => 'e-checkbox__control')) !!}
                                                @else
                                                    {!! Form::checkbox('filters[]', $a->id, false, array('id' => 'cb-' . $a->id, 'class' => 'e-checkbox__control clean')) !!}
                                                @endif
                                            @endif
                                            <div class=e-checkbox__background>
                                                <svg class=e-checkbox__checkmark viewBox="0 0 24 24"> <path class=e-checkbox__path fill=none stroke=white d="M1.73,12.91 8.1,19.28 22.79,4.59"></path> </svg>
                                            </div>
                                        </div>
                                        <label for="cb-{{$a->id }}">{{ $a->title }}</label>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endforeach
        @endif
        <div class=filter>
            <h4 class=filter__name>promjer kucista</h4>
            <div class=e-slider>
                @if(request('max-promer') > 0)
                    <div data-is-slider=true data-min-value={{ request('min-promer') }} data-max-value={{ request('max-promer') }} data-value-range=50 id=jsHousingSlider></div>
                @else
                    <div data-is-slider=true data-min-value=0 data-max-value=50 data-value-range=50 id=jsHousingSlider></div>
                @endif
                <div class=e-slider__labels>
                    <input type=text name=min-promer class=hidden data-label-for=min data-for-slider=jsHousingSlider readonly=readonly />
                    <span class="e-slider__label e-slider__label--mm" data-label-for=min data-for-slider=jsHousingSlider></span>
                    -
                    <input type=text name=max-promer class=hidden data-label-for=max data-for-slider=jsHousingSlider readonly=readonly />
                    <span class="e-slider__label e-slider__label--mm" data-label-for=max data-for-slider=jsHousingSlider></span>
                </div>
            </div>
        </div>
    </div>
</div>