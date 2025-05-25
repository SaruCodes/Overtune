<x-layouts.layout titulo="Detalle del Álbum">
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-2">{{ $album->title }}</h1>
        <p class="text-lg mb-4">Artista: {{ $album->artist }}</p>
        <p class="text-lg mb-4">Año: {{ $album->year }}</p>
        <p class="mb-6">{{ $album->description }}</p>

        <h2 class="text-2xl font-semibold mb-4">Reseñas más comentadas</h2>
        @if ($album->reviews->count() === 0)
            <p class="italic">No hay reseñas para este álbum.</p>
        @else
            @php
                $sortedReviews = $album->reviews->sortByDesc(fn($review) => $review->comments->count());
            @endphp
            @foreach ($sortedReviews as $review)
                <div class="border rounded p-4 mb-4">
                    <h3 class="text-xl font-semibold">{{ $review->title }}</h3>
                    <p class="mb-2">{{ $review->content }}</p>
                    <p class="text-sm text-gray-600">
                        Comentarios: {{ $review->comments->count() }}
                    </p>
                </div>
            @endforeach
        @endif
    </div>
</x-layouts.layout>
