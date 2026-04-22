<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Employee;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $query = Loan::with(['book', 'employee']);

        if ($search = $request->get('search')) {
            $query->whereHas('book', fn($q) => $q->where('title', 'like', "%{$search}%"))
                  ->orWhereHas('employee', fn($q) => $q->where('name', 'like', "%{$search}%"));
        }

        $filter = $request->get('filter', 'all');
        match ($filter) {
            'active'   => $query->whereNull('returned_at'),
            'returned' => $query->whereNotNull('returned_at'),
            'overdue'  => $query->whereNull('returned_at')->whereNotNull('due_date')->whereDate('due_date', '<', now()),
            default    => null,
        };

        $loans = $query->latest()->paginate(15)->withQueryString();

        return view('loans.index', compact('loans', 'filter'));
    }

    public function create()
    {
        $availableBooks = Book::where('status', 'available')->orderBy('title')->get();
        $employees      = Employee::where('active', true)->orderBy('name')->get();

        return view('loans.create', compact('availableBooks', 'employees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'book_id'     => ['required', 'exists:books,id'],
            'employee_id' => ['required', 'exists:employees,id'],
            'borrowed_at' => ['required', 'date'],
            'due_date'    => ['nullable', 'date', 'after_or_equal:borrowed_at'],
            'notes'       => ['nullable', 'string'],
        ]);

        $book = Book::findOrFail($data['book_id']);

        if (!$book->isAvailable()) {
            return back()->with('error', 'Este livro não está disponível para empréstimo.');
        }

        Loan::create($data);
        $book->update(['status' => 'borrowed']);

        return redirect()->route('loans.index')->with('success', 'Empréstimo registrado com sucesso!');
    }

    public function show(Loan $loan)
    {
        $loan->load(['book', 'employee']);
        return view('loans.show', compact('loan'));
    }

    public function edit(Loan $loan)
    {
        if ($loan->isReturned()) {
            return back()->with('error', 'Este empréstimo já foi devolvido.');
        }

        return view('loans.return', compact('loan'));
    }

    public function update(Request $request, Loan $loan)
    {
        if ($loan->isReturned()) {
            return back()->with('error', 'Este empréstimo já foi devolvido.');
        }

        $data = $request->validate([
            'returned_at' => ['required', 'date', 'after_or_equal:' . $loan->borrowed_at->format('Y-m-d')],
            'notes'       => ['nullable', 'string'],
        ]);

        $loan->update($data);
        $loan->book->update(['status' => 'available']);

        return redirect()->route('loans.index')->with('success', 'Devolução registrada com sucesso!');
    }

    public function destroy(Loan $loan)
    {
        if (!$loan->isReturned()) {
            $loan->book->update(['status' => 'available']);
        }

        $loan->delete();

        return redirect()->route('loans.index')->with('success', 'Empréstimo excluído com sucesso!');
    }
}
