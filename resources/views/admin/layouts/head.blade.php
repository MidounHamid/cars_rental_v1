<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>

    <link rel="stylesheet" href="{{ asset('style.css') }}">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />

    {{-- Optional custom table styling --}}
    {{-- <link rel="stylesheet" href="table.css" /> --}}

    @stack('styles') <!-- ✅ This enables child views to push additional CSS like Font Awesome -->
</head>
