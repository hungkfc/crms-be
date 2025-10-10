<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;



Route::group([
    'middleware' => ['api'], // Áp dụng rate limit 60 yêu cầu/phút
    'prefix' => 'auth',                      // Thêm tiền tố /auth vào tất cả route
    'as' => 'auth.'                          // Thêm tiền tố auth. cho tên route
], function () {
    
    // Đăng ký (Register)
    // Map RegisteredUserController::store (Đoạn 2) vào AuthController::register
    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->name('register');
        // ->middleware('guest'); 

    // Đăng nhập (Login)
    // Map AuthenticatedSessionController::store (Đoạn 2) vào AuthController::login
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->name('login')
        ->middleware('guest');

    // Quên mật khẩu (Forgot Password)
    // Map PasswordResetLinkController::store (Đoạn 2) vào AuthController::forgotPassword
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'forgotPassword'])
        ->name('password.email')
        ->middleware('guest');

    // Đặt lại mật khẩu (Reset Password)
    // Map NewPasswordController::store (Đoạn 2) vào AuthController::resetPassword
    Route::post('/reset-password', [NewPasswordController::class, 'resetPassword'])
        ->name('password.store')
        ->middleware('guest');
    
    // Gửi lại email xác thực (Send Verification)
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'sendVerificationNotification'])
        ->middleware(['auth:sanctum', 'throttle:6,1']) // Dùng auth:sanctum cho API
        ->name('verification.send');

    // Xác thực email (Verify Email)
    Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, 'verifyEmail'])
        ->middleware(['auth:sanctum', 'signed', 'throttle:6,1'])
        ->name('verification.verify');

    // Đăng xuất (Logout)
    // Map AuthenticatedSessionController::destroy (Đoạn 2) vào AuthController::logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'logout'])
        ->middleware('auth:sanctum') // Dùng auth:sanctum cho API
        ->name('logout');
});