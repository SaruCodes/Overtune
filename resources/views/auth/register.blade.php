<x-layouts.layout titulo="Overtune - Register">
    <div class="relative flex flex-col justify-center items-center min-h-screen bg-gray-300 text-gray-900"
         style="background: url('{{ asset('images/tunel.jpg') }}') center/cover no-repeat;">
        <div class="absolute inset-0 bg-purple-950 bg-opacity-50"></div>

        <!-- Contenedor del formulario -->
        <div class="relative bg-white bg-opacity-90 rounded-2xl p-6 shadow-lg w-full max-w-md">
            <h1 class="text-violet-900 font-bold text-2xl text-center">{{__('¡Únete a Overtune!')}}</h1>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mt-4">
                    <x-input-label for="name" :value="__('Nombre')" class="text-gray-900 font-bold" />
                    <x-text-input id="name" class="block mt-1 w-full text-gray-900 placeholder-gray-800 border-gray-600"
                                  type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-700" />
                </div>

                <div class="mt-4">
                    <x-input-label for="email" :value="__('Correo Electrónico')" class="text-gray-900 font-bold" />
                    <x-text-input id="email" class="block mt-1 w-full text-gray-900 placeholder-gray-800 border-gray-600"
                                  type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-700" />
                </div>

                <div class="mt-4">
                    <x-input-label for="password" :value="__('Contraseña')" class="text-gray-900 font-bold" />
                    <x-text-input id="password" class="block mt-1 w-full text-gray-900 placeholder-gray-800 border-gray-600"
                                  type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-700" />
                </div>

                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" class="text-gray-900 font-bold" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full text-gray-900 placeholder-gray-800 border-gray-600"
                                  type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-700" />
                </div>

                <div class="flex items-center justify-between mt-4">
                    <a class="underline text-sm text-gray-800 hover:text-gray-900" href="{{ route('login') }}">
                        {{ __('¿Ya tienes cuenta? Inicia sesión') }}
                    </a>

                    <x-primary-button class="bg-violet-700 hover:bg-violet-800 text-white px-4 py-2 rounded-md">
                        {{ __('Registrarse') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.layout>
