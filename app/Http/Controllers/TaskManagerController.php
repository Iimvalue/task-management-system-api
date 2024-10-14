<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskManagerController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'role:Admin,Manager']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    { {
            $status = $request->query('status');

            $query = Task::query();

            if ($status === 'Assigned') {
                $query->where('assign_status', 'Assigned');
            } elseif ($status === 'Not Assigned') {
                $query->where('assign_status', 'Not Assigned');
            } elseif ($status === 'Resolved') {
                $query->where('resolve_status', 'Resolved');
            }

            $tasks = $query->get();

            return response()->json(['tasks' => $tasks]);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'created_by' => auth()->id(),
        ]);

        return response()->json($task, 201);
    }

    /**
     * Assign to specific employee
     */
    public function assign(Request $request, $taskId)
    {
        $request->validate([
            'assigned_to' => "required|exists:users,id"
        ]);

        $task = Task::findOrFail($taskId);

        $task->assigned_to = $request->assigned_to;
        $task->assigned_at = now()->format('Y-m-d H:i:s');
        $task->assign_status = "Assigned";
        $task->resolve_status = "Not Resolved";
        $task->save();

        $this->createNotification($task->assigned_to, $task->id);


        return response()->json(['Task assigned successfully', 'task' => $task]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $task = $task->findOrFail($task->id);

        $task->update($request->all());

        return response()->json(['message' => 'Task updated successfully', 'task' => $task]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(['Task deleted successfully']);
    }

    private function createNotification($userId, $taskId)
    {
        Notification::create([
            'user_id' => $userId,
            'task_id' => $taskId,
        ]);
    }
}
