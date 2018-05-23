<div class="backdrop">
    <div class="container e-card-container instashop">
        <div class="e-card-wrap">
            <div class="instashop__wrap e-card">
                <h3 class="e-subheading">#instashop</h3>
                <p>Pokazite nam kako nosite proizvode iz nase kolekcije. #ELEGANZA</p>

                <div class="instashop-list">
                    @if(count($instaShops)>5)
                        @php $slices1 = $instaShops->slice(0,2); @endphp
                        @php $slices2 = $instaShops->slice(2,2); @endphp
                        @php $slices3 = $instaShops->slice(4,2); @endphp

                        <div class="instashop-list__item">
                            @if(count($slices1)>0)
                                @foreach($slices1 as $slice)
                                    <div class="instashop-image">
                                        <div class="e-image e-image--11 instashop-thumbnail with-zoom" data-id="{{ $slice->id }}">
                                            {!! HTML::Image($slice->image, $slice->title) !!}
                                            <div class="instashop-overlay">
                                                <div class="instashop-overlay__action">
                                                    <i class="fab fa-instagram"></i>
                                                    <span>shop the look</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="instashop-list__item">
                            @if(count($slices2)>0)
                                @foreach($slices2 as $slice)
                                    <div class="instashop-image">
                                        <div class="e-image e-image--11 instashop-thumbnail with-zoom" data-id="{{ $slice->id }}">
                                            {!! HTML::Image($slice->image, $slice->title) !!}
                                            <div class="instashop-overlay">
                                                <div class="instashop-overlay__action">
                                                    <i class="fab fa-instagram"></i>
                                                    <span>shop the look</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="instashop-list__item">
                            @if(count($slices3)>0)
                                @foreach($slices3 as $slice)
                                    <div class="instashop-image">
                                        <div class="e-image e-image--11 instashop-thumbnail with-zoom" data-id="{{ $slice->id }}">
                                            {!! HTML::Image($slice->image, $slice->title) !!}
                                            <div class="instashop-overlay">
                                                <div class="instashop-overlay__action">
                                                    <i class="fab fa-instagram"></i>
                                                    <span>shop the look</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>