<div class="page-content page-home">
    <div class="content">
        <article class="content-home" id="rectangle_newsletter">
            <p id="newsletter">Restez informés des nouvelles aides en vous inscrivant à la newsletter.</p>
            {{--l'id sert pour le css et également d'ancre pour rediriger l'utilisateur vers l'inscription à la newsletter--}}
            <section class="newsletter-container">
                <form action="{{ route('front.newsletter.subscribe') }}" method="post" class="form-contact" id="form-newsletter">
                    {{ csrf_field() }}
                    <p id="newsletter-champ-title">Quelle est votre adresse e-mail ?</p>
                    <input name="email" placeholder="@ Entrez votre adresse e-mail" type="email" tabindex="1" required value="{{ old('email') }}">
                   {{-- <input name="lastname" placeholder="Votre nom" type="text" tabindex="2" value="{{ old('lastname') }}">
                    <input name="firstname" placeholder="Votre prénom" type="text" tabindex="3" value="{{ old('firstname') }}">--}}
                    <button class="inscr-newsletter" name="submit" type="submit" id="newsletter-submit">S'inscrire à la newsletter</button>
                </form>
            </section>
        </article>


        <article class="content-home">
            <div class="page-header no-bottom with-actions">
                <p id="aides-semaine" >
                    Accédez directement aux aides enregistrées cette semaine
                </p>
            </div>

            <a href="https://aides-territoires.beta.gouv.fr/aides/?integration=&apply_before=&perimeter=70971&text=&order_by=publication_date&action=search" target="_blank" class="nostyle" >
                <div class="block-container" title="Vous allez être redirigé sur la plateforme aide territoire">
                    Voir les dernières aides <span class="fa fa-external-link"></span>
                </div>
            </a>
            <br/>


        </article>
    </div>
</div>
