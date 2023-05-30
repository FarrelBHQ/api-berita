<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();})
Route::get('/post', [PostController::class, 'index'])->middleware('auth:sanctum');
Route::get('/post/{id}', [PostController::class, 'show'])->middleware('auth:sanctum');
Route::get('/post1/{id}', [PostController::class, 'show1']);
Route::post('/create-post', [PostController::class, 'create']);
Route::patch('/edit-post/{id}', [PostController::class, 'edit']);
Route::delete('/delete-post/{id}', [PostController::class, 'delete']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/profile', [AuthController::class, 'profile'])->middleware('auth:sanctum');
Route::patch('/profile-edit/{user_id}', [AuthController::class, 'profileEdit'])->middleware('auth:sanctum');
Route::delete('/profile-delete/{user_id}', [AuthController::class, 'profileDelete'])->middleware('auth:sanctum');



Route::get('/list-user', [AuthController::class, 'showListUser']);

