<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CriterionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MooraController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoadController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLoginForm']);  // Changed from redirect to direct controller call

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'resetPassword'])->name('password.update');
Route::get('/account-request', [AuthController::class, 'showAccountRequestForm'])->name('account-request.create');
Route::post('/account-request', [AuthController::class, 'storeAccountRequest'])->name('account-request.store');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [AuthController::class, 'showProfileForm'])->name('profile.edit');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    Route::resource('criteria', CriterionController::class)->except(['show']);
    Route::resource('roads', RoadController::class)->except(['show']);
    Route::post('/roads/{road}/verify', [RoadController::class, 'verify'])->name('roads.verify');
    Route::resource('users', UserController::class)->only(['index', 'create', 'store']);
    Route::get('/account-requests', [AccountRequestController::class, 'index'])->name('account-requests.index');
    Route::post('/account-requests/{id}/approve', [AccountRequestController::class, 'approve'])->name('account-requests.approve');
    Route::post('/account-requests/{id}/deny', [AccountRequestController::class, 'deny'])->name('account-requests.deny');
    Route::post('/account-requests/{id}/resend', [AccountRequestController::class, 'resend'])->name('account-requests.resend');

    Route::get('/scores', [ScoreController::class, 'index'])->name('scores.index');
    Route::post('/scores', [ScoreController::class, 'store'])->name('scores.store');

    Route::get('/moora', [MooraController::class, 'index'])->name('moora.index');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export/csv', [ReportController::class, 'exportCsv'])->name('reports.export.csv');
});
