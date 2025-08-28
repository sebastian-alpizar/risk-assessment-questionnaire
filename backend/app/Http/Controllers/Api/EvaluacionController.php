<?php

namespace App\Http\Controllers\Api;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Evaluacion;

use Illuminate\Support\Facades\Log;

class EvaluacionController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'usuario_id' => 'required|exists:usuarios,usuario_id',
            'empresa' => 'required|string',
            'respuestas' => 'required|array',
            'respuestas.*.id_pregunta' => 'required|exists:pregunta,id_pregunta',
            'respuestas.*.respuesta' => 'required|in:si,no,na',
            'resultados' => 'required|array',
        ]);

        // Crear evaluación
        $evaluacion = Evaluacion::create([
            'usuario_id' => $data['usuario_id'],
            'empresa' => $data['empresa'],
            'fecha' => now(),
            'integridad' => (float)($data['resultados']['Integridad'] ?? 0),
            'confidencialidad' => (float)($data['resultados']['Confidencialidad'] ?? 0),
            'disponibilidad' => (float)($data['resultados']['Disponibilidad'] ?? 0),
        ]);

        // Guardar respuestas
        foreach ($data['respuestas'] as $resp) {
            $evaluacion->respuestas()->create($resp);
        }

         return response()->json([
            'message' => 'Evaluación y respuestas guardadas correctamente',
            'evaluacion' => Evaluacion::with(['respuestas.pregunta', 'usuario'])
                ->find($evaluacion->id)
        ]);
    }

    public function index(Request $request)
    {
        $query = Evaluacion::with(['respuestas.pregunta', 'usuario']);
        
        if ($request->has('usuario_id')) {
            $query->where('usuario_id', $request->usuario_id);
        }

        return response()->json($query->get());
    }

}
