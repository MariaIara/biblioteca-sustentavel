@extends('layouts.app')

@section('title', 'Registrar Devolução')
@section('page-title', 'Registrar Devolução')

@section('content')
<div class="max-w-lg pt-2">
    <div class="flex items-center gap-4 mb-5">
        <a href="{{ route('loans.show', $loan) }}" class="btn-ghost">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Voltar
        </a>
    </div>

    {{-- Summary --}}
    <div class="card p-5 flex gap-4 mb-5">
        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-amber-100">
            <svg class="h-6 w-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
            </svg>
        </div>
        <div>
            <p class="font-semibold text-slate-800">{{ $loan->book->title }}</p>
            <p class="text-sm text-slate-500">{{ $loan->employee->name }}</p>
            <p class="text-xs text-slate-400 mt-1">
                Retirado em {{ $loan->borrowed_at->format('d/m/Y') }}
                @if($loan->isOverdue())
                    · <span class="text-red-500 font-semibold">Em atraso desde {{ $loan->due_date->format('d/m/Y') }}</span>
                @elseif($loan->due_date)
                    · Devolução prevista: {{ $loan->due_date->format('d/m/Y') }}
                @endif
            </p>
        </div>
    </div>

    <div class="card">
        <div class="px-6 py-4 border-b border-slate-100">
            <h2 class="font-semibold text-slate-800">Confirmar Devolução</h2>
        </div>

        <form method="POST" action="{{ route('loans.return.update', $loan) }}" class="p-6 space-y-5">
            @csrf @method('PATCH')

            <div>
                <label for="returned_at" class="form-label">Data de Devolução <span class="text-red-500">*</span></label>
                <input type="date" id="returned_at" name="returned_at"
                    value="{{ old('returned_at', date('Y-m-d')) }}"
                    min="{{ $loan->borrowed_at->format('Y-m-d') }}"
                    max="{{ date('Y-m-d') }}"
                    class="form-input @error('returned_at') border-red-400 @enderror">
                @error('returned_at') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="notes" class="form-label">Observações</label>
                <textarea id="notes" name="notes" rows="3" class="form-textarea"
                    placeholder="Condições de devolução, etc...">{{ old('notes', $loan->notes) }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Confirmar Devolução
                </button>
                <a href="{{ route('loans.show', $loan) }}" class="btn-ghost">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
