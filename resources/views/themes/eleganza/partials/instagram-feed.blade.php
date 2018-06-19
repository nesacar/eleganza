<div class="backdrop">
    <div class="container e-card-container instashop">
        <div class="e-card-wrap">
            <div class="instashop__wrap e-card">
                <h3 class="e-subheading">#instashop</h3>
                <p>Pokazite nam kako nosite proizvode iz nase kolekcije. #ELEGANZA</p>

                <div class="instashop-list js-grid">
                  @if(count($instaShops)>5)
                    @php $instaShops = $instaShops->slice(0,6); @endphp
                    @foreach($instaShops as $i=>$item)
                    @php
                    $base = 'e-image instashop-thumbnail with-zoom';
                    $img_className = ($i % 2 == 0)
                      ? $base.' e-image--11'
                      : $base.' e-image--43';
                    @endphp
                    <div class="instashop-image js-grid-cell">
                      <div class="{{$img_className}}"
                        data-id="{{ $item->id }}">
                          {!! HTML::Image($item->image, $item->title) !!}
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
            </div>
        </div>
    </div>
</div>