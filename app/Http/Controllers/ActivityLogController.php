<?php

namespace App\Http\Controllers;
use Spatie\Activitylog\Models\Activity;


use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(){

        $activities = Activity::with(['causer', 'subject'])->latest()->paginate(20);
        return view('activityLogs.index', compact('activities'));

    }
}
