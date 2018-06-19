<div class=filters>
  <div class="filters-wrap">
    <div class=filters__header data-toggle=collapse href=#jsBasicFilters role=button aria-expanded=true
         aria-controls=#jsBasicFilters>osnovni filter<span style=margin-left:auto>&plus;</span></div>
    <div class="collapse show" id=jsBasicFilters>
      <div class="filters__body">
        @if($data['max'])
            <div class="filter cijena">
                <h4 class=filter__name>cijena</h4>
                <div class=e-slider>
                    @if(request('maxPrice') > 0)
                        <div data-is-slider=true
                             data-min-value={{ request('minPrice') }} data-max-value={{ request('maxPrice') }} data-value-range={{ $data['range'] }} id=jsPriceSlider></div>
                    @else
                        <div data-is-slider=true data-min-value=0
                             data-max-value={{ $data['max'] }} data-value-range={{ $data['max'] }} id=jsPriceSlider></div>
                    @endif
                    <div class=e-slider__labels>
                        <input type=text name=minPrice class=hidden data-label-for=min data-for-slider=jsPriceSlider
                               readonly=readonly/>
                        <span class="e-slider__label e-slider__label--kn" data-label-for=min
                              data-for-slider=jsPriceSlider></span>
                        -
                        <input type=text name=maxPrice class=hidden data-label-for=max data-for-slider=jsPriceSlider
                               readonly=readonly/>
                        <span class="e-slider__label e-slider__label--kn" data-label-for=max
                              data-for-slider=jsPriceSlider></span>
                    </div>
                </div>
            </div>
        @endif

        @if(count($props1)>0)
            @foreach($props1 as $prop)
                <div class=filter>
                    <h4 class=filter__name>{{ \App\Helper::removeBrackets($prop->title) }}</h4>
                    <ul class=filter-list>
                        @foreach($prop->attribute as $a)
                            @if($a->publish == 1)
                                <li class=filter-list__item>
                                    @if(in_array($a->id, $data['attIds']))
                                        <div class=e-list__item>
                                            <div class=e-checkbox>

                                                <input class="e-checkbox__control" id="{{ 'cb-' . $a->id }}"
                                                       value="{{ $a->id }}" name="filters[]"
                                                       type="checkbox" {{ request('filters') && in_array($a->id, request('filters')) ? 'checked' : '' }} />

                                                <div class=e-checkbox__background>
                                                    <svg class=e-checkbox__checkmark viewBox="0 0 24 24">
                                                        <path class=e-checkbox__path fill=none stroke=white
                                                              d="M1.73,12.91 8.1,19.28 22.79,4.59"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <label for="cb-{{$a->id }}">{{ $a->title }}</label>
                                        </div>
                                    @endif
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endforeach
        @endif
      </div>
    </div>
  </div>
</div>

<div class=filters>
  <div class="filters-wrap">
    <div class="filters__header collapsed" data-toggle=collapse href=#jsAdvancedFilters role=button aria-expanded=false
         aria-controls=#jsAdvancedFilters>prošireni filter<span style=margin-left:auto>&plus;</span></div>
    <div class="collapse" id=jsAdvancedFilters>
      <div class="filters__body">
        @if(count($props2)>0)
            @foreach($props2 as $prop)
                <div class=filter>
                    <h4 class="filter__name">{{ \App\Helper::removeBrackets($prop->title) }}</h4>
                    <ul class=filter-list>
                        @foreach($prop->attribute as $a)
                            @if($a->publish == 1)
                                <li class=filter-list__item>
                                    @if(in_array($a->id, $data['attIds']))
                                        <div class=e-list__item>
                                            <div class=e-checkbox>
                                                <input class="e-checkbox__control" id="{{ 'cb-' . $a->id }}"
                                                       value="{{ $a->id }}" name="filters[]"
                                                       type="checkbox" {{ request('filters') && in_array($a->id, request('filters')) ? 'checked' : '' }} />
                                                <div class=e-checkbox__background>
                                                    <svg class=e-checkbox__checkmark viewBox="0 0 24 24">
                                                        <path class=e-checkbox__path fill=none stroke=white
                                                              d="M1.73,12.91 8.1,19.28 22.79,4.59"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <label for="cb-{{$a->id }}">{{ $a->title }}</label>
                                        </div>
                                    @endif
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endforeach
        @endif

        @if(!empty($set) && $set->id == 4)
            <div class="filter promjer">
                <h4 class=filter__name>Vodootpornost</h4>
                <div class=e-slider>
                    @if(request('max-water') > 0)
                        <div data-is-slider=true
                             data-min-value={{ request('minWater') }} data-max-value={{ request('maxWater') }} data-value-range=500
                             id=jsHousingSlider2></div>
                    @else
                        <div data-is-slider=true data-min-value=0 data-max-value=500 data-value-range=500
                             id=jsHousingSlider2></div>
                    @endif
                    <div class=e-slider__labels>
                        <input type=text name=min-water class=hidden data-label-for=min data-for-slider=jsHousingSlider2
                               readonly=readonly/>
                        <span class="e-slider__label e-slider__label--mm" data-label-for=min
                              data-for-slider=jsHousingSlider2></span>
                        -
                        <input type=text name=max-water class=hidden data-label-for=max data-for-slider=jsHousingSlider2
                               readonly=readonly/>
                        <span class="e-slider__label e-slider__label--mm" data-label-for=max
                              data-for-slider=jsHousingSlider2></span>
                    </div>
                </div>
            </div>

            <div class="filter promjer">
                <h4 class=filter__name>promjer kućišta</h4>
                <div class=e-slider>
                    @if(request('max-promer') > 0)
                        <div data-is-slider=true
                             data-min-value={{ request('minPromer') }} data-max-value={{ request('maxPromer') }} data-value-range=50
                             id=jsHousingSlider></div>
                    @else
                        <div data-is-slider=true data-min-value=0 data-max-value=50 data-value-range=50
                             id=jsHousingSlider></div>
                    @endif
                    <div class=e-slider__labels>
                        <input type=text name=min-promer class=hidden data-label-for=min data-for-slider=jsHousingSlider
                               readonly=readonly/>
                        <span class="e-slider__label e-slider__label--mm" data-label-for=min
                              data-for-slider=jsHousingSlider></span>
                        -
                        <input type=text name=max-promer class=hidden data-label-for=max data-for-slider=jsHousingSlider
                               readonly=readonly/>
                        <span class="e-slider__label e-slider__label--mm" data-label-for=max
                              data-for-slider=jsHousingSlider></span>
                    </div>
                </div>
            </div>
        @endif
      </div>
    </div>
  </div>
</div>
