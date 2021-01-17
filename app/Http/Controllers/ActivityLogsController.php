<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Activity;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        //If we get an incoming filter for username
        if($request->get('name'))
        {
            $name = strtolower($request->get('name'));
            //The Spatie Activity class has a magic relationship with the causer and the subject. As causer can only be
            //Users in our application, we can safely use a where clause on it.
            $activityLogs = Activity::whereHas('causer', function($q) use ($name) { //whereHas allows us to provide a
                // constraint on the causer relation (User)
                $q->whereRaw('LOWER(`name`) = ?',[$name]) //Where name of User is the incoming name
                ->orWhereRaw("LOWER(`previous_names`) LIKE CONCAT('%\"', ?, '\"%')",[$name]); //Or any previous name of User is the incoming name
            })->with('causer','subject')->get(); //Add the causer and subject to the end result so view can get relations


            return $activityLogs->toJSON();
        }

        $activityLogs = Activity::with('causer', 'subject')->get();
        return $activityLogs->toJSON();
    }
}
