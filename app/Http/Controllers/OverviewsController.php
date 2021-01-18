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

class OverviewsController extends Controller
{
    public function reporters()
    {
        abort_if(Gate::denies('overviews_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $type = 'reporter';
        return view('overview.index', get_defined_vars());
    }

    public function subjects()
    {
        abort_if(Gate::denies('overviews_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');



        $type = 'subject';
        return view('overview.index', get_defined_vars());
    }

}
