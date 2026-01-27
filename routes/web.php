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

// Load admin routes
// Protected routes - require authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    // API endpoint for 2-minute change stat (for live polling)
    Route::get('/api/portfolio-change', [App\Http\Controllers\HomeController::class, 'portfolioChangeStat'])->name('api.portfolio-change');
    Route::get('/deposit', [App\Http\Controllers\DepositController::class, 'show'])->name('user.deposit');
    Route::post('/deposit/address', [App\Http\Controllers\DepositController::class, 'showAddress'])->name('user.deposit.address');
    Route::get('/deposit/history', [App\Http\Controllers\DepositController::class, 'history'])->name('user.deposit.history');

    // Daily Check-In routes
    Route::get('/daily-checkin', [App\Http\Controllers\DailyCheckinController::class, 'show'])->name('daily.checkin');
    Route::post('/daily-checkin', [App\Http\Controllers\DailyCheckinController::class, 'checkin'])->name('daily.checkin.submit');

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
    Route::get('/account/withdrawal-address', [App\Http\Controllers\AccountController::class, 'editWithdrawalAddress'])->name('account.withdrawal-address.edit');
    Route::post('/account/withdrawal-address/send-code', [App\Http\Controllers\AccountController::class, 'sendAddressVerificationCode'])->name('account.withdrawal-address.sendCode');
    Route::post('/account/withdrawal-address', [App\Http\Controllers\AccountController::class, 'bindWithdrawalAddress'])->name('account.withdrawal-address.bind');

    // Two-Factor Authentication routes
    Route::get('/account/2fa', [App\Http\Controllers\TwoFactorController::class, 'show2faForm'])->name('account.2fa');
    Route::post('/account/2fa/enable', [App\Http\Controllers\TwoFactorController::class, 'enable2fa'])->name('account.2fa.enable');
    Route::post('/account/2fa/disable', [App\Http\Controllers\TwoFactorController::class, 'disable2fa'])->name('account.2fa.disable');

    // Collection routes
    Route::get('/collection', [App\Http\Controllers\CollectionController::class, 'index'])->name('collection');

    // NFT Purchase routes
    Route::get('/nft/{id}/purchase', [App\Http\Controllers\NftController::class, 'showPurchase'])->name('nft.purchase');
    Route::post('/nft/{id}/buy', [App\Http\Controllers\NftController::class, 'buy'])->name('nft.buy');
    Route::post('/nft/{id}/like', [App\Http\Controllers\NftController::class, 'toggleLike'])->name('nft.like');
    // NFT Detail and Sell routes
    Route::get('/nft/{id}', [App\Http\Controllers\NftController::class, 'show'])->name('nft.show');
    Route::post('/nft/{id}/sell', [App\Http\Controllers\NftController::class, 'sell'])->name('nft.sell');

    // Receipt routes
    Route::get('/receipts', [App\Http\Controllers\ReceiptController::class, 'index'])->name('receipt.index');
    Route::get('/receipt/{id}', [App\Http\Controllers\ReceiptController::class, 'show'])->name('receipt.view');
    Route::get('/receipt/{id}/download', [App\Http\Controllers\ReceiptController::class, 'download'])->name('receipt.download');

    // Team routes
    Route::get('/team', [App\Http\Controllers\TeamController::class, 'index'])->name('team');
    // Auction routes
    Route::get('/auction', [App\Http\Controllers\AuctionController::class, 'index'])->name('auction.index');
    Route::get('/auction/track', [App\Http\Controllers\AuctionController::class, 'track'])->name('auction.track');
    Route::get('/auction/create/{nft_id}', [App\Http\Controllers\AuctionController::class, 'create'])->name('auction.create');
    Route::post('/auction/store', [App\Http\Controllers\AuctionController::class, 'store'])->name('auction.store');
    Route::get('/auction/{id}', [App\Http\Controllers\AuctionController::class, 'show'])->name('auction');
    Route::post('/auction/{id}/bid', [App\Http\Controllers\AuctionController::class, 'bid'])->name('auction.bid');
});


Route::middleware(['web', 'auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');

    // Users Management
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::post('/users/{user}/add-balance', [App\Http\Controllers\Admin\UserController::class, 'addBalance'])->name('users.addBalance');
    Route::post('/users/{user}/deduct-balance', [App\Http\Controllers\Admin\UserController::class, 'deductBalance'])->name('users.deductBalance');

    // NFTs Management
    Route::resource('nfts', App\Http\Controllers\Admin\NftController::class);
    Route::post('/nfts/{nft}/transfer', [App\Http\Controllers\Admin\NftController::class, 'transfer'])->name('nfts.transfer');

    // Auctions Management
    Route::resource('auctions', App\Http\Controllers\Admin\AuctionController::class);
    Route::post('/auctions/{auction}/end', [App\Http\Controllers\Admin\AuctionController::class, 'endAuction'])->name('auctions.end');
    Route::post('/auctions/{auction}/cancel', [App\Http\Controllers\Admin\AuctionController::class, 'cancelAuction'])->name('auctions.cancel');

    // Bids Management
    Route::get('/bids', [App\Http\Controllers\Admin\BidController::class, 'index'])->name('bids.index');
    Route::post('/bids', [App\Http\Controllers\Admin\BidController::class, 'store'])->name('bids.store');
    Route::delete('/bids/{bid}', [App\Http\Controllers\Admin\BidController::class, 'destroy'])->name('bids.destroy');

    // Deposits Management
    Route::get('/deposits', [App\Http\Controllers\Admin\DepositController::class, 'index'])->name('deposits.index');
    Route::post('/deposits', [App\Http\Controllers\Admin\DepositController::class, 'store'])->name('deposits.store');
    Route::post('/deposits/{deposit}/status', [App\Http\Controllers\Admin\DepositController::class, 'updateStatus'])->name('deposits.updateStatus');
    Route::delete('/deposits/{deposit}', [App\Http\Controllers\Admin\DepositController::class, 'destroy'])->name('deposits.destroy');

    // Withdrawals Management
    Route::get('/withdrawals', [App\Http\Controllers\Admin\WithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::post('/withdrawals/process', [App\Http\Controllers\Admin\WithdrawalController::class, 'process'])->name('withdrawals.process');

    // Settings
    Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
});

// NOWPayments webhook route (no auth middleware)
Route::post('/nowpayments/ipn', [App\Http\Controllers\DepositController::class, 'nowpaymentsIpn'])->name('nowpayments.ipn');
