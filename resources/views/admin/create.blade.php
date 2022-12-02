@extends('layouts.app')

@section('content')
    <div class="p-8 mt-2 rounded shadow bg-white">
        <form action="{{ route('store', ['id' => $id]) }}" method="post" class="w-full" enctype="multipart/form-data">
            @csrf
            <div class="flex items-center mb-6">
                <div class="w-1/4">
                    <label class="block text-gray-500 font-bold text-right mb-0 pr-4" for="id">
                        ID
                    </label>
                </div>
                <div class="w-3/4">
                    <span class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="id">{{ sprintf('%03d', $id) }}</span>
                </div>
            </div>
            <div class="flex items-center mb-6">
                <div class="w-1/4">
                    <label class="block text-gray-500 font-bold text-right mb-0 pr-4" for="picture">
                        Picture
                    </label>
                </div>
                <div class="w-3/4">
                    <input type="file" accept="image/*" capture="camera" id="picture" required name="picture">
                </div>
            </div>
            <div class="flex items-center">
                <div class="w-1/4"></div>
                <div class="w-3/4">
                    <input type="submit" value="Create" class="w-full shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" />
                </div>
            </div>
        </form>
    </div>
@endsection
