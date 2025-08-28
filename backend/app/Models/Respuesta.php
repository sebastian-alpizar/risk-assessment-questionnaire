<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Respuesta extends Model
{
    use HasFactory;

    protected $table = 'respuestas';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'evaluacion_id', 'id_pregunta', 'respuesta'
    ];

    public function pregunta(): BelongsTo
    {
        return $this->belongsTo(Pregunta::class, 'id_pregunta');
    }

    public function evaluacion(): BelongsTo
    {
        return $this->belongsTo(Evaluacion::class, 'id_evaluacion');
    }
}