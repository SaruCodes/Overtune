<x-layouts.layout titulo="Detalles de la Lista">
    <div class="max-w-4xl mx-auto p-6 bg-white rounded shadow mt-12 mb-8">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-3xl font-bold flex items-center gap-3">
                    {{ $list->title }}
                @auth
                    <form action="{{ route('favorite.toggle', ['type' => 'list', 'id' => $list->id]) }}" method="POST">
                    @csrf
                        <button type="submit" class="text-red-500 hover:text-red-600">
                            @if(auth()->user()?->favorites()->where('favoritable_type', \App\Models\ListModel::class)->where('favoritable_id', $list->id)->exists())
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="size-[1.2em]" viewBox="0 0 24 24">
                                    <path d="M12 21s-9-4.78-9-12a4.5 4.5 0 014.688-4.5c1.935 0 3.597 1.126 4.312 2.733C12.715 5.876 14.377 4.75 16.313 4.75A4.5 4.5 0 0121 8.25c0 7.22-9 12-9 12z"/>
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="size-[1.2em]" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                </svg>
                            @endif
                        </button>
                    </form>
                @endauth
                <a href="{{ route('lists.index') }}"
                   class="bg-accent hover:bg-orange-700 text-white text-sm py-2 px-4 rounded">
                    ← Volver
                </a>
                <div class="flex space-x-3">

                @auth
                    @if(auth()->id() === $list->user_id)
                        <a href="{{ route('lists.edit', $list->id) }}" title="Editar lista" class="text-blue-600 hover:text-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="hover:text-darkblue-600 w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><
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
                @endif
            @endauth
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
