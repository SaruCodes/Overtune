<x-layouts.layout titulo="{{ __('Overtune - Editar Álbum') }}">
    <div class="flex flex-col md:flex-row justify-center items-start gap-10 min-h-screen bg-main py-12 px-6">

        <div class="bg-purple-100 rounded-lg shadow-md p-6 w-full md:w-1/2">
            <h2 class="text-xl font-semibold text-primary mb-4">{{ __('Información actual') }}</h2>

            <p><strong class="text-text-dark">{{ __('Título') }}:</strong> {{ $album->title }}</p>
            <p><strong class="text-text-dark">{{ __('Artista') }}:</strong> {{ $album->artist->name }}</p>
            <p><strong class="text-text-dark">{{ __('Fecha de Lanzamiento') }}:</strong> {{ $album->release_date->format('Y-m-d') }}</p>
            <p><strong class="text-text-dark">{{ __('Tipo') }}:</strong> {{ $album->type }}</p>
            <p><strong class="text-text-dark">{{ __('Descripción') }}:</strong></p>
            <p class="whitespace-pre-line mb-4">{{ $album->description ?? '—' }}</p>

            @if ($album->cover_image)
                <img src="{{ asset('storage/' . $album->cover_image) }}" alt="Portada del álbum" class="rounded-md mt-4 w-full max-w-xs">
            @endif
        </div>

        <div class="bg-base-100 rounded-lg shadow-md p-6 w-full md:w-1/2">
            <form action="{{ route('albums.update', $album) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <h1 class="text-2xl font-semibold text-primary mb-6 text-center">{{ __('Editar Álbum') }}</h1>

                <div class="mb-4">
                    <x-input-label for="title" value="{{ __('Título') }}" class="text-text-dark" />
                    <x-text-input id="title" name="title" type="text"
                                  value="{{ old('title', $album->title) }}"
                                  class="block mt-1 w-full" required />
                    @error('title') <p class="text-error text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <x-input-label for="artist_id" value="{{ __('Artista') }}" class="text-text-dark" />
                    <select id="artist_id" name="artist_id" class="w-full mt-1 p-2 border border-gray-300 rounded-md" required>
                        <option value="">{{ __('Seleccione un artista') }}</option>
                        @foreach($artists as $artist)
                            <option value="{{ $artist->id }}" {{ old('artist_id', $album->artist_id) == $artist->id ? 'selected' : '' }}>
                                {{ $artist->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('artist_id') <p class="text-error text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <x-input-label for="release_date" value="{{ __('Fecha de Lanzamiento') }}" class="text-text-dark" />
                    <x-text-input id="release_date" name="release_date" type="date"
                                  value="{{ old('release_date', $album->release_date->format('Y-m-d')) }}"
                                  class="block mt-1 w-full" required />
                    @error('release_date') <p class="text-error text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <x-input-label for="type" value="{{ __('Tipo') }}" class="text-text-dark" />
                    <select id="type" name="type" class="w-full mt-1 p-2 border border-gray-300 rounded-md" required>
                        @foreach(['Album', 'EP', 'Single'] as $type)
                            <option value="{{ $type }}" {{ old('type', $album->type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('type') <p class="text-error text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <x-input-label for="description" value="{{ __('Descripción') }}" class="text-text-dark" />
                    <textarea id="description" name="description" rows="4"
                              class="w-full mt-1 p-2 border border-gray-300 rounded-md">{{ old('description', $album->description) }}</textarea>
                    @error('description') <p class="text-error text-sm">{{ $message }}</p> @enderror
                </div>

                {{-- NUEVO: Géneros --}}
                <div class="mb-4">
                    <x-input-label value="{{ __('Géneros') }}" class="text-text-dark" />
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2 mt-1">
                        @foreach ($genres as $genre)
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" name="genres[]" value="{{ $genre->id }}"
                                       class="checkbox checkbox-primary checkbox-sm"
                                    {{ (collect(old('genres', $album->genres->pluck('id')->toArray()))->contains($genre->id)) ? 'checked' : '' }}>
                                <span>{{ $genre->genre }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('genres') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <x-input-label for="cover_image" value="{{ __('Imagen de Portada') }}" class="text-text-dark" />
                    <input type="file" name="cover_image" id="cover_image" class="file-input file-input-bordered w-full" />
                    @error('cover_image') <p class="text-error text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('albums.crud') }}" class="btn btn-secondary">{{ __('Cancelar') }}</a>
                    <button type="submit" class="btn btn-primary">{{ __('Guardar Cambios') }}</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.layout>
