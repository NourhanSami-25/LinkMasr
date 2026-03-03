<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\user\User;
use App\Policies\RolePolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Role::class => RolePolicy::class
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(fn (User $user) => $user->isAdmin() ? true : null);

        $sections = [
            'project',
            'task',

            'client',
            'finance',
            'expense',
            'contract',
            'lead',
            'proposal',

            'request',
            'approve',
            'hr',
            'user',

            'announcement',
            'report',
            'reminder',
            'calendar',

            'support',
            'setting',
            
            // New modules
            'construction',
            'partners',
            'real_estate',
            'evm',
        ];

        foreach ($sections as $section) {
            Gate::define("access{$section}", function (User $user, $level) use ($section) {
                return $user->hasAccess($section, $level);
            });
        }
    }
}
