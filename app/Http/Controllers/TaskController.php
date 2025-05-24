<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
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
        return Inertia::render('tasks/CreateTask');
    }

    public function edit($id)
    {
        return Inertia::render('tasks/CreateTask', ['task_id' => $id, 'edit' => true]);
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

    public function update($id, StoreTaskRequest $request)
    {
        $task = Task::find($id);

        if ($task) {
            $task->update($request->all());
        }

        return redirect()->route('dashboard')->with('success', 'Task updated successfully.');
    }
}
