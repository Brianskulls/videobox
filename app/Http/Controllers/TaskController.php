<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();

        $tasks = Task::where('user_id',$user->id)->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        abort_if(Gate::denies('task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('tasks.create');
    }

    public function store(StoreTaskRequest $request)
    {
        $user = Auth::user();

        $task = new Task($request->validated());
        $task->user()->associate($user);
        $task->save();

        return redirect()->route('tasks.index');
    }

    public function show(Task $task)
    {
        abort_if(Gate::denies('task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        abort_unless($task->user_id === Auth::user()->id, Response::HTTP_FORBIDDEN, 'You may not view this task');

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        abort_if(Gate::denies('task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('tasks.edit', compact('task'));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        abort_if(Gate::denies('task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

//        $task->unsetRelation(Auth::user());
        $task->delete();

        return redirect()->route('tasks.index');
    }
}
