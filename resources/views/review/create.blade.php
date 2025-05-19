<x-layouts.layout titulo="Nueva Reseña">
    <div class="max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold mb-4">Nueva Reseña</h2>

        <form method="POST" action="{{ route('reviews.store') }}">
            @csrf

            @if ($album)
                <input type="hidden" name="album_id" value="{{ $album->id }}">
                <p><strong>Álbum:</strong> {{ $album->title }} ({{ $album->artist->name }})</p>
            @else
                <label for="album_id">Selecciona un álbum</label>
                <select name="album_id" required>
                    @foreach(App\Models\Album::all() as $alb)
                        <option value="{{ $alb->id }}">{{ $alb->title }} - {{ $alb->artist->name }}</option>
                    @endforeach
                </select>
            @endif

            <label for="rating">Puntuación</label>
            <input type="number" name="rating" min="0.5" max="5" step="0.5" required>

            <label for="content">Contenido</label>
            <textarea name="content" required></textarea>

            <button type="submit" class="btn">Guardar reseña</button>
        </form>
    </div>
</x-layouts.layout>
