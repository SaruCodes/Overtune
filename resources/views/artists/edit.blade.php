<x-layouts.layout titulo="{{ __('Overtune - Editar Artista') }}">
    <div class="flex flex-col md:flex-row justify-center items-start gap-10 min-h-screen bg-main py-12 px-6">
        {{-- Información Actual --}}
        <div class="bg-base-100 rounded-lg shadow-md p-6 w-full md:w-1/2">
            <h2 class="text-xl font-semibold text-primary mb-4">{{ __('Información actual') }}</h2>

            <p><strong class="text-text-dark">Nombre:</strong> {{ $artist->name }}</p>
            <p><strong class="text-text-dark">País:</strong> {{ $artist->country ?? '—' }}</p>
            <p><strong class="text-text-dark">Año de Debut:</strong> {{ $artist->debut ?? '—' }}</p>
            <p><strong class="text-text-dark">Biografía:</strong></p>
            <p class="whitespace-pre-line mb-4">{{ $artist->bio ?? '—' }}</p>

            @if ($artist->image)
                <img src="{{ asset('storage/' . $artist->image) }}" alt="Imagen del artista" class="rounded-md mt-4 w-full max-w-xs">
            @endif
        </div>

        {{-- Formulario de Edición --}}
        <div class="bg-base-100 rounded-lg shadow-md p-6 w-full md:w-1/2">
            <form action="{{ route('artists.update', $artist) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <h1 class="text-2xl font-semibold text-primary mb-6 text-center">{{ __('Editar Artista') }}</h1>

                <div class="mb-4">
                    <x-input-label for="name" value="{{ __('Nombre') }}" class="text-text-dark" />
                    <x-text-input id="name" name="name" type="text"
                                  value="{{ old('name', $artist->name) }}"
                                  class="block mt-1 w-full" required />
                    @error('name') <p class="text-error text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <x-input-label for="country" value="{{ __('País') }}" class="text-text-dark" />
                    <x-text-input id="country" name="country" type="text"
                                  value="{{ old('country', $artist->country) }}"
                                  class="block mt-1 w-full" />
                </div>

                <div class="mb-4">
                    <x-input-label for="debut" value="{{ __('Año de Debut') }}" class="text-text-dark" />
                    <select id="debut" name="debut" class="w-full mt-1 p-2 border border-gray-300 rounded-md">
                        <option value="">-- Selecciona un año --</option>
                        @for ($year = 2025; $year >= 1910; $year--)
                            <option value="{{ $year }}" {{ (old('debut', $artist->debut) == $year) ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                    @error('debut') <p class="text-error text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <x-input-label for="bio" value="{{ __('Biografía') }}" class="text-text-dark" />
                    <textarea id="bio" name="bio" rows="4"
                              class="w-full mt-1 p-2 border border-gray-300 rounded-md">{{ old('bio', $artist->bio) }}</textarea>
                </div>

                <div class="mb-4">
                    <x-input-label for="image" value="{{ __('Imagen') }}" class="text-text-dark" />
                    <div class="flex flex-col items-center gap-4">
                        <input type="file" name="image" id="image" class="file-input file-input-bordered w-full">
                    </div>
                    @error('image') <p class="text-error text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('artists.crud') }}" class="btn btn-secondary">{{ __('Cancelar') }}</a>
                    <button type="submit" class="btn btn-primary">{{ __('Guardar Cambios') }}</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.layout>
