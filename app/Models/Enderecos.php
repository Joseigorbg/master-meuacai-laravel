<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enderecos extends Model
{
    use HasFactory;

    protected $table = 'enderecos';

    protected $fillable = [
        'user_id',
        'point_id_fk',
        'cep',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'pais',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function point()
    {
        return $this->belongsTo(Point::class, 'point_id_fk');
    }
}
