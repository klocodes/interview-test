<?php

declare(strict_types=1);

namespace App\Features\Operations;

use App\Features\Operations\Dto\PresentationData;
use App\Models\Operation;
use Exception;

class FetchOperationsHistory
{
    const DEFAULT_LIMIT = 5;

    /**
     * @throws Exception
     */
    public function __invoke(int $user_id, array $params): array
    {
        $operations = collect();

        $countQuery = Operation::query()
            ->selectRaw('count(id) as count');

        $query = Operation::query()
            ->select('type', 'amount', 'description', 'created_at')
            ->where('user_id', $user_id);

        $sortFields = ['type', 'amount', 'description', 'created_at'];
        $sortDirections = ['asc', 'desc'];

        if (!isset($params['sort_field']) || !in_array($params['sort_field'], $sortFields)) {
            $params['sort_field'] = 'created_at';
        }

        if (!isset($params['sort_direction']) || !in_array($params['sort_direction'], $sortDirections)) {
            $params['sort_direction'] = 'desc';
        }

        if (!isset($params['page']) || $params['page'] < 1) {
            $params['page'] = 1;
        }

        if (!empty($params['search_string'])) {
            $query = $query->where('description', 'like', '%' . $params['search_string'] . '%');
            $countQuery = $countQuery->where('description', 'like', '%' . $params['search_string'] . '%');
        }

        $operationsCount = $countQuery->first()->count;

        $limit = $params['limit'] ?? self::DEFAULT_LIMIT;

        $rows = $query->orderBy($params['sort_field'], $params['sort_direction'])
            ->limit($limit)
            ->offset($limit * ($params['page'] - 1))
            ->get();


        foreach ($rows as $row) {
            $operations->push(new PresentationData(
                OperationType::from($row->type),
                (float)$row->amount,
                $row->description,
                $row->created_at->format('d.m.Y H:i')
            ));
        }

        return [$operationsCount, $operations];
    }
}
