<footer>
    <div class="container footer">
        <div class="footer-first">
            {{--@include('svg.marianne')--}}
            {{--<p class="brand">DREAL Nouvelle-Aquitaine</p>--}}
            {{--<img src="{{ asset('images/logo_ministere.jpg') }}" alt="Ministère de la Transition Écologique et Solidaire" class="logo-image">--}}
            <img src="{{ asset('images/logo_prefete.jpg') }}" alt="Préfete de la région Nouvelle-Aquitaine" class="logo-image">
        </div>
        <div class="footer-middle">
            <h2 class="title">Plan du site</h2>

            <nav class="sitemap" role="navigation">
                <ul class="sitemap-menu">
                    <li>
                        Qui sommes-nous ?
                        <ul class="submenu">
                            <li><a href="{{ route('front.about-us.project') }}">Le projet</a></li>
                            <li><a href="{{ route('front.about-us.database') }}">La base de données</a></li>
                            <li><a href="{{ route('front.about-us.team') }}">L'équipe</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('front.dispositifs') }}">Aides ouvertes</a></li>
                    <li><a href="{{ route('front.dispositifs', ['closed' => 'clotures']) }}">Aides clôturées</a></li>
                    <li><a href="{{ route('front.news.before') }}">Actualités des semaines précédentes</a></li>
                    <li>
                        Outils
                        <ul class="submenu">
                            <li><a href="{{ route('front.tools.data') }}">Mise à disposition des données</a></li>
                            <li><a href="{{ route('front.tools.website-library') }}">Sitothèque</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('front.accessibility') }}">Accessibilité</a></li>
                    <li><a href="{{ route('front.contact') }}">Contact - Signaler un problème</a></li>
                    <li><a href="{{ route('front.legal-notice') }}">Mentions légales</a></li>
                    <li><a rel="nofollow noopener" href="http://data.gouv.fr" target="_blank" title="data.gouv.fr - Ouvrir dans une nouvelle fenêtre">data.gouv.fr</a></li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="reseaux">
        <div class="container">
            <ul>
                <li>
                    <a rel="nofollow noopener" href="http://www.legifrance.gouv.fr/" target="_blank" title="legifrance.gouv.fr - Ouvrir dans une nouvelle fenêtre">legifrance.gouv.fr</a>
                </li>
                <li>
                    <a rel="nofollow noopener" href="http://www.service-public.fr/" target="_blank"
                       title="service-public.fr - Ouvrir dans une nouvelle fenêtre">service-public.fr</a>
                </li>
                <li>
                    <a rel="nofollow noopener" href="http://www.gouvernement.fr" target="_blank" title="gouvernement.fr - Ouvrir dans une nouvelle fenêtre">gouvernement.fr</a>
                </li>
                <li>
                    <a rel="nofollow noopener" href="http://www.france.fr" target="_blank" title="france.fr - Ouvrir dans une nouvelle fenêtre">france.fr</a>
                </li>
            </ul>
        </div>
    </div>
</footer>