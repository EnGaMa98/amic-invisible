<?php

namespace App\Providers;

use App\Database\NeonPostgresConnector;
use App\Mail\Transport\HttpSmtpTransport;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('db.connector.pgsql', NeonPostgresConnector::class);
    }

    public function boot(): void
    {
        Mail::extend('httpsmtp', function (array $config) {
            return new HttpSmtpTransport(
                $config['endpoint'],
                $config['secret'],
            );
        });
    }
}
