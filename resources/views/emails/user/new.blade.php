@component('mail::message')
Bienvenue sur l'administration du site "{{ config('app.name') }}" !

Voici vos identifiants pour vous connecter à la plateforme :

**E-mail :** {{ $notifiable->email }}<br>
**Mot de passe :** {{ $password }}

@component('mail::button', ['url' => 'http://'.config('app.bko_subdomain') . '.' . config('app.domain')])
    Se connecter
@endcomponent

{{ config('app.name') }}
@endcomponent
