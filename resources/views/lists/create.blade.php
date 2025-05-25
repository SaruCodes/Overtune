<x-layouts.layout titulo="Crear Lista">
    <div class="max-w-3xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Crear Lista Nueva</h1>

        <form action="{{ route('lists.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium">Título</label>
                <input type="text" name="title" class="input input-bordered w-full" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Descripción</label>
                <textarea name="description" class="textarea textarea-bordered w-full"></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Buscar Álbumes</label>
                <input type="text" id="album-search" class="input input-bordered w-full" placeholder="Nombre del álbum...">
                <div id="album-results" class="mt-2"></div>
                <input type="hidden" name="albums[]" id="selected-albums">
            </div>
            <button type="submit" class="btn btn-primary">Guardar Lista</button>
        </form>
    </div>
</x-layouts.layout>
