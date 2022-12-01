@extends('layouts.app')

@section('content')
    <div class="md:p-8 mt-2 rounded shadow bg-white">
        <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        <table class="min-w-full">
                            <thead class="border-b">
                                <tr>
                                    <th scope="col" class="text-md font-bold text-gray-900 px-6 py-4 text-left">
                                        #
                                    </th>
                                    <th scope="col" class="text-md font-bold text-gray-900 px-6 py-4 text-left">
                                        Created
                                    </th>
                                    <th scope="col" class="text-md font-bold text-gray-900 px-6 py-4 text-left">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($players as $player)
                                    <tr class="border-b">
                                        <td class="px-6 py-4 whitespace-nowrap text-md font-bold text-gray-900">
                                            {{ sprintf('%03d', $player->id) }}
                                        </td>
                                        <td class="text-md text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            {{ $player->created_at }}
                                        </td>
                                        <td class="text-md text-gray-900 font-light px-6 py-4 whitespace-nowrap flex space-x-2">
                                            @if ($player->alive)
                                                <a href="{{ route('switch', ['id' => $player->id]) }}" class="inline-block p-2 bg-green-600 rounded-full flex justify-center items-center text-white hover:bg-green-700 duration-300">
                                                    <span class="material-symbols-outlined">
                                                        favorite
                                                    </span>
                                                </a>
                                            @else
                                                <a href="{{ route('switch', ['id' => $player->id]) }}" class="inline-block p-2 bg-gray-600 rounded-full flex justify-center items-center text-white hover:bg-gray-700 duration-300">
                                                    <span class="material-symbols-outlined">
                                                        heart_broken
                                                    </span>
                                                </a>
                                            @endif
                                            <a href="{{ route('update', ['id' => $player->id]) }}" class="inline-block p-2 bg-purple-600 rounded-full flex justify-center items-center text-white hover:bg-purple-700 duration-300">
                                                <span class="material-symbols-outlined">
                                                    edit
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('create') }}" class="block fixed z-90 bottom-8 right-8 bg-blue-600 w-20 h-20 rounded-full drop-shadow-lg flex justify-center items-center text-white font-bold hover:bg-blue-700 duration-300">
        {{ $alive }}
    </a>
@endsection
