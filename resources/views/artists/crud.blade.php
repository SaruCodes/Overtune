<x-layouts.layout titulo="{{ __('Overtune - Gestión de Artistas') }}">
    <div class="min-h-screen flex flex-col">
        @if (session('mensaje'))
            <div id="message" role="alert" class="alert alert-success">
                <!-- icono -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('mensaje') }}</span>
            </div>
        @endif

        <div class="p-4 bg-gray-200 flex justify-between items-center">
            <div class="space-x-4">
                <a class="btn btn-primary text-lg" href="{{ route('artists.create') }}">
                    {{ __('Nuevo Artista') }}
                </a>
                <a class="btn btn-secondary text-lg" href="{{ route('user.profile') }}">
                    {{ __('Volver') }}
                </a>
            </div>

            <!-- Filtro por debut -->
            <form method="GET" action="{{ route('artists.crud') }}">
                <div class="flex items-center space-x-2">
                    <label for="debut" class="font-semibold">{{ __('Filtrar por debut') }}</label>
                    <input type="number" name="debut" id="debut" placeholder="Ej: 2010" value="{{ request('debut') }}" class="input input-bordered w-24" />
                    <button type="submit" class="btn btn-outline btn-info">{{ __('Filtrar') }}</button>
                </div>
            </form>
        </div>

        <div class="max-h-full overflow-x-auto p-4 flex-grow">
            <table class="table-auto w-full border-collapse border border-gray-300 text-base text-gray-800">
                <thead class="bg-indigo-400 text-xl font-bold">
                <tr>
                    <th class="border border-gray-400 p-2">{{ __('ID') }}</th>
                    <th class="border border-gray-400 p-2">{{ __('Nombre') }}</th>
                    <th class="border border-gray-400 p-2">{{ __('Debut') }}</th>
                    <th class="border border-gray-400 p-2">{{ __('Creado') }}</th>
                    <th class="border border-gray-400 p-2">{{ __('Editar') }}</th>
                    <th class="border border-gray-400 p-2">{{ __('Acciones') }}</th>
                </tr>
                </thead>
                <tbody class="bg-white">
                @foreach($artists as $artist)
                    <tr class="border border-gray-300 hover:bg-gray-100">
                        <td class="border border-gray-300 p-3">{{ $artist->id }}</td>
                        <td class="border border-gray-300 p-3">{{ $artist->name }}</td>
                        <td class="border border-gray-300 p-3">{{ $artist->debut ?? '-' }}</td>
                        <td class="border border-gray-300 p-3">{{ $artist->created_at->format('Y-m-d') }}</td>
                        <td class="border border-gray-300 p-3">
                            <a href="#" onclick="confirmEdit({{ $artist->id }})">
                                <!-- icono lápiz -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="hover:text-orange-600 w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                </svg>
                            </a>
                        </td>
                        <td class="border border-gray-300 p-3 flex space-x-2">
                            <form id="formulario{{ $artist->id }}" action="{{ route('artists.destroy', $artist) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="button" onclick="confirmDelete({{ $artist->id }})" class="text-red-600 hover:text-red-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9M4.772 5.79a48.108 48.108 0 013.478-.397m7.5 0a48.11 48.11 0 013.478.397M18 14v4.75A2.25 2.25 0 0115.75 21H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79" />
                                    </svg>
                                </button>
                            </form>
                            <a href="{{ route('artists.show', $artist) }}" class="text-blue-600 font-bold hover:text-blue-800">
                                {{ __('Ver') }}
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $artists->appends(request()->query())->onEachSide(1)->links('components.pagination') }}
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
                confirmButtonColor: "#783F8E",
                cancelButtonColor: "#f18701",
                confirmButtonText: "{{ __('Sí, borrar') }}",
                cancelButtonText: "{{ __('Cancelar') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("formulario" + id).submit();
                }
            });
        }

        function confirmEdit(id) {
            Swal.fire({
                title: "{{ __('¿Seguro que quiere editar?') }}",
                text: "{{ __('Va a editar un artista') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#783F8E",
                cancelButtonColor: "#f18701",
                confirmButtonText: "{{ __('Sí, editar') }}",
                cancelButtonText: "{{ __('Cancelar') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/artists/${id}/edit`;
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
