@props(['query' => null])
<div class="navbar bg-base-100 bg-nav h-18 md:h-21 flex flex-row px-4 justify-between items-center z-50 overflow-visible">
    <!-- Logo (Oculto en móvil) -->
    <div class="flex-1 flex items-center">
        <a href="{{ route('home') }}">
            <img class="w-auto h-auto max-h-14 md:max-h-16 max-w-full mx-auto object-contain hidden md:block"
                 src="{{ asset('images/logo.png') }}" alt="logo">
        </a>
    </div>

    <!--Menú de Navegación-->
    <div class="flex-none">
        <ul class="menu menu-horizontal px-1 space-x-4 flex items-center h-full relative">
            <li><a class="btn btn-sm btn-outline btn-secondary" href="{{ route('home') }}">{{ __('Inicio') }}</a></li>
            <li><a class="btn btn-sm btn-outline btn-secondary" href="{{ route('news.index') }}">{{ __('Noticias') }}</a></li>
            <li><a class="btn btn-sm btn-outline btn-secondary" href="{{ route('review.index') }}">{{ __('Reseñas') }}</a></li>
            <li><a class="btn btn-sm btn-outline btn-secondary" href="{{ route('artists.index') }}">{{ __('Artistas') }}</a></li>
            <li><a class="btn btn-sm btn-outline btn-secondary" href="{{ route('lists.index') }}">{{ __('Listas') }}</a></li>

            <!-- Botón lupa -->
            <li class="relative">
                <button id="btnSearchToggle" type="button" class="btn btn-square btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 21l-4.35-4.35m0 0a7.5 7.5 0 1110.607-10.607 7.5 7.5 0 01-10.607 10.607z" />
                    </svg>
                </button>

                <!-- Formulario búsqueda oculto inicialmente -->
                <form id="searchForm" action="{{ route('search.results') }}" method="GET"
                      class="hidden absolute right-0 top-full mt-2 flex space-x-2 bg-base-100 p-2 rounded shadow-lg w-64 z-50">
                    <input type="search" name="q" placeholder="Buscar..." required
                           class="input input-sm input-bordered flex-grow" />
                    <button type="submit" class="btn btn-sm btn-primary">Buscar</button>
                </form>
            </li>

            <li class="flex items-center relative z-50">
                @guest
                    <details class="relative flex items-center z-50">
                        <summary class="btn btn-sm btn-outline btn-secondary">{{ __('Acceso') }}</summary>
                        <ul class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 max-w-[80vw] w-auto bg-purple-950 text-white rounded-md shadow-lg p-2 z-50">
                            <li><a class="block px-4 py-2 hover:bg-violet-800 rounded-md" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            <li><a class="block px-4 py-2 hover:bg-violet-800 rounded-md" href="{{ route('register') }}">{{ __('Registro') }}</a></li>
                        </ul>
                    </details>
                @endguest
                @auth
                    <details class="relative flex items-center z-50">
                        <summary class=" btn btn-sm btn-outline btn-secondary">{{ __('Zona Personal') }}</summary>
                        <ul class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 max-w-[80vw] w-auto bg-purple-950 text-white rounded-md shadow-lg p-2 z-50">
                            <li class="flex items-center space-x-4">
                                <!--Enlace al perfil propio-->
                                <a href="{{ route('user.profile') }}" class="block px-4 py-2 hover:bg-violet-800 rounded-md">{{ __('Perfil') }}</a></li>
                            <!--Botón cerrar sesión-->
                            <form action="{{ route('logout') }}" method="POST" class="ml-0">
                                @csrf
                                <button type="submit">
                                    <a class="block px-4 py-2 hover:bg-violet-800 rounded-md">{{ __('Cerrar sesión') }}</a>
                                </button>
                            </form>
                        </ul>
                    </details>
                @endauth
            </li>
        </ul>
    </div>
</div>

<script>
    document.getElementById('btnSearchToggle').addEventListener('click', () => {
        const form = document.getElementById('searchForm');
        form.classList.toggle('hidden');
        if (!form.classList.contains('hidden')) {
            form.querySelector('input[name="query"]').focus();
        }
    });
</script>

