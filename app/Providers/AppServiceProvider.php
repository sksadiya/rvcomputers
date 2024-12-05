<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\paymentSettings;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Slider;
use App\Models\Tag;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\mailSetting;
use App\Models\Setting;
use App\Models\media;
use Illuminate\Support\Facades\Config;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $settings = mailSetting::pluck('value', 'key')->toArray();
        if (!empty($settings)) {
            Config::set('mail.default', $settings['mail_mailer'] ?? 'smtp');
            Config::set('mail.mailers.smtp.host', $settings['mail_host'] ?? 'smtp.default.com');
            Config::set('mail.mailers.smtp.port', $settings['mail_port'] ?? 587);
            Config::set('mail.mailers.smtp.username', $settings['mail_username'] ?? 'default@example.com');
            Config::set('mail.mailers.smtp.password', $settings['mail_password'] ?? 'defaultpassword');
            Config::set('mail.mailers.smtp.encryption', $settings['mail_encryption'] ?? 'tls');
            Config::set('mail.from.address', $settings['mail_from_address'] ?? 'default@example.com');
            Config::set('mail.from.name', $settings['mail_from_name'] ?? 'Laravel');
        }

        $companySettings = Setting::pluck('value', 'key')->toArray();
        view()->share('companySettings', $companySettings);
        $tempImages = media::orderBy('created_at', 'desc')->get();
        view()->share('tempImages', $tempImages);
        $categories = ProductCategory::where('parent_category_id', '!=', null)->get();
        view()->share('categories', $categories);
        $sliders = Slider::all();
        view()->share('sliders', $sliders);
        $products = Product::all();
        view()->share('products', $products);
        $brands = Brand::withCount('products')->get();
        view()->share('brands', value: $brands);
        $tags = Tag::all();
        view()->share('tags', $tags);
        $paymentSettings = paymentSettings::pluck('value', 'key')->toArray();
        view()->share('paymentSettings', $paymentSettings);
         // Share cart data with all views
         View::composer('*', function ($view) {
            $cart = Session::get('cart', []);
        
            $cartItems = array_map(function ($item) {
                $product = Product::find($item['product_id']);
                $item['product'] = $product ? $product->toArray() : null;
                return $item;
            }, $cart);
        
            $cartItemCount = array_reduce($cart, fn($count, $item) => $count + $item['quantity'], 0);
            $cartTotalPrice = array_reduce($cart, fn($total, $item) => $total + ($item['price'] * $item['quantity']), 0);
        
            $view->with('cartItems', $cartItems)
                 ->with('cartItemCount', $cartItemCount)
                 ->with('cartTotalPrice', number_format($cartTotalPrice, 2));
        });
    }
}
