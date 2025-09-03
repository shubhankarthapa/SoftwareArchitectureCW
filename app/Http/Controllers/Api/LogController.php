<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

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
}
