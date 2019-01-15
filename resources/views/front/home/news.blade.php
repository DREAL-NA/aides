<div class="page-content page-home">
    <div class="content">
        <article class="content-home">
            <div class="page-header no-bottom">
                <h2>Inscrivez-vous à notre newsletter !</h2>
                <p>Recevez le vendredi les aides enregistrées au cours de la semaine.</p>
            </div>

            <section class="newsletter-container">
                <form action="{{ route('front.newsletter.subscribe') }}" method="post" class="form-contact" id="form-newsletter">
                    {{ csrf_field() }}

                    <input name="email" placeholder="Votre adresse e-mail*" type="email" tabindex="1" required value="{{ old('email') }}">
                    <input name="lastname" placeholder="Votre nom" type="text" tabindex="2" value="{{ old('lastname') }}">
                    <input name="firstname" placeholder="Votre prénom" type="text" tabindex="3" value="{{ old('firstname') }}">
                    <button name="submit" type="submit" id="newsletter-submit">S'inscrire</button>
                </form>
            </section>
        </article>

        <article class="content-home">
            <div class="page-header no-bottom with-actions">
                <h2>
                    <span>Actualités de la semaine</span>
                    <a href="{{ route('front.news.before') }}">Voir les actualités des semaines précédentes</a>
                </h2>
                <p>Retrouvez ici les aides enregistrées au cours de la semaine.</p>
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