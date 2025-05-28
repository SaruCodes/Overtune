<x-layouts.layout titulo="Editar Reseña - Overtune">
    <div class="container mx-auto">
        <div class="card w-full max-w-lg mx-auto">
            <div class="card-body">
                <h2 class="text-2xl font-bold mb-4">{{ __('Editar Reseña') }}</h2>

                <form action="{{ route('review.update', $review->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="content" class="block text-sm font-semibold">{{ __('Contenido') }}</label>
                        <textarea
                            id="content"
                            name="content"
                            class="textarea textarea-bordered w-full mt-2"
                            required
                            maxlength="3000"
                            oninput="updateCounter()"
                        >{{ old('content', $review->content) }}</textarea>
                        <div class="text-sm text-gray-500 mt-1">
                            Caracteres: <span id="char-count">0</span> / 3000 (mínimo: 100)
                        </div>
                    </div>


                    <div class="mb-4">
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
                            value="{{ old('rating', $review->rating) }}">
                    </div>

                    <div class="flex justify-between mt-6">
                        <a href="{{ route('review.crud') }}" class="btn btn-secondary">{{ __('Volver') }}</a>

                        <div class="space-x-2">
                            <button type="submit" class="btn btn-primary">{{ __('Actualizar Reseña') }}</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
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
    document.addEventListener('DOMContentLoaded', updateCounter);
</script>
