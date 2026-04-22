<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Employee;
use App\Models\Loan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBooks      = Book::count();
        $availableBooks  = Book::where('status', 'available')->count();
        $borrowedBooks   = Book::where('status', 'borrowed')->count();
        $totalEmployees  = Employee::where('active', true)->count();
        $activeLoans     = Loan::whereNull('returned_at')->count();
        $overdueLoans    = Loan::whereNull('returned_at')
                               ->whereNotNull('due_date')
                               ->whereDate('due_date', '<', now())
                               ->count();

        $recentLoans = Loan::with(['book', 'employee'])
                           ->latest()
                           ->take(8)
                           ->get();

        $overdueList = Loan::with(['book', 'employee'])
                           ->whereNull('returned_at')
                           ->whereNotNull('due_date')
                           ->whereDate('due_date', '<', now())
                           ->orderBy('due_date')
                           ->take(5)
                           ->get();

        return view('dashboard', compact(
            'totalBooks', 'availableBooks', 'borrowedBooks',
            'totalEmployees', 'activeLoans', 'overdueLoans',
            'recentLoans', 'overdueList'
        ));
    }
}
