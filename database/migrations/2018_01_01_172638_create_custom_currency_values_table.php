<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomCurrencyValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if(!Schema::hasTable('custom_currency_values'))
      {
        Schema::create('custom_currency_values', function (Blueprint $table) {
          $table->increments('id')->unsigned();
          $table->string('currency_name', 100);
          $table->string('currency_code', 10);
          $table->float('currency_value', 11, 2);
          $table->timestamps();
        });
      }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('custom_currency_values');
    }
}