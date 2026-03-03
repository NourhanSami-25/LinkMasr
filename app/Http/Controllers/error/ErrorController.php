<?php

namespace App\Http\Controllers\error;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function index($message)
    {
        session()->forget('detailed_error', 'error');
        return view('error.index', compact('message'));
    }
}
