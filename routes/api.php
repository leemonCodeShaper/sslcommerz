<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'sslcommerz', 'middleware' => 'auth:sanctum'], function () {
    //Route::post('success', [PaymentController::class, 'success'])->name('payment.success');
    Route::post('failure', [PaymentController::class, 'failure'])->name('payment.failure');
    Route::post('cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
    Route::post('ipn', [PaymentController::class, 'ipn'])->name('payment.ipn');
    Route::post('pay', [PaymentController::class, 'pay'])->name('payment.pay');
    Route::get('refund', [PaymentController::class, 'refund'])->name('payment.refund');
    Route::get('refund-status', [PaymentController::class, 'refundStatus'])->name('payment.refund.status');
    Route::get('transaction-query', [PaymentController::class, 'transactionQuery'])->name('payment.transaction.query');
    Route::get('order-validation', [PaymentController::class, 'orderValidation'])->name('payment.order.validation');
});


Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

