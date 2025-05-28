<x-layouts.layout titulo="Resultados de búsqueda" :query="$query">
    <div class="p-6 max-w-7xl mx-auto">

        <!--Barra de Búsqueda-->
        <form action="{{ route('search.results') }}" method="GET" class="mb-8 flex items-center space-x-4">
            <input type="text" name="q" value="{{ old('q', $query) }}" placeholder="Buscar álbumes, artistas..." class="input input-bordered input-primary flex-grow" autofocus autocomplete="off">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <h1 class="text-3xl font-extrabold mb-8">Resultados para: <span class="text-primary">"{{ $query }}"</span></h1>

        <section>
            <h2 class="text-2xl font-semibold mb-4 border-b border-gray-300 pb-2">Álbumes</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($albums as $album)
                    <a href="{{ route('albums.show', $album->id) }}" class="group block border rounded-lg overflow-hidden shadow hover:shadow-lg transition relative">
                        <div class="w-full h-48 overflow-hidden">
                            <img
                                src="{{ $album->cover_image ? asset('storage/' . $album->cover_image) : asset('images/album-placeholder.png') }}"
                                alt="Portada {{ $album->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform"
                            />
                        </div>
                        <div class="p-4 bg-white">
                            <h3 class="font-bold text-lg mb-1">{{ $album->title }}</h3>
                            <p class="text-sm text-gray-500 mb-2">{{ $album->artist->name }}</p>
                            <p class="text-sm text-gray-600 line-clamp-3">
                                {{ Str::words($album->description ?? 'Sin descripción disponible.', 50, '...') }}
                            </p>
                        </div>
                    </a>
                @empty
                    <p>No se encontraron álbumes.</p>
                @endforelse
            </div>
        </section>

        <section class="mt-12">
            <h2 class="text-2xl font-semibold mb-4 border-b border-gray-300 pb-2">Artistas</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($artists as $artist)
                    <a href="{{ route('artists.show', $artist->id) }}" class="group block border rounded-lg overflow-hidden shadow hover:shadow-lg transition relative">
                        <div class="w-full h-48 overflow-hidden">
                            <img
                                src="{{ $artist->image ? asset('storage/' . $artist->image) : asset('images/artist-placeholder.png') }}"
                                alt="Foto de {{ $artist->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform"
                            />
                        </div>
                        <div class="p-4 bg-white">
                            <h3 class="font-bold text-lg mb-1">{{ $artist->name }}</h3>
                            <p class="text-sm text-gray-600 line-clamp-3">
                                {{ Str::words($artist->bio ?? 'Biografía no disponible.', 50, '...') }}
                            </p>
                        </div>
                    </a>
                @empty
                    <p>No se encontraron artistas.</p>
                @endforelse
            </div>
        </section>
    </div>
</x-layouts.layout>
