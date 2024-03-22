<?php

namespace App\Features\Operations;

use App\Features\Operations\Dto\PresentationData;
use App\Models\Operation;
use Illuminate\Support\Collection;

class FetchLatestOperations
{
    const LIMIT = 5;

    /**
     * @throws \Exception
     */
    public function __invoke(int $user_id): ?Collection
    {
        $operations = collect([]);

        $rows = Operation::query()
            ->select('type', 'amount', 'description', 'created_at')
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->limit(self::LIMIT)
            ->get();


        foreach ($rows as $row) {
            $operations->push(new PresentationData(
                OperationType::from($row->type),
                $row->amount,
                $row->description,
                $row->created_at->format('d.m.Y, H:i')
            ));
        }

        return $operations;
    }
}
