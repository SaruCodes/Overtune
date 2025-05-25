<x-layouts.layout titulo="Overtune - Home">
    <div class="relative w-full">
        <div class="carousel w-full">
            <div id="slide1" class="carousel-item relative w-full">
                <img src="{{ asset('images/fondo_home.jpg') }}" class="w-full h-[80vh] object-cover" />
                <div class="absolute inset-0 flex flex-col items-center justify-center bg-black bg-opacity-50 text-white text-center p-8">
                    <h1 class="text-5xl font-bold">Overtune</h1>
                    <p class="text-lg mt-4">{{ __('La web para fanáticos de la música. Puntúa, reseña y guarda tus lanzamientos musicales favoritos') }}</p>
                </div>
                <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
                    <a href="#slide3" class="btn btn-circle">❮</a>
                    <a href="#slide2" class="btn btn-circle">❯</a>
                </div>
            </div>
            <div id="slide2" class="carousel-item relative w-full">
                <img src="{{ asset('images/fondo_home2.jpg') }}" class="w-full h-[80vh] object-cover" />
                <div class="absolute inset-0 flex flex-col items-center justify-center bg-black bg-opacity-50 text-white text-center p-8">
                    <h1 class="text-5xl font-bold">{{__('Explora Nuevas Canciones')}}</h1>
                    <p class="text-lg mt-4">{{ __('Descubre y guarda tus álbumes favoritos con facilidad.') }}</p>
                </div>
                <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
                    <a href="#slide1" class="btn btn-circle">❮</a>
                    <a href="#slide3" class="btn btn-circle">❯</a>
                </div>
            </div>
            <div id="slide3" class="carousel-item relative w-full">
                <img src="{{ asset('images/fondo_home3.jpg') }}" class="w-full h-[80vh] object-cover" />
                <div class="absolute inset-0 flex flex-col items-center justify-center bg-black bg-opacity-50 text-white text-center p-8">
                    <h1 class="text-5xl font-bold">{{__('Únete a Nuestra Comunidad')}}</h1>
                    <p class="text-lg mt-4">{{ __('Comparte reseñas y descubre música con otros usuarios.') }}</p>
                </div>
                <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
                    <a href="#slide2" class="btn btn-circle">❮</a>
                    <a href="#slide1" class="btn btn-circle">❯</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Últimas reseñas (álbumes recientes con carátula e info) --}}
    <section class="p-8 bg-violet-100 mt-12">
        <h2 class="text-3xl font-semibold text-center mb-8">{{ __('Últimas reseñas') }}</h2>
        <div class="flex flex-wrap justify-center gap-6">
            @foreach ($latestAlbums as $album)
                <div class="card w-60 shadow-xl bg-gray-50">
                    <figure>
                        <img class="w-full h-40 object-cover"
                             src="{{ $album->cover_image ? asset('storage/' . $album->cover_image) : 'https://via.placeholder.com/200' }}"
                             alt="{{ $album->titulo }}" />
                    </figure>
                    <div class="card-body">
                        <h3 class="card-title">{{ $album->titulo }}</h3>
                        <p>{{ __('Artista: ') }}{{ $album->artista }}</p>
                        <p>{{ __('Calificación: ')}} {{ $album->average_rating ?? 'N/A' }}/5</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Noticia destacada --}}
    @if ($featuredNews)
        <section class="bg-violet-400 text-white p-8 mt-12">
            <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center gap-6">
                <div class="w-full md:w-1/2">
                    <img src="{{ $featuredNews->image ? asset('storage/' . $featuredNews->image) : 'https://via.placeholder.com/600x400' }}"
                         class="w-full h-64 object-cover rounded-lg shadow-lg" alt="{{ $featuredNews->title }}">
                </div>
                <div class="w-full md:w-1/2">
                    <h2 class="text-2xl font-bold mb-2">{{ $featuredNews->title }}</h2>
                    <p class="mb-4">{{ Str::limit(strip_tags($featuredNews->content), 300) }}</p>
                    <a href="{{ route('news.show', $featuredNews->id) }}" class="btn btn-secondary">{{ __('Leer más') }}</a>
                </div>
            </div>
        </section>
    @endif

    {{-- Reseña destacada con imagen al lado --}}
    @if ($featuredReview)
        <section class="p-8 bg-white mt-12">
            <div class="max-w-6xl mx-auto flex flex-col md:flex-row gap-6 items-center">
                <div class="w-full md:w-1/3">
                    <img src="{{ $featuredReview->album->cover_image ? asset('storage/' . $featuredReview->album->cover_image) : 'https://via.placeholder.com/400' }}"
                         class="w-full h-72 object-cover rounded-lg shadow-md" alt="{{ $featuredReview->album->titulo }}">
                </div>
                <div class="w-full md:w-2/3">
                    <h2 class="text-2xl font-bold mb-4">{{ __('Reseña destacada: ') }}{{ $featuredReview->album->titulo }}</h2>
                    <p class="mb-4">
                        {{ Str::limit($featuredReview->content, 500) }}
                        @if (strlen($featuredReview->content) > 500)
                            <a href="{{ route('review.show', $featuredReview->id) }}" class="text-sm underline text-violet-600">{{ __('Leer más') }}</a>
                        @endif
                    </p>
                </div>
            </div>
        </section>
    @endif

    {{-- Carousel de últimas noticias por categoría --}}
    <section class="p-8 bg-violet-100 mt-12">
        <h2 class="text-3xl font-semibold text-center mb-8">{{ __('Últimas Noticias por Categoría') }}</h2>
        <div class="carousel carousel-center space-x-4 rounded-box">
            @foreach ($latestByCategory as $news)
                <div class="carousel-item w-80 bg-white shadow-md rounded-lg p-4">
                    <h3 class="text-xl font-semibold mb-2">{{ $news->title }}</h3>
                    <p class="text-sm text-gray-700 mb-4">{{ Str::limit(strip_tags($news->content), 120) }}</p>
                    <a href="{{ route('news.show', $news->id) }}" class="text-violet-600 hover:underline text-sm">
                        {{ __('Leer más') }}
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Otra reseña destacada (solo texto) --}}
    @if ($secondaryReview)
        <section class="p-8 bg-white mt-12">
            <div class="max-w-5xl mx-auto">
                <h2 class="text-2xl font-bold mb-4">{{ __('Reseña especial: ') }}{{ $secondaryReview->album->titulo }}</h2>
                <p class="text-gray-700 text-lg leading-relaxed">
                    {{ Str::limit($secondaryReview->content, 800) }}
                    @if (strlen($secondaryReview->content) > 800)
                        <a href="{{ route('review.show', $secondaryReview->id) }}" class="text-violet-600 underline text-sm">{{ __('Leer más') }}</a>
                    @endif
                </p>
            </div>
        </section>
    @endif
    @guest
        <section class="p-8 bg-violet-100">
            <h2 class="text-3xl font-semibold text-center mb-8">{{__ ('Bienvenido a Overtune')}}</h2>
            <div class="max-w-4xl mx-auto text-center">
                <p class="text-lg mb-4">
                    {{ __('Explora nuestras funcionalidades para gestionar discos, álbumes y artistas.
                    Conoce la mejor forma de interactuar con la plataforma.')}}
                </p>
                <a class="btn btn-secondary" href="{{ route('register') }}">{{__ ('Registrarse Ahora')}}</a>
            </div>
        </section>
    @endguest

    @auth
        <div class="card lg:card-side bg-base-100 shadow-xl mx-4 mt-12 bg-primary/10">
            <figure class="lg:w-1/3">
                <img src="{{ asset('images/review-banner.jpg') }}" alt="Escribe reseñas" class="w-full h-64 lg:h-full object-cover">
            </figure>
            <div class="card-body lg:w-2/3">
                <h2 class="card-title text-3xl text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M21.947 9.179a1.001 1.001 0 0 0-.868-.676l-5.701-.453-2.467-5.461a.998.998 0 0 0-1.822-.001L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.213 4.107-1.49 6.452a1 1 0 0 0 1.53 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082c.297-.268.406-.686.278-1.065z"/>
                    </svg>
                    {{ __('¡Comparte tu opinión!') }}
                </h2>
                <p class="text-lg text-gray-600">
                    {{ __('¿Te gustó un álbum? ¡Califícalo y escribe tu reseña!') }}<br>
                    {{ __('Ayuda a otros amantes de la música a descubrir nuevos talentos.') }}
                </p>
                <div class="card-actions justify-end mt-4">
                    <a href="{{ route('albums.search')}}" class="btn btn-primary gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M12 3l0 18" />
                            <path d="M3 12l18 0" />
                        </svg>
                        {{ __('Crear Reseña') }}
                    </a>
                </div>
            </div>
        </div>
    @endauth
</x-layouts.layout>
