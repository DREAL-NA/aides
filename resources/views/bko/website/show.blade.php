@extends('layouts.bko')
@section('heading', "Site : ".$website->name)
@section('menu-item-website')
    <li class="menu-item active"><a href="{{ route('bko.site.show', $website) }}">Voir la fiche {{ $website->name }}</a>
    </li>
    <li class="menu-item"><a href="{{ route('bko.site.edit', $website) }}">Edition de {{ $website->name }}</a></li>
@endsection

@section('content')
    <div class="form-horizontal">
        {{--<div class="form-group">--}}
        {{--<label class="col-lg-3 control-label">Organisation</label>--}}
        {{--<div class="col-lg-9">--}}
        {{--<p class="form-control-static">{{ $website->organizationType->name }}</p>--}}
        {{--</div>--}}
        {{--</div>--}}
        <div class="form-group">
            <label class="col-lg-3 control-label">Nom de la structure*</label>
            <div class="col-lg-9">
                <p class="form-control-static">{{ $website->name }}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Thèmes</label>
            <div class="col-lg-9">
                <p class="form-control-static">{{ $website->themes }}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Localisations</label>
            <div class="col-lg-9">
                <p class="form-control-static">{!! $website->perimeters->implode('name', '<br>') !!}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Localisations - Précisions</label>
            <div class="col-lg-9">
                <p class="form-control-static">{{ $website->perimeter_comments }}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Délai</label>
            <div class="col-lg-9">
                <p class="form-control-static">{{ $website->delay }}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Budget alloué</label>
            <div class="col-lg-9">
                <p class="form-control-static">{{ $website->allocated_budget }}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Bénéficiaires</label>
            <div class="col-lg-9">
                <p class="form-control-static">{{ $website->beneficiaries }}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Adresse internet</label>
            <div class="col-lg-9">
                <p class="form-control-static">{{ $website->website_url }}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Observations</label>
            <div class="col-lg-9">
                <p class="form-control-static">{{ $website->description }}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Logo</label>
            <div class="col-lg-9">
                @if(!empty($website->getFirstMedia(\App\Website::MEDIA_COLLECTION)))
                    <img src="{{ $website->getFirstMedia(\App\Website::MEDIA_COLLECTION)->getUrl() }}" alt="logo"
                         class="img-responsive" style="width: 150px; margin-bottom: 15px;">
                @endif
            </div>
        </div>
    </div>
@endsection