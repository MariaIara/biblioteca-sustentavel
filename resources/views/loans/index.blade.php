@extends('layouts.app')

@section('title', 'Empréstimos')
@section('page-title', 'Empréstimos')

@section('content')
<div class="space-y-5 pt-2">
    {{-- Filters --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex gap-2 flex-wrap">
            <a href="{{ route('loans.index') }}"
               class="rounded-xl px-4 py-2 text-sm font-medium transition-colors {{ $filter === 'all' ? 'bg-[#1e3a8a] text-white' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
                Todos
            </a>
            <a href="{{ route('loans.index', ['filter' => 'active']) }}"
               class="rounded-xl px-4 py-2 text-sm font-medium transition-colors {{ $filter === 'active' ? 'bg-amber-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
                Ativos
            </a>
            <a href="{{ route('loans.index', ['filter' => 'overdue']) }}"
               class="rounded-xl px-4 py-2 text-sm font-medium transition-colors {{ $filter === 'overdue' ? 'bg-red-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
                Em Atraso
            </a>
            <a href="{{ route('loans.index', ['filter' => 'returned']) }}"
               class="rounded-xl px-4 py-2 text-sm font-medium transition-colors {{ $filter === 'returned' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
                Devolvidos
            </a>
        </div>
        <a href="{{ route('loans.create') }}" class="btn-primary shrink-0">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Novo Empréstimo
        </a>
    </div>

    <div class="card overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="text-left px-6 py-3.5 font-semibold text-slate-600 text-xs uppercase tracking-wider">Livro</th>
                    <th class="text-left px-4 py-3.5 font-semibold text-slate-600 text-xs uppercase tracking-wider">Funcionário</th>
                    <th class="text-center px-4 py-3.5 font-semibold text-slate-600 text-xs uppercase tracking-wider hidden sm:table-cell">Retirada</th>
                    <th class="text-center px-4 py-3.5 font-semibold text-slate-600 text-xs uppercase tracking-wider hidden md:table-cell">Prazo</th>
                    <th class="text-center px-4 py-3.5 font-semibold text-slate-600 text-xs uppercase tracking-wider hidden md:table-cell">Devolução</th>
                    <th class="text-center px-4 py-3.5 font-semibold text-slate-600 text-xs uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3.5"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($loans as $loan)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        <a href="{{ route('books.show', $loan->book) }}" class="font-medium text-slate-800 hover:text-amber-700 line-clamp-1">
                            {{ $loan->book->title }}
                        </a>
                        <p class="text-xs text-slate-400">{{ $loan->book->author }}</p>
                    </td>
                    <td class="px-4 py-4">
                        <a href="{{ route('employees.show', $loan->employee) }}" class="font-medium text-slate-700 hover:text-amber-700">
                            {{ $loan->employee->name }}
                        </a>
                        <p class="text-xs text-slate-400 hidden sm:block">{{ $loan->employee->department }}</p>
                    </td>
                    <td class="px-4 py-4 text-center text-slate-600 hidden sm:table-cell">
                        {{ $loan->borrowed_at->format('d/m/Y') }}
                    </td>
                    <td class="px-4 py-4 text-center hidden md:table-cell">
                        @if($loan->due_date)
                            <span class="{{ $loan->isOverdue() ? 'text-red-600 font-semibold' : 'text-slate-600' }}">
                                {{ $loan->due_date->format('d/m/Y') }}
                            </span>
                        @else
                            <span class="text-slate-400">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-center text-slate-600 hidden md:table-cell">
                        {{ $loan->returned_at ? $loan->returned_at->format('d/m/Y') : '—' }}
                    </td>
                    <td class="px-4 py-4 text-center">
                        @if($loan->isReturned())
                            <span class="badge-returned">Devolvido</span>
                        @elseif($loan->isOverdue())
                            <span class="badge-overdue">Em atraso</span>
                        @else
                            <span class="badge-borrowed">Ativo</span>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-right">
                        <div class="flex items-center justify-end gap-1.5">
                            <a href="{{ route('loans.show', $loan) }}" class="rounded-lg px-2.5 py-1.5 text-xs font-medium bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">Ver</a>
                            @if(!$loan->isReturned())
                                <a href="{{ route('loans.return', $loan) }}" class="rounded-lg px-2.5 py-1.5 text-xs font-medium bg-amber-100 hover:bg-amber-200 text-amber-800 transition-colors">Devolver</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center text-slate-400 text-sm">
                        Nenhum empréstimo encontrado.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $loans->links() }}</div>
</div>
@endsection
