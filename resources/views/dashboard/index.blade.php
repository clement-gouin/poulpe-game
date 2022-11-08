<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>{{ $title ?? config('app.name') }}</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
        <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

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
                overflow: hidden;
                border-color: #222;
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
        <div id="app" class="h-fit w-full">
            <div class="player-container flex flex-wrap items-center h-fit w-full">
                <div v-for="player in players" v-on:click="pswitch(player.id)" :style="style" :href="'/switch/' + player.id" :class="{ dead: !player.alive }" class="block player relative border-zinc-900 rounded items-center text-center">
                    <img :src="player.picture" />
                    <div class="player-id absolute z-90 bottom-0 left-0 right-0 font-bold text-white w-fit mx-auto px-2 rounded-t-lg" v-html="getFormatedId(player.id)"></div>
                </div>
            </div>
        </div>
        <script>
            const { createApp } = Vue;

            const app = createApp({
                data() {
                    return {
                        players: [],
                    }
                },
                computed: {
                    style() {
                        const N = this.players.length;

                        const maxW = document.body.scrollWidth;
                        const maxH = document.body.scrollHeight;
                        const k = 7 / 6;

                        const ratio = maxH / (maxW * k);

                        const ref = Array(N)
                            .fill()
                            .map((_, i) => i+1)
                            .map(i => [i, Math.floor(i * ratio)])
                            .filter(v => v[0] * v[1] > N && (v[1] * maxW * k / v[0]) < maxH)
                            .map(v => 100 / v[0])[0];

                        return {
                            'font-size': ref * .3 / 2 + 'vw',
                            'width': ref + 'vw',
                            'height': ref * k + 'vw',
                            'border-width': ref * .1 / 3 + 'vw',
                        };
                    }
                },
                methods: {
                    fetchData() {
                        fetch('/players')
                            .then(res => res.json())
                            .then(this.loadData)
                            .catch(err => { throw err });
                    },
                    loadData(json) {
                        this.players = json;
                    },
                    getFormatedId(id) {
                        return '#' + String(id).padStart(3, '0');
                    },
                    pswitch(id) {
                        fetch('/admin/switch/' + id)
                            .then(this.fetchData)
                    }
                },
                mounted: function() {
                    this.fetchData();
                    setInterval(this.fetchData, 1000);
                },
            });

            app.mount('#app');
        </script>
    </body>
</html>
