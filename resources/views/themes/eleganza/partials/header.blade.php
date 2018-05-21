<header class=header id=jsHeader>
    <div class=menu-toggler id=jsMenuToggler data-e-controls=#jsMobileMenu>
        <div class=nav-icon>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <h1 class=logo>
        <a href={{ url('/') }}>eleganza</a>
    </h1>
    @if(!empty($menus))
    <ul class=nav-list>
        @foreach($menus as $menu)
            <li class=nav-list__item>

                <a href="{{ url($menu->link) }}" class="nav-list__item__link @if(count($menu->children)>0) with-arrow @endif"> @if($menu->title == 'Kitchen') <i class="far fa-heart"></i> @endif {{ $menu->title }} </a>
                @if(count($menu->children)>0)
                    <div class=nav-list__item__submenu>
                        <div class="container submenu">
                            @foreach($menu->children as $sub)
                                @if($sub->image)
                                    <div class=submenu__col>
                                        <div class="e-image e-image--custom">
                                            <a href="{{ url($sub->link) }}">{!! HTML::Image($sub->image, $sub->title) !!}</a>
                                        </div>
                                    </div>
                                @else
                                <div class=submenu__col>
                                    <div class=submenu__title>{{ $sub->title }}</div>

                                    @if(count($sub->children)>0)
                                        <ul class=submenu__list>
                                            @foreach($sub->children as $sub2)
                                                <li class=submenu__list__item> <a href="{{ url($sub2->link . $sub2->sufix ) }}">{{ \App\MenuLink::cropTitle($sub2->title, '(') }}</a> </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </li>
        @endforeach
    </ul>
    @endif
</header>