<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title', 'author', 'isbn', 'description', 'cover_image',
        'genre', 'year', 'publisher', 'status', 'owner_id',
    ];

    public function owner()
    {
        return $this->belongsTo(Employee::class, 'owner_id');
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function activeLoan()
    {
        return $this->hasOne(Loan::class)->whereNull('returned_at')->latest();
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }
}
