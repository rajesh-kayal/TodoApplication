<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\TodoController;
Route::get('/todos',[TodoController::class, 'getAlltodos']);
Route::get('/todo/edit/{id}', [TodoController::class, 'getTodoId']);
Route::post('/todo/search', [TodoController::class, 'searchTodo']);
Route::post('/todo/sort', [TodoController::class, 'shortTodo']);
Route::post('/todo/add', [TodoController::class, 'insertTodo']);
Route::any('/todo/{id}', [TodoController::class, 'updateTodo']);
Route::delete('/todo/delete/{id}', [TodoController::class, 'deleteTodo']);

use App\Http\Controllers\AjaxController;
Route::get('/',[AjaxController::class,'index']);
Route::get('/users',[AjaxController::class,'users']);

use App\Http\Controllers\UserController;
Route::post('/users/signup',[UserController::class,'signup']);
Route::post('/users/signin', [UserController::class, 'login']);
Route::get('/users/logout', [UserController::class, 'logout']);