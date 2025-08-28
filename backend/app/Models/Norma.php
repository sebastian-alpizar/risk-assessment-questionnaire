<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Norma extends Model
{
    use HasFactory;

    protected $table = 'norma';
    protected $primaryKey = 'id_norma';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    public function tareas(): HasMany
    {
        return $this->hasMany(Tarea::class, 'id_norma');
    }
}