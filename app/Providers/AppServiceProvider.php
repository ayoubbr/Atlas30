<?php

namespace App\Providers;

use App\Repository\AdminRepository;
use App\Repository\AuthRepository;
use App\Repository\CommentRepository;
use App\Repository\DashboardRepository;
use App\Repository\ForumRepository;
use App\Repository\GameRepository;
use App\Repository\GroupRepository;
use App\Repository\LikeRepository;
use App\Repository\NotificationRepository;
use App\Repository\PaymentRepository;
use App\Repository\PostRepository;
use App\Repository\ProfileRepository;
use App\Repository\RoleRepository;
use App\Repository\StadiumRepository;
use App\Repository\TeamRepository;
use App\Repository\TicketRepository;
use App\Repository\UserRepository;
use App\Repository\Impl\IAdminRepository;
use App\Repository\Impl\IAuthRepository;
use App\Repository\Impl\ICommentRepository;
use App\Repository\Impl\IDashboardRepository;
use App\Repository\Impl\IForumRepository;
use App\Repository\Impl\IGameRepository;
use App\Repository\Impl\IGroupRepository;
use App\Repository\Impl\ILikeRepository;
use App\Repository\Impl\INotificationRepository;
use App\Repository\Impl\IPaymentRepository;
use App\Repository\Impl\IPostRepository;
use App\Repository\Impl\IProfileRepository;
use App\Repository\Impl\IRoleRepository;
use App\Repository\Impl\IStadiumRepository;
use App\Repository\Impl\ITeamRepository;
use App\Repository\Impl\ITicketRepository;
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
        $this->app->bind(IPostRepository::class, PostRepository::class);
        $this->app->bind(ICommentRepository::class, CommentRepository::class);
        $this->app->bind(ILikeRepository::class, LikeRepository::class);
        $this->app->bind(ITeamRepository::class, TeamRepository::class);
        $this->app->bind(ITicketRepository::class, TicketRepository::class);
        $this->app->bind(IProfileRepository::class, ProfileRepository::class);
    }

    public function boot()
    { }
}
