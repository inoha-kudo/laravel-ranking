<?php

declare(strict_types=1);

namespace Miraiportal\LaravelRanking;

use Illuminate\Support\ServiceProvider;

final class RankingServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishesMigrations([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'ranking-migrations');
        }
    }
}
