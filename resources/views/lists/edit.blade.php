<x-layouts.layout titulo="Editar Lista">
    <form action="{{ route('lists.update', $list->id) }}" method="POST" class="max-w-5xl mx-auto p-6 bg-base-200 rounded-lg shadow-md space-y-6">
        @csrf
        @method('PUT')

        <h2 class="text-2xl font-semibold mb-4">Editar Lista</h2>

        <div class="form-control w-full max-w-xl">
            <label for="title" class="label">
                <span class="label-text font-medium">Título</span>
            </label>
            <input type="text" name="title" id="title"
                   value="{{ old('title', $list->title) }}"
                   required
                   placeholder="Introduce el título"
                   class="input input-bordered w-full" />
        </div>

        <div class="form-control w-full max-w-xl">
            <label for="description" class="label">
                <span class="label-text font-medium">Descripción</span>
            </label>
            <textarea name="description" id="description" rows="4"
                      placeholder="Escribe una descripción..."
                      class="textarea textarea-bordered w-full resize-none">{{ old('description', $list->description) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-8">
            <div>
                <label class="label">
                    <span class="label-text font-medium">Todos los Álbumes</span>
                </label>
                <div id="all-albums" class="max-h-96 overflow-auto border rounded p-3 bg-base-100 space-y-2">
                    @foreach(App\Models\Album::orderBy('title')->get() as $album)
                        @php
                            $checked = in_array($album->id, old('albums', $list->albums->pluck('id')->toArray()));
                        @endphp
                        <label class="flex items-center space-x-3 cursor-pointer hover:bg-base-300 p-2 rounded">
                            <input type="checkbox" name="albums[]" value="{{ $album->id }}" class="checkbox checkbox-primary album-checkbox" data-id="{{ $album->id }}" data-title="{{ $album->title }}" data-artist="{{ $album->artist }}" data-thumbnail="{{ $album->thumbnail_url }}" {{ $checked ? 'checked' : '' }} />
                            <img src="{{ $album->thumbnail_url }}" alt="{{ $album->title }}" class="w-12 h-12 object-cover rounded" />
                            <div class="flex flex-col">
                                <span class="font-semibold">{{ $album->title }}</span>
                                <span class="text-sm text-gray-500">{{ $album->artist }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!--Álbumes seleccionados-->
            <div>
                <label class="label">
                    <span class="label-text font-medium">Álbumes Seleccionados</span>
                </label>
                <div id="selected-albums" class="max-h-96 overflow-auto border rounded p-3 bg-base-100 space-y-2">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-full mt-6">
            Guardar cambios
        </button>
    </form>

    <script>
        function updateSelectedAlbums() {
            const container = document.getElementById('selected-albums');
            container.innerHTML = ''; // limpiar

            const checkboxes = document.querySelectorAll('.album-checkbox:checked');

            if (checkboxes.length === 0) {
                container.innerHTML = '<p class="text-gray-500">No hay álbumes seleccionados.</p>';
                return;
            }

            checkboxes.forEach(cb => {
                const id = cb.getAttribute('data-id');
                const title = cb.getAttribute('data-title');
                const artist = cb.getAttribute('data-artist');
                const thumbnail = cb.getAttribute('data-thumbnail');

                const div = document.createElement('div');
                div.className = 'flex items-center space-x-3 p-2 bg-base-200 rounded shadow';

                div.innerHTML = `
                    <img src="${thumbnail}" alt="${title}" class="w-12 h-12 object-cover rounded" />
                    <div class="flex flex-col">
                        <span class="font-semibold">${title}</span>
                        <span class="text-sm text-gray-600">${artist}</span>
                    </div>
                `;

                container.appendChild(div);
            });
        }

        document.querySelectorAll('.album-checkbox').forEach(cb => {
            cb.addEventListener('change', updateSelectedAlbums);
        });

        window.addEventListener('DOMContentLoaded', updateSelectedAlbums);
    </script>
</x-layouts.layout>
