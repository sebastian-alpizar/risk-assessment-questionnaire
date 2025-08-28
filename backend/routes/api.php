<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PreguntaController;
use App\Http\Controllers\Api\EvaluacionController;

use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::get('/preguntas', [PreguntaController::class, 'index']);

Route::post('/evaluaciones', [EvaluacionController::class, 'store']);
Route::get('/evaluaciones', [EvaluacionController::class, 'index']);
