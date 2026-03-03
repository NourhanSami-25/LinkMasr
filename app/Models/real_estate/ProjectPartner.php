<?php

namespace App\Models\real_estate;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\project\Project;
use App\Models\user\User;

class ProjectPartner extends Pivot
{
    protected $table = 'project_partner';

    public $incrementing = true;

    protected $fillable = [
        'project_id',
        'partner_id',
        'share_percentage',
        'management_fee_percentage',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function partner()
    {
        return $this->belongsTo(User::class, 'partner_id');
    }
}
