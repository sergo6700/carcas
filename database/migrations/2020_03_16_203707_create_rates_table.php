<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('room_type_id')->unsigned();
            $table->foreign('room_type_id')
                ->references('id')->on('room_types')
                ->onDelete('cascade');

            $table->date('date');

            $table->decimal('amount');

            $table->smallInteger('availability')->nullable();
            $table->smallInteger('min_stay')->nullable();
            $table->smallInteger('max_stay')->nullable();
            $table->smallInteger('cut_off')->nullable();

            $table->tinyInteger('cta')->default(\ConstGeneralStatuses::NO);
            $table->tinyInteger('ctd')->default(\ConstGeneralStatuses::NO);
            $table->tinyInteger('stop_sell')->default(\ConstGeneralStatuses::NO);

            $table->unique(['date', 'room_type_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rates');
    }
}
