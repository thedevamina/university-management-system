<?php

namespace App\Providers;
use App\Models\Result;
use App\Observers\ResultObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
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
    Result::observe(ResultObserver::class);
    
        
        Relation::enforceMorphMap([
            'student' => \App\Models\StudentProfile::class,
            'faculty' => \App\Models\FacultyProfile::class,
        ]);
    }
}
