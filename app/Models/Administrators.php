<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrators extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'position', 'start_date'];
}
