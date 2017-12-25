<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Lib\AlphaVantage\Database;

class FetchMonthlyPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:months {symbol}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches monthly prices';

    protected $database;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Database $database)
    {
        parent::__construct();
        $this->database = $database;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $symbol = $this->argument('symbol');
        $this->database->updateMonthly($symbol);
        $this->info('done');
    }
}
