<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoqBreakdownCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'name_ar',
        'sort_order',
    ];

    /**
     * Get the breakdown items for this category.
     */
    public function items()
    {
        return $this->hasMany(BoqBreakdownItem::class, 'category_id');
    }

    /**
     * Get localized name based on app locale.
     */
    public function getLocalizedNameAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->name_ar : $this->name;
    }
}
