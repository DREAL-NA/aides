<?php
return [
    'home' => [
        'count' => "{0,1} <p class='count-dispositifs'>Accéder gratuitement et librement à <strong>:count</strong> aide</p>|[2,*] <p class='count-dispositifs'>Accéder gratuitement et librement aux <strong>:count</strong> aides</p>",
        'count_link' => "{0,1} Voir l'aide|[2,*] Voir les :count aides"
    ],
    'dispositifs' => [
        'count' => "{0,1} :count Aide|[2,*] :count Aides"
    ],
    'subscribers' => [
        'subscribed' => 'Abonné',
        'unsubscribed' => 'Désabonné',
        'actions' => [
            'subscribed' => 'Désabonner',
            'unsubscribed' => 'Abonner',
        ]
    ]
];