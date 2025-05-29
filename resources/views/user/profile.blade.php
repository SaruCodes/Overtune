<x-layouts.layout titulo="Perfil de Usuario - Overtune">
    <div class="card bg-white shadow-md w-full max-w-md mx-auto mt-12">
        <div class="card-body text-center relative">
            <div class="avatar mx-auto">
                <div class="w-24 rounded-full">
                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : '/images/placeholder_avatar.png' }}" />
                </div>
            </div>
            <h2 class="card-title text-2xl font-bold mt-4">{{ auth()->user()->name }}</h2>
            <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
            <p class="text-md text-gray-700 mt-2">{{ auth()->user()->bio }}</p>

            <div class="card-actions justify-center mt-4 space-x-2">
                <a href="{{ route('user.edit') }}" class="btn btn-primary btn-sm">{{ __('Editar Perfil') }}</a>
                @if ($user->isAdmin())
                <a href="{{ route('admin.panel') }}" class="btn btn-outline btn-secondary btn-sm">{{__('Panel de Control')}}</a>
                @endif
            </div>
        </div>
    </div>

    @php
        $user = auth()->user();
    @endphp
        <!--Panel de administradores-->
    @if ($user->isAdmin() || $user->isEditor())
        <div class="max-w-4xl mx-auto mt-6">
            <details class="collapse collapse-arrow bg-purple-300">
                <summary class="collapse-title text-lg font-medium">Panel de Administración</summary>
                <div class="collapse-content">
                    <ul class="space-y-3 mt-4">
                        <li>
                            <a href="{{ route('artists.crud') }}" class="btn btn-outline btn-primary w-full">Administrar Artistas</a>
                        </li>
                        <li>
                            <a href="{{ route('albums.crud') }}" class="btn btn-outline btn-primary w-full">Administrar Álbumes</a>
                        </li>
                        <li>
                            <a href="{{ route('news.crud') }}" class="btn btn-outline btn-primary w-full">Administrar Noticias</a>
                        </li>
                    </ul>
                </div>
            </details>
        </div>
    @endif

    <div class="card bg-white shadow max-w-4xl mx-auto mt-8">
        <div class="card-body">
            <h3 class="text-xl font-semibold mb-4">Favoritos</h3>

            <div class="mb-6">
                <h4 class="font-semibold mb-2">Listas</h4>
                <ul class="space-y-3">
                    @foreach($user->favoriteLists()->with('favoritable')->get() as $fav)
                        <li class="flex items-center space-x-4">
                            @php $list = $fav->favoritable; @endphp
                            <a href="{{ route('lists.show', $list->id) }}" class="text-primary hover:underline font-medium">{{ $list->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="mb-6">
                <h4 class="font-semibold mb-2">Álbumes</h4>
                <ul class="space-y-3">
                    @foreach($user->favoriteAlbums()->with('favoritable')->get() as $fav)
                        <li class="flex items-center space-x-4">
                            @php $album = $fav->favoritable; @endphp
                            <img src="{{ $album->cover_image ? asset('storage/' . $album->cover_image) : '/images/placeholder_album.png' }}" alt="Miniatura álbum" class="w-12 h-12 rounded object-cover">
                            <a href="{{ route('albums.show', $album->id) }}" class="text-primary hover:underline font-medium">{{ $album->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="font-semibold mb-2">Artistas</h4>
                <ul class="space-y-3">
                    @foreach($user->favoriteArtists()->with('favoritable')->get() as $fav)
                        <li class="flex items-center space-x-4">
                            @php $artist = $fav->favoritable; @endphp
                            <img src="{{ $artist->image ? asset('storage/' . $artist->image) : '/images/placeholder_artist.png' }}" alt="Miniatura artista" class="w-12 h-12 rounded-full object-cover">
                            <a href="{{ route('artists.show', $artist->id) }}" class="text-primary hover:underline font-medium">{{ $artist->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    @if (auth()->check())
        <div class="max-w-4xl mx-auto mt-8 space-y-6">
            <!--Listas-->
            <div class="card bg-white shadow max-w-4xl mx-auto">
                <div class="card-body">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-semibold">Tus Listas</h3>
                        <a href="{{ route('lists.create') }}" class="btn btn-sm btn-primary">Crear Nueva Lista</a>
                    </div>
                    <ul class="mt-4 space-y-2">
                        @foreach ($user->lists as $list)
                            <li>
                                <a href="{{ route('lists.show', $list->id) }}" class="text-primary hover:underline">
                                    {{ $list->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="card bg-white shadow max-w-4xl mx-auto mb-12">
                <div class="card-body">
                    <h3 class="text-xl font-semibold flex justify-between items-center"> Tus Reseñas
                        @if(auth()->check() && auth()->id() === $user->id)
                            <a href="{{ route('albums.search') }}" class="btn btn-sm btn-primary">Crear Reseña</a>
                        @endif
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                        @foreach ($user->reviews->sortByDesc('created_at') as $review)
                            <a href="{{ route('review.show', $review->id) }}" class="block border rounded shadow hover:shadow-lg overflow-hidden">
                                <img src="{{ asset('storage/' . $review->album->cover_image) }}" alt="Cover album" />
                                <div class="p-3">
                                    <h4 class="font-semibold">{{ $review->album->title }}</h4>
                                    <p class="text-gray-600 text-sm">{{ \Illuminate\Support\Str::limit($review->content, 80) }}</p>
                                    <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-layouts.layout>
