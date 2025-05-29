<x-layouts.layout titulo="Detalle del Álbum">
    <div class="container mx-auto px-4 pt-10 mb-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <div>
                <img src="{{ asset('storage/' . $album->cover_image) }}" alt="{{ $album->title }}" class="rounded-xl shadow-md w-full max-w-sm md:mx-0" />
            </div>
            <div>
                <h1 class="text-4xl font-bold mb-4">{{ $album->title }}
                    <!--Favoritos-->
                @auth
                <form action="{{ route('favorite.toggle', ['type' => 'album', 'id' => $album->id]) }}" method="POST">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-600">
                        @if(auth()->user()?->favorites()->where('favoritable_type', \App\Models\Album::class)->where('favoritable_id', $album->id)->exists())
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="size-[1.2em]" viewBox="0 0 24 24">
                                <path d="M12 21s-9-4.78-9-12a4.5 4.5 0 014.688-4.5c1.935 0 3.597 1.126 4.312 2.733C12.715 5.876 14.377 4.75 16.313 4.75A4.5 4.5 0 0121 8.25c0 7.22-9 12-9 12z"/>
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="size-[1.2em]" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                        @endif
                    </button>
                </form>
                @endauth
                </h1>

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

            <div class="col-span-2 ml-12">
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

