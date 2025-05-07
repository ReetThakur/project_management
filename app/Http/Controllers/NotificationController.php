<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Let's modify this to show all notifications for admin users
        $query = Notification::query();

        if (auth()->user()->isAdmin()) {
            // Admin can see all notifications
            $notifications = $query->with(['task.project', 'user'])
                ->latest()
                ->paginate(10);
        } else {
            // Other users see only their notifications
            $notifications = $query->where('user_id', auth()->id())
                ->with(['task.project', 'user'])
                ->latest()
                ->paginate(10);
        }

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        // Allow admin to delete any notification
        if (!auth()->user()->isAdmin() && $notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->delete();

        return back()->with('success', 'Notification deleted.');
    }

    public function markAsRead(Notification $notification)
    {
        // Allow admin to mark any notification as read
        if (!auth()->user()->isAdmin() && $notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->update(['read' => true]);

        return back()->with('success', 'Notification marked as read.');
    }
}
