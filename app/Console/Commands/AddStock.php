<?php

namespace App\Console\Commands;

use App\Models\Stock;
use Illuminate\Console\Command;

class AddStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:stock {symbol} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add:stock {symbol} {name}';

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
        $name = $this->argument('name');

        $stock = $this->stock->bySymbol($symbol)->first();
        if ($stock === null) {
            $stock = new Stock;
            $stock->symbol = $symbol;
        }
        $stock->name = $name;
        $stock->save();
        $this->info($stock);
        $this->info('Done');
    }
}
