<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('room_type_id')->unsigned()->nullable();
            $table->foreign('room_type_id')
                ->references('id')->on('room_types')
                ->onDelete('cascade');

            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->bigInteger('octorate_reservation_id')->unsigned()->nullable();
            $table->foreign('octorate_reservation_id')
                ->references('id')->on('octorate_reservations')
                ->onDelete('cascade');

            $table->string('res_id')->index()->nullable();

            $table->smallInteger('status');

            $table->date('start_date');

            $table->date('end_date');

            $table->decimal('amount');
            $table->decimal('city_tax')->nullable();
            $table->decimal('ota_fee')->nullable();

            $table->string('currency', 3);
            $table->string('source')->nullable();
            $table->string('arrival_time')->nullable();

            $table->smallInteger('adults')->nullable();
            $table->smallInteger('children')->nullable();
            $table->smallInteger('infants')->nullable();

            $table->tinyInteger('is_paid')->default(\ConstGeneralStatuses::NO);
            $table->tinyInteger('is_refundable')->default(\ConstGeneralStatuses::YES);
            $table->tinyInteger('is_ciaobooking')->default(\ConstGeneralStatuses::NO);

            $table->string('ccs_token')->nullable();
            $table->string('ccs_prepaid')->nullable();
            $table->string('ccs_brand')->nullable();
            $table->string('ccs_bank')->nullable();
            $table->string('ccs_scheme')->nullable();
            $table->string('ccs_type')->nullable();

            $table->date('ccs_expire_date')->nullable();

            $table->string('ccs_pan')->nullable();
            $table->string('ccs_card_holder')->nullable();

            $table->text('ota_note')->nullable();
            $table->text('internal_note')->nullable();
            $table->text('service_note')->nullable();

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
        Schema::dropIfExists('reservations');
    }
}
