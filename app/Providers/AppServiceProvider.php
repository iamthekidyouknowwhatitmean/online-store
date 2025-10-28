<?php

namespace App\Providers;

use App\Events\UserRegistered;
use App\Listeners\SendEmailToUser;
use App\Service\PaymentService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PaymentService::class, function ($app) {
            return new PaymentService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();

        Event::listen(
            UserRegistered::class,
            [SendEmailToUser::class, 'handle']
        );
    }
}
