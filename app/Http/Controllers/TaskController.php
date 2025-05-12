<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use Inertia\Inertia;
use App\Models\Task;

class TaskController extends Controller
{
    public function create()
    {
        return Inertia::render('tasks/CreateTask');
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
