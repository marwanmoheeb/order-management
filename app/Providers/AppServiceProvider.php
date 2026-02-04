<?php

namespace App\Providers;

use App\Contracts\PaymentGatewayInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PaymentGatewayInterface::class, function ($app) {
            $gateway = config('payment.default');
            $class = config("payment.gateways.{$gateway}");

            if (!$class || !class_exists($class)) {
                throw new \InvalidArgumentException("Payment gateway [{$gateway}] is not configured or does not exist.");
            }

            return $app->make($class);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
