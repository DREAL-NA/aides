<nav class="menu-nav">
    <div class="container">
        <div class="menu-nav-container">
            <ul class="menu-list">
                <li class="menu-item">
                <a class="{{ Route::is('front.home') ? 'current' : '' }}" href="{{ route('front.home') }}">Accueil</a>
                </li>

                <li class="menu-item">
                    <a class="{{ Route::is('front.aides.consulter','front.aides.about-us') ? 'current' : '' }}" href="#" menu-selector="aides">Les aides en Nouvelle-Aquitaine</a>
                </li>

                <li class="menu-item">
                    <a class="{{ Route::is('front.mecenat') ? 'current' : '' }}" href="#" title="Rubrique bientôt disponible" >Le mécénat en Nouvelle-Aquitaine (Bientôt disponible)</a>
                </li>

                <!--li class="menu-item" >
                    <a class="{{ Route::is('front.dispositifs') ? 'current' : '' }}" href="{{ route('front.dispositifs') }}">Les aides</a>
                </li-->

                <!--li class="menu-item" id="{{ Route::is('publish') ? 'active' : '' }}">
                    <a class="{{ Route::is('front.publish') ? 'current' : '' }}" href="{{ route('front.publish') }}">Publier une aide</a>
                </li-->

                <!--li class="menu-item">
                    <a class="{{ Route::is('front.about-us.project','front.about-us.database','front.about-us.team') ? 'current' : '' }}" href="#" menu-selector="who">Qui sommes-nous&nbsp;?</a>
                </li>

                <li class="menu-item">
                    <a class="{{ Route::is('front.tools.data','front.tools.website-library') ? 'current' : '' }}" href="#" menu-selector="tools">Outils</a>
                </li-->

            </ul>
        </div>
    </div>
    <div class="menu-children">
        <div class="container">
            <ul id="submenu-aides" class="menu-list-children">
                <li class="menu-item-children"><a href="{{ route('front.aides.consulter') }}">Consulter les aides</a></li>
                <li class="menu-item-children"><a href="{{ route('front.aides.about-us') }}">Qui sommes nous ?</a></li>
            </ul>
        </div>
    </div>
</nav>
