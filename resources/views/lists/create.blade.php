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

                <div class="mb-4 flex flex-col">
                    <label class="block text-sm font-medium mb-1" for="description">Descripción</label>
                    <textarea name="description" id="description" rows="4" class="textarea textarea-bordered w-full">{{ old('description') }}</textarea>
                </div>

                <!--Álbumes añadidos-->
                <div class="mb-4">
                    <h2 class="text-lg font-semibold mb-2">Álbumes añadidos</h2>

                    @php
                        $selectedAlbumIds = old('albums', session('selected_albums', []));
                    @endphp

                    @if(count($selectedAlbumIds) > 0)
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
                                        <form action="{{ route('lists.removeAlbumTemp') }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="album_id" value="{{ $album->id }}">
                                            <button type="submit" class="btn btn-xs btn-error px-2 py-1">Eliminar</button>
                                        </form>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-600">No has añadido álbumes aún.</p>
                    @endif
                </div>
                @foreach ($selectedAlbumIds as $albumId)
                    <input type="hidden" name="albums[]" value="{{ $albumId }}">
                @endforeach

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

            <div class="grid grid-cols-3 gap-6 overflow-y-auto max-h-[600px]">
                @if(isset($albums) && $albums->count())
                    @foreach($albums as $album)
                        @php
                            $alreadyAdded = in_array($album->id, $selectedAlbumIds);
                        @endphp
                        <div class="border rounded p-3 flex flex-col items-center bg-white shadow-sm">
                            <img src="{{ asset('storage/' . $album->cover_image) }}" alt="{{ $album->title }}"
                                 class="w-28 h-28 object-cover rounded mb-2">
                            <div class="font-semibold text-center truncate w-full mb-1">{{ $album->title }}</div>

                            @if($alreadyAdded)
                                <button disabled class="btn btn-sm btn-success w-full">Añadido</button>
                            @else
                                <form method="POST" action="{{ route('lists.addAlbumTemp') }}" class="w-full">
                                    @csrf
                                    <input type="hidden" name="album_id" value="{{ $album->id }}">
                                    <button type="submit" class="btn btn-sm btn-primary w-full">Añadir</button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                @elseif(request()->has('search'))
                    <p>No se encontraron álbumes para "{{ request('search') }}"</p>
                @endif
            </div>
        </section>
    </div>
</x-layouts.layout>
