<x-layouts.layout titulo="Editar Perfil - Overtune">
    <div class="container mx-auto my-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-5xl mx-auto">
            {{-- Formulario de perfil --}}
            <div class="card bg-white shadow-md w-full">
                <div class="card-body">
                    <h2 class="text-2xl font-bold mb-4">{{ __('Editar Perfil') }}</h2>
                    <form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-semibold">{{ __('Nombre') }}</label>
                            <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" class="input input-bordered w-full mt-2" required>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-semibold">{{ __('Email') }}</label>
                            <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" class="input input-bordered w-full mt-2" required>
                        </div>

                        <div class="mb-4">
                            <label for="bio" class="block text-sm font-semibold">{{ __('Bio') }}</label>
                            <textarea id="bio" name="bio" class="textarea textarea-bordered w-full mt-2">{{ auth()->user()->bio }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-semibold">{{ __('Avatar') }}</label>
                            <input type="file" name="avatar" class="mt-2">
                        </div>

                        <div class="flex justify-end mt-6 space-x-2">
                            <a href="{{ route('user.profile') }}" class="btn btn-secondary">{{ __('Volver') }}</a>
                            <button type="submit" class="btn btn-primary">{{ __('Actualizar Perfil') }}</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Formulario de contraseña --}}
            <div class="card bg-white shadow-md w-full">
                <div class="card-body">
                    <h3 class="text-2xl font-bold mb-4">{{ __('Cambiar Contraseña') }}</h3>
                    <form action="{{ route('user.update-password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="current_password" class="block text-sm font-semibold">{{ __('Contraseña actual') }}</label>
                            <input type="password" id="current_password" name="current_password" class="input input-bordered w-full mt-2" required>
                        </div>

                        <div class="mb-4">
                            <label for="new_password" class="block text-sm font-semibold">{{ __('Nueva contraseña') }}</label>
                            <input type="password" id="new_password" name="new_password" class="input input-bordered w-full mt-2" required>
                        </div>

                        <div class="mb-4">
                            <label for="new_password_confirmation" class="block text-sm font-semibold">{{ __('Confirmar nueva contraseña') }}</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="input input-bordered w-full mt-2" required>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit" class="btn btn-warning">{{ __('Actualizar Contraseña') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.layout>
<script>
    @if (session('status'))
    Swal.fire({
        icon: 'success',
        title: '¡Hecho!',
        text: "{{ session('status') }}",
        confirmButtonColor: '#6b21a8'
    });
    @endif

    @if ($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        html: `{!! implode('<br>', $errors->all()) !!}`,
        confirmButtonColor: '#6b21a8'
    });
    @endif
</script>
