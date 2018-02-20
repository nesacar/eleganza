<nav class="navbar navbar-default megamenu stick">
    @if(count($topMenu))
    <div class="container" style="z-index: 11;">
        <div class="collapse navbar-collapse">
            {!! HTML::image($theme->slug.'/img/kockica.png', 'strelica', array('class' => 'kockica')) !!}
            <a href="#" id="trigger" class="menu-trigger">{!! HTML::image($theme->slug.'/img/nav-toggle.png') !!}</a>
            @foreach($topMenu as $top)
                <ul class="nav navbar-nav" id="{{ $top->link }}-menu" style="display: none">
                    @php $cat = \App\Menu::find(1)->menuLinks()->where('menu_links.parent', $top->cat_id)->get(); @endphp
                    @if(count($cat))
                        @foreach($cat as $c)
                        <li @if(isset($active)) @if(isset($active2) && $active2 == $c->link) class="active" @endif @endif ><a href="{{ url($c->link) }}">{{ $c->title }}</a></li>
                        @endforeach

                        @if(false)
                            @if(count($top->category) > 0)

                                @foreach($top->category as $shop)
                                    <?php $list = \App\Category::where('parent', $shop->id)->where('publish', 1)->orderby('order', 'ASC')->get();?>
                                    @if(count($list))

                                        <li class="dropdown megamenu-fw">
                                            <a href="{{ url('shop/'.$top->slug) }}" id="shopmenu" class="dropdown-toggle shopic" role="button" aria-expanded="false" style="z-index: 100;">Shop</a>
                                            <ul class="dropdown-menu megamenu-content" role="menu">
                                                <li>
                                                    <div class="row">
                                                        <div class="col-sm-9" style="padding-right: 20px;">
                                                            <ul class="shop-menu">
                                                                @foreach($list as $l)
                                                                    <?php $list2 = \App\Category::where('parent', $l->id)->where('publish', 1)->orderby('order', 'ASC')->get();?>
                                                                    @if(count($list2))
                                                                        <li style="width: 24%">
                                                                            <a href="{{ url('shop/'.$top->slug.'/'.$l->slug) }}" class="second" data-large="{{ url($l->image) }}" data-desc="{{ $l->desc }}" data-title="{{ $l->title }}">{{ $l->title }}</a>
                                                                            <ul class="shop-menu-sub">
                                                                                @foreach($list2 as $l2)
                                                                                    @if($l2->image != '')
                                                                                        <li><a href="{{ url('shop/'.$top->slug.'/'.$l->slug.'/'.$l2->slug) }}" class="third" data-large="{{ url($l2->image) }}" data-desc="{{ $l2->desc }}" data-parent="{{ $l->title }}">{{ $l2->title }}</a></li>
                                                                                    @else
                                                                                        <li><a href="{{ url('shop/'.$top->slug.'/'.$l->slug.'/'.$l2->slug) }}" class="third" data-large="{{ url($l->image) }}" data-desc="{{ $l2->desc }}" data-parent="{{ $l->title }}">{{ $l2->title }}</a></li>
                                                                                    @endif
                                                                                @endforeach
                                                                            </ul>
                                                                        </li>
                                                                    @else
                                                                        <li style="width: 24%">
                                                                            <a href="{{ url('shop/'.$top->slug.'/'.$l->slug) }}" class="second" data-large="{{ url($l->image) }}" data-desc="{{ $l->desc }}" data-title="{{ $l->title }}">{{ $l->title }}</a>
                                                                        </li>
                                                                    @endif

                                                                @endforeach
                                                            </ul>
                                                            <div class="clear"></div>
                                                            <p class="opis">{{ $top->desc }}</p>
                                                        </div><!-- end col-sm-9 -->
                                                        <div class="col-sm-3">
                                                            {!! HTML::image('img/mega-sat.jpg', '', array('class' => 'mega-sat')) !!}
                                                            <div class="clear"></div>
                                                            <ul class="mega-kat">
                                                                <li>{{ $top->title }}</li>
                                                                <li class="druga">@if($list){{ $list->first()->title }}@endif</li>
                                                                <li class="treca">Muški satovi</li>
                                                            </ul>
                                                        </div><!-- end col-3 -->
                                                    </div><!-- end row -->
                                                </li>
                                            </ul>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        @endif


                    @endif
                </ul>
            @endforeach
            <ul class="social">
                <li><a href="{{ url('korpa') }}"><i class="fa fa-shopping-bag" aria-hidden="true"></i></a><span class="korpica">1</span></li>
                <li><a href="{{ $settings->instagram }}" target="_blank"><i class="fa fa-instagram"></i></a></li>
                <li><a href="{{ $settings->facebook }}" target="_blank"><i class="fa fa-facebook-official"></i></a></li>
                <li><a href="#"><i class="fa fa-search" id="klik"></i></a></li>
            </ul><!-- .social -->
            {!! Form::open(['action' => ['PagesController@search'], 'method' => 'GET']) !!}
                <div id="srch">
                    <input type="search" name="text" id="pretraga">
                    <input type="submit" id="submit-search" value="">
                </div>
            {!! Form::close() !!}
        </div><!-- /.navbar-collapse -->
    </div>
    @else
        nema navigacije
    @endif
</nav>