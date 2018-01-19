<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    @include('front._header')
    @include('front._menu')

	<div class="container main-wrapper">
		@yield('breadcrumb')
		@yield('content')
	</div>

	@include('front._footer')

	@yield('after-content')

	<script src="{{ asset('js/bko.js') }}"></script>
	@stack('inline-script')
</body>
</html>
