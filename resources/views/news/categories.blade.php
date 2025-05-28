<x-layouts.layout titulo="Noticias - {{ $category->category }}">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-accent mb-6">
            Noticias de {{ $category->category }}
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($news as $item)
                <div class="relative group overflow-hidden rounded shadow hover:shadow-lg transition-shadow">
                    <a href="{{ route('news.show', $item) }}">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-48 object-cover rounded" />
                        <div class="absolute bottom-0 bg-purple-400 bg-opacity-80 w-full p-2">
                            <h4 class="text-white text-sm font-semibold">{{ $item->title }}</h4>
                        </div>
                        <div class="absolute top-0 left-0 bg-primary text-white px-2 py-1 text-xs rounded-bl">
                            {{ $item->category->name }}
                        </div>
                    </a>
                </div>
            @empty
                <p>No hay noticias disponibles en esta categoría.</p>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $news->links() }}
        </div>
    </div>
</x-layouts.layout>
