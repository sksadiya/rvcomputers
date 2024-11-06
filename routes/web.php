<?php

use App\Http\Controllers\accountController;
use App\Http\Controllers\attributeController;
use App\Http\Controllers\AttributeVal;
use App\Http\Controllers\AttributeValue;
use App\Http\Controllers\Auth\registerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\checkoutController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\customerCrud;
use App\Http\Controllers\CustomerForgotPasswordController;
use App\Http\Controllers\CustomerResetPasswordController;
use App\Http\Controllers\googleReviewController;
use App\Http\Controllers\paymentSettingController;
use App\Http\Controllers\reviewController;
use App\Http\Controllers\shopController;
use App\Http\Controllers\sliderController;
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
    Route::get('/clear-cache', [settingController::class, 'clearCache'])->name('clear.cache');

    //payment settings
    Route::get('/payment/settings', [paymentSettingController::class, 'index'])->name('payment.index');
    Route::post('/payment/settings', [paymentSettingController::class, 'saveSettings'])->name('payment.update');

    //review settings
    Route::get('/review/settings', [googleReviewController::class, 'index'])->name('review.index');
    Route::post('/review/settings', [googleReviewController::class, 'saveSettings'])->name('review.update');

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
Route::get('/product', [productController::class, 'index'])->name('product.index');
Route::get('/product/create', [productController::class, 'create'])->name('product.create');
Route::post('/product/store', [productController::class, 'store'])->name('product.store');
Route::get('products/data', [productController::class, 'getData'])->name('products.data');
Route::get('/product/edit/{id}', [productController::class, 'edit'])->name('product.edit');
Route::post('/product/update/{id}', [productController::class, 'update'])->name('product.update');
Route::post('/product/add-more-choice-option', [productController::class, 'getChoiceOptions'])->name('product.add_more_choice_option');
Route::post('/product/combination', [productController::class, 'combination'])->name('product.combination');
Route::delete('/products/{id}', [productController::class, 'destroy'])->name('products.destroy');
Route::post('/product/status-change', [productController::class, 'changeStatus'])->name('product.changeStatus');
Route::post('/variants/delete', [productController::class, 'deleteVariant'])->name('variants.delete');

//reviews
Route::delete('/review/{id}', [reviewController::class, 'destroy'])->name('reviews.destroy');
Route::get('/review/show/{id}', [reviewController::class, 'show'])->name('reviews.show');
Route::get('reviews/data', [reviewController::class, 'getData'])->name('reviews.data');
Route::get('/review', [reviewController::class, 'index'])->name('reviews.index');
Route::post('/review/status-change', [reviewController::class, 'changeStatus'])->name('review.changeStatus');

//slider
Route::get('/slider', [sliderController::class, 'index'])->name('slider.index');
  Route::get('/slider/create', [sliderController::class, 'create'])->name('slider.create');
  Route::post('/slider/store', [sliderController::class, 'store'])->name('slider.store');
  Route::get('sliders/data', [sliderController::class, 'getData'])->name('sliders.data');
  Route::get('/slider/edit/{id}', [sliderController::class, 'edit'])->name('slider.edit');
  Route::post('/slider/update/{id}', [sliderController::class, 'update'])->name('slider.update');
Route::delete('/sliders/{id}', [sliderController::class, 'destroy'])->name('sliders.destroy');
Route::post('/sliders/status-change', [sliderController::class, 'changeStatus'])->name('sliders.changeStatus');

//customer
Route::get('/customer', [customerCrud::class, 'index'])->name('customer.index');
  Route::get('/customer/create', [customerCrud::class, 'create'])->name('customer.create');
  Route::post('/customer/store', [customerCrud::class, 'store'])->name('customer.store');
  Route::get('customers/data', [customerCrud::class, 'getData'])->name('customers.data');
  Route::get('/customer/edit/{id}', [customerCrud::class, 'edit'])->name('customer.edit');
  Route::post('/customer/update/{id}', [customerCrud::class, 'update'])->name('customer.update');
Route::delete('/customers/{id}', [customerCrud::class, 'destroy'])->name('customers.destroy');
Route::post('/customer/status-change', [customerCrud::class, 'changeStatus'])->name('customer.changeStatus');

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

Route::group(['middleware' => ['customer']], function () { 
  Route::get('/customer/dashboard', [registerController::class, 'index'])->name('customer.dashboard');
  Route::get('/customer/logout', [registerController::class, 'logout'])->name('customer.logout');
  Route::get('/customer/address', [accountController::class, 'address'])->name('customer.address');
  Route::post('/customer/address', [accountController::class, 'updateAddress'])->name('update.address');
  Route::get('/customer/orders', [accountController::class, 'orders'])->name('customer.orders');
  Route::get('/customer/profile', [accountController::class, 'settings'])->name('customer.settings');
  Route::post('/customer/profile', [accountController::class, 'updateProfile'])->name('update.settings');
  Route::get('/customer/checkout', [checkoutController::class, 'index'])->name('checkout');
  Route::post('/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('apply.coupon');

});
//customer auth
// Forgot Password
Route::get('customer/password/reset', [CustomerForgotPasswordController::class, 'showLinkRequestForm'])->name('customer.password.request');
Route::post('customer/password/email', [CustomerForgotPasswordController::class, 'sendResetLinkEmail'])->name('customer.password.email');

// Reset Password
Route::get('customer/password/reset/{token}', [CustomerResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('customer/password/reset', [CustomerResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/account/register', [registerController::class, 'showRegisterForm'])->name('customer.register');
Route::post('/account/register', [registerController::class, 'processRegister'])->name('customer.processRegister');
Route::get('/account/login', [registerController::class, 'login'])->name('customer.login');
Route::post('/account/login', [registerController::class, 'processLogin'])->name('customer.processLogin');
Route::get('/customer/activate/{token}', [registerController::class, 'activateAccount'])->name('customer.activate');

// Fetch states based on country ID
Route::get('/states/{countryId}', [countryController::class, 'getStates'])->name('states.fetch');

// Fetch cities based on state ID
Route::get('/cities/{stateId}', [countryController::class, 'getCities'])->name('cities.fetch');

Route::get('product/show/{slug}', [productController::class, 'show'])->name('product.show');
Route::get('product/shop', [shopController::class, 'index'])->name('product.shop');
Route::post('product/review', [reviewController::class, 'store'])->name('review.add');
Route::post('/check-variant', [ProductController::class, 'checkVariant'])->name('product.checkVariant');
Route::post('/addToCart', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart-remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
