<x-layouts.layout titulo="Noticia - {{ $news->title }}">
    <div class="bg-white">
        <div class="w-full">
            <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="w-full h-[700px] object-cover">
        </div>

        <div class="max-w-4xl mx-auto p-6">
            <h1 class="text-4xl font-bold mb-2">{{ $news->title }}</h1>
            <p class="text-sm text-gray-500 mb-4">{{ $news->created_at->format('d/m/Y') }}</p>
            <div class="prose max-w-none">
                {!! nl2br(e($news->content)) !!}
            </div>
        </div>

        <div class="max-w-5xl mx-auto mt-10 px-4">
            <h2 class="text-2xl font-semibold mb-4">Noticias Relacionadas</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach ($news->category->news->where('id', '!=', $news->id)->take(3) as $related)
                    <a href="{{ route('news.show', $related) }}" class="relative group rounded-lg overflow-hidden shadow-lg">
                        <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->title }}" class="w-full h-48 object-cover group-hover:brightness-50 transition duration-300">
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                            <span class="text-white text-lg font-semibold text-center px-4">{{ $related->title }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        <!--Comentarios-->
        <x-layouts.layout titulo="Overtune - Noticias">
            <section class="w-full mb-12">
                <div class="carousel w-full h-[650px]">
                    @foreach($latestNews->take(5) as $index => $news)
                        <div id="newsSlide{{ $index }}" class="carousel-item relative w-full h-full">
                            <img src="{{ asset('storage/' . $news->image) }}" class="w-full h-full object-cover" alt="{{ $news->title }}" />
                            <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
                                <div class="text-center px-6">
                                    <h2 class="text-white text-4xl md:text-5xl font-bold mb-4">{{ $news->title }}</h2>
                                    <p class="text-white text-lg hidden md:block">{{ Str::limit(strip_tags($news->content), 150) }}</p>
                                    <div class="mt-4">
                                        <a href="{{ route('news.show', $news->id) }}" class="btn btn-secondary">{{ __('Leer más') }}</a>
                                    </div>
                                    <span class="mt-6 inline-block bg-primary text-white px-3 py-1 text-sm rounded">{{ $news->category->name }}</span>
                                </div>
                            </div>
                            <!--Botones-->
                            <a href="#newsSlide{{ $index == 0 ? $latestNews->take(5)->count() - 1 : $index - 1 }}"
                               class="absolute left-5 top-1/2 transform -translate-y-1/2 btn btn-circle bg-white bg-opacity-50 hover:bg-opacity-80">
                                ❮
                            </a>
                            <a href="#newsSlide{{ ($index + 1) % $latestNews->take(5)->count() }}"
                               class="absolute right-5 top-1/2 transform -translate-y-1/2 btn btn-circle bg-white bg-opacity-50 hover:bg-opacity-80">
                                ❯
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>

            <div class="container mx-auto px-4">
                <section class="mb-12">
                    <h2 class="text-3xl font-bold mb-6 text-primary">Actualidad</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2 relative group overflow-hidden rounded shadow hover:shadow-lg transition-shadow">
                            <a href="{{ route('news.show', $latestNews[0]) }}">
                                <img src="{{ asset('storage/' . $latestNews[0]->image) }}" alt="{{ $latestNews[0]->title }}" class="w-full h-full object-cover rounded" />
                                <div class="absolute bottom-0 bg-purple-400 bg-opacity-80 w-full p-4">
                                    <h3 class="text-white text-xl font-bold">{{ $latestNews[0]->title }}</h3>
                                </div>
                                <div class="absolute top-0 left-0 bg-primary text-white px-2 py-1 text-xs rounded-bl">
                                    {{ $latestNews[0]->category->name }}
                                </div>
                            </a>
                        </div>
                        <div class="flex flex-col gap-6">
                            @foreach($latestNews->slice(1, 2) as $news)
                                <div class="relative group overflow-hidden rounded shadow hover:shadow-lg transition-shadow">
                                    <a href="{{ route('news.show', $news) }}">
                                        <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="w-full h-48 object-cover rounded" />
                                        <div class="absolute bottom-0 bg-purple-400 bg-opacity-80 w-full p-2">
                                            <h4 class="text-white text-sm font-semibold">{{ $news->title }}</h4>
                                        </div>
                                        <div class="absolute top-0 left-0 bg-primary text-white px-2 py-1 text-xs rounded-bl">
                                            {{ $news->category->name }}
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
                <!--Noticias por categoría-->
                @foreach($categoriesWithNews as $category)
                    <section class="mb-12">
                        <div class="mb-2 relative">
                            <h2 class="text-2xl font-bold text-secondary inline-block px-2 relative z-10">{{ $category->category }}</h2>
                            <hr class="border-t-2 border-secondary mt-2 -translate-y-3">
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                            @foreach($category->latestNews as $news)
                                <div class="relative group overflow-hidden rounded shadow hover:shadow-lg transition-shadow">
                                    <a href="{{ route('news.show', $news) }}">
                                        <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="w-full h-36 object-cover rounded" />
                                        <div class="absolute bottom-0 bg-purple-400 bg-opacity-80 w-full p-2">
                                            <h4 class="text-white text-sm font-semibold">{{ $news->title }}</h4>
                                        </div>
                                        <div class="absolute top-0 left-0 bg-primary text-white px-2 py-1 text-xs rounded-bl">
                                            {{ $news->category->name }}
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endforeach
            </div>
        </x-layouts.layout>


    </div>
</x-layouts.layout>
<script>
    function confirmDelete(event) {
        event.preventDefault();
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Esto eliminará el comentario!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit();
            }
        });
        return false;
    }

    function confirmReport(commentId) {
        Swal.fire({
            title: '¿Reportar comentario?',
            text: "Puedes reportar este comentario a los moderadores.",
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Reportar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/comments/${commentId}/report`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                }).then(() => {
                    Swal.fire('Reportado', 'El comentario ha sido reportado.', 'success');
                });
            }
        });
    }
</script>
