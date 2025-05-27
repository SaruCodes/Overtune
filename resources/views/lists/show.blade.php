<x-layouts.layout titulo="Detalles de la Lista">
        <div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">

            <div class="flex justify-between items-center mb-4">
                <h1 class="text-3xl font-bold">{{ $list->title }}</h1>

                <div class="flex space-x-3">

                    <a href="{{ route('lists.edit', $list->id) }}" title="Editar lista" class="text-blue-600 hover:text-blue-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17h2m2-12h-6a2 2 0 00-2 2v12a2 2 0 002 2h6a2 2 0 002-2v-6l-6-6z" />
                        </svg>
                    </a>

                    <form action="{{ route('lists.destroy', $list->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar esta lista?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Eliminar lista" class="text-red-600 hover:text-red-800 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            @if($list->description)
                <p class="mb-4 text-gray-700">{{ $list->description }}</p>
            @endif

            <p class="mb-6 text-sm text-gray-500">Creada por: <strong>{{ $list->user->name ?? 'Desconocido' }}</strong></p>

            <h2 class="text-xl font-semibold mb-3">Álbumes en esta lista</h2

            @if($list->albums->isEmpty())
                <p>No hay álbumes en esta lista.</p>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                    @foreach($list->albums as $album)
                        <a href="{{ route('albums.show', $album->id) }}" class="group block bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                            <img
                                src="{{ asset('storage/' . $album->cover_image) }}"
                                alt="{{ $album->title }}"
                                class="w-full h-48 object-cover group-hover:scale-105 transform transition-transform duration-300"
                                loading="lazy"
                            />
                            <div class="p-3 text-center">
                                <h3 class="text-md font-semibold text-gray-900 truncate">{{ $album->title }}</h3>
                                <p class="text-sm text-gray-600 truncate">{{ $album->artist ?? 'Artista desconocido' }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
</x-layouts.layout>
