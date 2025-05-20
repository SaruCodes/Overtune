<x-layouts.layout titulo="Perfil de Usuario - Overtune">
    <div class="card bg-white shadow-md w-full max-w-lg mx-auto">
        <div class="card-body text-center relative">
            <div class="avatar mx-auto">
                <div class="w-24 rounded-full">
                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://img.daisyui.com/images/profile/demo/yellingcat@192.webp' }}" />
                </div>
            </div>
            <h2 class="card-title text-2xl font-bold mt-4">{{ auth()->user()->name }}</h2>
            <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
            <p class="text-md text-gray-700 mt-2">{{ auth()->user()->bio }}</p>

            <div class="card-actions justify-center mt-4 space-x-2">
                <a href="{{ route('user.edit') }}" class="btn btn-primary btn-sm">{{ __('Editar Perfil') }}</a>

                <a href="{{ route('review.crud') }}" class="btn btn-outline btn-secondary btn-sm">
                    {{ __('Mis Reseñas') }}
                </a>
            </div>
        </div>
    </div>

    @php
        $user = auth()->user();
    @endphp

    @if ($user->isAdmin() || $user->isEditor())
        <div class="mt-12">
            <h3 class="text-xl font-semibold mb-4">{{ __('Gestión de Contenido') }}</h3>
            <div class="grid grid-cols-2 gap-8">
                <div class="card bg-gray-100 shadow-xl">
                    <div class="card-body text-center">
                        <h4 class="text-lg font-semibold">{{ __('Gestión de Artistas') }}</h4>
                        <a href="{{ route('artists.crud') }}" class="btn btn-outline btn-primary">{{ __('Acceder') }}</a>
                    </div>
                </div>
                <div class="card bg-gray-100 shadow-xl">
                    <div class="card-body text-center">
                        <h4 class="text-lg font-semibold">{{ __('Gestión de Álbumes') }}</h4>
                        <a href="{{ route('albums.crud') }}" class="btn btn-outline btn-primary">{{ __('Acceder') }}</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-layouts.layout>
