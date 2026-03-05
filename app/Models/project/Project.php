<?php

namespace App\Models\project;

use App\Models\user\User;
use App\Models\client\Client;
use App\Models\task\Task;


use App\Models\business\Lead;
use App\Models\business\Contract;
use App\Models\business\Proposal;

use App\Models\finance\Invoice;
use App\Models\finance\CreditNote;
use App\Models\finance\PaymentRequest;
use App\Models\finance\Expense;

use App\Models\common\File;
use App\Models\common\Note;
use App\Models\common\Discussion;
use App\Models\reminder\Reminder;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'user_id',
        'client_id',
        'name',
        'subject',
        'description',
        'status',
        'date',
        'start_date',
        'due_date',
        'deadline_date',
        'billing_type',
        'is_repeated',
        'repeat_every',
        'repeat_counter',
        'assignees',
        'followers',
        'created_by',
    ];




    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

 




    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function paymentRequests(): HasMany
    {
        return $this->hasMany(PaymentRequest::class);
    }

    public function creditNotes(): HasMany
    {
        return $this->hasMany(CreditNote::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function Proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }


    // Common models relations
    public function files()
    {
        return $this->morphMany(File::class, 'referable');
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'referable');
    }

    public function reminders()
    {
        return $this->morphMany(Reminder::class, 'referable');
    }

    public function discussion()
    {
        return $this->morphOne(Discussion::class, 'discussionable');
    }
    // Real Estate Relations
    public function partners()
    {
        return $this->belongsToMany(User::class, 'project_partner', 'project_id', 'partner_id')
                    ->withPivot('share_percentage', 'management_fee_percentage')
                    ->withTimestamps()
                    ->using(\App\Models\real_estate\ProjectPartner::class);
    }

    public function units(): HasMany
    {
        return $this->hasMany(\App\Models\real_estate\PropertyUnit::class);
    }

    public function drawings(): HasMany
    {
        return $this->hasMany(\App\Models\real_estate\ProjectDrawing::class);
    }

    // Construction Relations
    public function boqItems(): HasMany
    {
        return $this->hasMany(\App\Models\construction\ConstructionBoq::class);
    }
}
