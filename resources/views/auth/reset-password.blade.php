<x-layouts.layout titulo="Overtune - Restablecer Contraseña">
    <div class="relative flex flex-col justify-center items-center min-h-screen bg-gray-300 text-gray-900"
         style="background: url('{{ asset('images/tunel.jpg') }}') center/cover no-repeat;">
        <div class="absolute inset-0 bg-purple-950 bg-opacity-50"></div>

        <div class="relative bg-white bg-opacity-90 rounded-2xl p-6 shadow-lg w-full max-w-md">
            <h1 class="text-violet-900 font-bold text-2xl text-center mb-4">{{ __('Restablecer contraseña') }}</h1>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="mb-4">
                    <x-input-label for="email" :value="__('Correo Electrónico')" class="text-gray-800 font-bold"/>
                    <x-text-input id="email" class="block mt-1 w-full"
                                  type="email" name="email" :value="old('email', $request->email)"
                                  required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="password" :value="__('Nueva Contraseña')" class="text-gray-800 font-bold"/>
                    <x-text-input id="password" class="block mt-1 w-full"
                                  type="password" name="password"
                                  required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" class="text-gray-800 font-bold"/>
                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                  type="password" name="password_confirmation"
                                  required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex justify-end">
                    <x-primary-button class="bg-purple-700 hover:bg-purple-800 text-white px-4 py-2 rounded-md">
                        {{ __('Guardar nueva contraseña') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.layout>
