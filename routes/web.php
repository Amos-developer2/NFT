<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\TwoFactorController;


Auth::routes();

// Explicit registration form route for referral links
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');

// Verification routes
Route::get('/register/verify', [RegisterController::class, 'showVerificationForm'])->name('register.verify');
Route::post('/register/verify', [RegisterController::class, 'verifyAndCreate'])->name('register.verify.submit');
Route::post('/register/resend', [RegisterController::class, 'resendCode'])->name('register.resend');

// Handle code verification
Route::post('/password/code', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'verifyCode'])->name('password.code.verify');
// Password reset code entry page
Route::get('/password/code', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showCodeForm'])->name('password.code');

// 2FA verification routes
Route::get('/2fa', [TwoFactorController::class, 'index'])->name('2fa.index');
Route::post('/2fa', [TwoFactorController::class, 'verify'])->name('2fa.verify');

// About Us page route
Route::view('/about', 'about')->name('about');

// Protected routes - require authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    // API endpoint for 2-minute change stat (for live polling)
    Route::get('/api/portfolio-change', [App\Http\Controllers\HomeController::class, 'portfolioChangeStat'])->name('api.portfolio-change');
    Route::get('/deposit', [App\Http\Controllers\DepositController::class, 'show'])->name('user.deposit');
    Route::post('/deposit/address', [App\Http\Controllers\DepositController::class, 'showAddress'])->name('user.deposit.address');
    Route::get('/deposit/history', [App\Http\Controllers\DepositController::class, 'history'])->name('user.deposit.history');

    // Withdrawal routes
    Route::get('/withdrawal', [App\Http\Controllers\WithdrawalController::class, 'show'])->name('user.withdrawal');
    Route::post('/withdrawal/process', [App\Http\Controllers\WithdrawalController::class, 'process'])->name('user.withdrawal.process');
    Route::get('/withdrawal/history', [App\Http\Controllers\WithdrawalController::class, 'history'])->name('user.withdrawal.history');


    // Account routes
    Route::get('/account', [App\Http\Controllers\AccountController::class, 'index'])->name('account');
    Route::get('/account/profile', [App\Http\Controllers\AccountController::class, 'editProfile'])->name('account.profile.edit');
    Route::put('/account/profile', [App\Http\Controllers\AccountController::class, 'updateProfile'])->name('account.profile');
    Route::get('/account/password', [App\Http\Controllers\AccountController::class, 'editPassword'])->name('account.password.edit');
    Route::put('/account/password', [App\Http\Controllers\AccountController::class, 'updatePassword'])->name('account.password');
    Route::post('/account/password/send-code', [App\Http\Controllers\AccountController::class, 'sendVerificationCode'])->name('account.password.sendCode');
    Route::post('/account/password/verify-code', [App\Http\Controllers\AccountController::class, 'verifyVerificationCode'])->name('account.password.verifyCode');
    Route::get('/account/pin', [App\Http\Controllers\AccountController::class, 'editPin'])->name('account.pin.edit');
    Route::put('/account/pin', [App\Http\Controllers\AccountController::class, 'updatePin'])->name('account.pin');

    // Two-Factor Authentication routes
    Route::get('/account/2fa', [App\Http\Controllers\TwoFactorController::class, 'show2faForm'])->name('account.2fa');
    Route::post('/account/2fa/enable', [App\Http\Controllers\TwoFactorController::class, 'enable2fa'])->name('account.2fa.enable');
    Route::post('/account/2fa/disable', [App\Http\Controllers\TwoFactorController::class, 'disable2fa'])->name('account.2fa.disable');

    // Collection routes
    Route::get('/collection', [App\Http\Controllers\CollectionController::class, 'index'])->name('collection');

    // NFT Purchase routes
    Route::get('/nft/{id}/purchase', [App\Http\Controllers\NftController::class, 'showPurchase'])->name('nft.purchase');
    Route::post('/nft/{id}/buy', [App\Http\Controllers\NftController::class, 'buy'])->name('nft.buy');

    // Team routes
    Route::get('/team', [App\Http\Controllers\TeamController::class, 'index'])->name('team');
    // Auction routes
    Route::get('/auction', [App\Http\Controllers\AuctionController::class, 'index'])->name('auction');
    Route::post('/auction/{id}/bid', [App\Http\Controllers\AuctionController::class, 'bid'])->name('auction.bid');
});

// NOWPayments webhook route (no auth middleware)
Route::post('/nowpayments/ipn', [App\Http\Controllers\DepositController::class, 'nowpaymentsIpn'])->name('nowpayments.ipn');
