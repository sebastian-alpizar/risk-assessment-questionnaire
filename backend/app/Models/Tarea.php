<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tarea extends Model
{
    use HasFactory;

    protected $table = 'tarea';
    protected $primaryKey = 'id_tarea';
    public $timestamps = true;

    protected $fillable = [
        'id_norma',
        'nombre',
        'descripcion'
    ];

    public function norma(): BelongsTo
    {
        return $this->belongsTo(Norma::class, 'id_norma');
    }

    public function preguntas(): HasMany
    {
        return $this->hasMany(Pregunta::class, 'id_tarea');
    }
}