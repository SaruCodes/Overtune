<x-layouts.layout titulo="Overtune - Crear Noticia">
    <div class="flex justify-center items-center min-h-screen bg-main py-12 px-4">
        <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data"
              class="w-full max-w-xl bg-base-100 rounded-lg shadow-md p-6">
            @csrf

            <h1 class="text-2xl font-semibold text-primary mb-6 text-center">Crear Noticia</h1>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-4">
                <label for="title" class="block text-text-dark font-medium mb-1">Título</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}"
                       class="w-full p-2 border border-gray-300 rounded-md" required>
                @error('title') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="content" class="block text-text-dark font-medium mb-1">Contenido</label>
                <textarea name="content" id="content" rows="5"
                          class="w-full p-2 border border-gray-300 rounded-md" required>{{ old('content') }}</textarea>
                @error('content') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="category_id" class="block text-text-dark font-medium mb-1">Categoría</label>
                <select name="category_id" id="category_id"
                        class="w-full p-2 border border-gray-300 rounded-md" required>
                    <option value="">Selecciona una categoría</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->category }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="image" class="block text-text-dark font-medium mb-1">Imagen de portada</label>
                <input type="file" name="image" id="image" class="file-input file-input-bordered w-full">
                @error('image') <p class="text-error text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-4 mt-6">
                <a href="{{ route('news.crud') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Crear Noticia</button>
            </div>
        </form>
    </div>
</x-layouts.layout>
