<?php

namespace App\Models\setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\user\User;


class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withPivot('access_level');
    }

    public function hasRole($role, $level = null)
    {
        $query = $this->roles->where('name', $role);

        if ($level) {
            return $query->where('pivot.access_level', $level)->count() > 0;
        }

        return $query->count() > 0;
    }
}
