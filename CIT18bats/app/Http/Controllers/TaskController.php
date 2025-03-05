<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('tasker.index', compact('tasks'));
    }

    public function create()
    {
        return view('create'); 
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $task = Task::create([
        'title' => $request->title,
        'description' => $request->description,
        'is_completed' => false,
    ]);

    
    dd(Task::all()); 

    return redirect()->route('tasker.index')->with('success', 'Task added successfully!');
}


    public function show(Task $task)
    {
        return response()->json($task);
    }

    public function edit(Task $task)
    {
        return view('tasker.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'is_completed' => 'boolean',
        ]);

        $task->update($request->all());

        return Redirect::route('tasker.index')->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
{
    $task->delete();
    return redirect()->route('tasker.index')->with('success', 'Task deleted successfully!');
}

}