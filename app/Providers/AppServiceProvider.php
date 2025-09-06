<?php

namespace App\Providers;

use App\Listeners\LogAuthenticationEvents;
use App\Repositories\Contracts\LocationRepositoryInterface;

use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\SeasonRepositoryInterface;
use App\Repositories\Contracts\ProgramRepositoryInterface;
use App\Repositories\Contracts\SubjectRepositoryInterface;
use App\Repositories\Contracts\CourseRepositoryInterface;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use App\Repositories\Contracts\BankRepositoryInterface;
use App\Repositories\Contracts\StaffRepositoryInterface;
use App\Repositories\Contracts\StudentRepositoryInterface;
use App\Repositories\Contracts\SyllabusRepositoryInterface;
use App\Repositories\Contracts\TuitionRepositoryInterface;


use App\Repositories\Eloquent\LocationRepository;
use App\Repositories\Eloquent\RoleRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\SeasonRepository;
use App\Repositories\Eloquent\ProgramRepository;
use App\Repositories\Eloquent\SubjectRepository;
use App\Repositories\Eloquent\CourseRepository;
use App\Repositories\Eloquent\PermissionRepository;
use App\Repositories\Eloquent\BankRepository;
use App\Repositories\Eloquent\StaffRepository;
use App\Repositories\Eloquent\StudentRepository;
use App\Repositories\Eloquent\SyllabusRepository;
use App\Repositories\Eloquent\TuitionRepository;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(LocationRepositoryInterface::class, LocationRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(SeasonRepositoryInterface::class, SeasonRepository::class);
        $this->app->bind(ProgramRepositoryInterface::class, ProgramRepository::class);
        $this->app->bind(SubjectRepositoryInterface::class, SubjectRepository::class);
        $this->app->bind(CourseRepositoryInterface::class, CourseRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);

        $this->app->bind(StudentRepositoryInterface::class, StudentRepository::class);
        $this->app->bind(StaffRepositoryInterface::class, StaffRepository::class);
        $this->app->bind(BankRepositoryInterface::class, BankRepository::class);
        $this->app->bind(SyllabusRepositoryInterface::class, SyllabusRepository::class);
        $this->app->bind(TuitionRepositoryInterface::class, TuitionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Fix MySQL key length issue for utf8mb4
        Schema::defaultStringLength(191);

        RedirectIfAuthenticated::redirectUsing(function () {
            return route('dashboard');
        });

        Authenticate::redirectUsing(function () {
            Session::flash('status', 'Bạn cần đăng nhập để tiếp tục');
            return route('login');
        });

        // Register authentication event listeners
        Event::subscribe(LogAuthenticationEvents::class);
    }
}
