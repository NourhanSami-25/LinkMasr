<?php

namespace App\Models\hr;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\user\User;


class Sector extends Model
{
    use HasFactory;

    protected $fillable = ['subject', 'manager_id'];

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }
}
