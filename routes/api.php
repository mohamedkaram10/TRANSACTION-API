<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
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
//     return $request->user();
// });

// User Story 1: Admin login
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::post('/register', [AuthController::class, 'register']);

// User Story 2: Admin enters new transactions
Route::post('/create/transactions', [TransactionController::class, 'createTransaction']);

// User Story 3: Admin records payments
Route::post('/payments', [TransactionController::class, 'recordPayment']);

Route::middleware('isAdmin')->group(function () {
    // User Story 4: User views transactions
    Route::get('/transactions', [TransactionController::class, 'viewTransactions']); // Ensure authentication middleware is applied

    // User Story 5: Admin generates monthly reports
    Route::post('/reports', [TransactionController::class, 'generateMonthlyReport']); // Ensure authentication middleware is applied
});
