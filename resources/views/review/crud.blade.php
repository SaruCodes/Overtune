<x-layouts.layout titulo="{{ __('Overtune - Mis Reseñas') }}">
    <div class="min-h-screen flex flex-col">
        @if (session('success'))
            <div id="message" role="alert" class="alert alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="p-4 bg-gray-200 flex justify-between items-center">
            <div class="space-x-4">
                <a class="btn btn-secondary text-lg" href="{{ route('user.profile') }}">
                    {{ __('Volver') }}
                </a>
            </div>
        </div>

        <div class="overflow-x-auto p-4 flex-grow">
            <table class="table-auto w-full border-collapse border border-gray-300 text-base text-gray-800">
                <thead class="bg-indigo-400 text-xl font-bold">
                <tr>
                    <th class="border border-gray-400 p-2">Álbum</th>
                    <th class="border border-gray-400 p-2">Artista</th>
                    <th class="border border-gray-400 p-2">Puntaje</th>
                    <th class="border border-gray-400 p-2">Contenido</th>
                    <th class="border border-gray-400 p-2">Fecha</th>
                    <th class="border border-gray-400 p-2">Acciones</th>
                </tr>
                </thead>
                <tbody class="bg-white">
                @forelse($reviews as $review)
                    <tr class="border border-gray-300 hover:bg-gray-100">
                        <td class="border border-gray-300 p-3">{{ $review->album->title }}</td>
                        <td class="border border-gray-300 p-3">{{ $review->album->artist->name }}</td>
                        <td class="border border-gray-300 p-3">{{ $review->rating }}/5</td>
                        <td class="border border-gray-300 p-3">{{ Str::limit($review->content, 100) }}</td>
                        <td class="border border-gray-300 p-3">{{ $review->created_at->format('d/m/Y') }}</td>
                        <td class="border border-gray-300 p-3 flex space-x-2">
                            <a href="{{ route('review.edit', $review) }}" class="hover:text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                </svg>
                            </a>
                            <form id="delete-form-{{ $review->id }}" action="{{ route('review.destroy', $review) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete({{ $review->id }})" class="text-red-600 hover:text-red-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.74 9l-.346 9m-4.788 0L9.26 9M4.772 5.79a48.108 48.108 0 013.478-.397m7.5 0a48.11 48.11 0 013.478.397M18 14v4.75A2.25 2.25 0 0115.75 21H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center p-4">No tienes reseñas todavía.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $reviews->onEachSide(1)->links('components.pagination') }}
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: '¿Confirmar borrado?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#783F8E',
                cancelButtonColor: '#f18701',
                confirmButtonText: 'Sí, borrar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("delete-form-" + id).submit();
                }
            });
        }

        setTimeout(() => {
            const msg = document.getElementById('message');
            if (msg) {
                msg.style.transition = 'opacity 0.5s ease';
                msg.style.opacity = '0';
                setTimeout(() => msg.remove(), 500);
            }
        }, 5000);
    </script>
</x-layouts.layout>
