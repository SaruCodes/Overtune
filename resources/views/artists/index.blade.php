<x-layouts.layout titulo="Artistas - Overtune">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex items-center justify-between flex-wrap mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Artistas</h1>

            <div class="space-x-2 mt-4 sm:mt-0 flex flex-wrap items-center">
                @foreach([1980, 1990, 2000, 2010, 2020] as $decade)
                    <a href="{{ route('artists.index', ['debut' => $decade]) }}"
                       class="btn btn-sm btn-outline {{ request('debut') == $decade ? 'btn-primary' : 'btn-outline hover:bg-purple-200 hover:text-purple-800 transition' }}">
                        {{ $decade }}s
                    </a>
                @endforeach
                <!--limpiar filtros-->
                @if(request()->has('debut'))
                    <a href="{{ route('artists.index') }}"
                       class="btn btn-sm btn-accent btn-outline ml-2">
                        Quitar filtros
                    </a>
                @endif
            </div>

        </div>

        <h2 class="text-xl font-semibold text-purple-800 mb-4 border-b-2 border-purple-700 pb-1">Últimos añadidos</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @foreach ($artists->take(5) as $artist)
                <div class="text-center transform transition duration-300 hover:scale-105">
                    <a href="{{ route('artists.show', $artist->id) }}">
                        <img src="{{ asset('storage/' . $artist->image) }}" class="w-full h-48 object-cover rounded-md shadow-md hover:shadow-xl transition duration-300" alt="{{ $artist->name }}">
                        <h3 class="mt-2 font-semibold text-gray-800 hover:text-purple-600 transition duration-300">{{ $artist->name }}</h3>
                    </a>
                    <p class="text-sm text-gray-500">{{ $artist->debut }}</p>
                </div>

            @endforeach
        </div>
    </div>

    @php $featured = $artists->last(); @endphp
    @if ($featured)
        <div class="bg-gray-50 py-12 border-t">
            <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center gap-6 px-4">
                <a href="{{ route('artists.show', $featured->id) }}" class="group">
                    <img src="{{ asset('storage/' . $featured->image) }}" class="w-48 h-48 object-cover rounded shadow-md group-hover:shadow-xl transition duration-300" alt="{{ $featured->name }}">
                </a>
                <div>
                    <h2 class="text-2xl font-bold text-purple-600">
                        <a href="{{ route('artists.show', $featured->id) }}" class="text-primary hover:underline hover:text-purple-700 transition">
                            {{ __('Artista Destacado') }}: {{ $featured->name }}
                        </a>
                    </h2>
                    <p class="text-gray-600 mt-2">{{ Str::limit($featured->bio, 300) }}</p>
                    <p class="mt-2 text-sm text-gray-500">Debut: {{ $featured->debut }} | País: {{ $featured->country }}</p>
                </div>
            </div>
        </div>
    @endif

    <!--Artistas filtrados por decada-->
    <div class="max-w-7xl mx-auto px-4 py-12">
        <h2 class="text-xl font-semibold text-purple-800 mb-4 border-b-2 border-purple-700 pb-1">Recomendados 80s</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @foreach ($artists80 as $artist80)
                <div class="text-center">
                    <a href="{{ route('artists.show', $artist80->id) }}">
                        <img src="{{ asset('storage/' . $artist80->image) }}" class="w-full h-48 object-cover rounded-md shadow" alt="{{ $artist80->name }}">
                        <h3 class="mt-2 font-semibold">{{ $artist80->name }}</h3>
                    </a>
                    <p class="text-sm text-gray-500">{{ $artist80->debut }}</p>
                </div>
            @endforeach

        </div>
    </div>
</x-layouts.layout>

