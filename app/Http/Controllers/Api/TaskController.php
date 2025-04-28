<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return response()->json(['status' => true, 'data' => $tasks]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'is_complete' => 'required|boolean',
        ]);
        $userId = $request->user_id == null ? auth()->id() : $request->user_id;
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_complete' => $request->is_complete,
            'user_id' => $userId,
        ]);

        return response()->json(['status' => true, 'message' => 'Task created successfully!', 'data' => $task]);
    }

    public function show(Task $task)
    {
        return response()->json(['status' => true, 'data' => $task]);
    }

    public function update(Request $request, Task $task)
    {
        $task->update($request->all());
        return response()->json(['status' => true, 'message' => 'Task updated successfully!']);
    }

    public function destroy(Task $task)
    {
        $task->status = 'Inactive';  
        $task->save();
        return response()->json(['status' => true, 'message' => 'Task deleted successfully!']);
    }

}
