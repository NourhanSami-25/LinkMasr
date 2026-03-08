<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\calendar\CalendarFunctionController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\finance\Invoice;
use App\Models\finance\Pyment;
use App\Models\finance\CreditNote;
use App\Models\finance\PaymentRequest;
use App\Models\finance\Expense;

use App\Models\business\Contract;


use App\Models\task\Task;
use App\Models\client\Client;
use App\Models\user\User;
use App\Models\event\Event;
use App\Models\utility\Announcement;
use App\Models\reminder\Reminder;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    protected $calendarFunctionController;

    public function __construct(CalendarFunctionController $calendarFunctionController)
    {
        $this->calendarFunctionController = $calendarFunctionController;
    }

    public function index()
    {
        $authUser = auth()->user();

        // Mapping: view variable name => [methodName, permissionKey]
        $sections = [
            'invoices'                  => ['get_invoices', 'finance'],
            'paymentRequests'           => ['get_paymentRequests', 'finance'],
            'pyments'                   => ['get_pyments', 'finance'],
            'creditNotes'               => ['get_creditNotes', 'finance'],
            'expenses'                  => ['get_expenses', 'expense'],
            'expiredContracts'          => ['get_expired_contracts', 'contract'],
            'aboutToExpiredContracts'   => ['get_about_to_expired_contracts', 'contract'],
            'activeContracts'           => ['get_active_contracts', 'contract'],
            'reminders'                 => ['get_reminders', 'reminder'],
            'tasks'                     => ['get_tasks', 'task'],
            'taskCounts'                => ['get_task_counts', 'task'],
            'days'                      => ['get_events', 'calendar'],
            'announcements'             => ['get_announcements', 'announcement'],
            // New modules
            'constructionStats'         => ['get_construction_stats', 'project'],
            'partnersStats'             => ['get_partners_stats', 'project'],
            'realEstateStats'           => ['get_real_estate_stats', 'project'],
        ];

        $data = [];

        foreach ($sections as $varName => [$method, $permission]) {
            if (
                $authUser->isAdmin() ||
                $authUser->hasAccess($permission, 'full') ||
                $authUser->hasAccess($permission, 'view') ||
                $authUser->hasAccess($permission, 'view_global')
            ) {
                $data[$varName] = $this->{$method}();
            } else {
                $data[$varName] = [];
            }
        }

        return view('dashboard.index', $data);
    }



    /**
     * Helper method to fetch and cache items with permission filtering
     */
    private function fetchCachedItems($cacheKey, $query, $mapFunction)
    {
        $authUser = auth()->user();
        $userId = $authUser->id;

        return Cache::remember($cacheKey, 60, function () use ($authUser, $userId, $query, $mapFunction) {
            // If not admin and doesn't have full/view_global access, filter by creator
            if (!(
                $authUser->isAdmin() ||
                $authUser->hasAccess('finance', 'full') ||
                $authUser->hasAccess('finance', 'view_global')
            )) {
                $query->where('created_by', $userId);
            }

            return $query->take(20)
                ->get()
                ->map($mapFunction)
                ->filter();
        });
    }

    public function get_invoices()
    {
        return $this->fetchCachedItems(
            'dashboard-invoices-' . auth()->id(),
            Invoice::select('id', 'client_id', 'number', 'date', 'due_date', 'total', 'status')->with(['client:id,name'])->latest('date'),
            function ($invoice) {
                return [
                    'id' => $invoice->id,
                    'number' => $invoice->number,
                    'date' => $invoice->date,
                    'due_date' => $invoice->due_date,
                    'total' => $invoice->total,
                    'status' => $invoice->status,
                    'client' => $invoice->client->name,
                ];
            }
        );
    }

    public function get_paymentRequests()
    {
        return $this->fetchCachedItems(
            'dashboard-paymentRequests-' . auth()->id(),
            PaymentRequest::select('id', 'client_id', 'number', 'date', 'due_date', 'total', 'status')->with(['client:id,name'])->latest('date'),
            function ($paymentRequest) {
                return [
                    'id' => $paymentRequest->id,
                    'number' => $paymentRequest->number,
                    'date' => $paymentRequest->date,
                    'due_date' => $paymentRequest->due_date,
                    'total' => $paymentRequest->total,
                    'status' => $paymentRequest->status,
                    'client' => $paymentRequest->client->name,
                ];
            }
        );
    }

    public function get_pyments()
    {
        return $this->fetchCachedItems(
            'dashboard-pyments-' . auth()->id(),
            Pyment::select('id', 'client_id', 'number', 'date', 'subject', 'total', 'status')->with(['client:id,name'])->latest('date'),
            function ($pyment) {
                return [
                    'id' => $pyment->id,
                    'number' => $pyment->number,
                    'date' => $pyment->date,
                    'subject' => $pyment->subject,
                    'total' => $pyment->total,
                    'status' => $pyment->status,
                    'client' => $pyment->client->name,
                ];
            }
        );
    }

    public function get_creditNotes()
    {
        return $this->fetchCachedItems(
            'dashboard-creditNotes-' . auth()->id(),
            CreditNote::select('id', 'client_id', 'number', 'date', 'due_date', 'total', 'status')->with(['client:id,name'])->latest('date'),
            function ($creditNote) {
                return [
                    'id' => $creditNote->id,
                    'number' => $creditNote->number,
                    'date' => $creditNote->date,
                    'due_date' => $creditNote->due_date,
                    'total' => $creditNote->total,
                    'status' => $creditNote->status,
                    'client' => $creditNote->client->name,
                ];
            }
        );
    }

    public function get_expenses()
    {
        $authUser = auth()->user();
        $userId = $authUser->id;

        return Cache::remember('dashboard-expenses-' . $userId, 60, function () use ($authUser, $userId) {

            $query = Expense::select('id', 'client_id', 'number', 'date', 'type', 'total', 'status')
                ->with(['client:id,name'])
                ->latest('date');

            // If full or view_global → get all expenses
            if (!(
                $authUser->isAdmin() ||
                $authUser->hasAccess('expense', 'full') ||
                $authUser->hasAccess('expense', 'view_global')
            )) {
                $query->where('created_by', $userId);
            }

            return $query->take(20)
                ->get()
                ->map(function ($expense) {
                    try {
                        return [
                            'id' => $expense->id,
                            'number' => $expense->number,
                            'date' => $expense->date,
                            'type' => $expense->type,
                            'total' => $expense->total,
                            'status' => $expense->status,
                            'client' => optional($expense->client)->name,
                        ];
                    } catch (\Exception $e) {
                        return null;
                    }
                })
                ->filter();
        });
    }


    public function get_expired_contracts()
    {
        return $this->fetchCachedItems(
            'dashboard-expired-contracts-' . auth()->id(),
            Contract::select('id', 'client_id', 'number', 'subject', 'date', 'due_date', 'created_at', 'status')
                ->with(['client:id,name'])
                ->where('status', 'expired')
                ->latest('date'),
            function ($contract) {
                return $this->mapContract($contract);
            }
        );
    }

    public function get_about_to_expired_contracts()
    {
        return $this->fetchCachedItems(
            'dashboard-about-to-expired-contracts-' . auth()->id(),
            Contract::select('id', 'client_id', 'number', 'subject', 'date', 'due_date',  'created_at','status')
                ->with(['client:id,name'])
                ->where('status', 'about_to_expire')
                ->latest('date'),
            function ($contract) {
                return $this->mapContract($contract);
            }
        );
    }

    public function get_active_contracts()
    {
        return $this->fetchCachedItems(
            'dashboard-active-contracts-' . auth()->id(),
            Contract::select('id', 'client_id', 'number', 'subject', 'date', 'due_date',  'created_at', 'status')
                ->with(['client:id,name'])
                ->where('status', 'active')
                ->latest('date'),
            function ($contract) {
                return $this->mapContract($contract);
            }
        );
    }

    private function mapContract($contract) {
        return [
            'id' => $contract->id,
            'number' => $contract->number,
            'subject' => $contract->subject,
            'date' => $contract->date,
            'due_date' => $contract->due_date,
            'client_id' => $contract->client_id,
            'status' => $contract->status,
            'client' => $contract->client->name,
            'created_at' => $contract->created_at,
        ];
    }

    public function get_reminders()
        {
            return Cache::remember('dashboard-reminders-' . auth()->id(), 60, function () {
                $userId = (string) auth()->id();
                $today = now()->toDateString(); // only date part
                $sessionToday = now()->startOfDay();
                $now = now(); // full timestamp

                // Base query with proper grouping for user conditions
                $baseQuery = Reminder::select('id', 'subject', 'date', 'created_at', 'priority', 'status')
                    ->where(function ($query) use ($userId) {
                        $query->where('created_by', $userId);
                        // Removed orWhereJsonContains for now since members column was missing
                        // ->orWhereJsonContains('members', $userId);
                    });

                $allReminders = (clone $baseQuery)
                    ->latest('created_at')
                    ->take(30)
                    ->get();

                $todayReminders = (clone $baseQuery)
                    ->where('status', 'pending')
                    ->whereDate('date', $today)
                    ->latest('created_at')
                    ->take(30)
                    ->get();

                // Missed: status in [pending, missed], and date < today (not time-sensitive)
                $missedReminders = (clone $baseQuery)
                    ->whereDate('date', '<', $today)
                    // ->where('status', 'missed')
                    ->latest('created_at')
                    ->take(30)
                    ->get();

                // Coming: date > today and status not in [completed, missed]
                $commingReminders = (clone $baseQuery)
                    ->whereDate('date', '>=', $today)
                    ->where('status',  'pending') // Changed from whereNotIn for single value
                    ->latest('created_at')
                    ->take(30)
                    ->get();


                // Format reminders (excluding sessions which is already formatted)
                $formatReminders = function ($reminders) {
                    return $reminders->map(function ($reminder) {
                        try {
                            return [
                                'id' => $reminder->id,
                                'subject' => $reminder->subject,
                                'date' => $reminder->date,
                                'created_at' => $reminder->created_at,
                                'priority' => $reminder->priority,
                                'status' => $reminder->status,
                            ];
                        } catch (\Exception $e) {
                            Log::error("Dashboard Reminder Error: " . $e->getMessage());
                            return null;
                        }
                    })->filter();
                };

                return [
                    'todayReminders' => $formatReminders($todayReminders),
                    'commingReminders' => $formatReminders($commingReminders),
                    'missedReminders' => $formatReminders($missedReminders),
                    'allReminders' => $formatReminders($allReminders),
                ];
            });
        }

    public function get_tasks()
    {
        $authUser = auth()->user();
        $userId = $authUser->id;

        return Cache::remember('dashboard-tasks-' . $userId, 60, function () use ($authUser, $userId) {

            // If full or view_global → return all tasks
            if (
                $authUser->isAdmin() ||
                $authUser->hasAccess('task', 'full') ||
                $authUser->hasAccess('task', 'view_global')
            ) {
                return Task::select('id', 'subject', 'related', 'date', 'due_date', 'status')
                    ->latest('date')
                    ->take(20)
                    ->get()
                    ->map(function ($task) {
                        return [
                            'id' => $task->id,
                            'subject' => $task->subject,
                            'related' => $task->related,
                            'date' => $task->date,
                            'due_date' => $task->due_date,
                            'status' => $task->status,
                        ];
                    });
            }

            // Otherwise apply the existing filtering logic
            return Task::select('id', 'subject', 'related', 'date', 'due_date', 'status')
                ->latest('date')
                ->where('created_by', $userId)
                ->orWhereJsonContains('assignees', (string) $userId)
                ->orWhereJsonContains('followers', (string) $userId)
                ->take(20)
                ->get()
                ->map(function ($task) {
                    try {
                        return [
                            'id' => $task->id,
                            'subject' => $task->subject,
                            'related' => $task->related,
                            'date' => $task->date,
                            'due_date' => $task->due_date,
                            'status' => $task->status,
                        ];
                    } catch (\Exception $e) {
                        Log::error("Dashboard Task Error: " . $e->getMessage());
                        return null;
                    }
                })
                ->filter();
        });
    }


    public function get_task_counts()
    {
        $authUser = auth()->user();
        $userId = $authUser->id;

        return Cache::remember('dashboard-task-counts-' . $userId, 60, function () use ($authUser, $userId) {

            // If full or view_global → count all tasks
            if (
                $authUser->isAdmin() ||
                $authUser->hasAccess('task', 'full') ||
                $authUser->hasAccess('task', 'view_global')
            ) {
                $baseQuery = Task::query();
            } 
            // Otherwise → only tasks where user is creator, assignee, or follower
            else {
                $baseQuery = Task::where(function ($query) use ($userId) {
                    $query->where('created_by', $userId)
                        ->orWhereJsonContains('assignees', (string) $userId)
                        ->orWhereJsonContains('followers', (string) $userId);
                });
            }

            return [
                'onHoldTasksCount'    => (clone $baseQuery)->where('status', 'on_hold')->count(),
                'completedTasksCount' => (clone $baseQuery)->where('status', 'completed')->count(),
                'inProgressTasksCount'=> (clone $baseQuery)->where('status', 'in_progress')->count(),
                'allTasksCount'       => (clone $baseQuery)->count(),
            ];
        });
    }



    public function get_announcements()
    {
        return $this->fetchCachedItems(
            'dashboard-announcements-' . auth()->id(),
            Announcement::select('id', 'subject', 'message', 'created_at', 'created_by', 'show_name', 'status')
                ->where('status', 'active')
                ->latest('created_at'),
            function ($announcement) {
                return [
                    'id' => $announcement->id,
                    'subject' => $announcement->subject,
                    'message' => $announcement->message,
                    'show_name' => $announcement->show_name,
                    'created_at' => $announcement->created_at,
                    'created_by' => $announcement->created_by,
                ];
            }
        );
    }

    public function get_events()
    {
        // Fetch events (ensure it's an array)
        $events = $this->calendarFunctionController->getFilteredCalendarEvents([
            'projects', 'tasks','events'
        ]);

        // Ensure $events is an array (convert if it's a JSON response or collection)
        if ($events instanceof \Illuminate\Http\JsonResponse) {
            $events = $events->getData(true); // Convert JSON response to array
        } elseif ($events instanceof Collection) {
            $events = $events->toArray(); // Convert Laravel Collection to array
        }

        // Define the date range (3 days past, today, and 7 days ahead)
        $days = [];
        foreach (range(-3, 7) as $offset) {
            $days[Carbon::today()->addDays($offset)->toDateString()] = [];
        }

        // Process events
        foreach ($events as $event) {
            if (!isset($event['start'])) continue; // Skip if 'start' is missing

            $startDate = Carbon::parse($event['start'])->toDateString();
            $endDate = isset($event['end']) ? Carbon::parse($event['end'])->toDateString() : null;

            // Loop through all days between start and end date
            $eventPeriod = Carbon::parse($startDate)->daysUntil($endDate ?? $startDate);

            foreach ($eventPeriod as $date) {
                $day = $date->toDateString();
                if (array_key_exists($day, $days)) {
                    $days[$day][] = $event; // ✅ Works as a regular array now
                }
            }
        }

        return $days;
    }

    /**
     * Get Construction/EVM Statistics
     */
    private function get_construction_stats()
    {
        try {
            $projects = \App\Models\project\Project::withCount('boqItems')->get();
            
            $stats = [
                'total_projects' => $projects->count(),
                'projects_with_boq' => $projects->where('boq_items_count', '>', 0)->count(),
                'at_risk' => 0,
                'on_track' => 0,
                'total_budget' => 0,
                // Integration stats
                'expenses_linked' => 0,
                'tasks_linked' => 0,
                'total_actual_cost' => 0,
            ];

            $constructionService = app(\App\Services\ConstructionService::class);
            
            foreach ($projects->where('boq_items_count', '>', 0) as $project) {
                try {
                    $summary = $constructionService->getProjectSummary($project->id);
                    $stats['total_budget'] += $summary['bac'] ?? 0;
                    $stats['total_actual_cost'] += $summary['ac'] ?? 0;
                    
                    $cpi = $summary['cpi'] ?? 1;
                    $spi = $summary['spi'] ?? 1;
                    
                    if ($cpi < 0.9 || $spi < 0.9) {
                        $stats['at_risk']++;
                    } else {
                        $stats['on_track']++;
                    }
                } catch (\Exception $e) {
                    // Skip if error
                }
            }

            // Count linked expenses and tasks
            try {
                $stats['expenses_linked'] = \App\Models\finance\Expense::whereNotNull('boq_id')->count();
                $stats['tasks_linked'] = \App\Models\task\Task::whereNotNull('boq_id')->count();
            } catch (\Exception $e) {
                // Columns might not exist yet
                $stats['expenses_linked'] = 0;
                $stats['tasks_linked'] = 0;
            }

            return $stats;
        } catch (\Exception $e) {
            // Return default values if any error occurs
            return [
                'total_projects' => 0,
                'projects_with_boq' => 0,
                'at_risk' => 0,
                'on_track' => 0,
                'total_budget' => 0,
                'expenses_linked' => 0,
                'tasks_linked' => 0,
                'total_actual_cost' => 0,
            ];
        }
    }

    /**
     * Get Partners Statistics
     */
    private function get_partners_stats()
    {
        $stats = [
            'total_partners' => 0,
            'total_distributed' => 0,
            'total_withdrawals' => 0,
            'pending_balance' => 0,
        ];

        try {
            // Count unique partners
            $stats['total_partners'] = \App\Models\real_estate\ProjectPartner::distinct('user_id')->count('user_id');
            
            // Total distributed
            $stats['total_distributed'] = \App\Models\RevenueDistributionItem::sum('total_amount');
            
            // Total withdrawals
            $stats['total_withdrawals'] = \App\Models\PartnerWithdrawal::sum('amount');
            
            // Pending balance
            $stats['pending_balance'] = $stats['total_distributed'] - $stats['total_withdrawals'];
        } catch (\Exception $e) {
            // Tables might not exist yet
        }

        return $stats;
    }

    /**
     * Get Real Estate Statistics
     */
    private function get_real_estate_stats()
    {
        $stats = [
            'total_units' => 0,
            'available_units' => 0,
            'sold_units' => 0,
            'reserved_units' => 0,
            'total_value' => 0,
            'total_materials' => 0,
            // Integration stats
            'contracts_linked' => 0,
            'sold_value' => 0,
        ];

        try {
            $units = \App\Models\real_estate\PropertyUnit::all();
            $stats['total_units'] = $units->count();
            $stats['available_units'] = $units->where('status', 'available')->count();
            $stats['sold_units'] = $units->where('status', 'sold')->count();
            $stats['reserved_units'] = $units->where('status', 'reserved')->count();
            $stats['total_value'] = $units->sum('price');
            $stats['sold_value'] = $units->where('status', 'sold')->sum('price');
            
            // Materials count
            $stats['total_materials'] = \App\Models\real_estate\ConstructionMaterial::count();
            
            // Contracts linked to units
            $stats['contracts_linked'] = \App\Models\business\Contract::whereNotNull('unit_id')->count();
        } catch (\Exception $e) {
            // Tables might not exist yet
        }

        return $stats;
    }
}
