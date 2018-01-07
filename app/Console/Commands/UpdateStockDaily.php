<?php

namespace App\Console\Commands;

use App\Models\Stock;
use Illuminate\Console\Command;
use App\Lib\AlphaVantage\Database;

class UpdateStockDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Updates 1 stock's daily price that needs updating";

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
        \Log::info('Here');
        $stocks = $this->stock->with(['day' => function ($q) {
            $q->orderBy('date', 'DESC');
        }])->get();

        $stock = $stocks->sortBy(function($i) {
            return $i->day ? $i->day->date->timestamp : 0;
        })->first();

        if ($stock === null) {
            $this->info("No stock $symbol found");
            return;
        }

        \Log::info("$stock->symbol");
        if ($stock->day &&
            $stock->day->date->toDateString() == Carbon::now()->toDateString()) {
            $this->info("Stock $stock->symbol up to date");
            return;
        }

        $this->info("Updating $stock->symbol");

        $this->database->updateDaily($stock);

        $this->info("Updated $stock->symbol days");
    }
}
