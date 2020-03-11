<div class="page-content page-home">
    <div class="content">
        <article class="content-home">
            <div class="page-header no-bottom">
                <p class="home-description">Nous recensons les aides pour la protection de l'environnement, l'aménagement des villes et des campagnes, le développement économique local,... </p>
                <p class="home-news" id="newsletter"><strong>Pour connaître les nouvelles aides</strong>, recevez notre newsletter hebdomadaire : </p>
            </div>
            <section class="newsletter-container">
                <form action="{{ route('front.newsletter.subscribe') }}" method="post" class="form-contact" id="form-newsletter">
                    {{ csrf_field() }}

                    <input name="email" placeholder="Votre adresse e-mail*" type="email" tabindex="1" required value="{{ old('email') }}">
                   {{-- <input name="lastname" placeholder="Votre nom" type="text" tabindex="2" value="{{ old('lastname') }}">
                    <input name="firstname" placeholder="Votre prénom" type="text" tabindex="3" value="{{ old('firstname') }}">--}}
                    <button class="inscr-newsletter" name="submit" type="submit" id="newsletter-submit">Recevoir la newsletter</button>
                </form>
            </section>
        </article>

        <article class="content-home">
            <div class="page-header no-bottom with-actions">
                <h2>
                    <span>Aides recensées cette semaine</span>
                    <a href="{{ route('front.news.before') }}">Voir les semaines précédentes</a>
                </h2>
            </div>

            <section class="dispositif-items">
                <div class="dispositifs-items-header slim">
                    <div class="first thematic hidden-xs">Thématique</div>
                    <div class="middle full infos no-border-right hidden-xs">Informations</div>
                </div>

                @each('front.news.thematic', $callsOfTheWeek, 'callsForProjects_thematic', 'front.news.empty')
            </section>
        </article>
    </div>
</div>