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
                $tasks = $tasks->where($key, $value);
            }
        }

        $perPage = $request->input('per_page', 10);
        $tasks = $tasks->paginate($perPage);

        return TaskResource::collection($tasks);
    }
}
