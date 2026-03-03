<?php

namespace App\Http\Controllers\log;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogController extends Controller
{
    public function indexRequests()
    {
        $this->authorize('accesssetting', ['view']);
        $date = now()->toDateString();
        $logFilePath = storage_path('logs/requests/daily_requests-' . $date . '.log');
        $logs = [];

        if (File::exists($logFilePath)) {
            $fileContent = File::get($logFilePath);
            preg_match_all('/\{.*\}/', $fileContent, $matches); // Extract JSON parts from log

            foreach ($matches[0] as $logEntry) {
                $data = json_decode($logEntry, true);

                if ($data) {
                    $logs[] = [
                        'username' => $data['user'], // Subject (e.g., user performing the action)
                        'action_type' => $data['method'], // HTTP Method (POST, GET, etc.)
                        'action' => $data['action'], // Controller and method
                        'date' => now()->toDateTimeString(), // Current date-time
                    ];
                }
            }
        }

        return view('log.requests_logs', data: compact('logs'));
    }

    public function indexErrors()
    {
        $this->authorize('accesssetting', ['view']);
        $date = '2024-10-11'; // Example parameter, replace with dynamic input if needed
        $logFilePath = storage_path('logs/errors/daily_errors-' . $date . '.log'); // Adjust path for error log
        $logs = [];

        if (File::exists($logFilePath)) {
            $fileContent = File::get($logFilePath);

            // Match error logs, assuming the standard Laravel error log format
            preg_match_all('/\[(.*?)\] local\.ERROR: (.*?) \{(.*?)\}/', $fileContent, $matches, PREG_SET_ORDER);

            foreach ($matches as $match) {
                $timestamp = $match[1]; // Date and time of the error
                $message = $match[2];  // The main error message
                $context = json_decode('{' . $match[3] . '}', true); // Error context as JSON

                $logs[] = [
                    'date' => $timestamp,
                    'message' => $message,
                    'exception_type' => $context['exception_type'] ?? 'N/A',
                    'exception_file' => $context['exception_file'] ?? 'N/A',
                    'exception_line' => $context['exception_line'] ?? 'N/A',
                    'environment' => $context['environment'] ?? 'N/A',
                ];
            }
        }

        return view('log.error_logs', compact('logs'));
    }

    public function deleteRequestsLogs(Request $request)
    {
        $this->authorize('accesssetting', ['delete']);
        $logDir = storage_path('logs/requests'); // Directory containing error logs
        if (File::exists($logDir)) {
            $files = File::files($logDir);
            foreach ($files as $file) {
                File::delete($file->getPathname());
            }
            return redirect()->back()->with('success', 'All requests logs deleted successfully.');
        }
        return redirect()->back()->with('error', 'Error requests directory not found.');
    }

    public function deleteErrorsLogs(Request $request)
    {
        $this->authorize('accesssetting', ['delete']);
        $logDir = storage_path('logs/errors'); // Directory containing error logs
        if (File::exists($logDir)) {
            $files = File::files($logDir);
            foreach ($files as $file) {
                File::delete($file->getPathname());
            }
            return redirect()->back()->with('success', 'All error logs deleted successfully.');
        }
        return redirect()->back()->with('error', 'Error logs directory not found.');
    }

    public function getMonthlyLogsRequests(Request $request)
    {
        $this->authorize('accesssetting', ['view']);
        $month = $request->input('month', now()->format('Y-m'));
        $logDir = storage_path('logs/requests'); // Directory where logs are stored
        $logs = [];

        if (File::exists($logDir)) {
            // Get all log files in the directory
            $files = File::files($logDir);

            foreach ($files as $file) {
                // Extract the file name (e.g., daily_law-2024-10-01.log)
                $fileName = $file->getFilename();

                // Check if the file name matches the given month
                if (str_contains($fileName, $month)) {
                    // Read the content of the log file
                    $fileContent = File::get($file->getPathname());

                    // Extract log entries using regex (assumes logs follow a structured format)
                    preg_match_all('/\{.*\}/', $fileContent, $matches); // Adjust regex for your format

                    foreach ($matches[0] as $logEntry) {
                        $data = json_decode($logEntry, true);

                        if ($data) {
                            $logs[] = [
                                'username' => $data['user'], // Subject (e.g., user performing the action)
                                'action_type' => $data['method'], // HTTP Method (POST, GET, etc.)
                                'action' => $data['action'], // Controller and method
                                'date' => now()->toDateTimeString(), // Current date-time
                            ];
                        }
                    }
                }
            }
        }

        return view('log.requests_logs', compact('logs'));
    }

    public function getMonthlyLogsErrors(Request $request)
    {
        $this->authorize('accesssetting', ['view']);
        $month = $request->input('month', now()->format('Y-m'));
        $logDir = storage_path('logs/errors'); // Directory where error logs are stored
        $logs = [];

        if (File::exists($logDir)) {
            // Get all log files in the directory
            $files = File::files($logDir);

            foreach ($files as $file) {
                // Extract the file name (e.g., laravel-2024-10-01.log)
                $fileName = $file->getFilename();

                // Check if the file name matches the given month
                if (str_contains($fileName, $month)) {
                    // Read the content of the log file
                    $fileContent = File::get($file->getPathname());

                    // Extract error log entries using regex (assuming standard Laravel log format)
                    preg_match_all('/\[(.*?)\] local\.ERROR: (.*?) \{(.*?)\}/', $fileContent, $matches, PREG_SET_ORDER);

                    foreach ($matches as $match) {
                        $timestamp = $match[1]; // Date and time of the error
                        $message = $match[2];  // The main error message
                        $context = json_decode('{' . $match[3] . '}', true); // Error context as JSON

                        $logs[] = [
                            'date' => $timestamp,
                            'message' => $message,
                            'exception_type' => $context['exception_type'] ?? 'N/A',
                            'exception_file' => $context['exception_file'] ?? 'N/A',
                            'exception_line' => $context['exception_line'] ?? 'N/A',
                            'environment' => $context['environment'] ?? 'N/A',
                        ];
                    }
                }
            }
        }
        return view('log.error_logs', compact('logs'));
    }

    public function indexRequestsAll()
    {
        $this->authorize('accesssetting', ['view']);
        $logDir = storage_path('logs/requests'); // Directory for request logs
        $logs = [];

        if (File::exists($logDir)) {
            // Get all log files in the directory
            $files = File::files($logDir);

            foreach ($files as $file) {
                // Read the content of each log file
                $fileContent = File::get($file->getPathname());

                // Extract log entries assuming they are JSON formatted
                preg_match_all('/\{.*\}/', $fileContent, $matches);

                foreach ($matches[0] as $logEntry) {
                    $data = json_decode($logEntry, true);

                    if ($data) {
                        $logs[] = [
                            'username' => $data['user'], // Subject (e.g., user performing the action)
                            'action_type' => $data['method'], // HTTP Method (POST, GET, etc.)
                            'action' => $data['action'], // Controller and method
                            'date' => now()->toDateTimeString(), // Current date-time
                        ];
                    }
                }
            }
        }

        return view('log.requests_logs', data: compact('logs'));
    }

    public function indexErrorsAll()
    {
        $this->authorize('accesssetting', ['view']);
        $logDir = storage_path('logs/errors'); // Directory for error logs
        $logs = [];

        if (File::exists($logDir)) {
            // Get all log files in the directory
            $files = File::files($logDir);

            foreach ($files as $file) {
                // Read the content of each log file
                $fileContent = File::get($file->getPathname());

                // Extract error log entries using regex
                preg_match_all('/\[(.*?)\] local\.ERROR: (.*?) \{(.*?)\}/', $fileContent, $matches, PREG_SET_ORDER);

                foreach ($matches as $match) {
                    $timestamp = $match[1];
                    $message = $match[2];
                    $context = json_decode('{' . $match[3] . '}', true);

                    $logs[] = [
                        'date' => $timestamp,
                        'message' => $message,
                        'exception_type' => $context['exception_type'] ?? 'N/A',
                        'exception_file' => $context['exception_file'] ?? 'N/A',
                        'exception_line' => $context['exception_line'] ?? 'N/A',
                        'environment' => $context['environment'] ?? 'N/A',
                    ];
                }
            }
        }

        return view('log.error_logs', compact('logs'));
    }
}
