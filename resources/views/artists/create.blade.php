<x-layouts.layout titulo="{{ __('Overtune - Nuevo Artista') }}">
    <div class="flex flex-col justify-center items-center min-h-screen bg-main py-12">
        <form action="{{ route('artists.store') }}" method="POST" enctype="multipart/form-data"
              class="w-full max-w-md bg-base-100 shadow-lg rounded-lg p-8">
            @csrf

            <h1 class="text-2xl font-semibold text-primary mb-6 text-center">
                {{ __('Nuevo Artista') }}
            </h1>

            <div class="mb-4">
                <x-input-label for="name" value="{{ __('Nombre') }}" class="text-text-dark" />
                <x-text-input id="name" name="name" type="text" value="{{ old('name') }}" class="block mt-1 w-full" required />
                @error('name') <p class="text-error text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <x-input-label for="country" value="{{ __('País') }}" class="text-text-dark" />
                <x-text-input id="country" name="country" type="text" value="{{ old('country') }}" class="block mt-1 w-full" />
            </div>

            <div class="mb-4">
                <x-input-label for="debut" value="{{ __('Año de Debut') }}" class="text-text-dark" />
                <select id="debut" name="debut" class="w-full mt-1 p-2 border border-gray-300 rounded-md" required>
                    <option value="">-- Selecciona un año --</option>
                    @for ($year = 2025; $year >= 1910; $year--)
                        <option value="{{ $year }}" {{ old('debut') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endfor
                </select>
                @error('debut') <p class="text-error text-sm">{{ $message }}</p> @enderror
            </div>


            <div class="mb-4">
                <x-input-label for="bio" value="{{ __('Biografía') }}" class="text-text-dark" />
                <textarea id="bio" name="bio" class="w-full mt-1 p-2 border border-gray-300 rounded-md" rows="4">{{ old('bio') }}</textarea>
            </div>

            <div class="mb-4">
                <x-input-label for="image" value="{{ __('Imagen') }}" class="text-text-dark" />
                <div class="flex flex-col items-center gap-4">
                    <input type="file" name="image" id="image" class="file-input file-input-bordered w-full">
                </div>
                @error('image') <p class="text-error text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('artists.index') }}" class="btn btn-secondary">
                    {{ __('Cancelar') }}
                </a>
                <button type="submit" class="btn btn-primary">
                    {{ __('Guardar') }}
                </button>
            </div>
        </form>
    </div>
</x-layouts.layout>
