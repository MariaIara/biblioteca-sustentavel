@extends('layouts.app')

@section('title', 'Cadastrar Funcionário')
@section('page-title', 'Cadastrar Funcionário')

@section('content')
<div class="max-w-xl pt-2">
    <div class="card">
        <div class="px-6 py-4 border-b border-slate-100">
            <h2 class="font-semibold text-slate-800">Dados do Funcionário</h2>
            <p class="text-sm text-slate-500 mt-0.5">Preencha as informações para cadastrar um funcionário.</p>
        </div>

        <form method="POST" action="{{ route('employees.store') }}" class="p-6 space-y-5">
            @csrf

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="name" class="form-label">Nome Completo <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="form-input @error('name') border-red-400 @enderror" placeholder="Nome do funcionário">
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="email" class="form-label">E-mail <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="form-input @error('email') border-red-400 @enderror" placeholder="nome@empresa.com">
                    @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="department" class="form-label">Departamento</label>
                    <input type="text" id="department" name="department" value="{{ old('department') }}"
                        class="form-input" placeholder="Ex: TI, RH, Financeiro...">
                </div>

                <div>
                    <label for="phone" class="form-label">Telefone</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                        class="form-input" placeholder="(11) 99999-9999">
                </div>

                <div>
                    <label for="registration" class="form-label">Matrícula</label>
                    <input type="text" id="registration" name="registration" value="{{ old('registration') }}"
                        class="form-input" placeholder="Número de matrícula">
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Cadastrar Funcionário
                </button>
                <a href="{{ route('employees.index') }}" class="btn-ghost">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
