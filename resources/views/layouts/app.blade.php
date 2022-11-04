<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>{{ $title ?? config('app.name') }}</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="https://cdn.tailwindcss.com?plugins=forms"></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,700,1,0" />

        <style>
            body {
                font-family: 'Fira Sans', sans-serif;
            }
        </style>
    </head>
    <body class="bg-gray-100 text-gray-900 tracking-wider leading-normal">
        <div class="container w-full md:w-4/5 xl:w-3/5  mx-auto px-2">
            @yield('content')
        </div>

        @stack('scripts')
    </body>
</html>
