<?php
return [
    /*
     * Number of items to retrieve per feed
     */
    'itemsPerFeed' => 20,

    'author' => "DREAL Nouvelle-Aquitaine",

    'feeds' => [
        'main' => [
            /*
             * Here you can specify which class and method will return
             * the items that should appear in the feed. For example:
             * 'App\Model@getAllFeedItems'
             *
             * You can also pass an argument to that method:
             * ['App\Model@getAllFeedItems', 'argument']
             */
            'items' => 'App\CallForProjects@getFeedItems',

            /*
             * The feed will be available on this url.
             */
            'url' => '/feed',

            'title' => 'Les 20 derniers dispositifs',
        ],
//        'thematics' => [
//            /*
//             * Here you can specify which class and method will return
//             * the items that should appear in the feed. For example:
//             * 'App\Model@getAllFeedItems'
//             *
//             * You can also pass an argument to that method:
//             * ['App\Model@getAllFeedItems', 'argument']
//             */
//            'items' => 'App\CallForProjects@getFeedItemsByThematic',
//
//            /*
//             * The feed will be available on this url.
//             */
//            'url' => '/feed/thematics',
//
//            'title' => 'My feed by thematics',
//        ],
    ],

];
