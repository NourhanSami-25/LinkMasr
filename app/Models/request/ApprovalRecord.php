<?php

namespace App\Models\request;

use Illuminate\Database\Eloquent\Model;

class ApprovalRecord extends Model
{
    protected $fillable = [
        'subject',
        'related_request',
        'department',
        'role',
        'followup_id',
        'followup_name',
        'approver_id',
        'approver_name',
        'days_to_sign'
    ];
}
