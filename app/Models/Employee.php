<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name', 'email', 'department', 'phone', 'registration', 'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function activeLoans()
    {
        return $this->hasMany(Loan::class)->whereNull('returned_at');
    }

    public function ownedBooks()
    {
        return $this->hasMany(Book::class, 'owner_id');
    }
}
