<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Stock;
use Illuminate\Console\Command;
use App\Lib\AlphaVantage\Database;

class UpdateStockMonthly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Updates 1 stock's monthly price that needs updating";

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
        $stocks = $this->stock->with(['month' => function ($q) {
            $q->orderBy('date', 'DESC');
        }])->get();

        $stock = $stocks->sortBy(function($i) {
            return $i->month ? $i->month->date->timestamp : 0;
        })->first();

        if ($stock === null) {
            $this->info("No stock $symbol found");
            return;
        }

        if ($stock->month &&
            $stock->month->date->toDateString() == Carbon::now()->toDateString()) {
            $this->info("Stock $stock->symbol up to date");
            return;
        }

        $this->info("Updating $stock->symbol");

        $this->database->updateMonthly($stock);

        $this->info("Updated $stock->symbol months");
    }
}
