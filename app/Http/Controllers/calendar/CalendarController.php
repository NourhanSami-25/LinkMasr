<?php

namespace App\Http\Controllers\calendar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    protected $calendarFunctionController;

    public function __construct(CalendarFunctionController $calendarFunctionController)
    {
        $this->calendarFunctionController = $calendarFunctionController;
    }

    public function index()
    {
        return view('calendar.index');
    }
}
