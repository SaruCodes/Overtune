<x-layouts.layout titulo="Detalles de la Lista">
    <div class="max-w-3xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">{{ $list->title }}</h1>

        <p class="mb-6 whitespace-pre-line">{{ $list->description ?? 'Sin descripción' }}</p>

        <p class="mb-4 text-sm text-gray-600">
            Creada por: <strong>{{ $list->user->name ?? 'Desconocido' }}</strong>
        </p>

        <h2 class="text-xl font-semibold mb-3">Álbumes en esta lista</h2>

        @if($list->albums->isEmpty())
            <p>No hay álbumes en esta lista.</p>
        @else
            <ul class="list-disc list-inside space-y-1">
                @foreach($list->albums as $album)
                    <li>
                        <strong>{{ $album->title }}</strong> — {{ $album->artist ?? 'Artista desconocido' }}
                    </li>
                @endforeach
            </ul>
        @endif

        <a href="{{ route('lists.index') }}" class="btn btn-link mt-6 inline-block">Volver a todas las listas</a>
    </div>
</x-layouts.layout>
