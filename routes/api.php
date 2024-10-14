<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TaskEmployeeController;
use App\Http\Controllers\TaskManagerController;
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


Route::get('/reports/tasks', [ReportController::class, 'generateReport']);

// Manager Routes
Route::post('/login', [AuthController::class, 'login']);
Route::resource('tasks', TaskManagerController::class);
Route::put('/tasks/{taskId}/assign', [TaskManagerController::class, 'assign']);


//Employee Routes
Route::get('employee/tasks', [TaskEmployeeController::class, 'index']);
Route::post('employee/tasks/{taskId}/resolve', [TaskEmployeeController::class, 'resolve']);

//Notifications Routes
Route::get('/notifications', [NotificationController::class, 'getNotifications']);
Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
