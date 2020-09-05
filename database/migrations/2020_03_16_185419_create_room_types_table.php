<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_types', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->index();

            $table->smallInteger('quantity')->nullable();
            $table->smallInteger('adults')->nullable();
            $table->smallInteger('children')->nullable();
            $table->smallInteger('bathrooms')->nullable();
            $table->smallInteger('cfnd')->nullable();
            $table->smallInteger('infants')->nullable();

            $table->tinyInteger('breakfast')->default(\ConstGeneralStatuses::NO);
            $table->tinyInteger('refundable')->default(\ConstGeneralStatuses::NO);

            $table->decimal('min_price')->nullable();

            $table->smallInteger('min_stay')->nullable();
            $table->smallInteger('max_stay')->nullable();

            $table->tinyInteger('is_child')->default(\ConstGeneralStatuses::NO);
            $table->tinyInteger('is_parent')->default(\ConstGeneralStatuses::NO);

            $table->string('octorate_room_type_id')->nullable();

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
        Schema::dropIfExists('room_types');
    }
}
