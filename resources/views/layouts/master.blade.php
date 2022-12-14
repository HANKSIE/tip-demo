<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="stylesheet" href="{{mix('/css/app.css')}}">
</head>
<body>
    <header class="navbar navbar-expand-lg bg-light">
        header
    </header>
    <main class="pa-4">
        @yield('main')
    </main>
    <script src="{{ mix('/js/app.js') }}"></script>
</body>
@stack('scripts')
</html>
