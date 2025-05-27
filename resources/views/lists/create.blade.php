<x-layouts.layout titulo="Crear Lista">
    <div class="max-w-7xl mx-auto px-4 py-8 flex gap-8">
        <section class="w-1/3 flex flex-col">
            <h1 class="text-2xl font-bold mb-4">Crear Lista Nueva</h1>

            <form action="{{ route('lists.store') }}" method="POST" class="flex flex-col flex-grow">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1" for="title">Título</label>
                    <input type="text" name="title" id="title" class="input input-bordered w-full" required
                           value="{{ old('title') }}">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1" for="description">Descripción</label>
                    <textarea name="description" id="description" rows="4" class="textarea textarea-bordered w-full">{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <h2 class="text-lg font-semibold mb-2">Álbumes seleccionados</h2>
                    @php
                        $selectedAlbumIds = old('albums', []);
                    @endphp
                    @if(count($selectedAlbumIds))
                        <ul class="space-y-2 max-h-96 overflow-y-auto border rounded p-2 bg-white">
                            @foreach($selectedAlbumIds as $albumId)
                                @php
                                    $album = \App\Models\Album::find($albumId);
                                @endphp
                                @if($album)
                                    <li class="flex items-center gap-2 border-b pb-2 last:border-b-0">
                                        <img src="{{ asset('storage/' . $album->cover_image) }}"
                                             alt="{{ $album->title }}" class="w-12 h-12 object-cover rounded">
                                        <div class="flex-grow">
                                            <div class="font-semibold truncate max-w-[140px]">{{ $album->title }}</div>
                                            <div class="text-xs text-gray-600 truncate max-w-[140px]">Artista: {{ $album->artist->name }}</div>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-600">No has seleccionado álbumes aún.</p>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary mt-auto">Guardar Lista</button>
            </form>
        </section>

        <section class="w-2/3 flex flex-col">
            <h2 class="text-xl font-semibold mb-4">Buscar Álbumes para añadir</h2>

            <form method="GET" action="{{ route('lists.create') }}" class="flex gap-2 mb-4">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Buscar álbum por título..."
                       class="input input-bordered flex-grow">
                <button type="submit" class="btn btn-primary">Buscar</button>
                <a href="{{ route('lists.create') }}" class="btn btn-secondary">Limpiar</a>
            </form>

            @if(isset($albums) && $albums->count())
                <form method="POST" action="{{ route('lists.store') }}" class="grid grid-cols-3 gap-6 overflow-y-auto max-h-[600px]">
                    @csrf
                    <input type="hidden" name="title" value="{{ old('title') }}">
                    <input type="hidden" name="description" value="{{ old('description') }}">
                    @foreach($albums as $album)
                        <div class="border rounded p-3 flex flex-col items-center bg-white shadow-sm">
                            <img src="{{ asset('storage/' . $album->cover_image) }}" alt="{{ $album->title }}"
                                 class="w-28 h-28 object-cover rounded mb-2">
                            <div class="font-semibold text-center truncate w-full mb-1">{{ $album->title }}</div>

                            <label class="flex items-center gap-2 text-sm">
                                <input type="checkbox" name="albums[]" value="{{ $album->id }}"
                                    {{ in_array($album->id, old('albums', [])) ? 'checked' : '' }}>
                                Seleccionar
                            </label>
                        </div>
                    @endforeach
                    <div class="col-span-3 mt-4">
                        <button type="submit" class="btn btn-primary w-full">Guardar Lista con Seleccionados</button>
                    </div>
                </form>
            @elseif(request()->has('search'))
                <p>No se encontraron álbumes para "{{ request('search') }}"</p>
            @endif
        </section>
    </div>
</x-layouts.layout>
