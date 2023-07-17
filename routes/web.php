<?php

use App\Http\Controllers\MemberIndexController;
use App\Http\Controllers\PaymentIndexController;
use App\Http\Controllers\PaymentRedirectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripeWebHookController;
use App\Http\Middleware\RedirectIfNotMember;
use App\Http\Middleware\VerifyCsrfToken;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
//    dd(app('stripe'));
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware([RedirectIfNotMember::class])->group(function (){
    Route::get('/members', MemberIndexController::class);
});

Route::get('/payments', PaymentIndexController::class);
Route::post('/payments/redirect', PaymentRedirectController::class)->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/webhooks/stripe', StripeWebHookController::class)->withoutMiddleware([VerifyCsrfToken::class]);


require __DIR__.'/auth.php';
