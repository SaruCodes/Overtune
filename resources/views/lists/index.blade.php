<x-layouts.layout titulo="Listas - Overtune">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex items-center justify-between flex-wrap mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Listas</h1>
            @auth()
            <a href="{{ route('lists.create') }}" class="btn btn-md btn-primary">+ Crear Lista</a>
            @endauth
        </div>

        <h2 class="text-xl font-semibold text-purple-800 mb-4 border-b-2 border-purple-700 pb-1">Más Populares</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($popularLists as $list)
                <div class="card bg-white shadow-md">
                    <div class="card-body">
                        <h3 class="font-semibold text-lg">{{ $list->title }}</h3>
                        <p class="text-sm text-gray-500">{{ Str::limit($list->description, 100) }}</p>
                        <p class="text-xs text-gray-400 mt-1">❤️ {{ $list->favorites_count }} favoritos</p>
                        <a href="{{ route('lists.show', $list->id) }}" class="btn btn-sm btn-outline btn-accent hover:text-white mt-2">Ver Lista</a>
                    </div>
                </div>
            @endforeach
        </div>


        <h2 class="text-xl font-semibold text-purple-800 mt-10 mb-4 border-b-2 border-purple-700 pb-1">Últimas Listas</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($latestLists as $list)
                <div class="card bg-white shadow-md">
                    <div class="card-body">
                        <h3 class="font-semibold text-lg">{{ $list->title }}</h3>
                        <p class="text-sm text-gray-500">{{ Str::limit($list->description, 100) }}</p>
                        <a href="{{ route('lists.show', $list->id) }}" class="btn btn-sm btn-outline btn-accent hover:text-white mt-2">Ver Lista</a>
                    </div>
                </div>
            @endforeach
        </div>

        <h2 class="text-xl font-semibold text-purple-800 mt-10 mb-4 border-b-2 border-purple-700 pb-1">Listas Recomendadas</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($recommendedLists as $list)
                <div class="card bg-white shadow-md">
                    <div class="card-body">
                        <h3 class="font-semibold text-lg">{{ $list->title }}</h3>
                        <p class="text-sm text-gray-500">{{ Str::limit($list->description, 100) }}</p>
                        <a href="{{ route('lists.show', $list->id) }}" class="btn btn-sm btn-outline btn-accent hover:text-white mt-2">Ver Lista</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layouts.layout>
