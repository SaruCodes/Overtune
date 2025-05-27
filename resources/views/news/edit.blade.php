<x-layouts.layout titulo="Overtune - Editar Noticia">
    <div class="flex flex-col md:flex-row justify-center items-start gap-10 min-h-screen bg-main py-12 px-6">

        <div class="bg-purple-100 rounded-lg shadow-md p-6 w-full md:w-1/2">
            <h2 class="text-xl font-semibold text-primary mb-4">Información Actual</h2>
            <p><strong class="text-text-dark">Título:</strong> {{ $news->title }}</p>
            <p><strong class="text-text-dark">Categoría:</strong> {{ $news->category->category ?? '—' }}</p>
            <p class="whitespace-pre-line"><strong class="text-text-dark">Contenido:</strong><br>{{ $news->content }}</p>

            @if ($news->image)
                <img src="{{ asset('storage/' . $news->image) }}" alt="Imagen actual"
                     class="rounded-md mt-4 w-full max-w-xs">
            @endif
        </div>

        <div class="bg-base-100 rounded-lg shadow-md p-6 w-full md:w-1/2">
            <form action="{{ route('news.update', $news) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <h1 class="text-2xl font-semibold text-primary mb-6 text-center">Editar Noticia</h1>

                <div class="mb-4">
                    <label for="title" class="block text-text-dark font-medium mb-1">Título</label>
                    <input type="text" name="title" id="title"
                           value="{{ old('title', $news->title) }}"
                           class="w-full p-2 border border-gray-300 rounded-md" required>
                    @error('title') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label for="content" class="block text-text-dark font-medium mb-1">Contenido</label>
                    <textarea name="content" id="content" rows="5"
                              class="w-full p-2 border border-gray-300 rounded-md" required>{{ old('content', $news->content) }}</textarea>
                    @error('content') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label for="category_id" class="block text-text-dark font-medium mb-1">Categoría</label>
                    <select name="category_id" id="category_id"
                            class="w-full p-2 border border-gray-300 rounded-md" required>
                        <option value="">Selecciona una categoría</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $news->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->category }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-text-dark font-medium mb-1">Nueva Imagen</label>
                    <input type="file" name="image" id="image" class="file-input file-input-bordered w-full">
                    @error('image') <p class="text-error text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end space-x-4 mt-6">
                    <a href="{{ route('news.crud') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.layout>
