<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminController;
use App\Http\Controllers\adminAuthController;
use App\Http\Controllers\mailSettingsController;
use App\Http\Controllers\settingController;
use App\Http\Controllers\mediaController;
use App\Http\Controllers\countryController;
use App\Http\Controllers\stateController;
use App\Http\Controllers\cityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductCategoryController;

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

//product category
Route::get('/category', [ProductCategoryController::class, 'index'])->name('category.index');
Route::get('/category/create', [ProductCategoryController::class, 'create'])->name('category.create');
Route::post('/category/store', [ProductCategoryController::class, 'store'])->name('category.store');
Route::get('categories/data', [ProductCategoryController::class, 'getData'])->name('categories.data');
Route::get('/category/edit/{id}', [ProductCategoryController::class, 'edit'])->name('category.edit');
Route::post('/category/update/{id}', [ProductCategoryController::class, 'update'])->name('category.update');
Route::delete('/categories/{id}', [ProductCategoryController::class, 'destroy'])->name('categories.destroy');
Route::post('/category/status-change', [ProductCategoryController::class, 'changeStatus'])->name('category.changeStatus');

//country
Route::get('/country', [countryController::class, 'index'])->name('country.index');
  Route::get('/country/create', [countryController::class, 'create'])->name('country.create');
  Route::post('/country/store', [countryController::class, 'store'])->name('country.store');
  Route::get('countries/data', [countryController::class, 'getData'])->name('countries.data');
  Route::get('/country/edit/{id}', [countryController::class, 'edit'])->name('country.edit');
  Route::post('/country/update/{id}', [countryController::class, 'update'])->name('country.update');
Route::delete('/countries/{id}', [CountryController::class, 'destroy'])->name('countries.destroy');
Route::post('/countries/status-change', [CountryController::class, 'changeStatus'])->name('countries.changeStatus');

//state
Route::get('/state', [stateController::class, 'index'])->name('state.index');
  Route::get('/state/create', [stateController::class, 'create'])->name('state.create');
  Route::post('/state/store', [stateController::class, 'store'])->name('state.store');
  Route::get('states/data', [stateController::class, 'getData'])->name('states.data');
  Route::get('/state/edit/{id}', [stateController::class, 'edit'])->name('state.edit');
  Route::post('/state/update/{id}', [stateController::class, 'update'])->name('state.update');
Route::delete('/states/{id}', [stateController::class, 'destroy'])->name('states.destroy');
Route::post('/states/status-change', [stateController::class, 'changeStatus'])->name('states.changeStatus');

//city
Route::get('/city', [cityController::class, 'index'])->name('city.index');
  Route::get('/city/create', [cityController::class, 'create'])->name('city.create');
  Route::post('/city/store', [cityController::class, 'store'])->name('city.store');
  Route::get('cities/data', [cityController::class, 'getData'])->name('cities.data');
  Route::get('/city/edit/{id}', [cityController::class, 'edit'])->name('city.edit');
  Route::post('/city/update/{id}', [cityController::class, 'update'])->name('city.update');
Route::delete('/cities/{id}', [cityController::class, 'destroy'])->name('cities.destroy');
Route::post('/city/status-change', [cityController::class, 'changeStatus'])->name('city.changeStatus');
});

Route::get('/admin/login', [adminAuthController::class, 'index'])->name('admin.login');
Route::post('/admin/login', [adminAuthController::class, 'processLogin'])->name('admin.processLogin');
Route::get('/send-test-email', [mailSettingsController::class, 'sendTestEmail']);