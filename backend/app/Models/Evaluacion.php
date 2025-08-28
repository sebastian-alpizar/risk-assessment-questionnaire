<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Evaluacion extends Model
{
    use HasFactory;

    protected $table = 'evaluaciones';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'usuario_id', 'empresa', 'fecha', 'integridad', 'confidencialidad', 'disponibilidad'
    ];

    protected $casts = [
        'fecha' => 'date'
    ];

    public function respuestas(): HasMany
    {
        return $this->hasMany(Respuesta::class, 'evaluacion_id');
    }

    public function usuario() {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'usuario_id');
    }
}