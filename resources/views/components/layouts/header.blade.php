<header class="md:hidden bg-header flex flex-col items-center px-3 pt-2 pb-4 relative z-[60]">
    <!-- Logo centrado y con enlace -->
    <a href="{{ route('home') }}" class="w-full flex justify-center mb-2">
        <img class="h-14 object-contain" src="{{ asset('images/logo.png') }}" alt="logo">
    </a>

    <!-- Menú hamburguesa -->
    <div class="relative w-full flex flex-col items-center">
        <input type="checkbox" id="menu-toggle" class="peer hidden" />
        <label for="menu-toggle" class="text-3xl text-white cursor-pointer z-[70]">
            &#9778;
        </label>

        <!--Menú desplegable-->
        <div class="hidden peer-checked:flex flex-col items-center gap-2 absolute top-full mt-3 bg-purple-950 rounded-xl p-4 w-72 shadow-lg z-[80]">
            <form action="{{ route('search.results') }}" method="GET" class="flex w-full space-x-1">
                <input type="search" name="q" placeholder="Buscar..." required
                       class="input input-sm input-bordered flex-grow" />
                <button type="submit" class="btn btn-sm btn-primary">OK</button>
            </form>

            @auth
                <a href="{{ route('user.profile') }}" class="btn btn-sm btn-outline btn-secondary w-full">{{ __('Perfil') }}</a>
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-error w-full">{{ __('Cerrar sesión') }}</button>
                </form>
            @endauth

            @guest
                <a class="btn btn-sm btn-outline btn-secondary w-full" href="{{ route('login') }}">{{ __('Login') }}</a>
                <a class="btn btn-sm btn-outline btn-secondary w-full" href="{{ route('register') }}">{{ __('Registro') }}</a>
            @endguest
        </div>
    </div>
</header>
