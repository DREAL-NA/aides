@extends('layouts.bko')

@section('heading', 'Tableau de bord')

@section('content')
    <div class="home-statistics">

        <div class="home-statistics__item">
            <h4 class="title">Aides ajoutées ou modifiées</h4>

            <div class="cards-container">
                @component('bko.components.cards.number')
                    @slot('title', "7 derniers jours")
                    @slot('number', $countLastCallsForProjects__7days)
                @endcomponent
                @component('bko.components.cards.number')
                    @slot('title', "30 derniers jours")
                    @slot('number', $countLastCallsForProjects__1month)
                @endcomponent
                @component('bko.components.cards.number')
                    @slot('title', "6 derniers mois")
                    @slot('number', $countLastCallsForProjects__6months)
                @endcomponent
            </div>
        </div>

        <div class="home-statistics__item">
            <h4 class="title">Statistiques générales</h4>

            <div class="cards-container">
                @component('bko.components.cards.number')
                    @slot('title', "Sites")
                    @slot('number', $countWebsites)
                @endcomponent
                @component('bko.components.cards.number')
                    @slot('title', "Bénéficiaires")
                    @slot('number', $countBeneficiaries)
                @endcomponent
                @component('bko.components.cards.number')
                    @slot('title', "Localisations")
                    @slot('number', $countPerimeters)
                @endcomponent
                @component('bko.components.cards.number')
                    @slot('title', "Thématiques")
                    @slot('number', $countThematics)
                @endcomponent
                @component('bko.components.cards.number')
                    @slot('title', "Sous-thématiques")
                    @slot('number', $countSubthematics)
                @endcomponent
                @component('bko.components.cards.number')
                    @slot('title', "Financeurs des aides")
                    @slot('number', $countProjectHolders)
                @endcomponent
            </div>
        </div>

        <div class="home-statistics__item">
            <h4 class="title">Newsletter</h4>

            <div class="cards-container">
                @component('bko.components.cards.number')
                    @slot('title', "Abonnés")
                    @slot('number', $countNewsletterSubscribers__subscribed)
                @endcomponent
                @component('bko.components.cards.number')
                    @slot('title', "Désabonnés")
                    @slot('number', $countNewsletterSubscribers__unsubscribed)
                @endcomponent
            </div>
        </div>

    </div>
@endsection
