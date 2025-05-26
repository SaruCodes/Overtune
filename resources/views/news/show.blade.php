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
        <div class="max-w-4xl mx-auto mt-12 p-6">
            <h2 class="text-2xl font-semibold mb-4">Deja tu comentario</h2>
            @auth
                <form method="POST" action="{{ route('comments.store') }}">
                    @csrf
                    <input type="hidden" name="commentable_type" value="news">
                    <input type="hidden" name="commentable_id" value="{{ $news->id }}">
                    <textarea name="content" class="textarea textarea-bordered w-full h-32 mb-4" placeholder="Escribe tu comentario aquí..." required></textarea>
                    <button class="btn btn-primary">Enviar Comentario</button>
                </form>
            @else
                <p class="text-gray-600">Debes iniciar sesión para comentar.</p>
            @endauth

            <div class="mt-8 space-y-6">
                @foreach ($comments as $comment)
                    <div
                        x-data="{
                            editMode: false,
                            content: '{{ addslashes($comment->content) }}',
                            originalContent: '{{ addslashes($comment->content) }}'
                        }"
                        class="border p-4 rounded bg-gray-50 shadow-sm relative group"
                    >
                        <div class="flex items-center gap-4 mb-2">
                            <img src="{{ $comment->user->avatar ? asset('storage/' . $comment->user->avatar) : 'https://img.daisyui.com/images/profile/demo/yellingcat@192.webp' }}"
                                 alt="{{ $comment->user->name }}" class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <p class="font-semibold">{{ $comment->user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <template x-if="!editMode">
                            <p class="text-gray-700 whitespace-pre-wrap" x-text="content"></p>
                        </template>

                        <template x-if="editMode">
                            <form method="POST" action="{{ route('comments.update', $comment) }}" class="space-y-2">
                                @csrf
                                @method('PUT')
                                <textarea
                                    name="content"
                                    x-model="content"
                                    class="textarea textarea-bordered w-full h-24"
                                    required
                                ></textarea>
                                <div class="flex gap-2">
                                    <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                                    <button type="button" @click="content = originalContent; editMode = false" class="btn btn-sm">Cancelar</button>
                                </div>
                            </form>
                        </template>

                        @auth
                            @php
                                $userIsOwner = $comment->user_id === auth()->id();
                                $userIsAdminOrEditor = auth()->user()->hasRole('admin') || auth()->user()->hasRole('editor');
                            @endphp

                            <div class="absolute top-3 right-3 flex gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                @if($userIsOwner)
                                    <button @click="editMode = true" type="button" title="Editar comentario" class="text-indigo-600 hover:text-indigo-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3z" />
                                        </svg>
                                    </button>
                                @endif

                                @if($userIsOwner || $userIsAdminOrEditor)
                                    <form method="POST" action="{{ route('comments.destroy', $comment) }}" onsubmit="return confirmDelete(event)" id="delete-comment-{{ $comment->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Eliminar comentario" class="text-red-600 hover:text-red-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                                    <button onclick="confirmReport('comments', {{ $comment->id }})" title="Reportar comentario" class="text-yellow-500 hover:text-yellow-700 font-semibold text-sm self-center">
                                        Reportar
                                    </button>
                            </div>
                        @endauth
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    function confirmReport(type, id) {
        Swal.fire({
            title: '¿Reportar contenido?',
            text: "Esto será revisado por los moderadores.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Reportar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/report/${type}/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                })
                    .then(response => {
                        if (response.ok) return response.json();
                        if (response.status === 409) throw new Error("Ya reportado.");
                        throw new Error("Error al reportar.");
                    })
                    .then(data => Swal.fire('Enviado', data.message, 'success'))
                    .catch(err => Swal.fire('Error', err.message, 'error'));
            }
        });
    }
</script>

