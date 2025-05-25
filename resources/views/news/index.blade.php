<x-layouts.layout titulo="Overtune - Noticias">
    <section class="w-full mb-12">
        <div class="carousel w-full h-[750px]">
            @foreach($categoriesWithNews->take(4) as $index => $category)
                @php $news = $category->latestNews->first(); @endphp
                @if($news)
                    <div id="slide{{ $index }}" class="carousel-item relative w-full h-full">
                        <img src="{{ asset('storage/' . $news->image) }}" class="w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                            <div class="text-center">
                                <h2 class="text-white text-4xl md:text-5xl font-bold mb-2">{{ $news->title }}</h2>
                                <span class="bg-primary text-white px-3 py-1 text-sm rounded">{{ $category->name }}</span>
                            </div>
                        </div>
                        <!-- Controls -->
                        <a href="#slide{{ $loop->index == 0 ? $categoriesWithNews->take(4)->count() - 1 : $loop->index - 1 }}"
                           class="absolute left-5 top-1/2 transform -translate-y-1/2 btn btn-circle bg-white bg-opacity-50 hover:bg-opacity-80">
                            ❮
                        </a>
                        <a href="#slide{{ ($loop->index + 1) % $categoriesWithNews->take(4)->count() }}"
                           class="absolute right-5 top-1/2 transform -translate-y-1/2 btn btn-circle bg-white bg-opacity-50 hover:bg-opacity-80">
                            ❯
                        </a>
                    </div>
                @endif
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

        @foreach($categoriesWithNews as $category)
            <section class="mb-12">
                <div class="mb-2 relative">
                    <h2 class="text-2xl font-bold text-secondary inline-block bg-white px-2 relative z-10">{{ $category->name }}</h2>
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
