<x-layouts.layout titulo="Panel de Reportes">
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold mb-6 flex items-center justify-between">
            Reportes Recientes
            <a href="{{ route('admin.panel') }}"
               class="bg-accent hover:bg-orange-700 text-white text-sm py-2 px-4 rounded">
                ← Volver
            </a>
        </h1>
        <table class="w-full border-collapse border shadow">
            <thead>
            <tr class="bg-purple-900 text-white">
                <th class="border p-2">ID</th>
                <th class="border p-2">Tipo</th>
                <th class="border p-2">Contenido</th>
                <th class="border p-2">Reportado por</th>
                <th class="border p-2">Fecha</th>
                <th class="border p-2">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reports as $report)
                @php
                    $type = class_basename($report->reportable);
                @endphp
                <tr class="hover:bg-purple-50">
                    <td class="border p-2 border-purple-900">{{ $report->id }}</td>
                    <td class="border p-2 border-purple-900">
                        {{ $type === 'Review' ? 'Reseña' : 'Comentario' }}
                    </td>
                    <td class="border p-2 border-purple-900">
                        @if($type === 'Review' && $report->reportable)
                            <a href="{{ route('review.show', $report->reportable->id) }}"
                               class="text-blue-600 underline hover:text-blue-800"
                               title="Ver reseña completa">
                                {{ \Illuminate\Support\Str::limit($report->reportable->content, 80) }}
                            </a>
                        @elseif($type === 'Comment' && $report->reportable)
                            {{ \Illuminate\Support\Str::limit($report->reportable->content, 80) }}
                        @else
                            <em>Contenido no disponible</em>
                        @endif
                    </td>
                    <td class="border p-2 border-purple-900">{{ $report->user->name ?? 'Usuario eliminado' }}</td>
                    <td class="border p-2 border-purple-900">{{ $report->created_at->format('d/m/Y') }}</td>
                    <td class="border p-2 space-x-2 border-purple-900">
                        <form action="{{ route('admin.report.safe', $report->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white py-1 px-3 rounded">
                                Marcar como seguro
                            </button>
                        </form>
                        <form action="{{ route('admin.report.delete', $report->id) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('¿Estás seguro de eliminar este contenido?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $reports->links() }}
        </div>
    </div>
</x-layouts.layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: '{{ session('success') }}',
        confirmButtonColor: '#6b21a8'
    });
    @endif
    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session('error') }}',
        confirmButtonColor: '#b91c1c'
    });
    @endif
</script>
