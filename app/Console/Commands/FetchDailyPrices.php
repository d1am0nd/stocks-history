<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Lib\AlphaVantage\Database;

class FetchDailyPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:days {symbol} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches daily prices';

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
        $name = $this->argument('name');
        $this->database->updateDaily($symbol, $name);
        $this->info('done');
    }
}
