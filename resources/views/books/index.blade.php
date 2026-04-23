@extends('layouts.app')

@section('title', 'Livros')
@section('page-title', 'Acervo de Livros')

@section('content')
<div class="space-y-5">
    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <form method="GET" action="{{ route('books.index') }}" class="flex gap-2 flex-1 max-w-lg">
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por título, autor ou ISBN..."
                    class="form-input pl-9">
            </div>
            <select name="status" class="form-select w-36" onchange="this.form.submit()">
                <option value="">Todos</option>
                <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Disponíveis</option>
                <option value="borrowed" {{ request('status') === 'borrowed' ? 'selected' : '' }}>Emprestados</option>
            </select>
            <button type="submit" class="btn-secondary">Buscar</button>
        </form>
        <a href="{{ route('books.create') }}" class="btn-primary shrink-0">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Cadastrar Livro
        </a>
    </div>

    {{-- Grid --}}
    @if($books->count() > 0)
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-6">
        @foreach($books as $book)
        <div class="card group hover:shadow-md transition-shadow">
            <div class="relative overflow-hidden bg-gradient-to-br from-slate-100 to-slate-200" style="aspect-ratio: 2/3">
                @if($book->cover_image)
                    <img src="{{ $book->cover_image }}" alt="{{ $book->title }}"
                         class="h-full w-full object-cover"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                    <div class="h-full w-full items-center justify-center" style="display:none">
                        <svg class="h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                @else
                    <div class="flex h-full w-full items-center justify-center">
                        <svg class="h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                @endif
                <div class="absolute top-2 right-2">
                    @if($book->status === 'available')
                        <span class="badge-available">Disponível</span>
                    @else
                        <span class="badge-borrowed">Emprestado</span>
                    @endif
                </div>
            </div>
            <div class="p-3">
                <p class="text-sm font-semibold text-slate-800 line-clamp-2 leading-tight">{{ $book->title }}</p>
                <p class="text-xs text-slate-500 mt-1 truncate">{{ $book->author }}</p>
                @if($book->genre)
                    <p class="text-xs text-slate-400 mt-0.5">{{ $book->genre }}</p>
                @endif
                @if($book->owner)
                    <p class="text-xs text-amber-700 mt-1 truncate" title="Dono: {{ $book->owner->name }}">
                        ● {{ $book->owner->name }}
                    </p>
                @endif
                <div class="mt-3 flex gap-1.5">
                    <a href="{{ route('books.show', $book) }}" class="flex-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-xs font-medium text-slate-700 py-1.5 text-center transition-colors">Ver</a>
                    <a href="{{ route('books.edit', $book) }}" class="flex-1 rounded-lg bg-amber-100 hover:bg-amber-200 text-xs font-medium text-amber-800 py-1.5 text-center transition-colors">Editar</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div>
        {{ $books->links() }}
    </div>
    @else
        <div class="card px-6 py-16 text-center">
            <svg class="mx-auto h-12 w-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <p class="text-slate-500 text-sm">Nenhum livro encontrado.</p>
            <a href="{{ route('books.create') }}" class="mt-4 btn-primary inline-flex">Cadastrar primeiro livro</a>
        </div>
    @endif
</div>
@endsection
