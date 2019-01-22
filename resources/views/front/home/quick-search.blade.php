<div class="page-content page-home quick-search-container">
    <div class="content">
        <article class="content-home">
            <div class="page-header">
                <h2 class="h1 text-center">Trouver facilement les aides auxquelles vous avez droit</h2>
            </div>

            <section class="quick-search">
                <form action="{{ route('front.dispositifs') }}" method="get">
                    <div class="search-container__form">
                        <input type="text" id="query" name="query" placeholder="Recherche une aide">

                        <button type="submit">
                            {!! file_get_contents(public_path().'/svg/search.svg') !!}
                        </button>
                    </div>
                </form>

                <p>Des aides pour les associations, entreprises, collectivités et particuliers de Nouvelle-Aquitaine.</p>

                <div class="home-calls">
                    <a href="{{ route('front.dispositifs') }}">{!! trans_choice('messages.home.count_link', $countCallsForProjects) !!}</a>
                </div>
            </section>
        </article>
    </div>
</div>