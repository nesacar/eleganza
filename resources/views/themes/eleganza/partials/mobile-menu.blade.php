<div class="mobile-drawer-holder mobile-drawer-holder--temporary" id=jsMobileMenu data-e-is-overlay=true>
    <aside class="e-drawer e-drawer--left" data-e-is-surface=true>
        @if(count($menus)>0)
        <ul class=mobile-nav-list>
            @foreach($menus as $menu)

                @if(count($menu->children)>0)
                    <li class=mobile-nav-list__item>
                        <div class="e-list__item e-list__item--big">
                            <a href="{{ $menu->link }}">{{ $menu->title }}</a>
                            <span class=e-collapse-toggler data-toggle=collapse href=#collapseExample{{ $menu->id }} role=button aria-expanded=false aria-controls=collapseExample{{ $menu->id }}>&plus;</span>
                        </div>
                        <div class=collapse id=collapseExample{{ $menu->id }}>
                            <ul class=mobile-nav>
                                @foreach($menu->children as $sub)

                                    @if(count($sub->children)>0)
                                        <li class=mobile-nav-list__item>
                                            <div class="e-list__item e-list__item--big">
                                                <a href="#">{{ $sub->title }}</a>
                                                <span class=e-collapse-toggler data-toggle=collapse href=#collapseExample{{ $sub->id }} role=button aria-expanded=false aria-controls=collapseExample{{ $sub->id }}>&plus;</span>
                                            </div>
                                            <div class=collapse id=collapseExample{{ $sub->id }}>
                                                <ul class=mobile-nav>
                                                    @foreach($sub->children as $sub2)
                                                        <li class=mobile-nav-list__item>
                                                            <div class="e-list__item e-list__item--big">
                                                                <a href="{{ url($sub2->link . $sub2->sufix) }}">{{ $sub2->title }}</a>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>
                                    @else
                                        <li class=mobile-nav-list__item>
                                            <div class="e-list__item e-list__item--big">
                                                <a href="{{ url($sub->link) }}">{{ $sub->title }}</a>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @else
                    <li class=mobile-nav-list__item>
                        <div class="e-list__item e-list__item--big">
                            <a href="{{ url($menu->link) }}">{{ $menu->title }}</a>
                        </div>
                    </li>
                @endif

            @endforeach
        </ul>
        @endif
    </aside>
</div>