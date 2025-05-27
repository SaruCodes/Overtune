<header class="md:hidden bg-header flex flex-col justify-between px-3 items-center">
    <img class="w-auto h-14 mx-auto object-contain" src="{{ asset('images/logo.png') }}" alt="logo">

    <div>
        <input type="checkbox" id="menu-toggle" class="peer hidden">
        <label class="text-2xl hover:cursor-pointer text-white" for="menu-toggle">
            &#9778;
        </label>

        <div class="absolute hidden peer-checked:block p-3 rounded-xl flex flex-col">
            @auth
                <span class="text-white">{{ auth()->user()->name }}</span>
                <form action="{{route("logout")}}" method="POST">
                    @csrf
                    <input class="btn btn-glass" type="submit" value="Logout">
                </form>
            @endauth
            @guest
                <a class="btn btn-glass" href="{{route("login")}}">Login</a>
                <a class="btn btn-glass" href="{{route("register")}}">Register</a>
            @endguest
        </div>
    </div>
</header>
