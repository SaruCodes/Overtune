<x-layouts.layout titulo="Noticia - {{ $news->title }}">
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded">
        <h1 class="text-3xl font-bold mb-2">{{ $news->title }}</h1>
        <p class="text-sm text-gray-500 mb-4">{{ $news->created_at->format('d M Y') }}</p>
        <div class="prose">
            {!! nl2br(e($news->content)) !!}
        </div>

        <hr class="my-6">

        <h2 class="text-xl font-semibold mb-4">Comentarios</h2>
        @auth
            <form method="POST" action="{{ route('comments.store') }}">
                @csrf
                <input type="hidden" name="news_id" value="{{ $news->id }}">
                <textarea name="content" class="textarea w-full mb-2" required></textarea>
                <button class="btn btn-primary">Enviar Comentario</button>
            </form>
        @else
            <p>Inicia sesión para comentar.</p>
        @endauth

        <div class="mt-4 space-y-4">
            @foreach ($comments as $comment)
                <div class="p-4 border rounded shadow-sm">
                    <p class="text-sm text-gray-700">{{ $comment->user->name }} dijo:</p>
                    <p>{{ $comment->content }}</p>
                    <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                </div>
            @endforeach
        </div>
    </div>
</x-layouts.layout>
