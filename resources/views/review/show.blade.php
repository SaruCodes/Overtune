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

        <div class="max-w-4xl mx-auto mt-12 p-6">
            <h2 class="text-2xl font-semibold mb-4">Deja tu comentario</h2>
            @auth
                <form method="POST" action="{{ route('comments.store') }}">
                    @csrf
                    <input type="hidden" name="commentable_type" value="reviews">
                    <input type="hidden" name="commentable_id" value="{{ $review->id }}">
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
                                    <button type="button" @click="content = originalContent; editMode = false" class="btn btn-secondary btn-sm">Cancelar</button>
                                </div>
                            </form>
                        </template>

                        @auth
                            @php
                                $userIsOwner = $comment->user_id === auth()->id();
                                $userIsAdminOrEditor = auth()->user()->hasRole('admin') || auth()->user()->hasRole('editor');
                            @endphp

                            <div class="absolute top-2 right-2 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                @if($userIsOwner)
                                    <button @click="editMode = true" class="text-orange-600 hover:text-orange-800 text-lg" title="Editar" type="button">✏️</button>
                                @endif

                                @if($userIsOwner || $userIsAdminOrEditor)
                                    <form method="POST" action="{{ route('comments.destroy', $comment) }}" onsubmit="return confirmDelete(event)" id="delete-comment-{{ $comment->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-lg" title="Eliminar">🗑️</button>
                                    </form>
                                @endif

                                <button onclick="confirmReport({{ $comment->id }})" class="text-yellow-500 hover:text-yellow-700 text-sm" title="Reportar">Reportar</button>
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

    function confirmEdit(commentId) {
        Swal.fire({
            title: 'Editar comentario',
            text: "¿Quieres editar este comentario?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `/comments/${commentId}/edit`;
            }
        });
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
