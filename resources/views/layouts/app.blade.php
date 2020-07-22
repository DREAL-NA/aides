<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
@if(app()->environment() !== 'local' && config('app.google_analytics.enable') === true)
    <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('app.google_analytics.id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());

            gtag('config', '{{ config('app.google_analytics.id') }}');
        </script>
    @endif

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="author" content="{{ config('meta.author') }}">
    <meta name="language" content="{{ app()->getLocale() }}">

    <meta property="og:title" content="{{ config('app.name') }}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{ config('app.url') }}"/>
    <meta property="og:image" content="/favicon-32x32.png"/>
    <meta property="og:description" content="{{ config('meta.description') }}"/>
    <meta property="og:locale" content="{{ config('meta.locale') }}"/>

    <meta content="{{ config('meta.description') }}" name="description">
    <meta content="{{ config('meta.keywords') }}" name="keywords">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#fa824c">
    <meta name="theme-color" content="#ffffff">

    <link rel="canonical" href="{{ config('app.url') }}"/>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ (app()->environment() == 'production' ? '' : 'DEV - ') }}@yield('meta_title'){{ ' | '.config('app.name') }}</title>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">


    @include('feed::links')
</head>
<body>
<noscript>Javascript est désactivé dans votre navigateur. Vous risquez de ne pas avoir accès à toutes les fonctionnalités du site internet.</noscript>
<!--[if lt IE 11]>
<div class="browsehappy">
    <div class="container"><p>Savez-vous que votre navigateur est obsolète ?</p>
        <p>Pour naviguer de la manière la plus satisfaisante sur le Web, nous vous recommandons de procéder à une <a href="http://windows.microsoft.com/ie">mise à jour de votre
            navigateur</a>.<br>Vous pouvez aussi <a href="http://browsehappy.com/">essayer d’autres navigateurs web populaires</a>.</p></div>
</div><![endif]-->
@include('front._header')
@include('front._menu')

<div class="container main-wrapper">
    @if(Route::currentRouteName() != 'front.home' && Route::currentRouteName() != 'front.error')
        @include('front._breadcrumb')
    @endif

    @yield('content')
</div>

@include('front._footer')

<script src="{{ mix('js/app.js') }}">
var url = 'APP_URL';
var scriptDispositifs = {{ route('front.dispositifs') }}; //"{{ route('front.dispositifs', ['closed' => request('closed')]) }}";
</script>
@stack('inline-script')
</body>
</html>
