@component('mail::message')
Nouvelle inscription à la newsletter sur le site "{{ config('app.name') }}" !

Merci d'ajouter l'email suivant à la newsletter de la fiche personnalisée ADDNA sur la plateforme Aides territoire :

**E-mail :** {{ $email }} <br/>

{{ config('app.name') }}
@endcomponent
