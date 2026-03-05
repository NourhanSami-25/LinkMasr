<?php

namespace App\Models\real_estate;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\project\Project;
use App\Models\user\User;

class ProjectPartner extends Model
{
    protected $table = 'project_partner';
    
    protected $fillable = [
        'project_id',
        'partner_id',
        'share_percentage',
        'management_fee_percentage'
    ];

    protected $casts = [
        'share_percentage' => 'decimal:2',
        'management_fee_percentage' => 'decimal:2',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'partner_id');
    }
}