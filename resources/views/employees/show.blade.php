@extends('layouts.app')

@section('title', $employee->name)
@section('page-title', 'Perfil do Funcionário')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('employees.index') }}" class="btn-ghost">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Voltar
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Profile card --}}
        <div class="card p-6 text-center">
            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-[#1e3a8a] text-white text-2xl font-bold shadow-lg mb-4">
                {{ strtoupper(substr($employee->name, 0, 1)) }}
            </div>
            <h2 class="text-xl font-bold text-slate-800">{{ $employee->name }}</h2>
            <p class="text-slate-500 text-sm mt-1">{{ $employee->email }}</p>
            @if($employee->department)
                <p class="text-xs text-slate-400 mt-1">{{ $employee->department }}</p>
            @endif

            <div class="mt-4">
                @if($employee->active)
                    <span class="badge-available">Ativo</span>
                @else
                    <span class="badge-returned">Inativo</span>
                @endif
            </div>

            <div class="mt-5 space-y-2">
                <a href="{{ route('employees.edit', $employee) }}" class="btn-primary w-full justify-center">Editar</a>
                <a href="{{ route('loans.create', ['employee_id' => $employee->id]) }}" class="btn-secondary w-full justify-center">Novo Empréstimo</a>
                <form method="POST" action="{{ route('employees.destroy', $employee) }}" onsubmit="return confirm('Tem certeza?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-danger w-full justify-center">Excluir</button>
                </form>
            </div>
        </div>

        {{-- Info + Loans --}}
        <div class="lg:col-span-2 space-y-5">
            <div class="card p-6">
                <h3 class="font-semibold text-slate-800 mb-4">Informações</h3>
                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-xs text-slate-400 uppercase tracking-wide">Matrícula</dt>
                        <dd class="font-medium text-slate-700 mt-0.5">{{ $employee->registration ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-400 uppercase tracking-wide">Telefone</dt>
                        <dd class="font-medium text-slate-700 mt-0.5">{{ $employee->phone ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-400 uppercase tracking-wide">Departamento</dt>
                        <dd class="font-medium text-slate-700 mt-0.5">{{ $employee->department ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-400 uppercase tracking-wide">Cadastrado em</dt>
                        <dd class="font-medium text-slate-700 mt-0.5">{{ $employee->created_at->format('d/m/Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-400 uppercase tracking-wide">Total de Empréstimos</dt>
                        <dd class="font-medium text-slate-700 mt-0.5">{{ $employee->loans->count() }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-400 uppercase tracking-wide">Empréstimos Ativos</dt>
                        <dd class="font-medium text-slate-700 mt-0.5">{{ $employee->loans->whereNull('returned_at')->count() }}</dd>
                    </div>
                </dl>
            </div>

            <div class="card">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="font-semibold text-slate-800">Histórico de Empréstimos</h3>
                </div>
                @if($employee->loans->count() > 0)
                <div class="divide-y divide-slate-100">
                    @foreach($employee->loans as $loan)
                    <div class="flex items-center gap-4 px-6 py-3.5">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#1e3a8a]/10">
                            <svg class="h-5 w-5 text-[#1e3a8a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('books.show', $loan->book) }}" class="text-sm font-medium text-slate-800 hover:text-amber-700 truncate block">
                                {{ $loan->book->title }}
                            </a>
                            <p class="text-xs text-slate-500">
                                Retirada: {{ $loan->borrowed_at->format('d/m/Y') }}
                                @if($loan->returned_at)
                                    · Devolvido: {{ $loan->returned_at->format('d/m/Y') }}
                                @elseif($loan->due_date)
                                    · Prazo: {{ $loan->due_date->format('d/m/Y') }}
                                @endif
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            @if($loan->isReturned())
                                <span class="badge-returned">Devolvido</span>
                            @elseif($loan->isOverdue())
                                <span class="badge-overdue">Em atraso</span>
                                <a href="{{ route('loans.return', $loan) }}" class="rounded-lg px-2.5 py-1 text-xs font-medium bg-amber-100 hover:bg-amber-200 text-amber-800 transition-colors">Devolver</a>
                            @else
                                <span class="badge-borrowed">Ativo</span>
                                <a href="{{ route('loans.return', $loan) }}" class="rounded-lg px-2.5 py-1 text-xs font-medium bg-amber-100 hover:bg-amber-200 text-amber-800 transition-colors">Devolver</a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="px-6 py-8 text-center text-sm text-slate-400">
                    Nenhum empréstimo registrado para este funcionário.
                </div>
                @endif
            </div>

            {{-- Owned books --}}
            @if($employee->ownedBooks->count() > 0)
            <div class="card">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2">
                    <div class="flex h-6 w-6 items-center justify-center rounded-full bg-amber-100">
                        <svg class="h-3.5 w-3.5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-slate-800">Livros Doados ao Acervo</h3>
                    <span class="ml-auto rounded-full bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-700">
                        {{ $employee->ownedBooks->count() }}
                    </span>
                </div>
                <div class="divide-y divide-slate-100">
                    @foreach($employee->ownedBooks as $book)
                    <div class="flex items-center gap-4 px-6 py-3.5">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-50">
                            <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('books.show', $book) }}" class="text-sm font-medium text-slate-800 hover:text-amber-700 truncate block">
                                {{ $book->title }}
                            </a>
                            <p class="text-xs text-slate-500">{{ $book->author }}</p>
                        </div>
                        @if($book->status === 'available')
                            <span class="badge-available">Disponível</span>
                        @else
                            <span class="badge-borrowed">Emprestado</span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
