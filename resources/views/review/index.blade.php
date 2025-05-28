<x-layouts.layout titulo="Overtune - Reseñas">
    <div class="container mx-auto px-4 py-8 space-y-12">
        <!--Reseña destacada-->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 relative rounded-lg overflow-hidden shadow-xl h-150 group">
                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-300"
                     style="background-image: url('{{ asset('storage/' . $featuredReviews[0]->album->cover_image) }}');">
                </div>
                <div class="absolute inset-0 bg-purple-900/60 backdrop-blur-0 group-hover:backdrop-blur-sm transition duration-300"></div>
                <div class="relative z-10 p-6 text-white h-full flex flex-col justify-end">
                    <div>
                        <h3 class="text-3xl font-extrabold">{{ $featuredReviews[0]->album->title }}</h3>
                        <p class="mt-4 text-lg line-clamp-4">{{ $featuredReviews[0]->content }}</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm">{{ $featuredReviews[0]->created_at->diffForHumans() }}</span>
                        <a href="{{ route('review.show', $featuredReviews[0]) }}"
                           class="btn btn-sm bg-accent text-white hover:bg-secondary transition">Leer completa</a>
                    </div>
                </div>
            </div>


            <div class="flex flex-col space-y-4">
                @auth()
                <a href="{{ route('albums.search') }}" class="btn btn-md btn-primary">+ Añadir Reseña</a>
                @endauth
                    @foreach ($featuredReviews->slice(1, 3) as $review)
                    <div class="card bg-base-100 shadow-md border border-transparent hover:border-primary hover:shadow-xl transform hover:scale-[1.02] transition duration-300 ease-in-out p-4 flex gap-4">
                        <img src="{{ asset('storage/' . $review->album->cover_image) }}"
                             class="w-20 h-20 object-cover rounded ring-2 ring-primary" alt="{{ $review->album->title }}">
                        <div class="flex-1">
                            <h4 class="font-semibold text-sm text-primary">{{ $review->album->title }}</h4>
                            <p class="text-xs line-clamp-2">{{ $review->content }}</p>
                            <a href="{{ route('review.show', $review) }}"
                               class="text-accent text-xs mt-1 inline-block hover:underline transition">Leer</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="divider divider-secondary text-2xl font-bold text-primary mb-6">Destacada esta semana</div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-12">
                @if($featuredReviews->count() > 4)
                    <div class="card bg-base-100 border border-transparent hover:border-secondary shadow-md hover:shadow-xl transition transform hover:scale-[1.01] duration-300 flex flex-col lg:flex-row gap-6 p-6 items-center">
                        <img src="{{ asset('storage/' . $featuredReviews[4]->album->cover_image) }}" alt="{{ $featuredReviews[4]->album->title }}" class="w-32 h-32 lg:w-40 lg:h-40 object-cover rounded ring-2 ring-secondary flex-shrink-0" />
                        <div class="flex-1">
                            <h4 class="text-xl font-semibold mb-2 text-primary">{{ $featuredReviews[4]->album->title }}</h4>
                            <p class="line-clamp-3 text-gray-700">{{ $featuredReviews[4]->content }}</p>
                            <div class="mt-2 flex justify-between items-center text-sm">
                                <span>{{ $featuredReviews[4]->created_at->diffForHumans() }}</span>
                                <a href="{{ route('review.show', $featuredReviews[4]) }}"
                                   class="text-accent hover:text-secondary transition">Leer completa</a>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="divider divider-secondary"></div>
                <div>
                    <h2 class="text-2xl font-bold text-primary mb-6">Últimas Reseñas</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($recentReviews as $review)
                            <div class="card bg-purple-300 border border-transparent hover:border-primary shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition duration-300 ease-in-out">
                                <div class="card-body">
                                    <div class="flex gap-4 items-center mb-4">
                                        <img src="{{ asset('storage/' . $review->album->cover_image) }}"
                                             class="w-12 h-12 rounded object-cover ring-2 ring-primary" alt="{{ $review->album->title }}">
                                        <div>
                                            <h3 class="font-semibold text-primary">{{ $review->album->title }}</h3>
                                            <span class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <p class="line-clamp-3 text-gray-700 mb-4">{{ $review->content }}</p>
                                    <div class="card-actions justify-between">
                                        <a href="{{ route('review.show', $review) }}"
                                           class="btn btn-sm bg-accent text-white hover:bg-secondary transition">Leer completa</a>
                                        <span class="text-xs text-gray-500">{{ $review->comentarios_count }} comentarios</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8">
                        {{ $recentReviews->links('components.pagination') }}
                    </div>
                </div>
            </div>

            <!--Albumes destacados (columna lateral)-->
            <div class="space-y-6 hidden lg:block">
                <div class="card bg-base-100 shadow-lg border border-primary p-6">
                    <h2 class="card-title text-primary mb-4">Álbumes Populares</h2>
                    <div class="space-y-4">
                        @foreach ($topAlbums as $album)
                            <div class="flex items-center gap-4">
                                <img src="{{ asset('storage/' . $album->cover_image) }}" alt="{{ $album->title }}" class="w-16 h-16 object-cover">
                                <div>
                                    <h3 class="font-semibold text-sm text-primary">{{ $album->title }}</h3>
                                    <p class="text-xs text-gray-500">
                                        {{ $album->reviews_count }} reseñas
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.layout>
