<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/check-student', function (Request $request) {
    $no_matriks = $request->query('no_matriks');
    
    // Check if the student exists
    $exists = User::where('no_matriks', $no_matriks)->exists();

    return response()->json(['exists' => $exists]);
});
