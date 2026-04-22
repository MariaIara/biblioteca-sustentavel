@extends('layouts.app')

@section('title', 'Editar Livro')
@section('page-title', 'Editar Livro')

@section('content')
<div class="max-w-2xl pt-2">
    <div class="flex items-center gap-4 mb-5">
        <a href="{{ route('books.show', $book) }}" class="btn-ghost">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Voltar
        </a>
    </div>

    <div class="card">
        <div class="px-6 py-4 border-b border-slate-100">
            <h2 class="font-semibold text-slate-800">Editar: {{ $book->title }}</h2>
        </div>

        <form method="POST" action="{{ route('books.update', $book) }}" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="title" class="form-label">Título <span class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title', $book->title) }}"
                        class="form-input @error('title') border-red-400 @enderror">
                    @error('title') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="author" class="form-label">Autor <span class="text-red-500">*</span></label>
                    <input type="text" id="author" name="author" value="{{ old('author', $book->author) }}"
                        class="form-input @error('author') border-red-400 @enderror">
                    @error('author') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="isbn" class="form-label">ISBN</label>
                    <input type="text" id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}" class="form-input">
                </div>

                <div>
                    <label for="genre" class="form-label">Gênero</label>
                    <input type="text" id="genre" name="genre" value="{{ old('genre', $book->genre) }}" class="form-input">
                </div>

                <div>
                    <label for="year" class="form-label">Ano</label>
                    <input type="number" id="year" name="year" value="{{ old('year', $book->year) }}"
                        class="form-input" min="1000" max="{{ date('Y') }}">
                </div>

                <div class="sm:col-span-2">
                    <label for="publisher" class="form-label">Editora</label>
                    <input type="text" id="publisher" name="publisher" value="{{ old('publisher', $book->publisher) }}" class="form-input">
                </div>

                <div class="sm:col-span-2">
                    <label for="owner_id" class="form-label">Dono do Livro</label>
                    <select id="owner_id" name="owner_id" class="form-select">
                        <option value="">Sem dono definido</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('owner_id', $book->owner_id) == $employee->id ? 'selected' : '' }}>
                                {{ $employee->name }}{{ $employee->department ? ' — ' . $employee->department : '' }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-slate-400">Funcionário que trouxe o livro para o acervo.</p>
                </div>

                <div class="sm:col-span-2">
                    <label for="description" class="form-label">Sinopse</label>
                    <textarea id="description" name="description" rows="4" class="form-textarea">{{ old('description', $book->description) }}</textarea>
                </div>

                <div class="sm:col-span-2">
                    <label for="cover_image" class="form-label">Link da Capa</label>
                    <div class="flex gap-3 items-start">
                        <div class="flex-1">
                            <input type="url" id="cover_image" name="cover_image"
                                value="{{ old('cover_image', $book->cover_image) }}"
                                class="form-input @error('cover_image') border-red-400 @enderror"
                                placeholder="https://..."
                                oninput="previewCover(this.value)">
                            <p class="mt-1 text-xs text-slate-400">
                                Cole o link direto de uma imagem da web.
                            </p>
                            @error('cover_image') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div id="cover-preview-wrap" class="{{ old('cover_image', $book->cover_image) ? '' : 'hidden' }} shrink-0">
                            <img id="cover-preview"
                                src="{{ old('cover_image', $book->cover_image) }}"
                                alt="Preview da capa"
                                class="h-28 w-20 rounded-lg object-cover shadow border border-slate-200"
                                onerror="this.parentElement.classList.add('hidden')">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Salvar Alterações
                </button>
                <a href="{{ route('books.show', $book) }}" class="btn-ghost">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
function previewCover(url) {
    const wrap = document.getElementById('cover-preview-wrap');
    const img  = document.getElementById('cover-preview');
    if (url) {
        img.src = url;
        wrap.classList.remove('hidden');
    } else {
        wrap.classList.add('hidden');
    }
}
</script>
@endsection
