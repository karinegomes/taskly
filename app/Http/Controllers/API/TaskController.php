<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::with('assignee');

        if ($request->has('sort')) {
            foreach($request->input('sort') as $item) {
                $tasks = $tasks->orderBy($item['key'], $item['direction']);
            }
        }

        if ($request->has('filter')) {
            foreach($request->input('filter') as $key => $value) {
                if ($key === 'status' || $key === 'priority') {
                    $tasks = $tasks->where($key, $value);
                }
            }

            if ($request->has('filter.from_date') && $request->has('filter.to_date')) {
                $tasks = $tasks
                    ->whereDate('due_date', '>=', $request->input('filter.from_date'))
                    ->whereDate('due_date', '<=', $request->input('filter.to_date'));

            }
        }

        $perPage = $request->input('per_page', 10);
        $tasks = $tasks->paginate($perPage);

        return TaskResource::collection($tasks);
    }

    public function show($id)
    {
        $task = Task::with('assignee')->findOrFail($id);

        return new TaskResource($task);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return 'ok';
    }
}
