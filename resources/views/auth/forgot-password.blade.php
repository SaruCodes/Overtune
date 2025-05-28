<x-layouts.layout titulo="Overtune - Recuperar Contraseña">
    <div class="relative flex flex-col justify-center items-center min-h-screen bg-gray-300 text-gray-900"
         style="background: url('{{ asset('images/tunel.jpg') }}') center/cover no-repeat;">
        <div class="absolute inset-0 bg-purple-950 bg-opacity-50"></div>

        <div class="relative bg-white bg-opacity-90 rounded-2xl p-6 shadow-lg w-full max-w-md">
            <h1 class="text-violet-900 font-bold text-2xl text-center mb-4">{{ __('¿Olvidaste tu contraseña?') }}</h1>
            <p class="text-sm text-gray-700 text-center mb-4">
                {{ __('Introduce tu dirección de correo electrónico y te enviaremos un enlace para restablecer tu contraseña.') }}
            </p>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-4">
                    <x-input-label for="email" :value="__('Correo Electrónico')" class="text-gray-800 font-bold"/>
                    <x-text-input id="email" class="block mt-1 w-full"
                                  type="email" name="email" :value="old('email')"
                                  required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">
                        {{ __('Volver al login') }}
                    </a>

                    <x-primary-button class="bg-purple-700 hover:bg-purple-800 text-white px-4 py-2 rounded-md">
                        {{ __('Enviar enlace') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.layout>
