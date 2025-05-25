<x-layouts.layout titulo="{{ __('Overtune - Gestión de Noticias') }}">
    <div class="min-h-screen flex flex-col">
        @if (session('mensaje'))
            <div id="message" role="alert" class="alert alert-success">
                <span>{{ session('mensaje') }}</span>
            </div>
        @endif

        <div class="p-4 flex justify-between items-center">
            <div class="space-x-4">
                <a class="btn btn-primary text-lg" href="{{ route('news.create') }}">
                    {{ __('Nueva Noticia') }}
                </a>
                <a class="btn btn-secondary text-lg" href="{{ route('user.profile') }}">
                    {{ __('Volver') }}
                </a>
            </div>

            <form method="GET" action="{{ route('news.crud') }}">
                <div class="flex items-center space-x-2">
                    <label for="category" class="font-semibold">{{ __('Filtrar por categoría') }}</label>
                    <select name="category" id="category" class="input input-bordered">
                        <option value="">{{ __('Todas') }}</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->category }}" {{ request('category') == $cat->category ? 'selected' : '' }}>
                                {{ $cat->category }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-outline btn-info">{{ __('Filtrar') }}</button>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto p-4 flex-grow">
            <table class="table-auto w-full border-collapse border border-gray-300 text-base">
                <thead class="bg-indigo-400 text-xl font-bold">
                <tr>
                    <th class="border p-2">{{ __('ID') }}</th>
                    <th class="border p-2">{{ __('Título') }}</th>
                    <th class="border p-2">{{ __('Categoría') }}</th>
                    <th class="border p-2">{{ __('Creado') }}</th>
                    <th class="border p-2">{{ __('Acciones') }}</th>
                </tr>
                </thead>
                <tbody class="bg-white">
                @foreach($news as $item)
                    <tr class="hover:bg-gray-100">
                        <td class="border p-2">{{ $item->id }}</td>
                        <td class="border p-2">{{ $item->title }}</td>
                        <td class="border p-2">{{ $item->category->category }}</td>
                        <td class="border p-2">{{ $item->created_at->format('Y-m-d') }}</td>
                        <td class="border p-2 flex space-x-2">
                            <a href="{{ route('news.edit', $item) }}" class="text-orange-600 hover:text-orange-800">
                                ✏️
                            </a>
                            <form id="delete{{ $item->id }}" action="{{ route('news.destroy', $item) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="button" onclick="confirmDelete({{ $item->id }})" class="text-red-600 hover:text-red-800">
                                    🗑️
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $news->appends(request()->query())->onEachSide(1)->links('components.pagination') }}
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: "{{ __('¿Confirmar borrado?') }}",
                text: "{{ __('Esta acción no se puede deshacer') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "{{ __('Sí, borrar') }}",
                cancelButtonText: "{{ __('Cancelar') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("delete" + id).submit();
                }
            });
        }

        setTimeout(() => {
            const msg = document.getElementById('message');
            if (msg) {
                msg.style.transition = 'opacity 0.5s ease';
                msg.style.opacity = '0';
                setTimeout(() => msg.remove(), 500);
            }
        }, 5000);
    </script>
</x-layouts.layout>

