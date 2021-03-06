<?php

namespace App\Console\Commands;

use App\Models\Stock;
use Illuminate\Console\Command;
use App\Lib\AlphaVantage\Database;

class FetchDailyPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:days {symbol}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches daily prices';

    protected $database;

    protected $stock;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Database $database, Stock $stock)
    {
        parent::__construct();
        $this->database = $database;
        $this->stock = $stock;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $symbol = $this->argument('symbol');
        $stock = $this->stock->bySymbol($symbol)->first();
        if ($stock === null) {
            $this->info("No stock $symbol found");
            return;
        }

        $this->database->updateDaily($stock);

        $this->info('done');
    }
}
