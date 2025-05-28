<x-layouts.layout titulo="Detalles de la Lista">
    <div class="max-w-4xl mx-auto p-6 bg-white rounded shadow mt-12 mb-8">

        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold">{{ $list->title }}</h1>

            <div class="flex space-x-3">

                <a href="{{ route('lists.edit', $list->id) }}" title="Editar lista" class="text-blue-600 hover:text-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="hover:text-darkblue-600 w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                    </svg>
                </a>

                <form id="deleteForm" action="{{ route('lists.destroy', $list->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" title="Eliminar lista" class="text-red-600 hover:text-red-800 focus:outline-none" onclick="confirmDelete()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9M4.772 5.79a48.108 48.108 0 013.478-.397m7.5 0a48.11 48.11 0 013.478.397M18 14v4.75A2.25 2.25 0 0115.75 21H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        @if($list->description)
            <p class="mb-4 text-gray-700">{{ $list->description }}</p>
        @endif

        <p class="mb-6 text-sm text-gray-500">Creada por: <strong class="text-primary">{{ $list->user->name ?? 'Desconocido' }}</strong></p>

        <h2 class="text-xl font-semibold mb-3">Álbumes en esta lista</h2>

        @if($list->albums->isEmpty())
            <p>No hay álbumes en esta lista.</p>
        @else
            <div class="grid grid-cols-4 gap-4">
                @foreach($list->albums as $album)
                    <a href="{{ route('albums.show', $album->id) }}"
                       class="group relative block rounded overflow-hidden shadow hover:shadow-md transition-all duration-300">
                        <div class="aspect-square w-16 h-16 overflow-hidden mt-8 mx-auto">
                            <img src="{{ asset('storage/' . $album->cover_image) }}" alt="{{ $album->title }}" class="w-16 h-16 object-cover rounded mb-2 group-hover:scale-105" loading="lazy"/>
                        </div>
                        <div class="font-semibold text-center text-sm truncate w-full mb-1">{{ $album->title }}</div>
                        <div class="text-xs text-gray-500 truncate w-full mb-2">{{ $album->artist->name }}</div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        function confirmDelete() {
            Swal.fire({
                title: '¿Confirmar borrado?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#783F8E",
                cancelButtonColor: "#f18701",
                confirmButtonText: 'Sí, borrar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm').submit();
                }
            });
        }
    </script>
</x-layouts.layout>
