<?php

namespace App\Services\common;

use Illuminate\Support\Facades\Auth;


class DiscussionService
{
    public function createFor($model)
    {
        return $model->discussion()->create();
    }
}
