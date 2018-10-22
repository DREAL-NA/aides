@component('mail::message')
Bonjour,

La campagne correspondant aux actualités de la semaine {{ $week  }} a bien été envoyée.

Pour rappel, voici les titres des actualités de la semaine :

@foreach($news as $item)
Thématique : {{ $item->thematic->name }}<br>
{{ $item->name }}<br><br>
@endforeach

@endcomponent
