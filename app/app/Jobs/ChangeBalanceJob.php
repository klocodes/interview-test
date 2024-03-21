<?php

namespace App\Jobs;

use App\Features\Balance\Change;
use App\Features\Balance\Dto\ChangeData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ChangeBalanceJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public ChangeData $changeData;

    /**
     * Create a new job instance.
     */
    public function __construct(ChangeData $changeData)
    {
        $this->changeData = $changeData;
    }


    /**
     * Execute the job.
     */
    public function handle(Change $change): void
    {
        $change($this->changeData);
    }
}
