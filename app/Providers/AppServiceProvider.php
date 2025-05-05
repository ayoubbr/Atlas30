<?php

namespace App\Providers;

use App\Repository\AdminRepository;
use App\Repository\GameRepository;
use App\Repository\Impl\IAdminRepository;
use App\Repository\Impl\IGameRepository;
use App\Repository\Impl\IRoleRepository;
use App\Repository\Impl\IUserRepository;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
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
        $this->app->bind(IGameRepository::class, GameRepository::class);
        $this->app->bind(IAdminRepository::class, AdminRepository::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IRoleRepository::class, RoleRepository::class);
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
