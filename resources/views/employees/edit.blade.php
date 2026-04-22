@extends('layouts.app')

@section('title', 'Editar Funcionário')
@section('page-title', 'Editar Funcionário')

@section('content')
<div class="max-w-xl pt-2">
    <div class="flex items-center gap-4 mb-5">
        <a href="{{ route('employees.show', $employee) }}" class="btn-ghost">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Voltar
        </a>
    </div>

    <div class="card">
        <div class="px-6 py-4 border-b border-slate-100">
            <h2 class="font-semibold text-slate-800">Editar: {{ $employee->name }}</h2>
        </div>

        <form method="POST" action="{{ route('employees.update', $employee) }}" class="p-6 space-y-5">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="name" class="form-label">Nome Completo <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $employee->name) }}"
                        class="form-input @error('name') border-red-400 @enderror">
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="email" class="form-label">E-mail <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email', $employee->email) }}"
                        class="form-input @error('email') border-red-400 @enderror">
                    @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="department" class="form-label">Departamento</label>
                    <input type="text" id="department" name="department" value="{{ old('department', $employee->department) }}" class="form-input">
                </div>

                <div>
                    <label for="phone" class="form-label">Telefone</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $employee->phone) }}" class="form-input">
                </div>

                <div>
                    <label for="registration" class="form-label">Matrícula</label>
                    <input type="text" id="registration" name="registration" value="{{ old('registration', $employee->registration) }}" class="form-input">
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <input type="checkbox" id="active" name="active" value="1"
                        class="h-4 w-4 rounded border-slate-300 text-amber-600 focus:ring-amber-500"
                        {{ old('active', $employee->active) ? 'checked' : '' }}>
                    <label for="active" class="text-sm font-medium text-slate-700">Funcionário ativo</label>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Salvar Alterações
                </button>
                <a href="{{ route('employees.show', $employee) }}" class="btn-ghost">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
