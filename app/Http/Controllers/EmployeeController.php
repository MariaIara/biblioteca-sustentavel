<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%")
                  ->orWhere('registration', 'like', "%{$search}%");
            });
        }

        $employees = $query->withCount(['activeLoans'])->latest()->paginate(15)->withQueryString();

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'unique:employees,email'],
            'department'   => ['nullable', 'string', 'max:255'],
            'phone'        => ['nullable', 'string', 'max:20'],
            'registration' => ['nullable', 'string', 'max:50'],
        ]);

        Employee::create($data);

        return redirect()->route('employees.index')->with('success', 'Funcionário cadastrado com sucesso!');
    }

    public function show(Employee $employee)
    {
        $employee->load(['loans.book', 'ownedBooks']);
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'unique:employees,email,' . $employee->id],
            'department'   => ['nullable', 'string', 'max:255'],
            'phone'        => ['nullable', 'string', 'max:20'],
            'registration' => ['nullable', 'string', 'max:50'],
            'active'       => ['boolean'],
        ]);

        $data['active'] = $request->has('active');
        $employee->update($data);

        return redirect()->route('employees.show', $employee)->with('success', 'Funcionário atualizado com sucesso!');
    }

    public function destroy(Employee $employee)
    {
        if ($employee->activeLoans()->exists()) {
            return back()->with('error', 'Não é possível excluir um funcionário com empréstimos ativos.');
        }

        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Funcionário excluído com sucesso!');
    }
}
