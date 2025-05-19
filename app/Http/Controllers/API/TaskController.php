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
        $perPage = $request->input('per_page', 10);
        $tasks = Task::paginate($perPage);

        return TaskResource::collection($tasks);
    }
}
