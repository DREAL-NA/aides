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
    <div class="page-content page-simple">
        <h2>Mise à disposition des données</h2>
        <div class="content">
            <div class="page-item">
                <div class="page-header">
                    <h3>Jeu de données</h3>
                </div>
                <div class="item-content">
                    <p class="text-center">
                        <a class="btn btn-primary btn-lg" href="{{ route('export.csv', ['table' => 'dispositifs', 'columns' => 'key', 'withDates' => true, 'sep' => 'pipe']) }}"
                           target="_blank">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                            Télécharger au format CSV
                        </a>
                        <img src="https://www.etalab.gouv.fr/wp-content/uploads/2011/10/licence-ouverte-open-licence.gif" width="125" alt="Licence ouverte"/>
                    </p>
                    <p>
                        Ce jeu de données est mise à disposition sous une <a href="https://www.etalab.gouv.fr/wp-content/uploads/2017/04/ETALAB-Licence-Ouverte-v2.0.pdf">Licence
                            Ouverte 2.0</a> : vous êtes libre de réutiliser les informations qu’elle contient comme bon vous semble, dans la mesure où vous indiquez qu’elles
                        proviennent de la DREAL Nouvelle-Aquitaine et la date à laquelle vous y avez accédé pour la dernière fois.
                    </p>

                    <table class="table table-striped">
                        <caption>Format du jeu de données</caption>
                        <thead>
                        <tr>
                            <th>Nom de colonne</th>
                            <th>Valeur représentée</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach((new App\Exports\DispositifsExport(['withDates' => true]))->columnsWithDescription() as $column => $description)
                            <tr>
                                <td><samp>{{ $column }}</samp></td>
                                <td>{{ $description }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="page-item">
                <div class="page-header">
                    <h3>Flux RSS mis à disposition</h3>
                </div>
                <div class="item-content">
                    <p>Ces flux permettent d'obtenir les derniers ajouts d'aides.</p>
                    <ul>
                        @php($feeds = config('feed.feeds'))

                        @foreach(collect($feeds)->sortBy('title') as $feed)
                            <li><a href="{{ $feed['url'] }}" target="_blank">{{ $feed['title'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
