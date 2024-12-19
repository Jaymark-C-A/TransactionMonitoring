<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    use HasFactory;
    protected $fillable = [
        'Office',
        'Service',
        'CC1',
        'CC2',
        'CC3',
        'SQD_0',
        'SQD_1',
        'SQD_2',
        'SQD_3',
        'SQD_4',
        'SQD_5',
        'SQD_6',
        'SQD_7',
        'Feedback',
        'created_at'
    ];
}

