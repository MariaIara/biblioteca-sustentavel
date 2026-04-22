@extends('layouts.app')

@section('title', 'Novo Empréstimo')
@section('page-title', 'Registrar Empréstimo')

@section('content')
<div class="max-w-xl pt-2">
    <div class="card">
        <div class="px-6 py-4 border-b border-slate-100">
            <h2 class="font-semibold text-slate-800">Novo Empréstimo</h2>
            <p class="text-sm text-slate-500 mt-0.5">Vincule um livro disponível a um funcionário.</p>
        </div>

        <form method="POST" action="{{ route('loans.store') }}" class="p-6 space-y-5">
            @csrf

            <div>
                <label for="book_id" class="form-label">Livro <span class="text-red-500">*</span></label>
                @if($availableBooks->count() > 0)
                    <select id="book_id" name="book_id" class="form-select @error('book_id') border-red-400 @enderror">
                        <option value="">Selecione um livro disponível...</option>
                        @foreach($availableBooks as $book)
                            <option value="{{ $book->id }}" {{ old('book_id', request('book_id')) == $book->id ? 'selected' : '' }}>
                                {{ $book->title }} — {{ $book->author }}
                            </option>
                        @endforeach
                    </select>
                @else
                    <div class="rounded-xl bg-amber-50 border border-amber-200 px-4 py-3 text-sm text-amber-800">
                        Nenhum livro disponível para empréstimo no momento.
                        <a href="{{ route('books.create') }}" class="font-semibold underline">Cadastrar livro</a>
                    </div>
                @endif
                @error('book_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="employee_id" class="form-label">Funcionário <span class="text-red-500">*</span></label>
                @if($employees->count() > 0)
                    <select id="employee_id" name="employee_id" class="form-select @error('employee_id') border-red-400 @enderror">
                        <option value="">Selecione um funcionário...</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id', request('employee_id')) == $employee->id ? 'selected' : '' }}>
                                {{ $employee->name }}{{ $employee->department ? ' — ' . $employee->department : '' }}
                            </option>
                        @endforeach
                    </select>
                @else
                    <div class="rounded-xl bg-amber-50 border border-amber-200 px-4 py-3 text-sm text-amber-800">
                        Nenhum funcionário ativo cadastrado.
                        <a href="{{ route('employees.create') }}" class="font-semibold underline">Cadastrar funcionário</a>
                    </div>
                @endif
                @error('employee_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label for="borrowed_at" class="form-label">Data de Retirada <span class="text-red-500">*</span></label>
                    <input type="date" id="borrowed_at" name="borrowed_at"
                        value="{{ old('borrowed_at', date('Y-m-d')) }}"
                        max="{{ date('Y-m-d') }}"
                        class="form-input @error('borrowed_at') border-red-400 @enderror">
                    @error('borrowed_at') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="due_date" class="form-label">Data de Devolução Prevista</label>
                    <input type="date" id="due_date" name="due_date"
                        value="{{ old('due_date') }}"
                        class="form-input @error('due_date') border-red-400 @enderror">
                    @error('due_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="notes" class="form-label">Observações</label>
                <textarea id="notes" name="notes" rows="3" class="form-textarea"
                    placeholder="Alguma observação sobre este empréstimo...">{{ old('notes') }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary" {{ $availableBooks->count() === 0 || $employees->count() === 0 ? 'disabled' : '' }}>
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                    Registrar Empréstimo
                </button>
                <a href="{{ route('loans.index') }}" class="btn-ghost">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
