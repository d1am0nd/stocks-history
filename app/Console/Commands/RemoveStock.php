<?php

namespace App\Console\Commands;

use App\Models\Stock;
use Illuminate\Console\Command;

class RemoveStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:stock {symbol}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'remove:stock {symbol}';

    protected $stock;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Stock $stock)
    {
        parent::__construct();
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
            $this->info("Stock $symbol not found");
            return;
        }
        $stock->delete();
        $this->info('Done');
    }
}
