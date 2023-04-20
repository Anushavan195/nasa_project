<?php

namespace App\Console\Commands;

use App\Http\ApiClient\ApiConnector;
use Illuminate\Console\Command;

class SaveDataFromApiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:save-data-from-api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get data from the API and store it in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $message = (new ApiConnector())->checkAndSaveData();

        $this->info($message);
    }
}
