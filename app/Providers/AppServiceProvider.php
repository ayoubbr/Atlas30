<?php

namespace App\Providers;

use App\Repository\AdminRepository;
use App\Repository\AuthRepository;
use App\Repository\DashboardRepository;
use App\Repository\ForumRepository;
use App\Repository\GameRepository;
use App\Repository\GroupRepository;
use App\Repository\NotificationRepository;
use App\Repository\PaymentRepository;
use App\Repository\RoleRepository;
use App\Repository\StadiumRepository;
use App\Repository\UserRepository;
use App\Repository\Impl\IAdminRepository;
use App\Repository\Impl\IAuthRepository;
use App\Repository\Impl\IDashboardRepository;
use App\Repository\Impl\IForumRepository;
use App\Repository\Impl\IGameRepository;
use App\Repository\Impl\IGroupRepository;
use App\Repository\Impl\INotificationRepository;
use App\Repository\Impl\IPaymentRepository;
use App\Repository\Impl\IRoleRepository;
use App\Repository\Impl\IStadiumRepository;
use App\Repository\Impl\IUserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(IGameRepository::class, GameRepository::class);
        $this->app->bind(IStadiumRepository::class, StadiumRepository::class);
        $this->app->bind(IAdminRepository::class, AdminRepository::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IRoleRepository::class, RoleRepository::class);
        $this->app->bind(IAuthRepository::class, AuthRepository::class);
        $this->app->bind(IDashboardRepository::class, DashboardRepository::class);
        $this->app->bind(IGroupRepository::class, GroupRepository::class);
        $this->app->bind(INotificationRepository::class, NotificationRepository::class);
        $this->app->bind(IPaymentRepository::class, PaymentRepository::class);
        $this->app->bind(IForumRepository::class, ForumRepository::class);
    }

    public function boot()
    { }
}
