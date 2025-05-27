<x-layouts.layout titulo="Panel de Reportes">
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold mb-6">Reportes Recientes</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">{{ session('error') }}</div>
        @endif

        <table class="w-full border-collapse border">
            <thead>
            <tr class="bg-purple-900">
                <th class="border p-2 text-white">ID</th>
                <th class="border p-2 text-white">Tipo</th>
                <th class="border p-2 text-white">ID Contenido</th>
                <th class="border p-2 text-white">Reportado por</th>
                <th class="border p-2 text-white">Fecha</th>
                <th class="border p-2 text-white">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reports as $report)
                <tr class="border-purple-900">
                    <td class="border p-2 border-purple-900">{{ $report->id }}</td>
                    <td class="border p-2 border-purple-900">{{ ucfirst($report->content_type) }}</td>
                    <td class="border p-2 border-purple-900">{{ $report->content_id }}</td>
                    <td class="border p-2 border-purple-900">{{ $report->user->name ?? 'Usuario eliminado' }}</td>
                    <td class="border p-2 border-purple-900">{{ $report->created_at->format('d/m/Y') }}</td>
                    <td class="border p-2 space-x-2 border-purple-900">
                        <form action="{{ route('admin.report.safe', $report->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="text-blue-600 hover:underline">Marcar como seguro</button>
                        </form>
                        <form action="{{ route('admin.report.delete', $report->id) }}" method="POST" class="inline"
                              onsubmit="return confirm('¿Estás seguro de eliminar este contenido?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
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
