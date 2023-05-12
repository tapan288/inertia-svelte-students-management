<?php

namespace App\Http\Middleware;

use Inertia\Middleware;
use Illuminate\Http\Request;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request?->user()?->loadMissing('roles.permissions');

        if ($user) {
            foreach ($user->roles as $role) {
                foreach ($role->permissions as $singlePermission) {
                    $permissionsArray[] = $singlePermission->title;
                }
            }

            $permissionsCollection = collect($permissionsArray)->unique();
        }

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
                'type' => fn () => $request->session()->get('type', 'success'),
            ],
            'appName' => config('app.name'),
            'can' => $user ? $permissionsCollection->map(function ($permission) {
                return [$permission => true];
            })->collapse()->all() : null,
        ]);
    }
}
