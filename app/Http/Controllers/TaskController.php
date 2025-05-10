<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class TaskController extends Controller
{
    public function create()
    {
        return Inertia::render('tasks/CreateTask');
    }
}
