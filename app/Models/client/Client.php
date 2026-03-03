<?php

namespace App\Models\client;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\user\User;
use App\Models\project\Project;

use App\Models\business\Lead;
use App\Models\business\Contract;
use App\Models\business\Proposal;

use App\Models\finance\Invoice;
use App\Models\finance\CreditNote;
use App\Models\finance\PaymentRequest;
use App\Models\finance\Expense;
use App\Models\finance\Pyment;


use App\Models\common\File;
use App\Models\common\Note;

class Client extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'name',
        'phone',
        'email',
        'currency',
        'default_language',
        'status',
        'created_by',
        'photo',
        'phone2',
        'website',
        'bio',
        'tax_number',
        'computer_number',
    ];

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    public function billingAddresses(): HasMany
    {
        return $this->hasMany(BillingAddress::class);
    }

    public function clientContacts(): HasMany
    {
        return $this->hasMany(ClientContact::class);
    }


    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
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
}
