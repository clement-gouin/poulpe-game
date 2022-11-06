<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>{{ $title ?? config('app.name') }}</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="refresh" content="5">

        <script src="https://cdn.tailwindcss.com?plugins=forms"></script>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,700,1,0" />

        <style>
            body {
                font-family: 'Righteous', sans-serif;
            }

            .player-container {
                padding: 0;
                margin: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                position: absolute;
                top: 50%;
                transform: translate(0, -50%);
            }

            .player {
                width: 6vw;
                height: 7vw;
                overflow: hidden;
                border: .2vw solid #222;
            }

            .player-id {
                background: rgba(24, 24, 27, .5);
            }

            .dead img {
                filter: grayscale(100%) brightness(60%);
            }
        </style>
    </head>
    <body class="tracking-wider leading-normal bg-zinc-900 w-screen h-screen">
        <div class="player-container flex flex-wrap items-center h-fit w-full">
            @foreach($players as $player)
                <a href="{{ route('switch', ['id' => $player->id]) }}" class="block player {{ $player->alive ? 'alive' : 'dead' }} relative border-zinc-900 rounded items-center  text-center">
                    <img src="{{ $player->picture }}" />
                    <div class="player-id absolute z-90 bottom-0 left-0 right-0 font-bold text-white w-fit mx-auto px-2 rounded-t-lg">{{ sprintf('#%03d', $player->id) }}</div>
                </a>
            @endforeach
        </div>
        @stack('scripts')
    </body>
</html>
