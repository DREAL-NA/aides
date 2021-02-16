<nav class="menu-nav">
    <div class="container">
        <div class="menu-nav-container">
            <ul class="menu-list">
                <li class="menu-item">
                <a class="{{ Route::is('front.home') ? 'current' : '' }}" href="{{ route('front.home') }}">Accueil</a>
                </li>

                <li class="menu-item">
                    <a class="{{ Route::is('front.aides.about-us') ? 'current' : '' }}" href="#" menu-selector="aides">Les aides en Nouvelle-Aquitaine</a>
                </li>

                <li class="menu-item">
                    <a class="{{ Route::is('front.mecenat') ? 'current' : '' }}" href="#" menu-selector="#" >Le mécénat en Nouvelle-Aquitaine (Bientôt disponible)</a>
                </li>

            </ul>
        </div>
    </div>
    <div class="menu-children">
        <div class="container">
            <ul id="submenu-aides" class="menu-list-children">
                <li class="menu-item-children"><a href="https://addna.aides-territoires.beta.gouv.fr/" target="_blank">Consulter les aides</a></li>
                <li class="menu-item-children"><a href="{{ route('front.aides.about-us') }}">Qui sommes nous ?</a></li>
            </ul>
            <ul id="submenu-mecenat" class="menu-list-children">


            </ul>
        </div>
    </div>
</nav>
