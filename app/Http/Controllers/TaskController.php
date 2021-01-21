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
        // Denies visit if the user does not have the correct permissions
        abort_if(Gate::denies('task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();

        // Link the task to the user id so users only see their tasks
        $tasks = Task::where('user_id',$user->id)->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        // Denies visit if the user does not have the correct permissions
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
        // Denies visit if the user does not have the correct permissions
        abort_if(Gate::denies('task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // If another user tries to see the page of another task made by another user he gets denied
        abort_unless($task->user_id === Auth::user()->id, Response::HTTP_FORBIDDEN, 'You may not view this task');

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        // Denies visit if the user does not have the correct permissions
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
        // Denies visit if the user does not have the correct permissions
        abort_if(Gate::denies('task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $task->delete();

        return redirect()->route('tasks.index');
    }
}
