<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Aluno
Route::prefix('/aluno')->group(function () {
    Route::post('/add',           [App\Http\Controllers\AlunoController::class, 'add'])->name('aluno.add');
    Route::get('/remove/{id}',    [App\Http\Controllers\AlunoController::class, 'remove'])->name('aluno.remove');
    Route::post('/atualizar/{id}',[App\Http\Controllers\AlunoController::class, 'atualizar'])->name('aluno.atualizar');
});

// Curso
Route::prefix('/curso')->group(function () {
    Route::post('/add',        [App\Http\Controllers\CursoController::class, 'add'])->name('curso.add');
    Route::get('/remove/{id}', [App\Http\Controllers\CursoController::class, 'remove'])->name('curso.remove');
    Route::post('/atualizar/{id}',[App\Http\Controllers\CursoController::class, 'atualizar'])->name('curso.atualizar');
});

// Professor
Route::prefix('/professor')->group(function () {
    Route::post('/add',        [App\Http\Controllers\ProfessorController::class, 'add'])->name('professor.add');
    Route::get('/remove/{id}', [App\Http\Controllers\ProfessorController::class, 'remove'])->name('professor.remove');
    Route::post('/atualizar/{id}', [App\Http\Controllers\ProfessorController::class, 'atualizar'])->name('professor.atualizar');
});

// Componente
Route::prefix('/componente')->group(function () {
    Route::post('/add',        [App\Http\Controllers\ComponenteController::class, 'add'])->name('componente.add');
    Route::get('/remove/{id}', [App\Http\Controllers\ComponenteController::class, 'remove'])->name('componente.remove');
    Route::post('/atualizar/{id}', [App\Http\Controllers\ComponenteController::class, 'atualizar'])->name('componente.atualizar');
});

// Administrador
Route::prefix('/administrador')->group(function () {
    Route::post('/add',        [App\Http\Controllers\AdministradorController::class, 'add'])->name('administrador.add');
    Route::get('/remove/{id}', [App\Http\Controllers\AdministradorController::class, 'remove'])->name('administrador.remove');
    Route::post('/atualizar/{id}', [App\Http\Controllers\AdministradorController::class, 'atualizar'])->name('administrador.atualizar');
});
