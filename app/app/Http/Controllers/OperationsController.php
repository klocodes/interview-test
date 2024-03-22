<?php

namespace App\Http\Controllers;

use App\Features\Operations\FetchOperationsHistory;
use App\Features\Operations\FetchLatestOperations;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperationsController extends Controller
{
    /**
     * @throws Exception
     */
    public function latest(FetchLatestOperations $fetchLatestOperations): JsonResponse
    {
        $user_id = Auth::id();

        $operations = $fetchLatestOperations($user_id);

        return response()->json([
            'operations' => $operations->toArray(),
        ]);
    }

    /**
     * @throws Exception
     */
    public function history(Request $request, FetchOperationsHistory $fetchHistoryOperations): JsonResponse
    {
        $user_id = Auth::id();
        $params = [
            'sort_field' => $request->get('sort_field'),
            'sort_direction' => $request->get('sort_direction'),
            'page' => $request->get('page'),
            'limit' => $request->get('limit'),
            'search_string' => $request->get('search_string'),

        ];

        list($operationsCount, $operations) = $fetchHistoryOperations($user_id, $params);

        return response()->json([
            'count' => $operationsCount,
            'operations' => $operations->toArray(),
        ]);
    }
}
