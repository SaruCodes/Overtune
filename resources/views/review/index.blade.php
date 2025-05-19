<x-layouts.layout titulo="Overtune - Reseñas">
    <div class="container mx-auto px-4 py-8">
        <div class="grid lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-primary">Últimas Reseñas</h2>

                    @auth
                        <a href="{{ route('albums.search') }}" class="btn btn-primary">+ Añadir Reseña</a>
                    @endauth
                </div>

                <div class="space-y-6">
                    @forelse ($recentReviews as $review)
                        <div class="card bg-base-100 shadow-lg hover:shadow-xl transition-shadow">
                            <div class="card-body">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="avatar">
                                            <div class="w-12 rounded-full">
                                                <img src="{{ $review->user->avatar }}" alt="{{ $review->user->name }}">
                                            </div>
                                        </div>
                                        <div>
                                            <h3 class="card-title">{{ $review->user->name }}</h3>
                                            <div class="text-sm text-gray-500">
                                                {{ $review->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="badge badge-primary gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        {{ $review->rating }}/5
                                    </div>
                                </div>

                                <h4 class="text-xl font-semibold mb-2">{{ $review->album->title }}</h4>
                                <p class="text-gray-600 line-clamp-3 mb-4">{{ $review->content }}</p>

                                <div class="card-actions justify-between items-center">
                                    <a href="{{ route('reviews.show', $review) }}" class="btn btn-ghost">
                                        Leer completa
                                    </a>
                                    <div class="flex items-center gap-2 text-sm text-gray-500">
                                        <span>{{ $review->comentarios_count }} comentarios</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Aún no hay reseñas disponibles</span>
                        </div>
                    @endforelse
                </div>

                <div class="mt-8">
                    {{ $recentReviews->links() }}
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="card bg-base-100 shadow-lg mb-8">
                    <div class="card-body">
                        <h2 class="card-title text-primary mb-4">Álbumes Populares</h2>
                        <div class="space-y-4">
                            @foreach ($topAlbums as $album)
                                <div class="flex items-center gap-4">
                                    <img src="{{ $album->cover_image }}"
                                         alt="{{ $album->title }}"
                                         class="w-16 h-16 object-cover rounded">
                                    <div>
                                        <h3 class="font-semibold">{{ $album->title }}</h3>
                                        <p class="text-sm text-gray-500">
                                            {{ $album->reviews_count }} reseñas
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                @if($featuredReview)
                    <div class="card bg-primary text-primary-content shadow-lg">
                        <div class="card-body">
                            <h2 class="card-title">Reseña Destacada</h2>
                            <div class="flex items-center gap-3 mb-4">
                                <div class="avatar">
                                    <div class="w-12 rounded-full">
                                        <img src="{{ $featuredReview->user->avatar }}"
                                             alt="{{ $featuredReview->user->name }}">
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-semibold">{{ $featuredReview->user->name }}</h3>
                                    <div class="text-sm">{{ $featuredReview->album->title }}</div>
                                </div>
                            </div>
                            <div class="rating rating-half">
                                @for($i = 1; $i <= 5; $i++)
                                    <input type="radio"
                                           class="mask mask-star-2 bg-orange-400"
                                           {{ $featuredReview->rating == $i ? 'checked' : '' }}
                                           disabled>
                                @endfor
                            </div>
                            <p class="mt-4 line-clamp-4">{{ $featuredReview->content }}</p>
                            <div class="card-actions justify-end mt-4">
                                <a href="{{ route('reviews.show', $featuredReview) }}"
                                   class="btn btn-ghost btn-sm text-white">
                                    Leer completa
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.layout>
