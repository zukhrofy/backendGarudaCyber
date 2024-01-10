<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VoucherController;
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
Route::get('/tenants', [TenantController::class, 'getTenants']);
Route::get('/tenants/{tenantId}/products', [ProductController::class, 'getProductsByTenant']);
Route::get('/voucher/{voucherCode}/', [VoucherController::class, 'checkVoucher']);

Route::post('/transaction/checkout', [TransactionController::class, 'checkout']);
Route::get('/test-route', [TransactionController::class, 'testRoute']);
