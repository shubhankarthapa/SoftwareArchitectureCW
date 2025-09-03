<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

class LogController extends Controller
{
    /**
     * Store a new log entry
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'application_name' => 'required|string|max:255',
            'level' => 'required|string|in:debug,info,warning,error,critical',
            'message' => 'required|string',
            'context' => 'nullable|array',
            'source' => 'nullable|string|max:255',
            'user_id' => 'nullable|string|max:255',
            'session_id' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $log = Log::create([
                'application_name' => $request->application_name,
                'level' => $request->level,
                'message' => $request->message,
                'context' => $request->context,
                'source' => $request->source,
                'user_id' => $request->user_id,
                'session_id' => $request->session_id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Log stored successfully',
                'data' => [
                    'id' => $log->id,
                    'created_at' => $log->created_at
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to store log',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Fetch logs with filtering and pagination
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Log::query();

            // Apply filters
            if ($request->has('application_name')) {
                $query->where('application_name', $request->application_name);
            }

            if ($request->has('level')) {
                $query->where('level', $request->level);
            }

            if ($request->has('user_id')) {
                $query->where('user_id', $request->user_id);
            }

            if ($request->has('source')) {
                $query->where('source', 'like', '%' . $request->source . '%');
            }

            if ($request->has('message')) {
                $query->where('message', 'like', '%' . $request->message . '%');
            }

            if ($request->has('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->has('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            // Order by created_at desc (newest first)
            $query->orderBy('created_at', 'desc');

            // Pagination
            $perPage = $request->get('per_page', 15);
            $perPage = min($perPage, 100); // Limit max per page to 100

            $logs = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $logs->items(),
                'pagination' => [
                    'current_page' => $logs->currentPage(),
                    'per_page' => $logs->perPage(),
                    'total' => $logs->total(),
                    'last_page' => $logs->lastPage(),
                    'from' => $logs->firstItem(),
                    'to' => $logs->lastItem(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch logs',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a specific log entry
     */
    public function show($id): JsonResponse
    {
        try {
            $log = Log::find($id);

            if (!$log) {
                return response()->json([
                    'success' => false,
                    'message' => 'Log not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $log
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch log',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get logs by application name
     */
    public function getByApplication(Request $request, $applicationName): JsonResponse
    {
        try {
            $query = Log::where('application_name', $applicationName);

            // Apply additional filters
            if ($request->has('level')) {
                $query->where('level', $request->level);
            }

            if ($request->has('user_id')) {
                $query->where('user_id', $request->user_id);
            }

            if ($request->has('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->has('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            $query->orderBy('created_at', 'desc');

            $perPage = $request->get('per_page', 15);
            $perPage = min($perPage, 100);

            $logs = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $logs->items(),
                'pagination' => [
                    'current_page' => $logs->currentPage(),
                    'per_page' => $logs->perPage(),
                    'total' => $logs->total(),
                    'last_page' => $logs->lastPage(),
                    'from' => $logs->firstItem(),
                    'to' => $logs->lastItem(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch logs for application',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get logs by level
     */
    public function getByLevel(Request $request, $level): JsonResponse
    {
        try {
            $query = Log::where('level', $level);

            // Apply additional filters
            if ($request->has('application_name')) {
                $query->where('application_name', $request->application_name);
            }

            if ($request->has('user_id')) {
                $query->where('user_id', $request->user_id);
            }

            if ($request->has('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->has('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            $query->orderBy('created_at', 'desc');

            $perPage = $request->get('per_page', 15);
            $perPage = min($perPage, 100);

            $logs = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $logs->items(),
                'pagination' => [
                    'current_page' => $logs->currentPage(),
                    'per_page' => $logs->perPage(),
                    'total' => $logs->total(),
                    'last_page' => $logs->lastPage(),
                    'from' => $logs->firstItem(),
                    'to' => $logs->lastItem(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch logs by level',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get logs by user ID
     */
    public function getByUser(Request $request, $userId): JsonResponse
    {
        try {
            $query = Log::where('user_id', $userId);

            // Apply additional filters
            if ($request->has('application_name')) {
                $query->where('application_name', $request->application_name);
            }

            if ($request->has('level')) {
                $query->where('level', $request->level);
            }

            if ($request->has('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->has('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            $query->orderBy('created_at', 'desc');

            $perPage = $request->get('per_page', 15);
            $perPage = min($perPage, 100);

            $logs = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $logs->items(),
                'pagination' => [
                    'current_page' => $logs->currentPage(),
                    'per_page' => $logs->perPage(),
                    'total' => $logs->total(),
                    'last_page' => $logs->lastPage(),
                    'from' => $logs->firstItem(),
                    'to' => $logs->lastItem(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch logs by user',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
