<?php

namespace App\Providers;

use App\Models\Role;
use App\Repositories\Option\EloquentOptionRepository;
use App\Repositories\Option\OptionRepository;
use App\Repositories\Questions\EloquentQuestionsRepository;
use App\Repositories\Questions\QuestionsRepository;
use App\Repositories\Role\EloquentRoleRepository;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Student\EloquentStudentRepository;
use App\Repositories\Student\StudentRepository;
use App\Repositories\StudentAttempt\EloquentStudentAttemptRepository;
use App\Repositories\StudentAttempt\StudentAttemptRepository;
use App\Repositories\Subject\EloquentSubjectRepository;
use App\Repositories\Subject\SubjectRepository;
use App\Repositories\User\EloquentUserRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        $this->app->bind(
            UserRepository::class,
            EloquentUserRepository::class
        );

        $this->app->bind(
            RoleRepository::class,
            EloquentRoleRepository::class
        );

        $this->app->bind(
            SubjectRepository::class,
            EloquentSubjectRepository::class
        );

        $this->app->bind(
            StudentRepository::class,
            EloquentStudentRepository::class
        );

        $this->app->bind(
            QuestionsRepository::class,
            EloquentQuestionsRepository::class
        );

        $this->app->bind(
            OptionRepository::class,
            EloquentOptionRepository::class
        );

        $this->app->bind(
            StudentAttemptRepository::class,
            EloquentStudentAttemptRepository::class
        );
    }
}
