<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDerivationRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('derivation_rules', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('room_type_id')->unsigned();
            $table->foreign('room_type_id')
                ->references('id')->on('room_types')
                ->onDelete('cascade');

            $table->bigInteger('parent_id')->unsigned();
            $table->foreign('parent_id')
                ->references('id')->on('room_types')
                ->onDelete('cascade');

            $table->decimal('amount');

            $table->smallInteger('amount_status');

            $table->tinyInteger('stop_sell')->default(\ConstGeneralStatuses::NO);
            $table->tinyInteger('availability')->default(\ConstGeneralStatuses::NO);
            $table->tinyInteger('restrictions')->default(\ConstGeneralStatuses::NO);
            $table->tinyInteger('length_of_stay')->default(\ConstGeneralStatuses::NO);
            $table->tinyInteger('is_round')->default(\ConstGeneralStatuses::NO);

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
        Schema::dropIfExists('derivation_rules');
    }
}
