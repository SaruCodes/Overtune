@props(['titulo' => '', 'query' => null])
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ $titulo ?? "" }}</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @vite(["resources/css/app.css", "resources/js/app.js"])
    </head>
    <body class="flex flex-col min-h-screen bg-main">
        <x-layouts.header />
        <x-layouts.nav :query="$query" />

        <main class="flex-1">
            {{ $slot }}
        </main>

        <x-layouts.footer />
    </body>
</html>
