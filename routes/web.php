<?php

use App\Http\Controllers\CharacterController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});
Route::get('/listCharacters', [CharacterController::class, 'index']);
Route::post('/saveCharacters', [CharacterController::class, 'store']);
Route::get('/editCharacter', [CharacterController::class, 'edit']);
Route::put('/updateCharacter', [CharacterController::class, 'update']);
Route::delete('/deleteCharacter', [CharacterController::class, 'destroy']);
