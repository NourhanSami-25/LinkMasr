<?php

namespace App\Models\business;

use App\Models\project\Project;
use App\Models\task\Task;
use App\Models\client\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    protected $fillable = [
  
        'client_name',
        'address',
        'number',
        'subject',
        'email',
        'website',
        'phone',
        'lead_value',
        'source',
        'sale_agent',
        'created_since',
        'status',
        'created_by'
    ];

   
}
