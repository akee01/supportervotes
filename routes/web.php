<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('home');
// profile
Route::group(['middleware' => ['auth']], function () {
    Route::get('/profile/edit', [UserController::class, 'edit_profile'])->name('profile.edit');
    Route::put('/profile/update', [UserController::class, 'update_profile'])->name('profile.update');
});

Route::get('/profile/{id?}', [UserController::class, 'profile'])->name('profile');
/*
 * Creator's Routes
 * ===================
 */
// polls
Route::group(['middleware' => ['auth', 'user.role:creator']], function () {
    Route::get('/polls/archive', [UserController::class, 'archived_polls'])->name('polls.archived');
    Route::get('/polls/create', [UserController::class, 'create_poll'])->name('polls.create');
    Route::get('/polls/{id}/edit', [UserController::class, 'edit_poll'])->name('polls.edit');
    Route::put('/polls/{id}/update', [UserController::class, 'update_poll'])->name('polls.update');
    Route::post('/polls/store', [UserController::class, 'store_poll'])->name('polls.store');
    Route::delete('/polls/{id}/delete', [UserController::class, 'destroy_poll'])->name('polls.delete');
    Route::put('/polls/{id}/finalize', [UserController::class, 'finalize_poll'])->name('polls.finalize');
    Route::get('/balance', [UserController::class, 'balance'])->name('balance');
    Route::post('/withdraw', [UserController::class, 'withdraw'])->name('withdraw');
});
Route::get('/polls/{id}', [UserController::class, 'single_poll'])->name('polls.single');

/*
 * Supporter's Routes
 * =======================
 */
Route::group(['middleware' => ['auth', 'user.role:supporter']], function () {
    Route::post('/vote', [UserController::class, 'vote'])->name('vote');
    Route::post('/pay', [PaymentController::class, 'pay'])->name('pay');
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
});

/*
 * Administrator's Routes
 * =======================
 */
Route::group(['middleware' => ['auth', 'user.role:admin']], function () {
    Route::post('/withdrawal/approve/{creator_id}', [AdminController::class, 'approve_withdrawal'])->name('withdrawal.approve');
});
