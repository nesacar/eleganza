@if(isset($watches) && count($watches) > 0)
    <div class="shop-bar up-30">
        <article class="col-md-4 col-sm-6 col-xs-12" style="z-index: 1;">
            <a href="{{ url(\App\Product::getProductLink($watches[0]->id)) }}">
                <div class="image-holder" style="background-image: url('{{ url($watches[0]->image) }}')"></div>
            </a>
            <div class="neki-okvir"></div>
            <div class="text-holder">
                <ul>
                    <li>{{ \App\Product::getBrend($watches[0]->id) }}</li>
                    <li>{{ \App\Product::getLastCategory($watches[0]->id) }}</li>
                    <li>{{ $watches[0]->title }}</li>
                </ul>
                <a href="{{ url(\App\Product::getProductLink($watches[0]->id)) }}">
                    <div class="sh">
                        Pogledaj
                    </div>
                </a>
            </div>
            <div class="clear"></div>
        </article>
        <article class="col-md-4 col-sm-6 col-xs-12" style="z-index: 1;">
            <a href="{{ url(\App\Product::getProductLink($watches[1]->id)) }}">
                <div class="image-holder" style="background-image: url('{{ url($watches[1]->image) }}')"></div>
            </a>
            <div class="neki-okvir"></div>
            <div class="text-holder">
                <ul>
                    <li>{{ \App\Product::getBrend($watches[1]->id) }}</li>
                    <li>{{ \App\Product::getLastCategory($watches[1]->id) }}</li>
                    <li>{{ $watches[1]->title }}</li>
                </ul>
                <a href="{{ url(\App\Product::getProductLink($watches[1]->id)) }}">
                    <div class="sh">
                        Pogledaj
                    </div>
                </a>
            </div>
            <div class="clear"></div>
        </article>
        <article class="col-md-4 col-sm-6 col-xs-12 hidden-sm" style="z-index: 1;">
            <a href="{{ url(\App\Product::getProductLink($watches[2]->id)) }}">
                <div class="image-holder" style="background-image: url('{{ url($watches[2]->image) }}')"></div>
            </a>
            <div class="neki-okvir"></div>
            <div class="text-holder">
                <ul>
                    <li>{{ \App\Product::getBrend($watches[2]->id) }}</li>
                    <li>{{ \App\Product::getLastCategory($watches[2]->id) }}</li>
                    <li>{{ $watches[2]->title }}</li>
                </ul>
                <a href="{{ url(\App\Product::getProductLink($watches[2]->id)) }}">
                    <div class="sh">
                        Pogledaj
                    </div>
                </a>
            </div>
            <div class="clear"></div>
        </article>
    </div>
@endif