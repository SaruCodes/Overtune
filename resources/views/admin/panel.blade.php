<x-layouts.layout titulo="Panel de Administracion">
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold mb-6">Panel de Control</h1>
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">{{ session('error') }}</div>
        @endif
        <!--Panel de reportes-->
        @if(auth()->user()->isAdmin())
        <div class="mb-6">
            <a href="{{ route('admin.report') }}" class="btn btn-secondary text-white font-semibold py-2 px-4 rounded">Ver Panel de Reportes</a>
        </div>
        @endif

    @if(auth()->user()->isAdmin())
            <section class="mb-8">
                <h2 class="text-xl font-semibold mb-4">Usuarios</h2>
                <table class="w-full border-collapse ">
                    <thead class="bg-purple-900">
                    <tr class="">
                        <th class="border p-2  text-white">ID</th>
                        <th class="border p-2 text-white">Nombre</th>
                        <th class="border p-2 text-white">Email</th>
                        <th class="border p-2 text-white">Rol</th>
                        <th class="border p-2 text-white">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="border p-2 border-purple-900">{{ $user->id }}</td>
                            <td class="border p-2 border-purple-900">{{ $user->name }}</td>
                            <td class="border p-2 border-purple-900">{{ $user->email }}</td>
                            <td class="border p-2 border-purple-900">
                                <form action="{{ route('users.updateRole', $user) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="role" onchange="this.form.submit()">
                                        <option value="user" @if($user->role === 'user') selected @endif>User</option>
                                        <option value="editor" @if($user->role === 'editor') selected @endif>Editor</option>
                                        <option value="admin" @if($user->role === 'admin') selected @endif>Admin</option>
                                    </select>
                                </form>
                            </td>
                            <td class="border p-2 border-purple-900">
                                @if(auth()->id() !== $user->id)
                                    <form action="" method="POST" onsubmit="return confirm('¿Eliminar usuario?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                    </form>
                                @else
                                    <em>No puedes eliminarte a ti mismo</em>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </section>
        @endif
        </section>
    </div>
</x-layouts.layout>
