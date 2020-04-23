<div class="page-content page-home">
    <div class="content">
        <article class="content-home">
            <div class="page-header no-bottom">
                <h2>2. Quelles sont les aides par thématique ?</h2>
                <p>Réalisez une recherche avancée en précisant vos besoins et votre localisation.</p>
            </div>

            <section class="filters-wrapper">
                <form action="{{ route('front.dispositifs') }}" method="get" class="form-home form-filters">
                    <div class="filters-step step-thematic">
                        <div class="title-container">
                            <h5 class="title">1.&nbsp;Préciser vos besoins</h5>
                            <button class="select-all" type="button">Tout sélectionner</button>
                        </div>
                        <ul class="filters-items">
                            @foreach($thematics as $thematic)
                                <li class="filter-item">
                                    <a href="#" class="selectThematic" data-id="{{ $thematic->id }}">{{ $thematic->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="filters-step step-perimeter">
                        <h5 class="title">2. Sélectionner votre localisation</h5>
                        <div class="step-perimeter-container">
                            <select name="{{ \App\Perimeter::URI_NAME }}[]" class="filters-select selectPerimeter" multiple>
                                <option disabled>Sélectionnez une localisation</option>
                                @foreach($perimeters as $perimeter)
                                    <option value="{{ $perimeter->id }}">{{ $perimeter->name }}</option>
                                @endforeach
                            </select>
                            <div class="buttons">
                                <button class="select-all" type="button">Tous</button>
                                <button class="select-none" type="button">Aucun</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="submit-button submit-filters">Rechercher</button>
                </form>
            </section>
        </article>
    </div>
</div>