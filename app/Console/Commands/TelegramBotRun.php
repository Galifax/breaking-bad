<?php

namespace App\Console\Commands;

use App\Services\TelegramBotService;
use Illuminate\Console\Command;

class TelegramBotRun extends Command
{
    protected $signature = 'telegram:bot:run';

    protected $description = 'Start telegram bot server';

    protected TelegramBotService $telegramBotService;

    public function __construct(TelegramBotService $telegramBotService)
    {
        $this->telegramBotService = $telegramBotService;
        parent::__construct();
    }

    public function handle(): int
    {
        $this->telegramBotService->boot();

        $this->comment('Telegram bot started');

        $this->telegramBotService->polling();

        return 0;
    }
}
