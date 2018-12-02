<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot;

class AppServiceProvider extends ServiceProvider {

    public function boot() {

    }
 
    public function register() {
        $this->app->bind('line-bot', function ($app, array $parameters) {
            return new LINEBot(
                new CurlHTTPClient(env('LINE_CHANNEL_ACCESS_TOKEN')),
                ['channelSecret' => env('LINE_CHANNEL_SECRET')]
            );
        });
    }
}
