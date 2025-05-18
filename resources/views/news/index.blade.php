<x-layouts.layout titulo="Overtune - Noticias">
    <div class="container mx-auto px-4">
        <!-- Sección Actualidad -->
        <section class="mb-12">
            <h2 class="text-3xl font-bold mb-6 text-primary">Actualidad</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($latestNews as $news)
                    <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow">
                        <div class="card-body">
                            <h3 class="card-title text-xl">{{ $news->title }}</h3>
                            <p class="text-gray-500">{{ $news->excerpt }}</p>
                            <div class="card-actions justify-end mt-2">
                                <span class="text-sm text-gray-400">{{ $news->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Sección por categorías -->
        @foreach($categoriesWithNews as $category)
            <section class="mb-12">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-secondary">{{ $category->name }}</h2>
                    <a href="{{ route('category.show', $category) }}" class="btn btn-ghost btn-sm">
                        Ver más
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($category->latestNews as $news)
                        <div class="card bg-base-100 shadow-md hover:shadow-lg transition-shadow">
                            <div class="card-body">
                                <h3 class="card-title">{{ $news->title }}</h3>
                                <p class="text-gray-500 text-sm">{{ $news->excerpt }}</p>
                                <div class="card-actions justify-end">
                                    <span class="text-xs text-gray-400">{{ $news->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach
</x-layouts.layout>
