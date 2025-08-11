<?php

namespace App\Http\Controllers;
use Spatie\Activitylog\Models\Activity;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{

    // Permissions Security
    public function __construct()
    {
        $this->middleware('permission:view logs')->only(['index']);
    }

    public function index(){

        $activities = Activity::with(['causer', 'subject'])->latest()->paginate(20);
        return view('activityLogs.index', compact('activities'));

    }
}