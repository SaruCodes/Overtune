<x-layouts.layout titulo="Editar Perfil - Overtune">
    <div class="container mx-auto my-8">
        <div class="card bg-white shadow-md w-full max-w-lg mx-auto">
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
                        <label>Avatar</label>
                        <input type="file" name="avatar">
                    </div>

                    <div class="flex justify-end mt-6 space-x-2">
                        <a href="{{ route('user.profile') }}" class="btn btn-secondary">{{ __('Volver') }}</a>
                        <button type="submit" class="btn btn-primary">{{ __('Actualizar Perfil') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.layout>
