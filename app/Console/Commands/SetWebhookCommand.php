<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SetWebhookCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-webhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Webhook setting';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $token = env('TELEGRAM_BOT_TOKEN');

        Http::post("https://api.telegram.org/bot .$token ./setWebhook", [
            'url' => env('TELEGRAM_WEBHOOK'),
        ]);

        $this->info('Ok');
    }
}
