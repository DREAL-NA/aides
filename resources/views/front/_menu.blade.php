<nav class="menu-nav">
    <div class="container">
        <div class="menu-nav-container">
            <ul class="menu-list">
                <li class="menu-item">
                    <a href="#" menu-selector="who">Qui sommes-nous&nbsp;?</a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('front.dispositifs') }}">Dispositifs</a>
                </li>
                <li class="menu-item">
                    <a href="#" menu-selector="tools">Outils</a>
                </li>
            </ul>

            <div class="search-wrapper">
                <form action="{{ route('front.search') }}" method="get">
                    <div class="search-container__form">
                        <input type="text" id="query" name="query" placeholder="Rechercher sur le site">

                        <button type="submit">
                            {!! file_get_contents(public_path().'/svg/search.svg') !!}
                        </button>
                    </div>
                </form>
            </div>
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