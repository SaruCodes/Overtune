<x-layouts.layout titulo="{{ __('Overtune - ') . $artist->name }}">

    <div class="text-center mb-6 mt-12 mx-8">
        <h1 class="text-4xl font-bold text-violet-900">{{ __('Detalles del Artista') }}</h1>
        <p class="text-xl text-gray-600">{{ __('ID del artista: ') }}<strong>{{ $artist->id }}</strong></p>
    </div>

    <!-- Imagen del artista -->
    <div class="text-center mb-8">
        @if ($artist->image)
            <img src="{{ asset('storage/' . $artist->image) }}" alt="Imagen del Artista" class="mx-auto w-64 h-64 object-cover rounded-lg shadow-md border-4 border-gray-300">
        @else
            <p class="text-gray-500">{{ __('No hay imagen disponible') }}</p>
        @endif
    </div>

    <!-- Detalles del artista -->
    <div class="text-center mb-6 mx-8">
        <h3 class="text-2xl font-semibold text-gray-800 mb-2">{{ $artist->name }}</h3>
        <p><strong>{{ __('País:') }}</strong> {{ $artist->country ?? __('No especificado') }}</p>
        <p><strong>{{ __('Debut:') }}</strong> {{ $artist->debut ?? __('No especificado') }}</p>
        <p class="mt-4"><strong>{{ __('Biografía:') }}</strong></p>
        <p class="text-gray-700 mt-1 whitespace-pre-line">{{ $artist->bio ?? __('No disponible') }}</p>
    </div>

    <div class="text-center my-6">
        <a href="{{ route('artists.crud') }}" class="btn btn-secondary">
            {{ __('Volver a la lista') }}
        </a>s
    </div>

</x-layouts.layout>
