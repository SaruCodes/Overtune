<x-layouts.layout titulo="Editar Noticia">
    <div class="container">
        <h1>Editar Noticia</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('news.update', $news->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title">Título</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $news->title) }}" required>
            </div>

            <div class="mb-3">
                <label for="content">Contenido</label>
                <textarea name="content" class="form-control" rows="5" required>{{ old('content', $news->content) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="category_id">Categoría</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Selecciona una categoría</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $news->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->category }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Noticia</button>
        </form>
    </div>
</x-layouts.layout>
