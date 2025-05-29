<x-layouts.layout titulo="Detalle del Álbum">
    <div class="container mx-auto px-4 pt-10 pb-16 mt-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-24">
            <div class="w-full max-w-xs md:max-w-sm aspect-square">
                <img src="{{ asset('storage/' . $album->cover_image) }}"
                     alt="{{ $album->title }}"
                     class="rounded-2xl shadow-lg object-cover w-full h-full" />
                <a href="{{ route('artists.show', $album->artist->id) }}" class="inline-block mt-4 px-4 py-2 bg-primary text-white text-sm font-medium rounded hover:bg-purple-950 transition">
                    ← Volver al artista: {{ $album->artist->name }}
                </a>
            </div>

            <div>
                <div class="flex items-start justify-between">

                    <h1 class="text-4xl font-bold text-purple-800">{{ $album->title }}</h1>
                    @auth
                        <form action="{{ route('favorite.toggle', ['type' => 'album', 'id' => $album->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="ml-4 text-red-500 hover:text-red-600">
                                @if(auth()->user()?->favorites()->where('favoritable_type', \App\Models\Album::class)->where('favoritable_id', $album->id)->exists())
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 24 24">
                                        <path d="M12 21s-9-4.78-9-12a4.5 4.5 0 014.688-4.5c1.935 0 3.597 1.126 4.312 2.733C12.715 5.876 14.377 4.75 16.313 4.75A4.5 4.5 0 0121 8.25c0 7.22-9 12-9 12z"/>
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="w-6 h-6" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                    </svg>
                                @endif
                            </button>
                        </form>
                    @endauth
                </div>

                <p class="text-gray-700 mt-4 mb-6">{{ $album->description ?? 'Sin descripción.' }}</p>

                <div class="bg-purple-300 p-6 rounded-xl shadow-md space-y-2">
                    <h2 class="text-xl font-semibold text-purple-900">Información del Álbum</h2>
                    <ul class="text-sm text-gray-800 space-y-1">
                        <li><strong>Artista:</strong> {{ $album->artist->name }}</li>
                        <li><strong>Fecha de lanzamiento:</strong> {{ $album->release_date->format('d/m/Y') }}</li>
                        <li><strong>Tipo:</strong> {{ $album->type }}</li>
                        <li><strong>Géneros:</strong> {{ $album->genres->pluck('genre')->join(', ') }}</li>
                    </ul>

                    <!--Spotify-->
                    @if(isset($spotifyAlbum))
                        <div class="mt-4">
                            <h2 class="text-md font-semibold mb-2">Escúchalo en Spotify</h2>
                            <div class="overflow-hidden rounded-lg shadow-lg">
                                <iframe
                                    src="https://open.spotify.com/embed/album/{{ $spotifyAlbum['id'] }}"
                                    width="100%"
                                    height="160"
                                    frameborder="0"
                                    allowtransparency="true"
                                    allow="encrypted-media"
                                    class="rounded-md">
                                </iframe>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!--RECOMENDADICONES Y RESEÑAS DOS COLUMNAS -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-14">
            <div class="bg-purple-300 rounded-xl p-6 shadow-md">
                <h2 class="text-lg font-semibold mb-4 text-purple-800">Recomendaciones</h2>
                @if($recommendedAlbums->isNotEmpty())
                    <ul class="space-y-4">
                        @foreach($recommendedAlbums as $rec)
                            <li class="flex items-center gap-4">
                                <img src="{{ asset('storage/' . $rec->cover_image) }}"
                                     alt="{{ $rec->title }}"
                                     class="w-12 h-12 rounded shadow" />
                                <div>
                                    <p class="font-medium text-sm">{{ $rec->title }}</p>
                                    <p class="text-xs text-gray-600">{{ $rec->artist->name }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm">No hay recomendaciones disponibles.</p>
                @endif
            </div>


            <div class="lg:col-span-2">
                <h2 class="text-lg font-semibold mb-4 text-purple-800">Reseñas mejor valoradas</h2>
                @forelse($album->review->sortByDesc(fn($review) => $review->comments->count()) as $review)
                    <div class="mb-6 bg-white p-4 rounded shadow border">
                        <p class="font-semibold text-sm text-gray-800">
                            Por {{ $review->user->name }} el {{ $review->created_at->format('d/m/Y') }}
                        </p>
                        <p class="text-gray-700 mt-2 text-sm">
                            {{ Str::limit($review->content, 250) }}
                        </p>
                        <a href="{{ route('review.show', $review->id) }}"
                           class="text-sm text-purple-600 hover:underline mt-1 inline-block">
                            Leer completa
                        </a>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No hay reseñas todavía.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.layout>
