<x-layouts.layout titulo="Reseña - {{ $review->album->title }}">
    <div class="max-w-4xl mx-auto px-6 py-12 bg-white shadow-lg rounded mt-12 mb-16">

        <div class="flex gap-6 mb-6 items-center">
            <img src="{{ asset('storage/' . $review->album->cover_image) }}" alt="{{ $review->album->title }}" class="w-48 h-48 object-cover rounded-lg shadow">
            <div>
                <h1 class="text-3xl font-bold mb-1">{{ $review->album->title }}</h1>
                <p class="text-lg text-gray-700 mb-2">{{ $review->album->artist->name }} &bull; {{ $review->album->year }}</p>
                <div class="mt-1 flex space-x-1 text-yellow-500 select-none">
                    @for ($i = 1; $i <= 5; $i++)
                        @php
                            $diff = $review->rating - $i;
                        @endphp
                        @if($diff >= 0)
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" >
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.974a1 1 0 00.95.69h4.178c.969 0 1.371 1.24.588 1.81l-3.38 2.455a1 1 0 00-.364 1.118l1.287 3.973c.3.922-.755 1.688-1.538 1.118l-3.38-2.454a1 1 0 00-1.176 0l-3.38 2.454c-.783.57-1.838-.196-1.538-1.118l1.287-3.973a1 1 0 00-.364-1.118L2.036 9.4c-.783-.57-.38-1.81.588-1.81h4.178a1 1 0 00.95-.69l1.286-3.974z" />
                            </svg>
                        @elseif($diff > -1 && $diff < 0)
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 20 20" fill="currentColor">
                                <defs>
                                    <linearGradient id="half-grad-{{ $i }}" x1="0" y1="0" x2="1" y2="0">
                                        <stop offset="50%" stop-color="currentColor"/>
                                        <stop offset="50%" stop-color="transparent"/>
                                    </linearGradient>
                                </defs>
                                <path fill="url(#half-grad-{{ $i }})" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.974a1 1 0 00.95.69h4.178c.969 0 1.371 1.24.588 1.81l-3.38 2.455a1 1 0 00-.364 1.118l1.287 3.973c.3.922-.755 1.688-1.538 1.118l-3.38-2.454a1 1 0 00-1.176 0l-3.38 2.454c-.783.57-1.838-.196-1.538-1.118l1.287-3.973a1 1 0 00-.364-1.118L2.036 9.4c-.783-.57-.38-1.81.588-1.81h4.178a1 1 0 00.95-.69l1.286-3.974z" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.974a1 1 0 00.95.69h4.178c.969 0 1.371 1.24.588 1.81l-3.38 2.455a1 1 0 00-.364 1.118l1.287 3.973c.3.922-.755 1.688-1.538 1.118l-3.38-2.454a1 1 0 00-1.176 0l-3.38 2.454c-.783.57-1.838-.196-1.538-1.118l1.287-3.973a1 1 0 00-.364-1.118L2.036 9.4c-.783-.57-.38-1.81.588-1.81h4.178a1 1 0 00.95-.69l1.286-3.974z" />
                            </svg>
                        @endif
                    @endfor
                </div>

            </div>
        </div>

        <div class="mb-10">
            <p class="font-bold pb-6">Por {{ $review->user->name }} el {{ $review->created_at->format('d/m/Y') }}</p>
            <p class="text-gray-800 whitespace-pre-wrap text-lg leading-relaxed">{{ $review->content }}</p>
            @auth
                @php
                    $userIsOwner = $review->user_id === auth()->id();
                    $userIsAdminOrEditor = auth()->user()->hasRole('admin') || auth()->user()->hasRole('editor');
                @endphp

                <div class="flex gap-4 mt-4">
                    @if($userIsOwner)
                        <a href="{{ route('reviews.edit', $review) }}" class="btn btn-sm btn-primary">Editar</a>
                    @endif

                    @if($userIsOwner || $userIsAdminOrEditor)
                        <form method="POST" action="{{ route('reviews.destroy', $review) }}" onsubmit="return confirmDelete(event)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-error text-white">Eliminar</button>
                        </form>
                    @endif
                    <button onclick="confirmReport('reviews', {{ $review->id }})" class="btn btn-sm btn-warning text-white">Reportar</button>
                </div>
            @endauth
        </div>

        <div class="max-w-4xl mx-auto mt-12 p-6 bg-gray-50 rounded-lg shadow-inner">
            <h2 class="text-2xl font-semibold mb-6">Deja tu comentario</h2>
            @auth
                <form method="POST" action="{{ route('comments.store') }}">
                    @csrf
                    <input type="hidden" name="commentable_type" value="reviews">
                    <input type="hidden" name="commentable_id" value="{{ $review->id }}">
                    <textarea name="content" class="textarea textarea-bordered w-full h-32 mb-4 resize-none focus:ring-2 focus:ring-blue-500" placeholder="Escribe tu comentario aquí..." required></textarea>
                    <button class="btn btn-primary hover:bg-blue-600 transition">Enviar Comentario</button>
                </form>
            @else
                <p class="text-gray-600">Debes iniciar sesión para comentar.</p>
            @endauth

            <div class="mt-10 space-y-6">
                @foreach ($comments as $comment)
                    <div
                        x-data="{
                            editMode: false,
                            content: '{{ addslashes($comment->content) }}',
                            originalContent: '{{ addslashes($comment->content) }}'
                        }"
                        class="border rounded-lg bg-white shadow-sm p-4 relative group hover:shadow-lg transition-shadow">
                        <div class="flex items-center gap-4 mb-3">
                            <img src="{{ $comment->user->avatar ? asset('storage/' . $comment->user->avatar) : 'https://img.daisyui.com/images/profile/demo/yellingcat@192.webp' }}"
                                 alt="{{ $comment->user->name }}" class="w-10 h-10 rounded-full object-cover shadow-sm">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $comment->user->name }}</p>
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
                                <textarea name="content" x-model="content" class="textarea textarea-bordered w-full h-24 resize-none focus:ring-2 focus:ring-purple-900" required></textarea>
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

                            <div class="absolute top-3 right-3 flex gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                @if($userIsOwner)
                                    <button @click="editMode = true" type="button" title="Editar comentario" class="text-indigo-600 hover:text-indigo-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="hover:text-blue-600 w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                        </svg>
                                    </button>
                                @endif

                                @if($userIsOwner || $userIsAdminOrEditor)
                                    <form method="POST" action="{{ route('comments.destroy', $comment) }}" onsubmit="return confirmDelete(event)" id="delete-comment-{{ $comment->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Eliminar comentario" class="text-red-600 hover:text-red-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9M4.772 5.79a48.108 48.108 0 013.478-.397m7.5 0a48.11 48.11 0 013.478.397M18 14v4.75A2.25 2.25 0 0115.75 21H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                                    <button onclick="confirmReport('comments', {{ $comment->id }})" title="Reportar comentario" class="text-secondary hover:text-yellow-700 font-semibold text-sm self-center">
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
