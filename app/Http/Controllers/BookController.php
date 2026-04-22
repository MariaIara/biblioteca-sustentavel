<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Employee;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $books = $query->with('owner')->latest()->paginate(12)->withQueryString();

        return view('books.index', compact('books'));
    }

    public function create()
    {
        $employees = Employee::where('active', true)->orderBy('name')->get();
        return view('books.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'author'      => ['required', 'string', 'max:255'],
            'isbn'        => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string'],
            'genre'       => ['nullable', 'string', 'max:100'],
            'year'        => ['nullable', 'integer', 'min:1000', 'max:' . date('Y')],
            'publisher'   => ['nullable', 'string', 'max:255'],
            'cover_image' => ['nullable', 'url', 'max:2048'],
            'owner_id'    => ['nullable', 'exists:employees,id'],
        ]);

        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Livro cadastrado com sucesso!');
    }

    public function show(Book $book)
    {
        $book->load(['owner', 'loans.employee']);
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $employees = Employee::where('active', true)->orderBy('name')->get();
        return view('books.edit', compact('book', 'employees'));
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'author'      => ['required', 'string', 'max:255'],
            'isbn'        => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string'],
            'genre'       => ['nullable', 'string', 'max:100'],
            'year'        => ['nullable', 'integer', 'min:1000', 'max:' . date('Y')],
            'publisher'   => ['nullable', 'string', 'max:255'],
            'cover_image' => ['nullable', 'url', 'max:2048'],
            'owner_id'    => ['nullable', 'exists:employees,id'],
        ]);

        $book->update($data);

        return redirect()->route('books.show', $book)->with('success', 'Livro atualizado com sucesso!');
    }

    public function destroy(Book $book)
    {
        if ($book->status === 'borrowed') {
            return back()->with('error', 'Não é possível excluir um livro que está emprestado.');
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Livro excluído com sucesso!');
    }
}
