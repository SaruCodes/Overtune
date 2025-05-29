<x-layouts.layout titulo="{{ __('Overtune - ').$artist->name }}">
    @if ($artist->image)
        <div class="w-full h-[32rem] md:h-[36rem] overflow-hidden rounded-b-lg shadow-lg mb-4">
            <img src="{{ asset('storage/' . $artist->image) }}"
                 alt="Imagen del Artista"
                 class="w-full h-full object-cover object-[center_20%] transition-transform duration-300">
        </div>
    @else
        <div class="w-full h-64 md:h-96 flex items-center justify-center bg-gray-200 rounded-b-lg shadow-lg mb-4">
            <p class="text-gray-500 text-xl">{{ __('No hay imagen disponible') }}</p>
        </div>
    @endif

        <div class="flex flex-col items-center mb-12">
            <div class="flex justify-center items-center gap-4 mb-4">
                <h1 class="text-4xl font-bold text-violet-900">{{ $artist->name }}</h1>

                @auth
                    <form action="{{ route('favorite.toggle', ['type' => 'artist', 'id' => $artist->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-600 transition">
                            @if(auth()->user()?->favorites()->where('favoritable_type', \App\Models\Artist::class)->where('favoritable_id', $artist->id)->exists())
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="size-[1.5em]" viewBox="0 0 24 24">
                                    <path d="M12 21s-9-4.78-9-12a4.5 4.5 0 014.688-4.5c1.935 0 3.597 1.126 4.312 2.733C12.715 5.876 14.377 4.75 16.313 4.75A4.5 4.5 0 0121 8.25c0 7.22-9 12-9 12z"/>
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="size-[1.5em]" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                </svg>
                            @endif
                        </button>
                    </form>
                @endauth
            </div>

            <a href="{{ route('artists.index') }}"
               class="inline-flex items-center text-sm font-semibold text-violet-800 hover:text-violet-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                {{ __('Volver a artistas') }}
            </a>
        </div>

    <!--ficha artista-->
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-24 mb-16">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-violet-800 mb-4">{{ __('Información del artista') }}</h2>
            <p><strong>{{ __('País:') }}</strong> {{ $artist->country ?? __('No especificado') }}</p>
            <p class="mt-4"><strong>{{ __('Debut:') }}</strong> {{ $artist->debut ?? __('No especificado') }}</p>

            <p class="mt-4"><strong>{{ __('Biografía:') }}</strong></p>
            <p class="whitespace-pre-line text-gray-600 mt-1 mb-4">{{ $artist->bio ?? __('No disponible') }}</p>

            <div class="flex flex-wrap gap-3 justify-start mb-6">
                <a href="https://open.spotify.com" target="_blank"
                   class="bg-green-500 hover:bg-green-600 text-white text-sm font-semibold py-2 px-4 rounded-lg shadow">
                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M19.098 10.638c-3.868-2.297-10.248-2.508-13.941-1.387-.593.18-1.22-.155-1.399-.748-.18-.593.154-1.22.748-1.4 4.239-1.287 11.285-1.038 15.738 1.605.533.317.708 1.005.392 1.538-.316.533-1.005.709-1.538.392zm-.126 3.403c-.272.44-.847.578-1.287.308-3.225-1.982-8.142-2.557-11.958-1.399-.494.15-1.017-.129-1.167-.623-.149-.495.13-1.016.624-1.167 4.358-1.322 9.776-.682 13.48 1.595.44.27.578.847.308 1.286zm-1.469 3.267c-.215.354-.676.465-1.028.249-2.818-1.722-6.365-2.111-10.542-1.157-.402.092-.803-.16-.895-.562-.092-.403.159-.804.562-.896 4.571-1.045 8.492-.595 11.655 1.338.353.215.464.676.248 1.028zm-5.503-17.308c-6.627 0-12 5.373-12 12 0 6.628 5.373 12 12 12 6.628 0 12-5.372 12-12 0-6.627-5.372-12-12-12z"/></svg>
                </a>
                <a href="https://music.apple.com" target="_blank"
                   class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold py-2 px-4 rounded-lg shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 448 512">
                        <path d="M224 32C100.3 32 0 132.3 0 256s100.3 224 224 224 224-100.3 224-224S347.7 32 224 32zm96.4 136.9c-2.6-7.5-10.6-11.8-18.1-9.2L208 184.3c-7.1 2.4-11.9 9.2-11.9 16.8v144.9c0 8.4-6.8 15.3-15.3 15.3-7.3 0-13.5-5.1-15-12.2-5.8-26.3-31-43-57.3-37.2S65 339 70.8 365.3s31 43 57.3 37.2c18.6-4.1 32.3-19 35.8-37v-95.2l128-43v66.2c0 8.4-6.8 15.3-15.3 15.3-7.3 0-13.5-5.1-15-12.2-5.8-26.3-31-43-57.3-37.2S161 267 166.8 293.3s31 43 57.3 37.2c18.6-4.1 32.3-19 35.8-37V179.7c0-2.4-.4-4.8-1.2-7.1z"/>
                    </svg>

                </a>
                <a href="https://soundcloud.com" target="_blank"
                   class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold py-2 px-4 rounded-lg shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M0 0v24h24v-24h-24zm4.667 15.524c-.405-.365-.667-.903-.667-1.512 0-.608.262-1.146.667-1.512v3.024zm1.333.476c-.243 0-.369.003-.667-.092v-3.792c.316-.101.465-.097.667-.081v3.965zm1.333 0h-.666v-3.778l.206.121c.091-.375.253-.718.461-1.023v4.68zm1.334 0h-.667v-5.378c.206-.154.426-.286.667-.377v5.755zm1.333 0h-.667v-5.905c.251-.027.328-.046.667.006v5.899zm1.333 0h-.667v-5.7l.253.123c.119-.207.261-.395.414-.572v6.149zm6.727 0h-6.06v-6.748c.532-.366 1.16-.585 1.841-.585 1.809 0 3.275 1.494 3.411 3.386 1.302-.638 2.748.387 2.748 1.876 0 1.143-.869 2.071-1.94 2.071z"/>
                    </svg>
                </a>
            </div>
        </div>

        <div class="md:col-span-2">
            <h2 class="text-2xl font-semibold text-violet-900 mb-4">{{ __('Álbumes de ') . $artist->name }}</h2>
            @if($artist->albums->isEmpty())
                <p class="text-center text-gray-500">{{ __('No hay álbumes disponibles para este artista.') }}</p>
            @else
                <table class="w-full border-collapse border border-gray-300 text-gray-800">
                    <thead class="bg-primary text-white">
                    <tr>
                        <th class="border border-gray-300 p-3 text-left">{{ __('Portada') }}</th>
                        <th class="border border-gray-300 p-3 text-left">{{ __('Título') }}</th>
                        <th class="border border-gray-300 p-3 text-left">{{ __('Fecha de Lanzamiento') }}</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white">
                    @foreach($artist->albums as $album)
                        <tr class="border border-gray-300 hover:bg-gray-100 cursor-pointer">
                            <td class="border border-gray-300 p-2 w-15">
                                @if($album->cover_image)
                                    <a href="{{ route('albums.show', $album) }}" class="block w-16 h-16 mx-auto overflow-hidden rounded-md shadow-md">
                                        <img src="{{ asset('storage/' . $album->cover_image) }}" alt="{{ $album->title }}" class="object-cover w-full h-full" />
                                    </a>
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-md flex items-center justify-center text-gray-400 text-xs">
                                        {{ __('No imagen') }}
                                    </div>
                                @endif
                            </td>
                            <td class="border border-gray-300 p-3 align-middle">
                                <a href="{{ route('albums.show', $album) }}" class="text-indigo-700 hover:underline font-semibold text-lg">
                                    {{ $album->title }}
                                </a>
                            </td>
                            <td class="border border-gray-300 p-3 align-middle w-6">
                                {{ $album->release_date->format('Y-m-d') }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-layouts.layout>
