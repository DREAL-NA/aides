<nav class="menu-nav">
    <div class="container">
        <div class="menu-nav-container">
            <ul class="menu-list">
                <li class="menu-item">
                <a class="{{ Route::is('front.home') ? 'current' : '' }}" href="{{ route('front.home') }}">Accueil</a>
                </li>

                <li class="menu-item" >
                    <a class="{{ Route::is('front.dispositifs') ? 'current' : '' }}" href="{{ route('front.dispositifs') }}">Les aides</a>
                </li>

                <li class="menu-item" id="{{ Route::is('publish') ? 'active' : '' }}">
                    <a class="{{ Route::is('front.publish') ? 'current' : '' }}" href="{{ route('front.publish') }}">Publier une aide</a>
                </li>

                <li class="menu-item">
                    <a class="{{ Route::is('front.about-us.project','front.about-us.database','front.about-us.team') ? 'current' : '' }}" href="#" menu-selector="who">Qui sommes-nous&nbsp;?</a>
                </li>

                <li class="menu-item">
                    <a class="{{ Route::is('front.tools.data','front.tools.website-library') ? 'current' : '' }}" href="#" menu-selector="tools">Outils</a>
                </li>

            </ul>
        </div>
    </div>
    <div class="menu-children">
        <div class="container">
            <ul id="submenu-who" class="menu-list-children">
                <li class="menu-item-children"><a href="{{ route('front.about-us.project') }}">Le projet</a></li>
                <li class="menu-item-children"><a href="{{ route('front.about-us.database') }}">La base de données</a></li>
                <li class="menu-item-children"><a href="{{ route('front.about-us.team') }}">L'équipe</a></li>
            </ul>
            <ul id="submenu-tools" class="menu-list-children">
                <li class="menu-item-children"><a href="{{ route('front.tools.data') }}">Mise à disposition des données</a></li>
                <li class="menu-item-children"><a href="{{ route('front.tools.website-library') }}">Sitothèque</a></li>
            </ul>
        </div>
    </div>
</nav>