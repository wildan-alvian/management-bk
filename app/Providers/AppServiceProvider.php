<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('layout.index', function($view) {
            $user = Auth::user();

            $notifications = Notification::orderBy('created_at', 'desc');
            if ($user->hasRole(['Guidance Counselor', 'Student', 'Student Parents'])) {
                if ($user->hasRole(['Student', 'Student Parents'])) {
                    $notifications = $notifications->where('user_id', $user->id);
                }
                $notifications = $notifications->where('type', $user->role);
            }

            $unreadCount = $notifications->where('status', false)->count();

            $view->with('unreadCountBadge', $unreadCount);
        });
    }
}
