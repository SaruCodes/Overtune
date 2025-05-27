<x-layouts.layout titulo="Nuevo Álbum">
    <div class="flex flex-col justify-center items-center min-h-screen py-12">
        <form action="{{ route('albums.store') }}" method="POST" enctype="multipart/form-data"
              class="w-full max-w-lg bg-white p-6 rounded shadow">
            @csrf
            <h1 class="text-2xl font-semibold mb-6 text-center">Crear Nuevo Álbum</h1>

            <div class="mb-4">
                <x-input-label for="title" value="Título" />
                <x-text-input id="title" name="title" type="text" value="{{ old('title') }}" required class="w-full" />
                @error('title') <p class="text-error text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <x-input-label for="artist_id" value="Artista" />
                <select id="artist_id" name="artist_id" required class="w-full p-2 border rounded">
                    @foreach ($artists as $artist)
                        <option value="{{ $artist->id }}" {{ old('artist_id') == $artist->id ? 'selected' : '' }}>
                            {{ $artist->name }}
                        </option>
                    @endforeach
                </select>
                @error('artist_id') <p class="text-error text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <x-input-label for="release_date" value="Fecha de lanzamiento" />
                <input type="date"
                       id="release_date"
                       name="release_date"
                       value="{{ old('release_date') }}"
                       class="w-full p-2 border rounded"
                       required>
                @error('release_date') <p class="text-error text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <x-input-label for="cover_image" value="Portada del álbum" />
                <input type="file" id="cover_image" name="cover_image" class="file-input file-input-bordered w-full">
                @error('cover_image') <p class="text-error text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <x-input-label for="description" value="Descripción" />
                <textarea id="description" name="description" rows="3" class="w-full p-2 border rounded">{{ old('description') }}</textarea>
                @error('description') <p class="text-error text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <x-input-label for="type" value="Tipo" />
                <select id="type" name="type" required class="w-full p-2 border rounded">
                    <option value="">-- Selecciona tipo --</option>
                    <option value="Album" {{ old('type') == 'Album' ? 'selected' : '' }}>Album</option>
                    <option value="EP" {{ old('type') == 'EP' ? 'selected' : '' }}>EP</option>
                    <option value="Single" {{ old('type') == 'Single' ? 'selected' : '' }}>Single</option>
                </select>
                @error('type') <p class="text-error text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <x-input-label value="Géneros" />
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                    @foreach ($genres as $genre)
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" name="genres[]" value="{{ $genre->id }}"
                                   {{ in_array($genre->id, old('genres', [])) ? 'checked' : '' }}
                                   class="checkbox checkbox-primary checkbox-sm">
                            <span>{{ $genre->genre }}</span>
                        </label>
                    @endforeach
                </div>
                @error('genres') <p class="text-error text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-4 mt-6">
                <a href="{{ route('albums.crud') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</x-layouts.layout>
