<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pregunta extends Model
{
    use HasFactory;

    protected $table = 'pregunta';
    protected $primaryKey = 'id_pregunta';
    public $timestamps = true;

    protected $fillable = [
        'id_tarea',
        'texto',
        'tipo_cia',
        'peso'
    ];

    protected $casts = [
        'peso' => 'decimal:2'
    ];

    public function tarea(): BelongsTo
    {
        return $this->belongsTo(Tarea::class, 'id_tarea');
    }

    public function respuestas(): HasMany
    {
        return $this->hasMany(Respuesta::class, 'id_pregunta');
    }
}