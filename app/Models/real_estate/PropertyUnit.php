<?php

namespace App\Models\real_estate;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyUnit extends Model
{
    protected $table = 'property_units';

    protected $fillable = [
        'project_id',
        'name',
        'status', // available, sold, reserved
        'price',
        'area',
        'drawing_id',
        'description',
        'pos_x',
        'pos_y',
        'sold_date',
        'buyer_id', // Client who bought the unit
    ];

    protected $casts = [
        'sold_date' => 'date',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(\App\Models\project\Project::class);
    }

    public function drawing(): BelongsTo
    {
        return $this->belongsTo(ProjectDrawing::class);
    }

    /**
     * The client who bought this unit
     */
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(\App\Models\client\Client::class, 'buyer_id');
    }

    /**
     * Contracts related to this unit
     */
    public function contracts()
    {
        return $this->hasMany(\App\Models\business\Contract::class, 'unit_id');
    }
}
