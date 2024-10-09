<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminController;
use App\Http\Controllers\adminAuthController;
use App\Http\Controllers\mailSettingsController;
use App\Http\Controllers\settingController;
use App\Http\Controllers\mediaController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('welcome');

Route::group(['middleware' => ['admin']], function () {
    Route::get('/admin', [adminController::class, 'index'])->name('root');
    Route::get('/logout', [adminAuthController::class, 'logout'])->name('logout');
    Route::get('/admin/profile', [adminController::class, 'profile'])->name('admin.profile');
    Route::post('/update/profile/{id}', [adminController::class, 'updateProfile'])->name('update.profile');
    Route::post('/update-password/{id}', [adminController::class, 'updatePassword'])->name('updatePassword');
    
    //mail settings
    Route::get('/mail/settings', [mailSettingsController::class, 'index'])->name('mail.index');
    Route::post('/mail/settings', [mailSettingsController::class,  'update'])->name('mail.update');
    
    //company settings
    Route::get('/company/settings', [settingController::class, 'index'])->name('company.index');
    Route::post('/company/settings', [settingController::class, 'saveSettings'])->name('company.update');

    //media
Route::get('/media', [mediaController::class, 'index'])->name('media.index');
Route::post('/media/upload', [mediaController::class, 'store'])->name('media.upload');
Route::get('/media/{id}', [mediaController::class, 'getMedia'])->name('get.media');
Route::post('/media', [mediaController::class, 'update'])->name('media.update');
Route::delete('/media/{id}', [mediaController::class, 'destroy'])->name('media.delete');
Route::post('/media/load', [mediaController::class, 'handleDisplay'])->name('media.load');
});

Route::get('/admin/login', [adminAuthController::class, 'index'])->name('admin.login');
Route::post('/admin/login', [adminAuthController::class, 'processLogin'])->name('admin.processLogin');
Route::get('/send-test-email', [mailSettingsController::class, 'sendTestEmail']);