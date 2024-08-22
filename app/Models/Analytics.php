<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analytics extends Model
{
    use HasFactory;

    // Adicione o campo user_id ao array $fillable
    protected $fillable = [
        'user_id',
        'clicks',
        'accesses',
    ];
}
