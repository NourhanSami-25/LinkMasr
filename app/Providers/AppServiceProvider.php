<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Role;
use App\Policies\RolePolicy;
use App\Models\task\Task;
use App\Models\project\Project;
use App\Models\client\Client;
use App\Models\finance\Invoice;
use App\Models\finance\PaymentRequest;
use App\Models\finance\CreditNote;
use App\Models\finance\Expense;
use App\Models\business\Contract;
use App\Models\user\User;
use App\Models\utility\Todo;
use App\Models\finance\Pyment;
use App\Services\setting\CompanyProfileService;
use App\Observers\ClientObserver;
use App\Observers\ProjectObserver;
use App\Observers\TaskObserver;
use App\Observers\UserObserver;
use App\Observers\FinanceObserver;
use App\Observers\ContractObserver;
use App\Observers\TodoObserver;
use App\Observers\PaymentObserver;
use Illuminate\Support\Facades\View;
use Illuminate\View\ViewException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */


    public function register(): void
    {
        $this->app->singleton(CompanyProfileService::class, function () {
            return new CompanyProfileService();
        });
    }

    public function boot(): void
    {
        // Force HTTPS only in production
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
        
        Task::observe(TaskObserver::class);
        Project::observe(ProjectObserver::class);
        Client::observe(ClientObserver::class);
        User::observe(UserObserver::class);


        Invoice::observe(FinanceObserver::class);
        CreditNote::observe(FinanceObserver::class);
        Expense::observe(FinanceObserver::class);
        PaymentRequest::observe(FinanceObserver::class);
        Contract::observe(ContractObserver::class);

        Todo::observe(TodoObserver::class);
        Pyment::observe(PaymentObserver::class);

        // Share todos with the drawer
        View::composer('layout._todo_drawer', \App\Http\View\Composers\TodoComposer::class);

        View::composer('*', function ($view) {
            try {
                $view->getName(); // Try to get the view name
            } catch (\Exception $e) {
                Log::error('View not found: ' . request()->path());
                abort(404, 'View Not Found');
            }
        });

        // Share user todos with all views
        View::composer('*', function ($view) {
            if (auth()->check()) {
                $userTodos = Todo::where('user_id', auth()->id())
                    ->orderBy('created_at', 'desc')
                    ->limit(10)
                    ->get();
                $view->with('userTodos', $userTodos);
            }
        });

        Blade::if('hasAccess', function ($subject, $level) {
            return auth()->check() && auth()->user()->hasAccess($subject, $level);
        });
    }
}
