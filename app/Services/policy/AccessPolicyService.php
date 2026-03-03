<?php

namespace App\Services\policy;

use Illuminate\Support\Facades\Gate;


class AccessPolicyService
{
    // public function authorizeAccess(string $module, string $level)
    // {
    //     if (!Gate::allows("access{$module}", $level)) {
    //         return redirect()->back()->with([
    //             'authError' => 'Unauthorized Access',
    //         ])->send(); // Prevents further execution (important!)
    //     }
    // }
}
