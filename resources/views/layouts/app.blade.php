<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    

    <title>{{ config('app.name', 'Laravel') }}</title>

    @include('layouts.header')


</head>

<body>

    @include('layouts.head')



    {{ $slot }}









    @include('layouts.footer')


    @include('layouts.scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>



</body>

</html>
