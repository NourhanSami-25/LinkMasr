<?php

namespace App\Models\real_estate;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectDrawing extends Model
{
    protected $table = 'project_drawings';

    protected $fillable = [
        'project_id',
        'title',
        'file_path',
        'type', // master_plan, unit_plan
        'parent_id',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(\App\Models\project\Project::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ProjectDrawing::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(ProjectDrawing::class, 'parent_id');
    }
    
    public function units(): HasMany
    {
        return $this->hasMany(PropertyUnit::class, 'drawing_id');
    }
}
