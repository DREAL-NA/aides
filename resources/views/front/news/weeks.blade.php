<div class="news-per-week">
    <div class="page-header no-bottom">
        <h3>Actualités du {{ $startDate->format('d/m/Y') }} au {{ $endDate->format('d/m/Y') }}</h3>
    </div>

    <section class="dispositif-items">
        <div class="dispositifs-items-header slim">
            <div class="first thematic hidden-xs">Thématique</div>
            <div class="middle full infos no-border-right hidden-xs">Informations</div>
        </div>

        @each('front.news.thematic', $callsOfTheWeek, 'callsForProjects_thematic', 'front.news.empty')

        @if(!empty($countPreviousWeeks))
            <div class="newsWeeks__loadMoreResultsContainer">
                <a href="#"
                   data-href="{{ route('front.news.before', ['start' => $beforeStartDate->format('Y-m-d'), 'end' => $beforeEndDate->format('Y-m-d')]) }}"
                   class="newsWeeks__loadMoreResults"
                >Charger plus de résultats</a>

                <div class="newsWeeks__loading" style="display: none;">
                    <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                    <span class="sr-only">Chargement...</span>
                </div>
            </div>
        @endif
    </section>
</div>