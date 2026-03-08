<?php

namespace App\Models\user;

use App\Models\common\Reminder;
use App\Models\project\Project;
use App\Models\task\Task;
use App\Models\client\Client;
use App\Models\hr\Department;
use App\Models\hr\Sector;
use App\Models\hr\Position;
use App\Models\setting\Role;

use App\Models\finance\Payment;
use App\Models\finance\Expense;
use App\Models\hr\Balance;
use App\Models\request\VacationRequest;
use App\Models\request\MissionRequest;
use App\Models\request\PermissionRequest;
use App\Models\request\MoneyRequest;
use App\Models\request\WorkHomeRequest;
use App\Models\request\OvertimeRequest;
use App\Models\request\SupportRequest;

use App\Models\utility\Announcement;
use App\Models\utility\Calendar;
use App\Models\utility\Todo;
use App\Models\utility\Goal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;
    use Notifiable;
    use Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'department_id',
        'job_title',
        'position_id',
        'role_id',
        'phone',
        'address',
        'linkedin',
        'facebook',
        'signature',
        'hourly_rate',
        'photo',
        'bio',
        'status',
        'language',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function roles()
    {
        return $this->belongsToMany(Role::class)->withPivot('access_level');
    }

    public function isAdmin(): bool
    {
        return $this->roles->contains('name', 'Administrator');
    }


    public function hasAccess(string $subject, string $permission): bool
        {
            if ($this->isAdmin()) {
                return true; // Admin has all access
            }

            $role = $this->roles->where('name', $subject)->first();

            if (!$role) {
                return false; // User has no role for this section
            }

            $accessLevel = $role->pivot->access_level;

            // Handle both JSON format and simple string format
            if (is_string($accessLevel) && in_array($accessLevel, ['read', 'modify', 'full'])) {
                // Simple string format from database constraint
                if ($accessLevel === 'full') {
                    return true; // Full access grants all permissions
                }
                if ($accessLevel === 'modify' && in_array($permission, ['view', 'create', 'edit', 'delete'])) {
                    return true; // Modify grants basic CRUD permissions
                }
                if ($accessLevel === 'read' && $permission === 'view') {
                    return true; // Read grants only view permission
                }
                return false;
            }

            // Legacy JSON format support
            $userPermissions = json_decode($accessLevel, true) ?? [];

            // If user has "full", they get all permissions
            if (in_array('full', $userPermissions)) {
                return true;
            }

            // "view_global" is stronger than "view"
            if ($permission === 'view' && in_array('view_global', $userPermissions)) {
                return true;
            }

            // Check if the specific permission exists
            return in_array($permission, $userPermissions);
        }



    // Request Relations
    public function balance()
{
    return $this->hasOne(Balance::class);
}

     public function vacationRequests(): HasMany
    {
        return $this->hasMany(VacationRequest::class);
    }
    public function permisisonRequests(): HasMany
    {
        return $this->hasMany(PermissionRequest::class);
    }
    public function missionRequests(): HasMany
    {
        return $this->hasMany(MissionRequest::class);
    }
    public function moneyRequests(): HasMany
    {
        return $this->hasMany(MoneyRequest::class);
    }
    public function supportRequests(): HasMany
    {
        return $this->hasMany(SupportRequest::class);
    }
    public function overtimeRequests(): HasMany
    {
        return $this->hasMany(OvertimeRequest::class);
    }
    public function workHomeRequests(): HasMany
    {
        return $this->hasMany(WorkHomeRequest::class);
    }



    // Utility Relations
    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }

    public function calendars(): HasMany
    {
        return $this->hasMany(Calendar::class);
    }

    public function todos(): HasMany
    {
        return $this->hasMany(Todo::class);
    }

    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class);
    }


    // User Relations
    public function positionRelation(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }


    public function managedSectors()
    {
        return $this->hasMany(Sector::class, 'manager_id');
    }


    public function managedDepartment()
    {
        return $this->hasMany(Department::class, 'manager_id');
    }





    // Common Relations
    public function reminders(): HasMany
    {
        return $this->hasMany(Reminder::class);
    }

    // Setting Relations










    // Real Estate Scopes
    public function scopePartners($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('name', 'partner'); // Assuming 'partner' role exists or will be created
        });
    }

    public function partnerProjects()
    {
        return $this->belongsToMany(Project::class, 'project_partner', 'partner_id', 'project_id')
                    ->withPivot('share_percentage', 'management_fee_percentage')
                    ->withTimestamps()
                    ->using(\App\Models\real_estate\ProjectPartner::class);
    }
}
