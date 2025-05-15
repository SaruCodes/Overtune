<x-layouts.layout titulo="Perfil de Usuario - Overtune">
    <div class="container mx-auto my-8">
        <!-- Tarjeta superior con información básica del usuario -->
        <div class="card bg-white shadow-md w-full max-w-lg mx-auto">
            <div class="card-body text-center">
                <div class="avatar">
                    <div class="w-24 rounded-full">
                        <img src="https://img.daisyui.com/images/profile/demo/yellingcat@192.webp" />
                    </div>
                </div>
                <h2 class="card-title text-2xl font-bold">{{ auth()->user()->name }}</h2>
                <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                <p class="text-md text-gray-700 mt-4">{{ auth()->user()->bio }}</p>
                <div class="card-actions justify-center mt-4">
                    <a href="{{ route('user.edit') }}" class="btn btn-primary">{{ __('Editar Perfil') }}</a>
                </div>
            </div>
        </div>

        <!-- Sección privada para editor y admin -->
        {{-- Sección privada para editor y admin --}}
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
                            <a href="{{ route('artists.index') }}" class="btn btn-outline btn-primary">{{ __('Acceder') }}</a>
                        </div>
                    </div>
                    <div class="card bg-gray-100 shadow-xl">
                        <div class="card-body text-center">
                            <h4 class="text-lg font-semibold">{{ __('Gestión de Álbumes') }}</h4>
                            <a href="" class="btn btn-outline btn-primary">{{ __('Acceder') }}</a>
                        </div>
                    </div>
                    <div class="card bg-gray-100 shadow-xl">
                        <div class="card-body text-center">
                            <h4 class="text-lg font-semibold">{{ __('Gestión de Noticias') }}</h4>
                            <a href="" class="btn btn-outline btn-primary">{{ __('Acceder') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layouts.layout>
