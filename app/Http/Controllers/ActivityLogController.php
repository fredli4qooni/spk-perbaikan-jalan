<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function index()
    {
        abort_unless(Auth::user()?->role === 'admin', 403);

        $activities = ActivityLog::with('user')->latest()->paginate(15);

        return view('activity-logs.index', compact('activities'));
    }
}
