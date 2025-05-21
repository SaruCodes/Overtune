<x-layouts.layout titulo="Overtune - Gestión de Noticias">
    <div class="min-h-screen flex flex-col">
        @if (session('mensaje'))
            <div id="message" role="alert" class="alert alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('mensaje') }}</span>
            </div>
        @endif

        <div class="p-4 flex justify-between items-center">
            <div class="space-x-4">
                <a class="btn btn-primary text-lg" href="{{ route('news.create') }}">Nueva Noticia</a>
                <a class="btn btn-secondary text-lg" href="{{ route('user.profile') }}">Volver</a>
            </div>

            <form method="GET" action="{{ route('news.crud') }}">
                <div class="flex items-center space-x-2">
                    <label for="category" class="font-semibold">Categoría</label>
                    <select name="category" id="category" class="select select-bordered">
                        <option value="">Todas</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-outline btn-info">Filtrar</button>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto p-4 flex-grow">
            <table class="table w-full border border-gray-300 text-base">
                <thead class="bg-indigo-400 text-xl font-bold">
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Categoría</th>
                    <th>Creada</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="bg-white">
                @foreach($news as $n)
                    <tr class="border-b hover:bg-gray-100">
                        <td>{{ $n->id }}</td>
                        <td>{{ $n->title }}</td>
                        <td>{{ $n->category->name ?? '-' }}</td>
                        <td>{{ $n->created_at->format('Y-m-d') }}</td>
                        <td class="flex space-x-2">
                            <a href="{{ route('news.edit', $n) }}" class="text-blue-600 hover:text-blue-800">
                                ✏️
                            </a>
                            <form action="{{ route('news.destroy', $n) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Borrar esta noticia?')" class="text-red-600 hover:text-red-800">🗑️</button>
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
</x-layouts.layout>
