<div class=filters>

  <div class="filters-wrap">
    <div class="filters__header js-emitter"
      data-event="slider:layout"
      data-toggle=collapse
      href=#jsBasicFilters
      role=button
      aria-expanded=true
      aria-controls=#jsBasicFilters
    >
      osnovni filter<span style=margin-left:auto>&plus;</span>
    </div>

    <div class="collapse show" id=jsBasicFilters>
      <div class="filters__body">
        @if($data['max'])
            <div class="filter cijena">
                <h4 class=filter__name>cijena</h4>
                <div class=e-slider>
                    @if(request('maxPrice') > 0)
                        <div data-is-slider=true
                          data-min={{ request('minPrice') }}
                          data-max={{ request('maxPrice') }}
                          data-rangemax={{ $data['range'] }}
                          data-rangemin="0"
                          id=jsPriceSlider
                        ></div>
                    @else
                        <div data-is-slider=true
                          data-min={{ $data['min'] }}
                          data-max={{ $data['max'] }}
                          data-rangemax={{ $data['max'] }}
                          data-rangemin="0"
                          id=jsPriceSlider
                        ></div>
                    @endif
                    <div class=e-slider__labels>
                        <input class=hidden
                          type=text
                          name=minPrice
                          data-label-for=min
                          data-for-slider=jsPriceSlider
                          readonly=readonly
                        />
                        <span class="e-slider__label e-slider__label--kn"
                          data-label-for=min
                          data-for-slider=jsPriceSlider
                        ></span>
                        -
                        <input class=hidden
                          type=text
                          name=maxPrice
                          data-label-for=max
                          data-for-slider=jsPriceSlider
                          readonly=readonly
                        />
                        <span class="e-slider__label e-slider__label--kn"
                          data-label-for=max
                          data-for-slider=jsPriceSlider
                        ></span>
                    </div>
                </div>
            </div>
        @endif

        @if(!empty($props1)>0)
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

                                                <input class="e-checkbox__control"
                                                  id="{{ 'cb-' . $a->id }}"
                                                  value="{{ $a->id }}"
                                                  name="filters[]"
                                                  type="checkbox" {{ request('filters') && in_array($a->id, request('filters')) ? 'checked' : '' }} />

                                                <div class=e-checkbox__background>
                                                    <svg class=e-checkbox__checkmark viewBox="0 0 24 24">
                                                        <path class=e-checkbox__path
                                                          fill=none
                                                          stroke=white
                                                          d="M1.73,12.91 8.1,19.28 22.79,4.59"
                                                        ></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <label title="{{$a->title}}" for="cb-{{$a->id }}">{{ $a->title }}</label>
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


@php
    $counter = 0;
    if (!empty($props2)>0) {
        foreach ($props2 as $prop) {
            foreach ($prop->attribute as $a) {
                if ($a->publish == 1 && in_array($a->id, $data['attIds'])) {
                    $counter++;
                }
            }
        }
    }
@endphp

  @if($counter > 0)

  <div class="filters-wrap">

    <div class="filters__header js-emitter collapsed"
      data-event="slider:layout"
      data-toggle=collapse
      href=#jsAdvancedFilters
      role=button
      aria-expanded=false
      aria-controls=#jsAdvancedFilters
    >
      prošireni filter<span style=margin-left:auto>&plus;</span>
    </div>

    <div class="collapse" id=jsAdvancedFilters>
      <div class="filters__body">
        @if(!empty($props2)>0)
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
                  <input class="e-checkbox__control"
                    id="{{ 'cb-' . $a->id }}"
                    value="{{ $a->id }}"
                    name="filters[]"
                    type="checkbox" {{ request('filters') && in_array($a->id, request('filters')) ? 'checked' : '' }} />
                  <div class=e-checkbox__background>
                    <svg class=e-checkbox__checkmark viewBox="0 0 24 24">
                      <path class=e-checkbox__path
                        fill=none
                        stroke=white
                        d="M1.73,12.91 8.1,19.28 22.79,4.59"
                      ></path>
                    </svg>
                  </div>
                </div>
                <label title="{{$a->title}}" for="cb-{{$a->id }}">{{ $a->title }}</label>
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
        @if($data['maxWater'])
        <div class="filter promjer">
          <h4 class=filter__name>Vodootpornost</h4>
          <div class=e-slider>

            <div data-is-slider=true
              data-min={{ $data['minWater'] }}
              data-max={{ $data['maxWater'] }}
              data-rangemax={{ $data['rangeWater'] }}
              data-rangemin="0"
              id=jsHousingSlider2
            ></div>

            <div class=e-slider__labels>
              <input class=hidden
                type=text
                name=minWater
                data-label-for=min
                data-for-slider=jsHousingSlider2
                readonly=readonly
              />
              <span class="e-slider__label e-slider__label--m"
                data-label-for=min
                data-for-slider=jsHousingSlider2
              ></span>
              -
              <input class=hidden
                type=text
                name=maxWater
                data-label-for=max
                data-for-slider=jsHousingSlider2
                readonly=readonly
              />
              <span class="e-slider__label e-slider__label--m"
                data-label-for=max
                data-for-slider=jsHousingSlider2
              ></span>
            </div>
          </div>
        </div>
        @endif

        @if($data['maxPromer'])
        <div class="filter promjer">
          <h4 class=filter__name>promjer kućišta</h4>
          <div class=e-slider>

            <div data-is-slider=true
              data-min={{ $data['minPromer'] }}
              data-max={{ $data['maxPromer'] }}
              data-rangemax={{ $data['rangePromer'] }}
              data-rangemin="0"
              id=jsHousingSlider
            ></div>

            <div class=e-slider__labels>
              <input class=hidden
                type=text
                name=minPromer
                data-label-for=min
                data-for-slider=jsHousingSlider
                readonly=readonly
              />
              <span class="e-slider__label e-slider__label--mm"
                data-label-for=min
                data-for-slider=jsHousingSlider
              ></span>
              -
              <input class=hidden
                type=text
                name=maxPromer
                data-label-for=max
                data-for-slider=jsHousingSlider
                readonly=readonly
              />
              <span class="e-slider__label e-slider__label--mm"
                data-label-for=max
                data-for-slider=jsHousingSlider
              ></span>
            </div>

          </div>
        </div>
        @endif
        @endif
      </div>

    </div>

  </div>
  @endif

</div>
