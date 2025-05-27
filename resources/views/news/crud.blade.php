<x-layouts.layout titulo="{{ __('Overtune - Gestión de Noticias') }}">
    <div class="flex flex-col min-h-[80vh]">
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
                <thead class="bg-primary text-xl text-white font-bold">
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
                                <svg xmlns="http://www.w3.org/2000/svg" class="hover:text-orange-600 w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                </svg>
                            </a>
                            <form id="delete{{ $item->id }}" action="{{ route('news.destroy', $item) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="button" onclick="confirmDelete({{ $item->id }})" class="text-red-600 hover:text-red-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9M4.772 5.79a48.108 48.108 0 013.478-.397m7.5 0a48.11 48.11 0 013.478.397M18 14v4.75A2.25 2.25 0 0115.75 21H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79" />
                                    </svg>
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

