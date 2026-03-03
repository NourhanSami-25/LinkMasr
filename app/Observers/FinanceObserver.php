<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

class FinanceObserver
{
    public function deleting(Model $model)
    {
        if (method_exists($model, 'financeItems')) {
            $model->financeItems()->delete();
        }
    }
}
