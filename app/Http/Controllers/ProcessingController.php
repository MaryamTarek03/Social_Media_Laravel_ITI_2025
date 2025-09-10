<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use App\Models\User;

class ProcessingController extends Controller
{
    /**
     * Display the main Processing module options page
     */
    public function index()
    {
        return view('modules.processing.index');
    }

    /**
     * Display data import options
     */
    public function import()
    {
        return view('modules.processing.import');
    }

    /**
     * Handle data import
     */
    public function importData(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,json|max:10240', // 10MB max
            'type' => 'required|in:users,posts,follows',
        ]);

        $file = $request->file('file');
        $type = $request->type;

        // Store the file temporarily
        $path = $file->store('temp-imports');

        // Process the file based on type
        try {
            $result = $this->processImportFile($path, $type);

            // Clean up temp file
            Storage::delete($path);

            return redirect()->route('processing.import')->with('success', "Import completed! {$result['processed']} records processed, {$result['errors']} errors.");
        } catch (\Exception $e) {
            // Clean up temp file on error
            Storage::delete($path);

            return redirect()->route('processing.import')->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    /**
     * Display data export options
     */
    public function export()
    {
        return view('modules.processing.export');
    }

    /**
     * Handle data export
     */
    public function exportData(Request $request)
    {
        $request->validate([
            'type' => 'required|in:users,posts,follows,all',
            'format' => 'required|in:csv,json',
        ]);

        $type = $request->type;
        $format = $request->format;

        try {
            $data = $this->prepareExportData($type);
            $filename = "export_{$type}_" . date('Y-m-d_H-i-s') . ".{$format}";

            if ($format === 'csv') {
                return $this->exportAsCsv($data, $filename);
            } else {
                return $this->exportAsJson($data, $filename);
            }
        } catch (\Exception $e) {
            return redirect()->route('processing.export')->with('error', 'Export failed: ' . $e->getMessage());
        }
    }

    /**
     * Display cleanup options
     */
    public function cleanup()
    {
        return view('modules.processing.cleanup');
    }

    /**
     * Handle data cleanup
     */
    public function performCleanup(Request $request)
    {
        $request->validate([
            'action' => 'required|in:orphaned_posts,inactive_users,old_notifications',
        ]);

        $action = $request->action;
        $count = 0;

        try {
            switch ($action) {
                case 'orphaned_posts':
                    $count = Post::whereDoesntHave('user')->delete();
                    break;
                case 'inactive_users':
                    $count = User::where('last_login_at', '<', now()->subMonths(6))->delete();
                    break;
                case 'old_notifications':
                    $count = \App\Models\Notification::where('created_at', '<', now()->subDays(30))->delete();
                    break;
            }

            return redirect()->route('processing.cleanup')->with('success', "Cleanup completed! {$count} records removed.");
        } catch (\Exception $e) {
            return redirect()->route('processing.cleanup')->with('error', 'Cleanup failed: ' . $e->getMessage());
        }
    }

    /**
     * Process import file based on type
     */
    private function processImportFile($path, $type)
    {
        $content = Storage::get($path);
        $processed = 0;
        $errors = 0;

        // Basic CSV processing (simplified)
        if (pathinfo($path, PATHINFO_EXTENSION) === 'csv') {
            $lines = explode("\n", trim($content));
            $headers = str_getcsv(array_shift($lines));

            foreach ($lines as $line) {
                if (empty(trim($line))) continue;

                try {
                    $data = array_combine($headers, str_getcsv($line));
                    $this->importRecord($data, $type);
                    $processed++;
                } catch (\Exception $e) {
                    $errors++;
                }
            }
        }

        return ['processed' => $processed, 'errors' => $errors];
    }

    /**
     * Import a single record
     */
    private function importRecord($data, $type)
    {
        switch ($type) {
            case 'users':
                User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'username' => $data['username'] ?? null,
                    'password' => bcrypt($data['password'] ?? 'password'),
                ]);
                break;
            case 'posts':
                Post::create([
                    'user_id' => $data['user_id'],
                    'content' => $data['content'],
                ]);
                break;
        }
    }

    /**
     * Prepare data for export
     */
    private function prepareExportData($type)
    {
        switch ($type) {
            case 'users':
                return User::all();
            case 'posts':
                return Post::with('user')->get();
            case 'follows':
                return \App\Models\Follow::with(['follower', 'following'])->get();
            case 'all':
                return [
                    'users' => User::all(),
                    'posts' => Post::with('user')->get(),
                    'follows' => \App\Models\Follow::with(['follower', 'following'])->get(),
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
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($data, $filename) {
            $file = fopen('php://output', 'w');

            if (is_array($data) && isset($data['users'])) {
                // Export all data
                foreach ($data as $type => $records) {
                    fprintf($file, "# %s\n", strtoupper($type));
                    if ($records->count() > 0) {
                        fputcsv($file, array_keys($records->first()->toArray()));
                        foreach ($records as $record) {
                            fputcsv($file, $record->toArray());
                        }
                    }
                    fprintf($file, "\n");
                }
            } else {
                // Export single type
                if ($data->count() > 0) {
                    fputcsv($file, array_keys($data->first()->toArray()));
                    foreach ($data as $record) {
                        fputcsv($file, $record->toArray());
                    }
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
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return response()->json($data, 200, $headers);
    }
}
