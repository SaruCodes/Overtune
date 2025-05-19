<x-layouts.layout titulo="{{ __('Overtune - ') . $artist->name }}">

    {{-- Banner imagen artista --}}
    @if ($artist->image)
        <div class="w-full h-64 md:h-96 overflow-hidden rounded-b-lg shadow-lg mb-8">
            <img src="{{ asset('storage/' . $artist->image) }}" alt="Imagen del Artista" class="w-full h-full object-cover object-center">
        </div>
    @else
        <div class="w-full h-64 md:h-96 flex items-center justify-center bg-gray-200 rounded-b-lg shadow-lg mb-8">
            <p class="text-gray-500 text-xl">{{ __('No hay imagen disponible') }}</p>
        </div>
    @endif

    {{-- Tarjeta con info del artista --}}
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-8 mb-12">
        <h1 class="text-4xl font-bold text-violet-900 mb-4 text-center">{{ $artist->name }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-gray-700">
            <div>
                <p><strong>{{ __('ID del artista:') }}</strong> {{ $artist->id }}</p>
                <p><strong>{{ __('País:') }}</strong> {{ $artist->country ?? __('No especificado') }}</p>
                <p><strong>{{ __('Debut:') }}</strong> {{ $artist->debut ?? __('No especificado') }}</p>
            </div>
            <div class="md:col-span-2">
                <p><strong>{{ __('Biografía:') }}</strong></p>
                <p class="whitespace-pre-line mt-2 text-gray-600">{{ $artist->bio ?? __('No disponible') }}</p>
            </div>
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('artists.crud') }}" class="btn btn-secondary inline-block">
                {{ __('Volver a la lista') }}
            </a>
        </div>
    </div>

    {{-- Tabla con álbumes asociados --}}
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-semibold text-violet-900 mb-6">{{ __('Álbumes de ') . $artist->name }}</h2>
        @if($artist->albums->isEmpty())
            <p class="text-center text-gray-500">{{ __('No hay álbumes disponibles para este artista.') }}</p>
        @else
            <table class="w-full border-collapse border border-gray-300 text-gray-800">
                <thead class="bg-indigo-400 text-white">
                <tr>
                    <th class="border border-gray-300 p-3 text-left">{{ __('Portada') }}</th>
                    <th class="border border-gray-300 p-3 text-left">{{ __('Título') }}</th>
                    <th class="border border-gray-300 p-3 text-left">{{ __('Fecha de Lanzamiento') }}</th>
                </tr>
                </thead>
                <tbody class="bg-white">
                @foreach($artist->albums as $album)
                    <tr class="border border-gray-300 hover:bg-gray-100 cursor-pointer">
                        <td class="border border-gray-300 p-2 w-20">
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
                        <td class="border border-gray-300 p-3 align-middle">
                            {{ $album->release_date->format('Y-m-d') }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

</x-layouts.layout>
