<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact',
        'department',
        'purpose',
        'ticket_number',
        'status', // 'waiting', 'serving', 'completed', etc.
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
