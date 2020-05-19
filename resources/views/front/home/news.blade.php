<div class="page-content page-home">
    <div class="content">
        <article class="content-home" id="rectangle_newsletter">
            <p id="newsletter"><b>Restez informés des nouvelles aides</b> chaque semaine :</p>
            {{--l'id sert pour le css et également d'ancre pour rediriger l'utilisateur vers l'inscription à la newsletter--}}
            <section class="newsletter-container">
                <form action="{{ route('front.newsletter.subscribe') }}" method="post" class="form-contact" id="form-newsletter">
                    {{ csrf_field() }}
                    <p id="newsletter-champ-title">Quelle est votre adresse e-mail ?</p>
                    <input name="email" placeholder="@ Entrez votre adresse e-mail" type="email" tabindex="1" required value="{{ old('email') }}">
                   {{-- <input name="lastname" placeholder="Votre nom" type="text" tabindex="2" value="{{ old('lastname') }}">
                    <input name="firstname" placeholder="Votre prénom" type="text" tabindex="3" value="{{ old('firstname') }}">--}}
                    <button class="inscr-newsletter" name="submit" type="submit" id="newsletter-submit">Recevoir la newsletter</button>
                </form>
            </section>
        </article>


        <article class="content-home">
            <div class="page-header no-bottom with-actions">
                <h2>
                    <span>Aides enregistrées cette semaine</span>
                    <a href="{{ route('front.news.before') }}">Voir les aides des semaines précédentes</a>
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
