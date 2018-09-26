<div class="item-wrapper">
    @php($url = empty($callForProjects->website_url) ? route('front.dispositifs.unique', [ 'slug' => $callForProjects->slug ]) : $callForProjects->website_url)
    <h5 class="title">
        <a href="{{ $url }}" {{ empty($callForProjects->website_url) ? '' : 'target="_blank"' }}>{{ $callForProjects->name }}</a>
    </h5>
    @if(!empty($callForProjects->closing_date))
        <div class="closing-date">Date de clôture&nbsp;: {{ $callForProjects->closing_date->format('d/m/Y') }}</div>
    @endif
    @if(!is_null($callForProjects->subthematic))
        <div class="perimeters">
            Sous-thématique&nbsp;: {{ $callForProjects->subthematic->name }}
        </div>
    @endif
    @if(!$callForProjects->perimeters->isEmpty())
        <div class="perimeters">
            Périmètres&nbsp;: {!! $callForProjects->perimeters->unique()->sortBy('name')->pluck('name')->implode(', ') !!}
        </div>
    @endif
    @if(!$callForProjects->projectHolders->isEmpty())
        <div class="perimeters">
            Porteurs du dispositif&nbsp;: {!! $callForProjects->projectHolders->unique()->sortBy('name')->pluck('name')->implode(', ') !!}
        </div>
    @endif
    <div class="objectives">{{ \Illuminate\Support\Str::words($callForProjects->objectives, 50) }}</div>
</div>