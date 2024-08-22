<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;
class Point extends Model
{
    use HasFactory;

    protected $table = 'points';

    protected $fillable = [
        'user_id',
        'ponto_id_fk',
        'name',
        'complementos_A',
        'endereco_A',
        'id_products',
        'latitude',
        'longitude',
        'tel_contato',
        'is_highlighted',
        'likes_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function complemento()
    {
        return $this->hasMany(Complemento::class, 'point_id_fk');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'ponto_id_fk');
    }

    public function endereco()
    {
        return $this->hasOne(Enderecos::class, 'point_id_fk'); 
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
