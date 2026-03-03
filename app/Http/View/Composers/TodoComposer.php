<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\utility\Todo;
use Illuminate\Support\Facades\Auth;

class TodoComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $userTodos = collect();
        
        if (Auth::check()) {
            $userTodos = Todo::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        }
        
        $view->with('userTodos', $userTodos);
    }
}
