@extends('layouts.app')

@section('meta_title', "Mise à disposition des données")

@section('breadcrumb')
    <li>
        <span>Outils</span>
        <span class="chevron">></span>
    </li>
    <li>
        <span>Mise à disposition des données</span>
    </li>
@endsection

@section('content')
    <div class="page-content">
        <h2>Mise à disposition des données</h2>
        <div class="content">

            <div class="feeds">
                <h3>Liste des flux mis à disposition</h3>

                <ul>
                    @php($feeds = config('feed.feeds'))

                    @foreach(collect($feeds)->sortBy('title') as $feed)
                        <li><a href="{{ $feed['url'] }}" target="_blank">{{ $feed['title'] }}</a></li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
@endsection