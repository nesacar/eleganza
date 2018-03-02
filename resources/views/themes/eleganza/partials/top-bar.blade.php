<div class=top-bar>
    <div class="container top-bar__wrapper" style=position:relative>
        <div class=e-search id=jsSearch>
            <button class="icon-btn icon-btn--primary" data-e-controls=#jsSearch> <i class="fas fa-times"></i> </button>
            <form action=GET>
                <input placeholder=Pretraživanje type=text name=search id=search>
                <button class="icon-btn icon-btn--primary" type=submit> <i class="fas fa-search"></i> </button>
            </form>
        </div>
        <div class=top-bar__box>
            @if(false)
            <div class=top-bar__link data-e-select>
                <div class=e-select__icon></div>
                <div class=e-select>
                    <select>
                        <option value=cro>hrvatski</option>
                        <option value=uk>english</option>
                    </select>
                </div>
            </div>
            <div class=top-bar__link>
                <div class=e-select>
                    <select>
                        <option value=eur>eur</option>
                        <option value=kn>hrk</option>
                    </select>
                </div>
            </div>
            @endif
            <a class=top-bar__link href="{{ url('lista-zelja') }}">
                <span>lista želja</span> <i class="fas fa-heart"></i> </a>
        </div>
        <div class=top-bar__box>
            @if(auth()->check())
                <a class=top-bar__link href="{{ url('profil') }}"> <span>profil</span> <i class="fas fa-user-circle"></i> </a>
                <a class=top-bar__link href="{{ url('kosarica') }}"> <span>košarica</span> <i class="fas fa-shopping-cart"></i> </a>
            @else
                <a class=top-bar__link href="{{ url('logovanje') }}"> <span>prijavi se</span> <i class="fas fa-user-circle"></i> </a>
            @endif
            <div class=top-bar__link data-e-controls=#jsSearch>
                <span>pretraži</span> <i class="fas fa-search"></i>
            </div>
        </div>
    </div>
</div>