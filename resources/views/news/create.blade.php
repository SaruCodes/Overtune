<x-layouts.layout titulo="Overtune - Gestión de Noticias">
    <div class="flex flex-col justify-center items-center min-h-screen bg-main py-12">
        <form action="{{ route('news.store') }}" method="POST" class="w-full max-w-md bg-base-100 shadow-lg rounded-lg p-8">
            @csrf

            <h1 class="text-2xl font-semibold text-primary mb-6 text-center">
                Crear Noticia
            </h1>

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
                <input
                    type="text"
                    name="title"
                    id="title"
                    value="{{ old('title') }}"
                    required
                    class="block w-full mt-1 p-2 border border-gray-300 rounded-md"
                >
                @error('title') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="content" class="block text-text-dark font-medium mb-1">Contenido</label>
                <textarea name="content" id="content" rows="5" required class="block w-full mt-1 p-2 border border-gray-300 rounded-md">
                    {{ old('content') }}
                </textarea>
                @error('content') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="category_id" class="block text-text-dark font-medium mb-1">Categoría</label>
                <select name="category_id" id="category_id" required class="block w-full mt-1 p-2 border border-gray-300 rounded-md">
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
                <label for="category_id" class="block text-text-dark font-medium mb-1">Portada de Noticia</label>
                <input type="file" id="image" name="image" class="file-input file-input-bordered w-full">
                @error('image') <p class="text-error text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('news.index') }}" class="btn btn-secondary">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    Crear Noticia
                </button>
            </div>
        </form>
    </div>
</x-layouts.layout>
