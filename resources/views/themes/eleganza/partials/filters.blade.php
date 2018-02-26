<div class=filters>
    <div class=filters__header>osnovni filter</div>
    <div class=filters__body>
        <div class=filter>
            <h4 class=filter__name>cijena</h4>
            <div class=e-slider>
                <div data-is-slider=true id=jsPriceSlider></div>
                <div class=e-slider__labels>
                    <span class="e-slider__label e-slider__label--kn" data-label-for=min data-for-slider=jsPriceSlider></span> - <span class="e-slider__label e-slider__label--kn" data-label-for=max data-for-slider=jsPriceSlider></span>
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
                        @if(false)
                            <li class=filter-list__item>
                                <div class=e-list__item>
                                    <div class=e-checkbox>
                                        <input id=cb-1 type=checkbox class=e-checkbox__control>
                                        <div class=e-checkbox__background>
                                            <svg class=e-checkbox__checkmark viewBox="0 0 24 24"> <path class=e-checkbox__path fill=none stroke=white d="M1.73,12.91 8.1,19.28 22.79,4.59"></path> </svg>
                                        </div>
                                    </div>
                                    <label for=cb-1>filter value1</label>
                                </div>
                            </li>
                            <li class=filter-list__item>
                                <div class=e-list__item>
                                    <div class=e-checkbox>
                                        <input id=cb-3 type=checkbox class=e-checkbox__control>
                                        <div class=e-checkbox__background>
                                            <svg class=e-checkbox__checkmark viewBox="0 0 24 24"> <path class=e-checkbox__path fill=none stroke=white d="M1.73,12.91 8.1,19.28 22.79,4.59"></path> </svg>
                                        </div>
                                    </div>
                                    <label for=cb-3>filter value3</label>
                                    <span class=e-collapse-toggler data-toggle=collapse href=#collapseExample4 role=button aria-expanded=false aria-controls=collapseExample4>&plus;</span>
                                </div>
                                <div class=collapse id=collapseExample4>
                                    <ul class=filter-list>
                                        <li class=filter-list__item>
                                            <div class=e-list__item>
                                                <div class=e-checkbox>
                                                    <input id=cb-4 type=checkbox class=e-checkbox__control>
                                                    <div class=e-checkbox__background>
                                                        <svg class=e-checkbox__checkmark viewBox="0 0 24 24"> <path class=e-checkbox__path fill=none stroke=white d="M1.73,12.91 8.1,19.28 22.79,4.59"></path> </svg>
                                                    </div>
                                                </div>
                                                <label for=cb-4>filter value4</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            @endforeach
        @else
            <div class=filter>
                <h4 class=filter__name>filter name</h4>
                <ul class=filter-list>
                    <li class=filter-list__item>
                        <div class=e-list__item>
                            <div class=e-checkbox>
                                <input id=cb-1 type=checkbox class=e-checkbox__control>
                                <div class=e-checkbox__background>
                                    <svg class=e-checkbox__checkmark viewBox="0 0 24 24"> <path class=e-checkbox__path fill=none stroke=white d="M1.73,12.91 8.1,19.28 22.79,4.59"></path> </svg>
                                </div>
                            </div>
                            <label for=cb-1>filter value1</label>
                            <span class=e-collapse-toggler data-toggle=collapse href=#collapseExample3 role=button aria-expanded=false aria-controls=collapseExample3>&plus;</span>
                        </div>
                        <div class=collapse id=collapseExample3>
                            <ul class=filter-list>
                                <li class=filter-list__item>
                                    <div class=e-list__item>
                                        <div class=e-checkbox>
                                            <input id=cb-2 type=checkbox class=e-checkbox__control>
                                            <div class=e-checkbox__background>
                                                <svg class=e-checkbox__checkmark viewBox="0 0 24 24"> <path class=e-checkbox__path fill=none stroke=white d="M1.73,12.91 8.1,19.28 22.79,4.59"></path> </svg>
                                            </div>
                                        </div>
                                        <label for=cb-2>filter value2</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class=filter-list__item>
                        <div class=e-list__item>
                            <div class=e-checkbox>
                                <input id=cb-3 type=checkbox class=e-checkbox__control>
                                <div class=e-checkbox__background>
                                    <svg class=e-checkbox__checkmark viewBox="0 0 24 24"> <path class=e-checkbox__path fill=none stroke=white d="M1.73,12.91 8.1,19.28 22.79,4.59"></path> </svg>
                                </div>
                            </div>
                            <label for=cb-3>filter value3</label>
                            <span class=e-collapse-toggler data-toggle=collapse href=#collapseExample4 role=button aria-expanded=false aria-controls=collapseExample4>&plus;</span>
                        </div>
                        <div class=collapse id=collapseExample4>
                            <ul class=filter-list>
                                <li class=filter-list__item>
                                    <div class=e-list__item>
                                        <div class=e-checkbox>
                                            <input id=cb-4 type=checkbox class=e-checkbox__control>
                                            <div class=e-checkbox__background>
                                                <svg class=e-checkbox__checkmark viewBox="0 0 24 24"> <path class=e-checkbox__path fill=none stroke=white d="M1.73,12.91 8.1,19.28 22.79,4.59"></path> </svg>
                                            </div>
                                        </div>
                                        <label for=cb-4>filter value4</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        @endif
        <div class=filter>
            <h4 class=filter__name>promjer kucista</h4>
            <div class=e-slider>
                <div data-is-slider=true id=jsHousingSlider></div>
                <div class=e-slider__labels>
                    <span class="e-slider__label e-slider__label--mm" data-label-for=min data-for-slider=jsHousingSlider></span> - <span class="e-slider__label e-slider__label--mm" data-label-for=max data-for-slider=jsHousingSlider></span>
                </div>
            </div>
        </div>
    </div>
</div>