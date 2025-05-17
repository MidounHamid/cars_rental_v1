<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ session('direction', 'ltr') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- DateRangePicker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

    @include('layouts.header')
    @stack('header')
    @stack('styles')

</head>

<body class="{{ session('direction', 'ltr') }}">
    @include('layouts.head')

    @hasSection('content')
        @yield('content')
    @else
        {{ $slot ?? '' }}
    @endif

    <div
        style="position: fixed; bottom: 10px; left: 10px; background: #f8f9fa; padding: 10px; border: 1px solid #ccc; z-index: 9999;">
        <p>Langue actuelle : {{ app()->getLocale() }}</p>
        <p>Session locale : {{ session('locale') }}</p>
        <p>Direction : {{ session('direction') }}</p>
    </div>

    @include('layouts.footer')
    @include('layouts.scripts')

    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

    <!-- Moment.js -->
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <!-- DateRangePicker JS -->
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('scripts')
</body>

</html>
