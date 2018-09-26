<?php

return [

    /*
     * The API key of a MailChimp account. You can find yours at
     * https://us10.admin.mailchimp.com/account/api-key-popup/.
     */
    'apiKey' => env('MAILCHIMP_APIKEY'),

    /*
     * The listName to use when no listName has been specified in a method.
     */
    'defaultListName' => 'subscribers',

    /*
     * Here you can define properties of the lists.
     */
    'lists' => [

        /*
         * This key is used to identify this list. It can be used
         * as the listName parameter provided in the various methods.
         *
         * You can set it to any string you want and you can add
         * as many lists as you want.
         */
        'subscribers' => [

            /*
             * A MailChimp list id. Check the MailChimp docs if you don't know
             * how to get this value:
             * http://kb.mailchimp.com/lists/managing-subscribers/find-your-list-id.
             */
            'id' => env('MAILCHIMP_LIST_ID', '5a619335d9'),
        ],
    ],

    /*
     * If you're having trouble with https connections, set this to false.
     */
    'ssl' => env('MAILCHIMP_SSL', true),


    /*
     * The from name and email used when sending campaigns
     */
    'from' => [
        'name' => env('NEWSLETTER_FROM_NAME', 'Sylvie Frugier'),
        'email' => env('NEWSLETTER_FROM_EMAIL', 'Sylvie.Frugier@developpement-durable.gouv.fr'),
    ],
];
