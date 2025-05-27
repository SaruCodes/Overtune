<x-layouts.layout titulo="Detalle del Álbum">
    <div class="container mx-auto px-4 pt-10 mb-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <div>
                <img src="{{ asset('storage/' . $album->cover_image) }}" alt="{{ $album->title }}" class="rounded-xl shadow-md w-full max-w-sm mx-auto md:mx-0" />
            </div>
            <div>
                <h1 class="text-4xl font-bold mb-4">{{ $album->title }}</h1>
                <p class="text-gray-700 mb-4">{{ $album->description ?? 'Sin descripción.' }}</p>

                <div class="bg-purple-300 p-6 rounded-xl shadow">
                    <h2 class="text-lg font-semibold mb-2">Información del Álbum</h2>
                    <ul class="space-y-1">
                        <li><strong>Artista:</strong> {{ $album->artist->name }}</li>
                        <li><strong>Fecha de lanzamiento:</strong> {{ $album->release_date->format('d/m/Y') }}</li>
                        <li><strong>Tipo:</strong> {{ $album->type }}</li>
                        <li><strong>Géneros:</strong>
                            {{ $album->genres->pluck('genre')->join(', ') }}
                        </li>
                    </ul>
                    @if($album->spotify_id)
                        <div class="my-8">
                            <h2 class="text-lg font-semibold mb-2">Escúchalo en Spotify</h2>
                            <iframe style="border-radius:12px"
                                    src="https://open.spotify.com/embed/album/{{ $album->spotify_id }}"
                                    width="100%" height="352" frameBorder="0"
                                    allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                                    loading="lazy">
                            </iframe>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!--RECOMENDACIONES Y RESEÑAS EN DOS COLUMNAS-->
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-48">
            <div class="bg-purple-300 rounded-xl p-6 shadow">
                <h2 class="text-lg font-semibold mb-4">Recomendaciones</h2>
                @if($recommendedAlbums->isNotEmpty())
                    <ul class="space-y-3">
                        @foreach($recommendedAlbums as $rec)
                            <li class="flex items-center space-x-3">
                                <img src="{{ asset('storage/' . $rec->cover_image) }}"
                                     alt="{{ $rec->title }}"
                                     class="w-12 h-12 rounded shadow" />
                                <div>
                                    <p class="text-sm font-medium">{{ $rec->title }}</p>
                                    <p class="text-xs text-gray-600">{{ $rec->artist->name }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm">No hay recomendaciones disponibles.</p>
                @endif
            </div>

            <div class="col-span-2">
                <h2 class="text-lg font-semibold mb-4">Reseñas mejor valoradas</h2>
                @foreach($album->review->sortByDesc(fn($review) => $review->comments->count()) as $review)
                    <div class="mb-6 border-b pb-4">
                        <p class="font-bold">Por {{ $review->user->name }} el {{ $review->created_at->format('d/m/Y') }}</p>
                        <p class="text-gray-700 mt-2">
                            {{ Str::limit($review->content, 250) }}
                        </p>
                        <a href="{{ route('review.show', $review->id) }}"
                           class="text-sm text-purple-600 hover:underline">
                            Leer completa
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.layout>

