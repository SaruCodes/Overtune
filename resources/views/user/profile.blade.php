<x-layouts.layout titulo="Perfil de Usuario - Overtune">
    dd(auth()->user()->role, auth()->user()->isEditor(), auth()->user()->isAdmin());

    <div class="card bg-white shadow-md w-full max-w-lg mx-auto">
        <div class="card-body text-center relative">
            <div class="avatar mx-auto">
                <div class="w-24 rounded-full">
                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://img.daisyui.com/images/profile/demo/yellingcat@192.webp' }}" />
                </div>
            </div>
            <h2 class="card-title text-2xl font-bold mt-4">{{ auth()->user()->name }}</h2>
            <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
            <p class="text-md text-gray-700 mt-2">{{ auth()->user()->bio }}</p>

            <div class="card-actions justify-center mt-4 space-x-2">
                <a href="{{ route('user.edit') }}" class="btn btn-primary btn-sm">{{ __('Editar Perfil') }}</a>
                @if(auth()->check() && auth()->id() === $user->id)
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
            <details class="collapse collapse-arrow bg-base-200">
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

    @if (auth()->check())
        <div class="max-w-4xl mx-auto mt-8 space-y-6">

            <!--Listas-->
            <div class="card bg-white shadow">
                <div class="card-body">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-semibold">Tus Listas</h3>
                        <a href="{{ route('lists.create') }}" class="btn btn-sm btn-primary">Crear Nueva Lista</a>
                    </div>
                    <ul class="mt-4 space-y-2">
                        @foreach ($user->lists as $list)
                            <li>
                                <a href="{{ route('lists.show', $list->id) }}" class="text-blue-600 hover:underline">
                                    {{ $list->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="card bg-white shadow">
                <div class="card-body">
                    <h3 class="text-xl font-semibold flex justify-between items-center"> Tus Reseñas
                        @if(auth()->check() && auth()->id() === $user->id)
                            <a href="{{ route('albums.search') }}" class="btn btn-sm btn-primary">Crear Reseña</a>
                        @endif
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                        @foreach ($user->reviews->sortByDesc('created_at') as $review)
                            <a href="{{ route('review.show', $review->id) }}" class="block border rounded shadow hover:shadow-lg overflow-hidden">
                                <img src="{{ asset('storage/' . $review->album->cover_image) }}" />
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
    @endif
</x-layouts.layout>
