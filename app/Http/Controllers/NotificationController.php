<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:sanctum");
    }
    public function getNotifications(Request $request)
    {
        $status = $request->query('is_read');

        $query = Notification::where('user_id', auth()->id());

        if (!is_null($status)) {
            $query->where('is_read', $status);
        }

        return response()->json($query->get());
    }


    
    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->firstOrFail();

        $notification->is_read = true;
        $notification->save();

        return response()->json(['message' => 'Notification marked as read']);
    }
}
