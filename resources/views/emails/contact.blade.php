@component('mail::message')
Vous avez reçu un message depuis le site internet créé le {{ $contact->updated_at->format('d/m/Y') }} à {{ $contact->updated_at->format('H:i') }} :

**Nom:** {{ $contact->name }}

**E-mail:** {{ $contact->email }}

**Sujet:** {{ $contact->subject }}

**Message:**
<p>{{ $contact->message }}</p>
@endcomponent
