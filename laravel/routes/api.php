<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Aluno
Route::prefix('/aluno')->group(function () {
    Route::post('/add',           [App\Http\Controllers\AlunoController::class, 'add'])->name('aluno.add');
    Route::get('/remover/{id}',    [App\Http\Controllers\AlunoController::class, 'remover'])->name('aluno.remover');
    Route::post('/atualizar/{id}',[App\Http\Controllers\AlunoController::class, 'atualizar'])->name('aluno.atualizar');
});

// Curso
Route::prefix('/curso')->group(function () {
    Route::post('/add',        [App\Http\Controllers\CursoController::class, 'add'])->name('curso.add');
    Route::get('/remover/{id}', [App\Http\Controllers\CursoController::class, 'remover'])->name('curso.remover');
    Route::post('/atualizar/{id}',[App\Http\Controllers\CursoController::class, 'atualizar'])->name('curso.atualizar');
});

// Professor
Route::prefix('/professor')->group(function () {
    Route::post('/add',        [App\Http\Controllers\ProfessorController::class, 'add'])->name('professor.add');
    Route::get('/remover/{id}', [App\Http\Controllers\ProfessorController::class, 'remover'])->name('professor.remover');
    Route::post('/atualizar/{id}', [App\Http\Controllers\ProfessorController::class, 'atualizar'])->name('professor.atualizar');
});

// Componente
Route::prefix('/componente')->group(function () {
    Route::post('/add',        [App\Http\Controllers\ComponenteController::class, 'add'])->name('componente.add');
    Route::get('/remover/{id}', [App\Http\Controllers\ComponenteController::class, 'remover'])->name('componente.remover');
    Route::post('/atualizar/{id}', [App\Http\Controllers\ComponenteController::class, 'atualizar'])->name('componente.atualizar');
});

// Administrador
Route::prefix('/administrador')->group(function () {
    Route::post('/add',        [App\Http\Controllers\AdministradorController::class, 'add'])->name('administrador.add');
    Route::get('/remover/{id}', [App\Http\Controllers\AdministradorController::class, 'remover'])->name('administrador.remove');
    Route::post('/atualizar/{id}', [App\Http\Controllers\AdministradorController::class, 'atualizar'])->name('administrador.atualizar');
});
