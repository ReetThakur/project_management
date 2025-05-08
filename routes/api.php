<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ColumnController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\ChecklistController;
use App\Http\Controllers\Api\ChecklistItemController;
use App\Http\Controllers\Api\LabelController;
use App\Http\Controllers\Api\NotificationController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Kanban Board Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/projects/{project}/columns', [ColumnController::class, 'index']);
    Route::post('/projects/{project}/columns', [ColumnController::class, 'store']);
    Route::put('/projects/{project}/columns/reorder', [ColumnController::class, 'reorder']);
    Route::put('/columns/{column}', [ColumnController::class, 'update']);
    Route::delete('/columns/{column}', [ColumnController::class, 'destroy']);
    
    Route::put('/tasks/{task}/move', [TaskController::class, 'move']);
    
    Route::post('/tasks/{task}/checklists', [ChecklistController::class, 'store']);
    Route::put('/checklists/{checklist}', [ChecklistController::class, 'update']);
    Route::delete('/checklists/{checklist}', [ChecklistController::class, 'destroy']);
    Route::put('/tasks/{task}/checklists/reorder', [ChecklistController::class, 'reorder']);
    
    Route::post('/checklists/{checklist}/items', [ChecklistItemController::class, 'store']);
    Route::put('/checklist-items/{item}', [ChecklistItemController::class, 'update']);
    Route::delete('/checklist-items/{item}', [ChecklistItemController::class, 'destroy']);
    Route::put('/checklists/{checklist}/items/reorder', [ChecklistItemController::class, 'reorder']);
    
    Route::get('/projects/{project}/labels', [LabelController::class, 'index']);
    Route::post('/projects/{project}/labels', [LabelController::class, 'store']);
    Route::put('/labels/{label}', [LabelController::class, 'update']);
    Route::delete('/labels/{label}', [LabelController::class, 'destroy']);
    Route::post('/labels/{label}/attach', [LabelController::class, 'attach']);
    Route::post('/labels/{label}/detach', [LabelController::class, 'detach']);
});

// Notification routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::put('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead']);
    Route::put('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead']);
}); 