<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use App\Models\Pregunta;


class PreguntaController extends Controller
{
    // Listar todas las preguntas
    public function index()
    {
        // Trae todas las preguntas con su tarea relacionada
        $preguntas = Pregunta::with('tarea.norma')->get();
        return response()->json($preguntas);
    }
}