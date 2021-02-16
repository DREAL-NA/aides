<footer>
    <div class="container footer">
        <div class="footer-first">
            {{--@include('svg.marianne')--}}
            {{--<p class="brand">DREAL Nouvelle-Aquitaine</p>--}}
            {{--<img src="{{ asset('images/logo_ministere.jpg') }}" alt="Ministère de la Transition Écologique et Solidaire" class="logo-image">--}}
            <img src="{{ asset('images/logo_prefete.jpg') }}" alt="Préfete de la région Nouvelle-Aquitaine" >
        </div>
        <div class="footer-middle">
            <h2 class="title">Plan du site</h2>

            <nav class="sitemap" role="navigation">
                <ul class="sitemap-menu">
                    <li>
                        Les aides en Nouvelle-Aquitaine
                        <ul class="submenu">
                            <li><a href="https://addna.aides-territoires.beta.gouv.fr/" target="_blank">Consulter les aides</a></li>
                            <li><a href="{{ route('front.aides.about-us') }}">Qui sommes-nous ?</a></li>
                        </ul>
                    </li>
                    <li>
                        Le mécénat en Nouvelle-Aquitaine
                        <ul class="submenu">
                            <li><i> - Contenu bientôt disponible - </i></li>
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
