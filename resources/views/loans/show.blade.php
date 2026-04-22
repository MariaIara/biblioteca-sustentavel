@extends('layouts.app')

@section('title', 'Empréstimo #' . $loan->id)
@section('page-title', 'Detalhes do Empréstimo')

@section('content')
<div class="space-y-6 pt-2">
    <div class="flex items-center gap-4">
        <a href="{{ route('loans.index') }}" class="btn-ghost">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Voltar
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        {{-- Loan info --}}
        <div class="card p-6 space-y-5">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-slate-800">Empréstimo #{{ $loan->id }}</h2>
                @if($loan->isReturned())
                    <span class="badge-returned">Devolvido</span>
                @elseif($loan->isOverdue())
                    <span class="badge-overdue">Em atraso</span>
                @else
                    <span class="badge-borrowed">Ativo</span>
                @endif
            </div>

            <dl class="space-y-3 text-sm">
                <div class="flex justify-between items-start">
                    <dt class="text-slate-500">Data de Retirada</dt>
                    <dd class="font-medium text-slate-800">{{ $loan->borrowed_at->format('d/m/Y') }}</dd>
                </div>
                <div class="flex justify-between items-start">
                    <dt class="text-slate-500">Devolução Prevista</dt>
                    <dd class="font-medium {{ $loan->isOverdue() ? 'text-red-600' : 'text-slate-800' }}">
                        {{ $loan->due_date ? $loan->due_date->format('d/m/Y') : '—' }}
                    </dd>
                </div>
                <div class="flex justify-between items-start">
                    <dt class="text-slate-500">Data de Devolução</dt>
                    <dd class="font-medium text-emerald-700">
                        {{ $loan->returned_at ? $loan->returned_at->format('d/m/Y') : '—' }}
                    </dd>
                </div>
                @if($loan->notes)
                <div class="pt-3 border-t border-slate-100">
                    <dt class="text-slate-500 mb-1">Observações</dt>
                    <dd class="text-slate-700 leading-relaxed">{{ $loan->notes }}</dd>
                </div>
                @endif
            </dl>

            @if(!$loan->isReturned())
                <a href="{{ route('loans.return', $loan) }}" class="btn-primary w-full justify-center">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                    </svg>
                    Registrar Devolução
                </a>
            @endif

            <form method="POST" action="{{ route('loans.destroy', $loan) }}" onsubmit="return confirm('Excluir este empréstimo?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger w-full justify-center">Excluir</button>
            </form>
        </div>

        <div class="space-y-5">
            {{-- Book card --}}
            <div class="card p-5 flex gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#1e3a8a]/10">
                    <svg class="h-6 w-6 text-[#1e3a8a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Livro</p>
                    <a href="{{ route('books.show', $loan->book) }}" class="font-semibold text-slate-800 hover:text-amber-700">
                        {{ $loan->book->title }}
                    </a>
                    <p class="text-sm text-slate-500 mt-0.5">{{ $loan->book->author }}</p>
                </div>
            </div>

            {{-- Employee card --}}
            <div class="card p-5 flex gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#1e3a8a] text-white font-bold">
                    {{ strtoupper(substr($loan->employee->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Funcionário</p>
                    <a href="{{ route('employees.show', $loan->employee) }}" class="font-semibold text-slate-800 hover:text-amber-700">
                        {{ $loan->employee->name }}
                    </a>
                    <p class="text-sm text-slate-500 mt-0.5">{{ $loan->employee->email }}</p>
                    @if($loan->employee->department)
                        <p class="text-xs text-slate-400 mt-0.5">{{ $loan->employee->department }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
