<?php

namespace App\Console\Commands;

use App\Services\StatService;
use Illuminate\Console\Command;

class CalculateTotalRequest extends Command
{
    protected $signature = 'stats:calculate';

    protected $description = 'Calculate total requests';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(StatService $statService): void
    {
        $statService->calculateTotalRequest();
    }
}
