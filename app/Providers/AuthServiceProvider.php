<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerGates();
    }

    protected function registerGates()
    {
        try {
            foreach (Permission::pluck('title') as $key => $permission) {
                Gate::define($permission, function ($user) use ($permission) {
                    return $user->roles()->whereHas('permissions', function (Builder $query) use ($permission) {
                        $query->where('title', $permission);
                    })->count() > 0;
                });
            }
        } catch (\Throwable $th) {
            info('registerUserGates: Database not found or not yet migrated. Ignoring user permissions while booting app.');
        }
    }
}
