<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Activity;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ActivityLogsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('activity_logs_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $activityLogs = Activity::with('causer', 'subject')->get();

        return view('activity-logs.index', compact('activityLogs'));
    }

    public function indexAjax(Request $request)
    {
        abort_if(Gate::denies('activity_logs_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $activityLogs = Activity::with('causer', 'subject')->get();

        if($request->get('name'))
        {
            foreach($activityLogs as $key => $activityLog)
            {
                if($activityLog->causer === null || strtolower($activityLog->causer->name) !== strtolower($request->get('name')))
                {
                    unset($activityLogs[$key]);
                }
            }
        }

        return $activityLogs->toJSON();
    }
}
