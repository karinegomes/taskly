<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\UserDropdownResource;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        return Inertia::render('tasks/Tasks', ['tasks' => $tasks]);
    }

    public function create()
    {
        $users = UserDropdownResource::collection(User::orderBy('name')->get());

        return Inertia::render('tasks/CreateTask', [
            'users' => $users,
        ]);
    }

    public function store(StoreTaskRequest $request)
    {
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'priority' => $request->priority,
            'due_date' => $request->due_date,
            'assigned_to' => $request->assigned_to,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Task created successfully.');
    }
}
