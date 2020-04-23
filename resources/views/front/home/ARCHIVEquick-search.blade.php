<div class="page-content page-home quick-search-container">
    <div class="content">
        <article class="content-home">
            <div class="page-header">
                <h2 class="text-center principal">Vous avez un projet de développement durable en Nouvelle-Aquitaine ? <br/><span class="count-dispositifs">{!! trans_choice('messages.home.count', $countCallsForProjects) !!}</span></h2>

                <p class="text-center sous-titre">Pour tous : associations, collectivités, entreprises, citoyens... </p>

            </div>

            <section class="quick-search">
                <form action="{{ route('front.dispositifs') }}" method="get">
                    <div class="search-container__form">
                        <input type="text" id="query" name="query" placeholder="Quels sont vos mot-clés? ">
                        <button class="button-search" type="submit"> Rechercher <span>{!! file_get_contents(public_path().'/svg/search.svg') !!}</span>
                        </button>
                    </div>
                </form>

            </section>
        </article>
    </div>
</div>
