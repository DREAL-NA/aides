<div class="page-content page-home quick-search-container">
    <div class="content">
        <article class="content-home">
            <div class="page-header">
                <h2 class="h1 text-center">Trouver facilement des aides pour vos projets développement durable</h2>
            </div>

            <section class="quick-search">
                <form action="{{ route('front.dispositifs') }}" method="get">
                    <div class="search-container__form">
                        <input type="text" id="query" name="query" placeholder="Rechercher une aide">

                        <button type="submit">
                            {!! file_get_contents(public_path().'/svg/search.svg') !!}
                        </button>
                    </div>
                </form>

                <p>Des aides pour les collectivités, associations, entreprises, particuliers, ... de Nouvelle-Aquitaine.</p>
            </section>
        </article>
    </div>
</div>