<?php

namespace App\Providers;

use App\Models\Commitment;
use App\Models\Subject;
use App\Policies\CommitmentPolicy;
use App\Policies\SubjectPolicy;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
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
        RateLimiter::for('general', function (Request $request) {
            return Limit::perMinute(150)->by($request->user()?->id ?: $request->ip());
        });

        Model::automaticallyEagerLoadRelationships();
        Model::unguard();

        Gate::policy(Subject::class, SubjectPolicy::class);
        Gate::policy(Commitment::class, CommitmentPolicy::class);
    }
}
