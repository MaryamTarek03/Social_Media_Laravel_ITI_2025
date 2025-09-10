<?php

namespace App\Livewire\Notification;

use App\Models\Notification;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class RealTimeNotifications extends Component
{
    public $notifications = [];
    public $unreadCount = 0;

    protected $listeners = [
        'notificationReceived' => 'handleNewNotification',
        'refreshNotifications' => '$refresh'
    ];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->toArray();

        $this->unreadCount = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();
    }

    public function handleNewNotification($notificationData)
    {
        // Add the new notification to the top of the list
        array_unshift($this->notifications, $notificationData);
        $this->unreadCount++;

        // Keep only the latest 10 notifications
        $this->notifications = array_slice($this->notifications, 0, 10);

        // Dispatch event to update notification badge
        $this->dispatch('notificationBadgeUpdate', $this->unreadCount);
    }

    public function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);

        if ($notification && $notification->user_id === Auth::id()) {
            $notification->update(['is_read' => true]);
            $this->unreadCount = max(0, $this->unreadCount - 1);

            // Update the notification in the array
            foreach ($this->notifications as &$notif) {
                if ($notif['id'] === $notificationId) {
                    $notif['is_read'] = true;
                    break;
                }
            }

            $this->dispatch('notificationBadgeUpdate', $this->unreadCount);
        }
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $this->unreadCount = 0;

        // Update all notifications as read
        foreach ($this->notifications as &$notification) {
            $notification['is_read'] = true;
        }

        $this->dispatch('notificationBadgeUpdate', $this->unreadCount);
    }

    public function deleteNotification($notificationId)
    {
        $notification = Notification::find($notificationId);

        if ($notification && $notification->user_id === Auth::id()) {
            $wasUnread = !$notification->is_read;
            $notification->delete();

            // Remove from array
            $this->notifications = array_filter($this->notifications, function ($notif) use ($notificationId) {
                return $notif['id'] !== $notificationId;
            });

            if ($wasUnread) {
                $this->unreadCount = max(0, $this->unreadCount - 1);
                $this->dispatch('notificationBadgeUpdate', $this->unreadCount);
            }
        }
    }

    public function render()
    {
        return view('livewire.notification.real-time-notifications');
    }
}
