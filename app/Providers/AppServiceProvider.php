<?php

namespace App\Providers;

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
    }
}
