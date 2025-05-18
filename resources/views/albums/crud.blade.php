<x-layouts.layout titulo="Gestión de Álbumes">
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6">Álbumes</h1>

        <a href="{{ route('albums.create') }}" class="btn btn-primary mb-4">Nuevo Álbum</a>

        <table class="table w-full bg-white shadow-md">
            <thead>
            <tr>
                <th>Título</th>
                <th>Artista</th>
                <th>Fecha</th>
                <th>Género/s</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($albums as $album)
                <tr>
                    <td>{{ $album->title }}</td>
                    <td>{{ $album->artist->name }}</td>
                    <td>{{ $album->release_date }}</td>
                    <td>
                        @foreach ($album->genres as $genre)
                            <span class="badge badge-info mr-1">{{ $genre->genre }}</span>
                        @endforeach
                    </td>
                    <td class="space-x-2">
                        <a href="{{ route('albums.show', $album) }}" class="btn btn-sm btn-outline">Ver</a>
                        <a href="{{ route('albums.edit', $album) }}" class="btn btn-sm btn-outline">Editar</a>
                        <form action="{{ route('albums.destroy', $album) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-error" onclick="return confirm('¿Eliminar álbum?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $albums->links() }}
        </div>
    </div>
</x-layouts.layout>
