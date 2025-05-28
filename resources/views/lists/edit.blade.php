<x-layouts.layout titulo="Editar Lista">
    <form action="{{ route('lists.update', $list->id) }}" method="POST" class="max-w-5xl mx-auto p-8 bg-white rounded-lg shadow-lg space-y-8">
        @csrf
        @method('PUT')

        <h2 class="text-3xl font-bold mb-6 text-center">Editar Lista</h2>

        <div class="form-control w-full max-w-xl mx-auto">
            <label for="title" class="label">
                <span class="label-text font-semibold text-lg">Título</span>
            </label>
            <input type="text" name="title" id="title"
                   value="{{ old('title', $list->title) }}"
                   required
                   placeholder="Introduce el título"
                   class="input input-bordered w-full text-lg" />
        </div>

        <div class="form-control w-full max-w-xl mx-auto">
            <label for="description" class="label">
                <span class="label-text font-semibold text-lg">Descripción</span>
            </label>
            <textarea name="description" id="description" rows="4"
                      placeholder="Escribe una descripción..."
                      class="textarea textarea-bordered w-full resize-none text-lg">{{ old('description', $list->description) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-10 max-w-5xl mx-auto">
            <div>
                <label class="label">
                    <span class="label-text font-semibold text-xl">Todos los Álbumes</span>
                </label>
                <div id="all-albums" class="max-h-[28rem] overflow-y-auto border rounded-lg p-4 bg-white shadow-sm space-y-3">
                    @foreach(App\Models\Album::with('artist')->orderBy('title')->get() as $album)
                        @php
                            $checked = in_array($album->id, old('albums', $list->albums->pluck('id')->toArray()));
                            $artistName = $album->artist ? $album->artist->name : 'Artista desconocido';
                            $thumbnailUrl = $album->cover_image ? asset('storage/' . $album->cover_image) : 'https://via.placeholder.com/56x56?text=No+Image';
                        @endphp
                        <label class="flex items-center space-x-4 cursor-pointer hover:bg-base-200 rounded-lg p-2 transition-colors duration-200">
                            <input type="checkbox" name="albums[]" value="{{ $album->id }}" class="checkbox checkbox-primary album-checkbox"
                                   data-id="{{ $album->id }}"
                                   data-title="{{ $album->title }}"
                                   data-artist="{{ $artistName }}"
                                   data-thumbnail="{{ $thumbnailUrl }}"
                                {{ $checked ? 'checked' : '' }} />
                            <img src="{{ $thumbnailUrl }}" alt="{{ $album->title }}" class="w-14 h-14 object-cover rounded-lg shadow" />
                            <div class="flex flex-col truncate">
                                <span class="font-semibold text-md truncate max-w-xs">{{ $album->title }}</span>
                                <span class="text-sm text-gray-500 truncate max-w-xs">{{ $artistName }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="label">
                    <span class="label-text font-semibold text-xl">Álbumes Seleccionados</span>
                </label>
                <div id="selected-albums" class="max-h-[28rem] overflow-y-auto border rounded-lg p-4 bg-white shadow-sm space-y-3">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-lg w-full max-w-xl mx-auto block mt-8">
            Guardar cambios
        </button>
    </form>
</x-layouts.layout>

<script>
    function updateSelectedAlbums() {
        const container = document.getElementById('selected-albums');
        container.innerHTML = ''; // limpiar

        const checkboxes = document.querySelectorAll('.album-checkbox:checked');

        if (checkboxes.length === 0) {
            container.innerHTML = '<p class="text-gray-400 italic text-center">No hay álbumes seleccionados.</p>';
            return;
        }

        checkboxes.forEach(cb => {
            const id = cb.getAttribute('data-id');
            const title = cb.getAttribute('data-title');
            const artist = cb.getAttribute('data-artist');
            const thumbnail = cb.getAttribute('cover_image');

            const div = document.createElement('div');
            div.className = 'flex items-center space-x-4 p-3 bg-base-100 rounded-lg shadow-sm';

            div.innerHTML = `
                    <img src="${thumbnail}" alt="${title}" class="w-14 h-14 object-cover rounded-lg shadow" />
                    <div class="flex flex-col truncate">
                        <span class="font-semibold text-md truncate max-w-xs">${title}</span>
                        <span class="text-sm text-gray-600 truncate max-w-xs">${artist}</span>
                    </div>`;

            container.appendChild(div);
        });
    }

    document.querySelectorAll('.album-checkbox').forEach(cb => {
        cb.addEventListener('change', updateSelectedAlbums);
    });

    window.addEventListener('DOMContentLoaded', updateSelectedAlbums);
</script>
