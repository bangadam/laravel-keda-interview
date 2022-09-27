<?php

namespace App\Providers;

use App\Repositories\Message\IMessageRepository;
use App\Repositories\Message\MessageRepository;
use App\Repositories\Report\IReportRepository;
use App\Repositories\Report\ReportRepository;
use App\Repositories\User\IUserRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // register our repository implementation
        $this->app->bind(
            IUserRepository::class,
            UserRepository::class,
        );

        $this->app->bind(
            IMessageRepository::class,
            MessageRepository::class,
        );

        $this->app->bind(
            IReportRepository::class,
            ReportRepository::class,
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
