@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6 pt-2">

    {{-- Stats cards --}}
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
        <div class="card col-span-2 sm:col-span-1 lg:col-span-2 p-5 flex items-center gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#1e3a8a]">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ $totalBooks }}</p>
                <p class="text-xs text-slate-500 mt-0.5">Total de Livros</p>
            </div>
        </div>

        <div class="card p-5 flex items-center gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-100">
                <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ $availableBooks }}</p>
                <p class="text-xs text-slate-500 mt-0.5">Disponíveis</p>
            </div>
        </div>

        <div class="card p-5 flex items-center gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-amber-100">
                <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ $borrowedBooks }}</p>
                <p class="text-xs text-slate-500 mt-0.5">Emprestados</p>
            </div>
        </div>

        <div class="card p-5 flex items-center gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-blue-100">
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ $totalEmployees }}</p>
                <p class="text-xs text-slate-500 mt-0.5">Funcionários</p>
            </div>
        </div>

        <div class="card p-5 flex items-center gap-4 {{ $overdueLoans > 0 ? 'border-red-200 bg-red-50' : '' }}">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl {{ $overdueLoans > 0 ? 'bg-red-100' : 'bg-slate-100' }}">
                <svg class="h-6 w-6 {{ $overdueLoans > 0 ? 'text-red-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold {{ $overdueLoans > 0 ? 'text-red-700' : 'text-slate-800' }}">{{ $overdueLoans }}</p>
                <p class="text-xs {{ $overdueLoans > 0 ? 'text-red-500' : 'text-slate-500' }} mt-0.5">Em Atraso</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Recent loans --}}
        <div class="lg:col-span-2 card">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <h2 class="font-semibold text-slate-800">Empréstimos Recentes</h2>
                <a href="{{ route('loans.index') }}" class="text-xs font-medium text-amber-700 hover:text-amber-800">Ver todos →</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentLoans as $loan)
                    <div class="flex items-center gap-4 px-6 py-3.5">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#1e3a8a]/10">
                            <svg class="h-5 w-5 text-[#1e3a8a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-800 truncate">{{ $loan->book->title }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ $loan->employee->name }}</p>
                        </div>
                        <div class="text-right shrink-0">
                            @if($loan->isReturned())
                                <span class="badge-returned">Devolvido</span>
                            @elseif($loan->isOverdue())
                                <span class="badge-overdue">Em atraso</span>
                            @else
                                <span class="badge-borrowed">Ativo</span>
                            @endif
                            <p class="text-xs text-slate-400 mt-1">{{ $loan->borrowed_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center text-sm text-slate-400">
                        Nenhum empréstimo registrado ainda.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Overdue / Quick actions --}}
        <div class="space-y-6">
            {{-- Quick actions --}}
            <div class="card p-5">
                <h2 class="font-semibold text-slate-800 mb-4">Ações Rápidas</h2>
                <div class="space-y-2.5">
                    <a href="{{ route('books.create') }}" class="flex items-center gap-3 rounded-xl p-3 hover:bg-amber-50 transition-colors group">
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-100 group-hover:bg-amber-200 transition-colors">
                            <svg class="h-5 w-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-slate-700">Cadastrar Livro</span>
                    </a>
                    <a href="{{ route('employees.create') }}" class="flex items-center gap-3 rounded-xl p-3 hover:bg-blue-50 transition-colors group">
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-100 group-hover:bg-blue-200 transition-colors">
                            <svg class="h-5 w-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-slate-700">Cadastrar Funcionário</span>
                    </a>
                    <a href="{{ route('loans.create') }}" class="flex items-center gap-3 rounded-xl p-3 hover:bg-emerald-50 transition-colors group">
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-100 group-hover:bg-emerald-200 transition-colors">
                            <svg class="h-5 w-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-slate-700">Novo Empréstimo</span>
                    </a>
                    <a href="{{ route('loans.index', ['filter' => 'active']) }}" class="flex items-center gap-3 rounded-xl p-3 hover:bg-slate-50 transition-colors group">
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 group-hover:bg-slate-200 transition-colors">
                            <svg class="h-5 w-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-slate-700">Ver Empréstimos Ativos</span>
                    </a>
                </div>
            </div>

            {{-- Overdue list --}}
            @if($overdueList->count() > 0)
            <div class="card border-red-200">
                <div class="flex items-center gap-2 px-5 py-4 border-b border-red-100 bg-red-50">
                    <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <h2 class="font-semibold text-red-700 text-sm">Devoluções em Atraso</h2>
                </div>
                <div class="divide-y divide-red-50">
                    @foreach($overdueList as $loan)
                        <div class="px-5 py-3">
                            <p class="text-sm font-medium text-slate-800 truncate">{{ $loan->book->title }}</p>
                            <p class="text-xs text-slate-500">{{ $loan->employee->name }}</p>
                            <p class="text-xs text-red-500 mt-0.5">Venceu em {{ $loan->due_date->format('d/m/Y') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
