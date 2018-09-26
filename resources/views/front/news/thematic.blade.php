<article class="dispositif-item news-item">
    <div class="first thematic"><span class="visible-xs">Thématique : </span>{{ $callsForProjects_thematic->first()->thematic->name }}</div>
    <div class="middle full infos no-border-right">
        @each('front.news.item', $callsForProjects_thematic, 'callForProjects')
    </div>
</article>