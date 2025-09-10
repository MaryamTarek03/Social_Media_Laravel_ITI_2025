<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Follow;
use App\Models\Notification;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    /**
     * Display the main Reports module options page
     */
    public function index()
    {
        return view('modules.reports.index');
    }

    /**
     * Generate user analytics report
     */
    public function userAnalytics()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('last_login_at', '>', now()->subDays(30))->count();
        $newUsersThisMonth = User::where('created_at', '>', now()->subDays(30))->count();

        $topUsersByPosts = User::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->take(10)
            ->get();

        $topUsersByFollowers = User::withCount('followers')
            ->orderBy('followers_count', 'desc')
            ->take(10)
            ->get();

        return view('modules.reports.user-analytics', compact(
            'totalUsers',
            'activeUsers',
            'newUsersThisMonth',
            'topUsersByPosts',
            'topUsersByFollowers'
        ));
    }

    /**
     * Generate post analytics report
     */
    public function postAnalytics()
    {
        $totalPosts = Post::count();
        $postsThisWeek = Post::where('created_at', '>', now()->subDays(7))->count();
        $postsThisMonth = Post::where('created_at', '>', now()->subDays(30))->count();

        $mostLikedPosts = Post::with('user')
            ->withCount('reactions')
            ->orderBy('reactions_count', 'desc')
            ->take(10)
            ->get();

        $recentPosts = Post::with('user')
            ->latest()
            ->take(20)
            ->get();

        $postsByDay = Post::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('modules.reports.post-analytics', compact(
            'totalPosts',
            'postsThisWeek',
            'postsThisMonth',
            'mostLikedPosts',
            'recentPosts',
            'postsByDay'
        ));
    }

    /**
     * Generate engagement report
     */
    public function engagement()
    {
        $totalReactions = \App\Models\Reaction::count();
        $reactionsThisWeek = \App\Models\Reaction::where('created_at', '>', now()->subDays(7))->count();

        $reactionTypes = \App\Models\Reaction::select('reaction_type_id', DB::raw('count(*) as count'))
            ->with('reactionType')
            ->groupBy('reaction_type_id')
            ->orderBy('count', 'desc')
            ->get();

        $followStats = [
            'total_follows' => Follow::count(),
            'follows_this_week' => Follow::where('created_at', '>', now()->subDays(7))->count(),
        ];

        $messageStats = [
            'total_messages' => Message::count(),
            'messages_this_week' => Message::where('created_at', '>', now()->subDays(7))->count(),
            'active_chats' => Chat::whereHas('messages', function ($query) {
                $query->where('created_at', '>', now()->subDays(7));
            })->count(),
        ];

        return view('modules.reports.engagement', compact(
            'totalReactions',
            'reactionsThisWeek',
            'reactionTypes',
            'followStats',
            'messageStats'
        ));
    }

    /**
     * Generate system health report
     */
    public function systemHealth()
    {
        $databaseStats = [
            'users_count' => User::count(),
            'posts_count' => Post::count(),
            'reactions_count' => \App\Models\Reaction::count(),
            'follows_count' => Follow::count(),
            'notifications_count' => Notification::count(),
            'chats_count' => Chat::count(),
            'messages_count' => Message::count(),
        ];

        $storageStats = [
            'total_disk_space' => disk_total_space('/'),
            'free_disk_space' => disk_free_space('/'),
            'used_disk_space' => disk_total_space('/') - disk_free_space('/'),
        ];

        $performanceStats = [
            'average_response_time' => 0, // Would need actual monitoring data
            'memory_usage' => memory_get_peak_usage(true),
            'uptime' => 0, // Would need system monitoring
        ];

        $orphanedRecords = [
            'posts_without_users' => Post::whereDoesntHave('user')->count(),
            'notifications_without_users' => Notification::whereDoesntHave('user')->count(),
            'follows_without_users' => Follow::whereDoesntHave('follower')->orWhereDoesntHave('following')->count(),
        ];

        return view('modules.reports.system-health', compact(
            'databaseStats',
            'storageStats',
            'performanceStats',
            'orphanedRecords'
        ));
    }

    /**
     * Export report data
     */
    public function export(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:user_analytics,post_analytics,engagement,system_health',
            'format' => 'required|in:csv,json,pdf',
        ]);

        $type = $request->report_type;
        $format = $request->format;

        $data = $this->getReportData($type);

        $filename = "{$type}_report_" . date('Y-m-d_H-i-s');

        switch ($format) {
            case 'csv':
                return $this->exportAsCsv($data, $filename);
            case 'json':
                return $this->exportAsJson($data, $filename);
            case 'pdf':
                return $this->exportAsPdf($data, $filename);
        }
    }

    /**
     * Get report data for export
     */
    private function getReportData($type)
    {
        switch ($type) {
            case 'user_analytics':
                return [
                    'total_users' => User::count(),
                    'active_users' => User::where('last_login_at', '>', now()->subDays(30))->count(),
                    'new_users_this_month' => User::where('created_at', '>', now()->subDays(30))->count(),
                    'top_users_by_posts' => User::withCount('posts')->orderBy('posts_count', 'desc')->take(10)->get(),
                    'top_users_by_followers' => User::withCount('followers')->orderBy('followers_count', 'desc')->take(10)->get(),
                ];
            case 'post_analytics':
                return [
                    'total_posts' => Post::count(),
                    'posts_this_week' => Post::where('created_at', '>', now()->subDays(7))->count(),
                    'posts_this_month' => Post::where('created_at', '>', now()->subDays(30))->count(),
                    'most_liked_posts' => Post::with('user')->withCount('reactions')->orderBy('reactions_count', 'desc')->take(10)->get(),
                ];
            case 'engagement':
                return [
                    'total_reactions' => \App\Models\Reaction::count(),
                    'reactions_this_week' => \App\Models\Reaction::where('created_at', '>', now()->subDays(7))->count(),
                    'follow_stats' => [
                        'total_follows' => Follow::count(),
                        'follows_this_week' => Follow::where('created_at', '>', now()->subDays(7))->count(),
                    ],
                    'message_stats' => [
                        'total_messages' => Message::count(),
                        'messages_this_week' => Message::where('created_at', '>', now()->subDays(7))->count(),
                    ],
                ];
            case 'system_health':
                return [
                    'database_stats' => [
                        'users_count' => User::count(),
                        'posts_count' => Post::count(),
                        'reactions_count' => \App\Models\Reaction::count(),
                        'follows_count' => Follow::count(),
                        'notifications_count' => Notification::count(),
                        'chats_count' => Chat::count(),
                        'messages_count' => Message::count(),
                    ],
                    'orphaned_records' => [
                        'posts_without_users' => Post::whereDoesntHave('user')->count(),
                        'notifications_without_users' => Notification::whereDoesntHave('user')->count(),
                        'follows_without_users' => Follow::whereDoesntHave('follower')->orWhereDoesntHave('following')->count(),
                    ],
                ];
        }
    }

    /**
     * Export data as CSV
     */
    private function exportAsCsv($data, $filename)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}.csv\"",
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            foreach ($data as $key => $value) {
                if (is_array($value) || is_object($value)) {
                    fprintf($file, "# %s\n", strtoupper(str_replace('_', ' ', $key)));
                    if (is_object($value) && method_exists($value, 'toArray')) {
                        $value = $value->toArray();
                    }
                    if (is_array($value) && count($value) > 0) {
                        fputcsv($file, array_keys($value[0]));
                        foreach ($value as $record) {
                            fputcsv($file, $record);
                        }
                    }
                    fprintf($file, "\n");
                } else {
                    fputcsv($file, [$key, $value]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export data as JSON
     */
    private function exportAsJson($data, $filename)
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Content-Disposition' => "attachment; filename=\"{$filename}.json\"",
        ];

        return response()->json($data, 200, $headers);
    }

    /**
     * Export data as PDF (placeholder - would need additional PDF library)
     */
    private function exportAsPdf($data, $filename)
    {
        // This would require a PDF library like TCPDF, DomPDF, etc.
        // For now, return JSON as fallback
        return $this->exportAsJson($data, $filename);
    }
}
