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

            $statusCondisions = [
                "Assigned" => ['assign_status', 'Assigned'],
                "Not Assigned" => ['assign_status', 'Not Assigned'],
                "Resolved" => ['resolve_status', 'Resolved']
            ];

            if (isset($statusCondisions[$status])) {
                [$column, $value] = $statusCondisions[$status];
                $query->where($column, $value);
            }

            if ($status && !isset($conditions[$status])) {
                return response()->json(['error' => 'Invalid status provided.'], 400);
            }


            $tasks = $query->get();

            return response()->json(['data' => $tasks]);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:80',
            'description' => 'nullable|string|max:1000',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'created_by' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Task created successfully.',
            'data' => $task,
        ], 201);
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


        return response()->json([
            'message' => 'Task assigned successfully',
            'data' => $task
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'title' => 'required|string|max:80',
            'description' => 'nullable|string|max:1000',
        ]);

        $task->update($data);

        return response()->json([
            'message' => 'Task assigned successfully',
            'data' => $task
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully'], 200);
    }

    private function createNotification($userId, $taskId)
    {
        Notification::create([
            'user_id' => $userId,
            'task_id' => $taskId,
        ]);
    }
}
