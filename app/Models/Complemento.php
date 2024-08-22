<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complemento extends Model
{
    use HasFactory;

    protected $table = 'complementos';

    protected $fillable = [
        'point_id_fk',
        'days_hours',
        'videos',
        'status',
        'images',
    ];

    public function point()
    {
        return $this->belongsTo(Point::class, 'point_id_fk');
    }
}
