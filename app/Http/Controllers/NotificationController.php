<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        return view('notification.index', [
            'notifications' => Notification::all()
        ]);
    }

    public function create(Notification $notification)
    {
        if (!$notification->exists) {
            $notification = null;
        }
        return view('notification.show', [
            'notification' => $notification
        ]);
    }

    public function save(Request $request)
    {
        $request->validate([
            'device' => 'required',
            'text' => 'required',
        ]);

        $notif = Notification::updateOrCreate(
            ['slug' => $request->name],
            [
                'device_id' => $request->device,
                'text' => $request->text,
            ]
        );

        return redirect('notifikasi')->with('success', 'Notification berhasil disimpan');
    }

    public function delete(Notification $notification)
    {
        $notification->delete();
        return redirect()->back()->with('success', 'Notification berhasil dihapus');
    }
}
