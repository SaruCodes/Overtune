<x-layouts.layout titulo="Reseña - {{ $review->album->title }}">
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded">
        <div class="flex gap-6 mb-6">
            <img src="{{ asset('storage/' . $review->album->cover_image) }}" alt="{{ $review->album->title }}" class="w-48 h-48 object-cover rounded">
            <div>
                <h1 class="text-3xl font-bold">{{ $review->album->title }}</h1>
                <p class="text-lg text-gray-700">{{ $review->album->artist->name }} - {{ $review->album->year }}</p>
                <div class="mt-2 text-yellow-500">
                    @for ($i = 1; $i <= 5; $i++)
                        @if($i <= $review->rating)
                            ★
                        @else
                            ☆
                        @endif
                    @endfor
                </div>
            </div>
        </div>

        <div class="mb-8">
            <p class="text-gray-800 whitespace-pre-wrap">{{ $review->content }}</p>
        </div>

        <section>
            <h2 class="text-xl font-semibold mb-4">Comentarios</h2>

            @auth
                <form action="{{ route('comments.store') }}" method="POST" class="mb-6">
                    @csrf
                    <input type="hidden" name="review_id" value="{{ $review->id }}">
                    <textarea name="content" rows="3" class="textarea textarea-bordered w-full mb-2" placeholder="Añade un comentario..." required></textarea>
                    <button type="submit" class="btn btn-primary">Comentar</button>
                </form>
            @else
                <p class="text-gray-500 italic mb-6">Solo los usuarios registrados pueden dejar comentarios.</p>
            @endauth

            <div class="space-y-4">
                @forelse ($review->comments as $comment)
                    <div class="p-4 border rounded">
                        <div class="flex items-center gap-4 mb-2">
                            <img src="{{ $comment->user->avatar ? asset('storage/' . $comment->user->avatar) : 'https://img.daisyui.com/images/profile/demo/yellingcat@192.webp' }}"
                                 alt="{{ $comment->user->name }}" class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <p class="font-semibold">{{ $comment->user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <p class="whitespace-pre-wrap">{{ $comment->content }}</p>
                    </div>
                @empty
                    <p class="text-gray-500">No hay comentarios aún.</p>
                @endforelse
            </div>
        </section>
    </div>
</x-layouts.layout>
