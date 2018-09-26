<div class="page-content page-home">
    <div class="content">
        <article class="content-home">
            <div class="page-header">
                <h2>Quelles sont les aides pour mon territoire ?</h2>
                <p>Effectuez une recherche rapide et découvrez quelles sont les aides pour votre territoire.</p>
            </div>

            <section class="quick-search">
                <form action="{{ route('front.dispositifs') }}" method="get" class="form-home form-filters">
                    <select name="{{ \App\Perimeter::URI_NAME }}_ext" class="filters-select selectChildrenPerimeter">
                        <option>Sélectionnez une localisation</option>
                        @foreach($perimeters as $perimeter)
                            <option value="{{ $perimeter->id }}">{{ $perimeter->name }}</option>
                        @endforeach
                    </select>

                    <button type="button" class="submit-button">Rechercher</button>
                </form>
            </section>
        </article>
    </div>
</div>