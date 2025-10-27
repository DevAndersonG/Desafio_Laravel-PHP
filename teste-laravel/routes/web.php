<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TextToSpeechController;

//Exibe o formulário
Route::get('/', [TextToSpeechController::class, 'index'])->name('tts.form');

//envio do formulário
Route::post('/generate', [TextToSpeechController::class, 'generate'])->name('tts.generate');