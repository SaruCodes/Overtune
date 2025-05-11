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

    <!-- Sección de discos con margen superior añadido -->
    <section class="p-8 bg-violet-100 mt-12">
        <h2 class="text-3xl font-semibold text-center mb-8">{{ __('Los 3 Mejores Álbumes') }}</h2>
        <div class="flex justify-center gap-6">
            @foreach ($albums as $album)
                <div class="card w-60 shadow-xl bg-gray-50">
                    <figure>
                        <img class="w-full h-40 object-cover"
                             src="{{ $album->cover_image ? asset('storage/' . $album->cover_image) : 'https://via.placeholder.com/200' }}"
                             alt="{{ $album->titulo }}" />
                    </figure>
                    <div class="card-body">
                        <h3 class="card-title">{{ $album->titulo }}</h3>
                        <p>{{ __('Artista: ') }}{{ $album->artista }}</p>
                        <p>{{ __('Calificación: ')}} 4.8/5</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    @guest
        <!-- Sección Adicional de Presentación -->
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
        <div class="card bg-base-100 image-full w-104 mx-auto shadow-sm mt-12">
            <figure class="h-full">
                <img src="{{ asset('/images/guitar.jpg') }}" alt="Album" class="object-cover w-full h-full"/>
            </figure>
            <div class="card-body flex items-center justify-center flex-col text-center">
                <h2 class="card-title">{{__('Gestión de biblioteca de Música')}}</h2>
                <p>{{__('Gestionamos altas, bajas, actualizaciones y borrado de una tabla de álbumes musicales')}}</p>
                <div class="card-actions justify-end mt-4">
                    <a class="btn btn-outline btn-primary" href="{{ route('discos.index') }}">{{__('Acceso a gestión')}}</a>
                </div>
            </div>
        </div>
    @endauth
</x-layouts.layout>
