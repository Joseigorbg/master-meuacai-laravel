<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'ponto_id_fk',
        'user_id',
        'name',
        'price',
        'quantity',
        'description',
        'image',
    ];

    // Relacionamento com o modelo Point
    public function point()
    {
        return $this->belongsTo(Point::class, 'ponto_id_fk');
    }

    // Relacionamento com o modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
