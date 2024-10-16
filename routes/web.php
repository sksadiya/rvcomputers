<?php

use App\Http\Controllers\attributeController;
use App\Http\Controllers\AttributeVal;
use App\Http\Controllers\AttributeValue;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\CouponController;
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
use App\Http\Controllers\TaxController;
use App\Http\Controllers\productController;

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

//product brand
Route::get('/brand', [BrandController::class, 'index'])->name('brand.index');
Route::get('/brand/create', [BrandController::class, 'create'])->name('brand.create');
Route::post('/brand/store', [BrandController::class, 'store'])->name('brand.store');
Route::get('brands/data', [BrandController::class, 'getData'])->name('brands.data');
Route::get('/brand/edit/{id}', [BrandController::class, 'edit'])->name('brand.edit');
Route::post('/brand/update/{id}', [BrandController::class, 'update'])->name('brand.update');
Route::delete('/brands/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');
Route::post('/brand/status-change', [BrandController::class, 'changeStatus'])->name('brand.changeStatus');

//color swatch
Route::get('/color', [ColorController::class, 'index'])->name('color.index');
Route::get('/color/create', [ColorController::class, 'create'])->name('color.create');
Route::post('/color/store', [ColorController::class, 'store'])->name('color.store');
Route::get('colors/data', [ColorController::class, 'getData'])->name('colors.data');
Route::get('/color/edit/{id}', [ColorController::class, 'edit'])->name('color.edit');
Route::post('/color/update/{id}', [ColorController::class, 'update'])->name('color.update');
Route::delete('/colors/{id}', [ColorController::class, 'destroy'])->name('colors.destroy');
Route::post('/color/status-change', [ColorController::class, 'changeStatus'])->name('color.changeStatus');

//tax group
Route::get('/tax', [TaxController::class, 'index'])->name('tax.index');
Route::get('/tax/create', [TaxController::class, 'create'])->name('tax.create');
Route::post('/tax/store', [TaxController::class, 'store'])->name('tax.store');
Route::get('taxes/data', [TaxController::class, 'getData'])->name('taxes.data');
Route::get('/tax/edit/{id}', [TaxController::class, 'edit'])->name('tax.edit');
Route::post('/tax/update/{id}', [TaxController::class, 'update'])->name('tax.update');
Route::delete('/taxes/{id}', [TaxController::class, 'destroy'])->name('taxes.destroy');
Route::post('/tax/status-change', [TaxController::class, 'changeStatus'])->name('tax.changeStatus');

//coupons 
Route::get('/coupon', [CouponController::class, 'index'])->name('coupon.index');
Route::get('/coupon/create', [CouponController::class, 'create'])->name('coupon.create');
Route::post('/coupon/store', [CouponController::class, 'store'])->name('coupon.store');
Route::get('coupons/data', [CouponController::class, 'getData'])->name('coupons.data');
Route::get('/coupon/edit/{id}', [CouponController::class, 'edit'])->name('coupon.edit');
Route::post('/coupon/update/{id}', [CouponController::class, 'update'])->name('coupon.update');
Route::delete('/coupons/{id}', [CouponController::class, 'destroy'])->name('coupons.destroy');
Route::post('/coupon/status-change', [CouponController::class, 'changeStatus'])->name('coupon.changeStatus');

//attributes 
Route::get('/attribute', [attributeController::class, 'index'])->name('attribute.index');
Route::get('/attribute/create', [attributeController::class, 'create'])->name('attribute.create');
Route::post('/attribute/store', [attributeController::class, 'store'])->name('attribute.store');
Route::get('attributes/data', [attributeController::class, 'getData'])->name('attributes.data');
Route::get('/attribute/edit/{id}', [attributeController::class, 'edit'])->name('attribute.edit');
Route::post('/attribute/update/{id}', [attributeController::class, 'update'])->name('attribute.update');
Route::delete('/attributes/{id}', [attributeController::class, 'destroy'])->name('attributes.destroy');

//attributes values
Route::get('/attributeValue/{id}', [AttributeVal::class, 'index'])->name('attributeValue.index');
Route::get('/attributeValue/create/{id}', [AttributeVal::class, 'create'])->name('attributeValue.create');
Route::post('/attributeValue/store/{id}', [AttributeVal::class, 'store'])->name('attributeValue.store');
Route::get('attributeValues/data/{id}', [AttributeVal::class, 'getData'])->name('attributeValues.data');
Route::get('/attributeValue/edit/{id}', [AttributeVal::class, 'edit'])->name('attributeValue.edit');
Route::post('/attributeValue/update/{id}', [AttributeVal::class, 'update'])->name('attributeValue.update');
Route::delete('/attributeValues/{id}', [AttributeVal::class, 'destroy'])->name('attributeValues.destroy');


//product
Route::get('/product/create', [productController::class, 'create'])->name('product.create');
Route::post('/product/store', [productController::class, 'store'])->name('product.store');
Route::post('/product/add-more-choice-option', [productController::class, 'getChoiceOptions'])->name('product.add_more_choice_option');
Route::post('/product/combination', [productController::class, 'combination'])->name('product.combination');

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