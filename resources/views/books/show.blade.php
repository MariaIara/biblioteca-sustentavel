@extends('layouts.app')

@section('title', $book->title)
@section('page-title', 'Detalhes do Livro')

@section('content')
<div class="space-y-6 pt-2">
    <div class="flex items-center gap-4">
        <a href="{{ route('books.index') }}" class="btn-ghost">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Voltar
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Cover + Status --}}
        <div class="space-y-4">
            <div class="card overflow-hidden">
                @if($book->cover_image)
                    <img src="{{ $book->cover_image }}" alt="{{ $book->title }}" class="w-full object-cover" style="aspect-ratio:2/3" onerror="this.parentElement.innerHTML='<div class=\'flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 h-full\'><svg class=\'h-20 w-20 text-slate-300\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253\'/></svg></div>'">
                @else
                    <div class="flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200" style="aspect-ratio:2/3">
                        <svg class="h-20 w-20 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                @endif
            </div>

            <div class="card p-4 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-500">Status</span>
                    @if($book->status === 'available')
                        <span class="badge-available">Disponível</span>
                    @else
                        <span class="badge-borrowed">Emprestado</span>
                    @endif
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('books.edit', $book) }}" class="btn-primary flex-1 justify-center">Editar</a>
                    @if($book->status === 'available')
                        <a href="{{ route('loans.create', ['book_id' => $book->id]) }}" class="btn-secondary flex-1 justify-center">Emprestar</a>
                    @endif
                </div>

                <form method="POST" action="{{ route('books.destroy', $book) }}" onsubmit="return confirm('Tem certeza que deseja excluir este livro?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-danger w-full justify-center">Excluir</button>
                </form>
            </div>
        </div>

        {{-- Details --}}
        <div class="lg:col-span-2 space-y-5">
            <div class="card p-6">
                <h1 class="text-2xl font-bold text-slate-800">{{ $book->title }}</h1>
                <p class="text-lg text-slate-600 mt-1">{{ $book->author }}</p>

                @if($book->owner)
                <div class="mt-3 flex items-center gap-2">
                    <div class="flex h-7 w-7 items-center justify-center rounded-full bg-amber-500 text-white text-xs font-bold shrink-0">
                        {{ strtoupper(substr($book->owner->name, 0, 1)) }}
                    </div>
                    <p class="text-sm text-slate-600">
                        Doado por
                        <a href="{{ route('employees.show', $book->owner) }}" class="font-semibold text-amber-700 hover:text-amber-800">
                            {{ $book->owner->name }}
                        </a>
                        @if($book->owner->department)
                            <span class="text-slate-400">({{ $book->owner->department }})</span>
                        @endif
                    </p>
                </div>
                @endif

                <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                    @if($book->isbn)
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">ISBN</p>
                        <p class="font-medium text-slate-700 mt-0.5">{{ $book->isbn }}</p>
                    </div>
                    @endif
                    @if($book->genre)
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Gênero</p>
                        <p class="font-medium text-slate-700 mt-0.5">{{ $book->genre }}</p>
                    </div>
                    @endif
                    @if($book->year)
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Ano</p>
                        <p class="font-medium text-slate-700 mt-0.5">{{ $book->year }}</p>
                    </div>
                    @endif
                    @if($book->publisher)
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Editora</p>
                        <p class="font-medium text-slate-700 mt-0.5">{{ $book->publisher }}</p>
                    </div>
                    @endif
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Cadastrado em</p>
                        <p class="font-medium text-slate-700 mt-0.5">{{ $book->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>

                @if($book->description)
                <div class="mt-5 pt-5 border-t border-slate-100">
                    <p class="text-xs text-slate-400 uppercase tracking-wide mb-2">Sinopse</p>
                    <p class="text-sm text-slate-700 leading-relaxed">{{ $book->description }}</p>
                </div>
                @endif
            </div>

            {{-- Loan history --}}
            <div class="card">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h2 class="font-semibold text-slate-800">Histórico de Empréstimos</h2>
                </div>
                @if($book->loans->count() > 0)
                <div class="divide-y divide-slate-100">
                    @foreach($book->loans as $loan)
                    <div class="flex items-center gap-4 px-6 py-3.5">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#1e3a8a]/10 text-[#1e3a8a] text-xs font-bold">
                            {{ strtoupper(substr($loan->employee->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-800">{{ $loan->employee->name }}</p>
                            <p class="text-xs text-slate-500">
                                Retirada: {{ $loan->borrowed_at->format('d/m/Y') }}
                                @if($loan->returned_at)
                                    · Devolvido: {{ $loan->returned_at->format('d/m/Y') }}
                                @elseif($loan->due_date)
                                    · Devolução prevista: {{ $loan->due_date->format('d/m/Y') }}
                                @endif
                            </p>
                        </div>
                        @if($loan->isReturned())
                            <span class="badge-returned">Devolvido</span>
                        @elseif($loan->isOverdue())
                            <span class="badge-overdue">Em atraso</span>
                        @else
                            <span class="badge-borrowed">Ativo</span>
                        @endif
                    </div>
                    @endforeach
                </div>
                @else
                <div class="px-6 py-8 text-center text-sm text-slate-400">
                    Nenhum empréstimo registrado para este livro.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
