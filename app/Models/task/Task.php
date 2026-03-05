<?php

namespace App\Models\task;

use App\Models\business\Lead;
use App\Models\business\Contract;
use App\Models\business\Proposal;

use App\Models\project\Project;

use App\Models\client\Client;

use App\Models\finance\Invoice;
use App\Models\finance\CreditNote;
use App\Models\finance\PaymentRequest;
use App\Models\finance\Expense;
use App\Models\finance\Pyment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\common\File;
use App\Models\common\Note;
use App\Models\common\Discussion;
use App\Models\reminder\Reminder;

class Task extends Model
{
    protected $fillable = [
        'project_id',
        'client_id',
        'boq_id', // Construction BOQ link for EVM integration
        'subject',
        'status',
        'start_date',
        'due_date',
        'priority',
        'related',
        'description',
        'type',
        'is_billed',
        'is_repeated',
        'repeat_every',
        'repeat_counter',
        'assignees',
        'followers',
        'created_by'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'due_date' => 'datetime',
        'assignees' => 'array',
        'followers' => 'array',
        'is_repeated' => 'boolean',
        'is_billed' => 'boolean',
    ];

    //  create has many for all finance , create has many for all requests


    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Relation to Construction BOQ Item for EVM integration
     */
    public function boqItem(): BelongsTo
    {
        return $this->belongsTo(\App\Models\ConstructionBoq::class, 'boq_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
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
        return $this->hasMany(creditNote::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function pyments(): HasMany
    {
        return $this->hasMany(Pyment::class);
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
}
