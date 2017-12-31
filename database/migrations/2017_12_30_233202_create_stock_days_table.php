<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_days', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stock_id')->unsigned();

            $table->date('date');
            $table->string('open');
            $table->string('high');
            $table->string('low');
            $table->string('close');
            $table->string('adjusted_close');
            $table->string('volume');
            $table->string('dividend_amount');
            $table->string('split_coefficient');

            $table->timestamps();

            $table->foreign('stock_id')
                ->references('id')
                ->on('stocks')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_days');
    }
}
