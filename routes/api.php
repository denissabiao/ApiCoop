<?php

use App\Http\Controllers\{
    ConsultaController,
    EspecialidadeController,
    LoginController,
    MedicoController
};
use App\Http\Controllers\ConvenioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::prefix('consulta')->group(function () {
    Route::get('/especialidade', [ConsultaController::class, 'buscaConsultaPelaEspecialidadeEData']);
    Route::get('/medico', [ConsultaController::class, 'getAppointmentByMedic']);
})->apiResource('consulta', ConsultaController::class)->only('show');

Route::prefix('medico')->group(function () {
    Route::get('/especialidade/{especialidade}', [MedicoController::class, 'buscaMedicoPelaEspecialidade']);
})->apiResource('medico', MedicoController::class)->only('show', 'index'); //busca automaticamente os metodos padroes

Route::prefix('especialidade')->group(function () {
    return 1;
})->apiResource('especialidade', EspecialidadeController::class)->only('index');

Route::prefix('convenio')->group(function () {
    return 1;
})->apiResource('convenio', ConvenioController::class)->only('index');

Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    return response()->json(['status' => true]);
});