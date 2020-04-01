<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('booking_id')->unsigned()->index();
            $table->integer('booking_status_id')->unsigned()->index();
            $table->text('remarks')->nullable()->default(null);
            $table->bigInteger('created_by')->nullable()->unsigned()->index()->default(null);
            $table->bigInteger('updated_by')->nullable()->unsigned()->index()->default(null);
            $table->timestamps();
        });

        Schema::table('booking_histories', function($table) {
           $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('restrict');
           $table->foreign('booking_status_id')->references('id')->on('booking_statuses')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_histories');
    }
}
