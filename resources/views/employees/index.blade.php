@extends('layouts.app')

@section('title', 'Funcionários')
@section('page-title', 'Funcionários')

@section('content')
<div class="space-y-5 pt-2">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <form method="GET" action="{{ route('employees.index') }}" class="flex gap-2 flex-1 max-w-md">
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nome, e-mail, matrícula..."
                    class="form-input pl-9">
            </div>
            <button type="submit" class="btn-secondary">Buscar</button>
        </form>
        <a href="{{ route('employees.create') }}" class="btn-primary shrink-0">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            Cadastrar Funcionário
        </a>
    </div>

    <div class="card overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="text-left px-6 py-3.5 font-semibold text-slate-600 text-xs uppercase tracking-wider">Funcionário</th>
                    <th class="text-left px-4 py-3.5 font-semibold text-slate-600 text-xs uppercase tracking-wider hidden sm:table-cell">Departamento</th>
                    <th class="text-left px-4 py-3.5 font-semibold text-slate-600 text-xs uppercase tracking-wider hidden md:table-cell">Matrícula</th>
                    <th class="text-center px-4 py-3.5 font-semibold text-slate-600 text-xs uppercase tracking-wider">Empréstimos</th>
                    <th class="text-center px-4 py-3.5 font-semibold text-slate-600 text-xs uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3.5"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($employees as $employee)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#1e3a8a] text-white text-xs font-bold">
                                {{ strtoupper(substr($employee->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-medium text-slate-800">{{ $employee->name }}</p>
                                <p class="text-xs text-slate-500">{{ $employee->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-4 text-slate-600 hidden sm:table-cell">{{ $employee->department ?? '—' }}</td>
                    <td class="px-4 py-4 text-slate-600 hidden md:table-cell">{{ $employee->registration ?? '—' }}</td>
                    <td class="px-4 py-4 text-center">
                        @if($employee->active_loans_count > 0)
                            <span class="badge-borrowed">{{ $employee->active_loans_count }} ativo{{ $employee->active_loans_count > 1 ? 's' : '' }}</span>
                        @else
                            <span class="text-slate-400 text-xs">Nenhum</span>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-center">
                        @if($employee->active)
                            <span class="badge-available">Ativo</span>
                        @else
                            <span class="badge-returned">Inativo</span>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('employees.show', $employee) }}" class="rounded-lg px-3 py-1.5 text-xs font-medium bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">Ver</a>
                            <a href="{{ route('employees.edit', $employee) }}" class="rounded-lg px-3 py-1.5 text-xs font-medium bg-amber-100 hover:bg-amber-200 text-amber-800 transition-colors">Editar</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center text-slate-400 text-sm">
                        Nenhum funcionário encontrado.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $employees->links() }}</div>
</div>
@endsection
