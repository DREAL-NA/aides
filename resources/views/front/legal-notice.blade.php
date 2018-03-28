@extends('layouts.app')

@section('breadcrumb')
    <li>
        <span>Mentions légales</span>
    </li>
@endsection

@section('content')
    <div class="page-content page-simple">
        <div class="content">
            <h2>Infos éditeurs et mentions légales (site pilote « Des dispositifs pour les territoires »)</h2>
            <p><i>publié le 28 mars 2018</i></p>

            <br>

            <h4>Service gestionnaire</h4>
            <p>Direction régionale de l’Environnement, de l’Aménagement et du Logement Nouvelle-Aquitaine (DREAL Nouvelle-Aquitaine)<br>
                Mission Développement Durable (MDD)<br>
                Pôle Innovation, Économie Durable <br>
                Immeuble Pastel - CS 53218 - 22, rue des Pénitents Blancs - 87032 Limoges cedex 1</p>

            <br>
            <h4>Directeur de la publication</h4>
            <h5>Sylvie FRUGIER - Chargée de mission Développement économique.</h5>
            <p>Chargée de mission Développement économique. :</p>
            <p>E-mail : <a href="mailto:{{ config('app.contact_mail') }}">{{ config('app.contact_mail') }}</a></p>
            <p>Tél. : <b>05 55 12 95 76</b> et <b>06 99 03 39 58</b></p>

            {{--Centre hébergeur--}}

            {{--SPIP--}}
            {{--Site réalisé sous SPIP, un programme Open Source sous licence GNU/GPL.--}}

            <br>
            <h4>Propriété intellectuelle</h4>
            <p>Les contenus présentés sur ce site sont soumis à la législation relative au droit des informations publiques et sont couverts par le droit d’auteur. Toute
                réutilisation des photographies, des créations graphiques, des illustrations et des lexiques, ainsi que de l’ensemble des contenus éditoriaux produits pour
                l’animation éditoriale du site est conditionnée à l’accord de l’auteur.</p>
            <p>Conformément au droit public de la propriété intellectuelle et notamment selon l’article L122-5 du Code de la propriété intellectuelle, les "documents officiels"
                sont librement réutilisables.</p>
            <p>La réutilisation non commerciale, et notamment pédagogique, est autorisée à la condition de respecter l’intégrité des informations et de n’en altérer ni le sens, ni
                la portée, ni l’application et d’en préciser l’origine et de sa date de publication.</p>
            <p>Les informations ne peuvent être utilisées à des fins commerciales ou promotionnelles sans l’autorisation expresse et l’obtention d’une licence de réutilisation des
                informations publiques. Est considérée comme réutilisation à des fins commerciales ou promotionnelles, l’élaboration à partir des informations publiques, d’un
                produit ou d’un service destiné à être mis à disposition de tiers, à titre gratuit ou onéreux.</p>
            <p>L’utilisation des marques déposées utilisées sur ce site sur tout autre support ou réseau est interdite.</p>

            <br>
            <h4>Liens hypertextes</h4>
            <p>Tout site public ou privé est autorisé à établir, sans autorisation préalable, un lien vers les informations diffusées par le Ministère de la Transition écologique
                et solidaire. En revanche les pages du site ne doivent pas être imbriquées à l’intérieur des pages d’un autre site.</p>
            <p>L’autorisation de mise en place d’un lien est valable pour tout support, à l’exception de ceux diffusant des informations à caractère polémique, pornographique,
                xénophobe ou pouvant, dans une plus large mesure porter atteinte à la sensibilité du plus grand nombre.</p>
            <p>La présence de liens hypertexte vers d’autres sites web n’engage pas le ministère quant au contenu de ces sites.</p>
            <p>Aucune page ne peut être présentée comme provenant de ce site si des transformations en modifiant le sens y ont été apportées.</p>

            <br>
            <h4>Responsabilité</h4>
            <p>Les informations proposées sur ce site le sont au titre de service rendu au public. Malgré tout le soin apporté à l’actualisation des textes officiels et à la
                vérification des contenus, les documents mis en ligne ne sauraient engager la responsabilité du Ministère de la Transition écologique et solidaire.</p>
            <p>Les informations et/ou documents disponibles sur ce site sont susceptibles d’être modifiés à tout moment, et peuvent faire l’objet de mises à jour.</p>
            <p>La DREAL Nouvelle-Aquitaine ne pourra en aucun cas être tenu responsable de tout dommage de quelque nature qu’il soit résultant de l’interprétation ou de
                l’utilisation des informations et/ou documents disponibles sur ce site.</p>

            <br>
            <h4>Données personnelles</h4>
            <p>Lorsque des données présentes sur ce site ont un caractère nominatif, les utilisateurs doivent en faire un usage conforme aux réglementations en vigueur et aux
                recommandations de la Commission nationale de l’informatique et des libertés (CNIL).</p>
            <h5>Déclaration CNIL :</h5>
            <p>Conformément à la loi Informatique et Liberté 78-17 du 6 janvier 1978 modifiée, vous disposez d’un droit d’opposition (art. 38), d’accès (art. 39), de rectification
                ou de suppression (art. 40) des données qui vous concernent. Vous pouvez exercer ce droit en vous adressant au ministère de la Justice et des Libertés.</p>
            <p>Ce droit s’exerce, en justifiant de son identité :</p>
            <ul>
                <li>
                    <p>par voie postale :</p>
                    <address>
                        Direction régionale de l’Environnement, de l’Aménagement et du Logement Nouvelle-Aquitaine (DREAL Nouvelle-Aquitaine) <br>
                        Mission Développement Durable (MDD) <br>
                        Pôle Innovation, Économie Durable <br>
                        Immeuble Pastel - CS 53218 - 22, rue des Pénitents Blancs - 87032 Limoges cedex 1 <br>
                    </address>
                </li>
                <li>par voie électronique : <a href="mailto:{{ config('app.contact_mail') }}">{{ config('app.contact_mail') }}</a></li>
            </ul>


            <p>Toutes les données personnelles qui sont recueillies sont traitées avec la plus stricte confidentialité. En particulier, la DREAL Nouvelle-Aquitaine s’engage à
                respecter la confidentialité des messages e-mails transmis au moyen d’une messagerie électronique.</p>

            <br>
            <h4>Accessibilité du site</h4>
            <p>Le site de la DREAL Nouvelle-Aquitaine utilise des outils Open Source, et a été conçu pour être pleinement accessible, en accord avec les principes d’accessibilité
                de contenu web.</p>

            <br>
            <h4>Disponibilité du site</h4>
            <p>L’éditeur s’efforce de permettre l’accès au site 24 heures sur 24, 7 jours sur 7, sauf en cas de force majeure ou d’un événement hors du contrôle du Ministère de la
                Transition écologique et solidaire, et sous réserve des éventuelles pannes et interventions de maintenance nécessaires au bon fonctionnement du site et des
                services.</p>
            <p>Par conséquent, la DREAL Nouvelle-Aquitaine ne peut garantir une disponibilité du site et/ou des services, une fiabilité des transmissions et des performances en
                terme de temps de réponse ou de qualité. Il n’est prévu aucune assistance technique vis-à-vis de l’utilisateur que ce soit par des moyens électroniques ou
                téléphoniques.</p>
            <p>La responsabilité de l’éditeur ne saurait être engagée en cas d’impossibilité d’accès à ce site et/ou d’utilisation des services.</p>
            <p>Le site de la DREAL Nouvelle-Aquitaine peut être amené à interrompre le site ou une partie des services, à tout moment sans préavis, le tout sans droit à
                indemnités.</p>
            <p>L’utilisateur reconnaît et accepte que la DREAL Nouvelle-Aquitaine ne soit pas responsable des interruptions, et des conséquences qui peuvent en découler pour
                l’utilisateur ou tout tiers.</p>

            <br>
            <h4>Droit applicable</h4>
            <p>Quel que soit le lieu d’utilisation, le présent site est régi par le droit français. En cas de contestation éventuelle, et après l’échec de toute tentative de
                recherche d’une solution amiable, les tribunaux français seront seuls compétents pour connaître de ce litige.</p>
            <p>Pour toute question relative aux présentes conditions d’utilisation du site, vous pouvez nous écrire à l’adresse suivante :</p>
            <p>Direction régionale de l’Environnement, de l’Aménagement et du Logement Nouvelle-Aquitaine (DREAL Nouvelle-Aquitaine)<br>
                Mission Développement Durable (MDD) <br>
                Pôle Innovation, Économie Durable <br>
                Immeuble Pastel - CS 53218 - 22, rue des Pénitents Blancs - 87032 Limoges cedex 1</p>

            <br>
            <h4>Acceptation des conditions d’utilisation</h4>
            <p>L’utilisateur reconnaît avoir pris connaissance des conditions d’utilisation, au moment de sa connexion vers le site de la DREAL Nouvelle-Aquitaine et déclare
                expressément les accepter sans réserve.</p>

            <br>
            <h4>Modifications des conditions générales d’utilisation</h4>
            <p>La DREAL Nouvelle-Aquitaine se réserve la possibilité de modifier, à tout moment et sans préavis, les présentes conditions d’utilisation afin de les adapter aux
                évolutions du site et/ou de son exploitation ».</p>

            <br>
        </div>
    </div>
@endsection