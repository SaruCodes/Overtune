<x-layouts.layout titulo="Nueva Reseña">
    <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-lg mt-10">

        <h2 class="text-3xl font-bold mb-6 text-center">Nueva Reseña</h2>

        <form method="POST" action="{{ route('review.store') }}" class="space-y-6">
            @csrf

            @if ($album)
                <input type="hidden" name="album_id" value="{{ $album->id }}">
                <p class="mb-4 text-lg font-medium">
                    <span class="text-gray-600">Álbum:</span>
                    <span class="text-indigo-600">{{ $album->title }}</span>
                    (<span class="text-indigo-400">{{ $album->artist->name }}</span>)
                </p>
            @else
                <label for="album_id" class="block mb-2 font-semibold text-gray-700">Selecciona un álbum</label>
                <select name="album_id" id="album_id" required class="select select-bordered w-full">
                    <option value="" disabled selected>-- Elige un álbum --</option>
                    @foreach(App\Models\Album::all() as $alb)
                        <option value="{{ $alb->id }}">{{ $alb->title }} - {{ $alb->artist->name }}</option>
                    @endforeach
                </select>
            @endif

            <div>
                <label for="rating" class="block mb-2 font-semibold text-gray-700">{{ __('Calificación') }}</label>
                <input
                    type="number"
                    id="rating"
                    name="rating"
                    min="0.5"
                    max="5"
                    step="0.5"
                    required
                    class="input input-bordered w-full"
                    placeholder="Ejemplo: 4.5"
                >
            </div>

            <div>
                <label for="content" class="block mb-2 font-semibold text-gray-700">{{ __('Contenido') }}</label>
                <textarea
                    id="content"
                    name="content"
                    rows="5"
                    required
                    class="textarea textarea-bordered w-full"
                    placeholder="Escribe tu reseña aquí..."
                    maxlength="3000"
                ></textarea>
                <div class="text-sm text-gray-500 mt-1">
                    Caracteres: <span id="char-count">0</span> / 3000 (mínimo: 100)
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary w-full max-w-xs">Guardar Reseña</button>
                <a href="{{ route('review.index') }}" class="btn btn-secondary">Volver a reseñas</a>
            </div>
        </form>
    </div>
</x-layouts.layout>
<script>
    function updateCounter() {
        const textarea = document.getElementById('content');
        const countDisplay = document.getElementById('char-count');
        const length = textarea.value.length;
        countDisplay.textContent = length;

        if (length < 100 || length > 3000) {
            countDisplay.classList.add('text-red-500');
        } else {
            countDisplay.classList.remove('text-red-500');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const textarea = document.getElementById('content');
        textarea.addEventListener('input', updateCounter);
        updateCounter();
    });
</script>


