<x-layouts.layout titulo="Buscar Álbumes">
    <div class="flex">
        <aside class="w-1/4 p-4 bg-gray-100 rounded-md">
            <form method="GET" action="{{ route('albums.search') }}">
                <h2 class="text-xl font-semibold mb-4">Filtros</h2>

                <div class="mb-4">
                    <label class="block font-medium mb-1" for="year">Año de lanzamiento</label>
                    <input type="number" name="year" id="year"
                           min="1920" max="2025"
                           value="{{ request('year') }}"
                           class="w-full border p-2 rounded-md" placeholder="Ej. 2022">
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-2">Géneros</label>
                    @foreach ($genres as $genre)
                        <label class="inline-flex items-center mb-1">
                            <input type="checkbox" name="genres[]" value="{{ $genre->id }}"
                                   @if (is_array(request('genres')) && in_array($genre->id, request('genres'))) checked @endif
                                   class="form-checkbox">
                            <span class="ml-2">{{ $genre->genre }}</span>
                        </label><br>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-primary w-full">Aplicar filtros</button>
            </form>
        </aside>

        <main class="w-3/4 p-4">
            <h1 class="text-2xl font-bold mb-4">Nueva Reseña</h1>

            <form method="GET" action="{{ route('albums.search') }}" class="flex flex-wrap items-center gap-2 mb-6 max-w-2xl">
                <input type="text" name="search"
                       placeholder="Buscar por nombre de álbum..."
                       value="{{ request('search') }}"
                       class="flex-grow border border-gray-300 p-2 rounded-md min-w-[200px] max-w-[400px]">

                <button type="submit" class="btn btn-primary px-4 py-2">Buscar</button>

                <a href="{{ route('albums.search') }}"
                   class="btn btn-secondary px-4 py-2 text-black rounded">
                    Limpiar
                </a>
            </form>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @forelse ($albums as $album)
                    <div class="bg-white shadow rounded-md overflow-hidden hover:shadow-lg transition">
                        <div class="aspect-square overflow-hidden">
                            <img src="{{ asset('storage/' . $album->cover_image) }}"
                                 class="w-full h-full object-cover" alt="{{ $album->title }}">
                        </div>
                        <div class="p-4">
                            <h3 class="text-md font-semibold truncate">{{ $album->title }}</h3>
                            <p class="text-sm text-gray-600">Artista: {{ $album->artist->name }}</p>
                            <p class="text-sm text-gray-600">Lanzado: {{ \Carbon\Carbon::parse($album->release_date)->year }}</p>

                                <a href="{{ route('review.create', ['album_id' => $album->id]) }}"
                                   class="inline-flex items-center mt-2 text-white bg-blue-500 hover:bg-blue-600 px-2 py-1 rounded text-sm">
                                    <span class="text-lg font-bold mr-1">+</span> Reseñar
                                </a>
                        </div>
                    </div>
                @empty
                    <p>No se encontraron álbumes con los filtros aplicados.</p>
                @endforelse
            </div>
        </main>
    </div>
</x-layouts.layout>
