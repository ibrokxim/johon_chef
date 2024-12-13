<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class RemoveWebhookCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remove-webhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove webhook setting';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $token = env('TELEGRAM_BOT_TOKEN');

        Http::get("https://api.telegram.org/bot .$token ./setWebhook?remove");

        $this->info('Ok');
    }
}
