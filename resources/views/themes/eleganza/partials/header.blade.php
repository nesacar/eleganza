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
                @php $submenu = \App\Menu::find(3)->menuLinks()->where('publish', 1)->where('parent', $menu->cat_id)->orderBy('order', 'ASC')->get(); @endphp
                <a href="{{ url($menu->link) }}" class="nav-list__item__link @if(count($submenu)>0) with-arrow @endif"> @if($menu->title == 'Kitchen') <i class="far fa-heart"></i> @endif {{ $menu->title }} </a>
                @if(count($submenu)>0)
                    <div class=nav-list__item__submenu>
                        <div class="container submenu">
                            @foreach($submenu as $sub)
                            <div class=submenu__col>
                                <div class=submenu__title>{{ $sub->title }}</div>
                                @php $submenu2 = \App\Menu::find(3)->menuLinks()->where('publish', 1)->where('parent', $sub->cat_id)->orderBy('order', 'ASC')->get(); @endphp
                                @if(count($submenu2)>0)
                                    <ul class=submenu__list>
                                        @foreach($submenu2 as $sub2)
                                            <li class=submenu__list__item> <a href="{{ url($sub2->link . $sub2->sufix ) }}">{{ \App\MenuLink::cropTitle($sub2->title, '(') }}</a> </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                            @endforeach
                            <div class=submenu__col>
                                <div class="e-image e-image--custom">
                                    {!! HTML::Image('themes/'.$theme->slug.'/img/nakit.jpg', '') !!}
                                </div>
                            </div>
                            <div class=submenu__col>
                                <div class="e-image e-image--custom">
                                    {!! HTML::Image('themes/'.$theme->slug.'/img/satovi.jpg', '') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </li>
        @endforeach
    </ul>
    @endif
</header>