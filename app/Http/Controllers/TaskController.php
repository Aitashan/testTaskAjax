<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    public function redirect()
    {
        return redirect()->route('tasks.index');
    }
    public function index() : View
    {
        $tasks = Task::orderBy('priority', 'DESC')->paginate(5);

        return view('tasks.index', compact('tasks'));
    }

    public function show(Task $task) : View
    {
        return view('tasks.show', ['task' => $task]);
    }

    public function create()
    {
        return view('tasks.form');
    }

    public function store(StoreTaskRequest $request) : RedirectResponse
    {
        $task = Task::create($request->validated());

        return redirect()->route('tasks.show', ['task' => $task])
            ->with('success', 'Task created successfully!');
    }

    public function edit(Task $task)
    {
        return view('tasks.form', compact('task'));
    }

    public function update(UpdateTaskRequest $request, Task $task) : RedirectResponse
    {
        $task->update($request->validated());

        return redirect()->route('tasks.show', compact('task'))
            ->with('success', 'Task updated successfully');
    }

    public function toggle(Task $task) {
        $task->toggleComplete();
      
        return redirect()->back()->with('success', 'Task toggled');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully');
    }
}
