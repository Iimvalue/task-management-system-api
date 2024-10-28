<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Http;


class TaskEmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:sanctum");
    }

    /**
     * view tasks of employee
     */
    public function index(Request $request)
    {

        $status = $request->query('status');

        $query = Task::where('assigned_to', auth()->id());

        if ($status === 'Resolved') {
            $query->where('resolve_status', 'Resolved');
        } elseif ($status === 'Not Resolved') {
            $query->where('resolve_status', 'Not Resolved');
        }

        $tasks = $query->get();

        return response()->json(['tasks' => $tasks]);
    }

    /**
     * resolve specific task status, and get weather data
     */
    public function resolve(Request $request, $taskId)
    {
        $request->validate([
            'notes' => 'nullable|string',
        ]);

        $task = Task::where('id', $taskId)
            ->where('assigned_to', auth()->id())
            ->firstOrFail();

        $task->resolve_status = 'Resolved';
        $task->notes = $request->notes;
        $task->save();

        $this->createNotification($task->created_by, $task->id);



        $weather = $this->getWeather();

        return response()->json([
            'message' => 'Task marked as resolved',
            'task' => $task,
            'weather' => $weather
        ]);
    }




    private function getWeather()
    {
        $apiKey = env('WEATHER_KEY');
        $city = 'Buraidah';
        $url = "http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric";

        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();
            return [
                'temperature' => $data['main']['temp'],
                'weather' => $data['weather'][0]['main'],
                'description' => $data['weather'][0]['description'],
                'humidity' => $data['main']['humidity'],
            ];
        }

        return null;
    }

    private function createNotification($userId, $taskId)
    {
        Notification::create([
            'user_id' => $userId,
            'task_id' => $taskId,
        ]);
    }
}
