<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingDriverDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_driver_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('booking_id')->unsigned()->index();
            $table->dateTime('departure_location')->nullable()->default(null);
            $table->dateTime('arrival_destination')->nullable()->default(null);
            $table->dateTime('departure_destination')->nullable()->default(null);
            $table->dateTime('arrival_location')->nullable()->default(null);
            $table->decimal('departure_location_speedometer', 12, 2)->nullable()->default(null);
            $table->decimal('arrival_destination_speedometer', 12, 2)->nullable()->default(null);
            $table->decimal('departure_destination_speedometer', 12, 2)->nullable()->default(null);
            $table->decimal('arrival_location_speedometer', 12, 2)->nullable()->default(null);
            $table->decimal('approximate_distance_traveled', 12, 2)->nullable()->default(null);
            $table->enum('fuel_type', ['gasoline', 'diesel']);
            $table->decimal('fuel_tank_balance', 12, 2)->nullable()->default(null);    
            $table->decimal('fuel_issued_stock', 12, 2)->nullable()->default(null);
            $table->decimal('fuel_add_purchased', 12, 2)->nullable()->default(null);
            $table->decimal('fuel_total', 12, 2)->nullable()->default(null);
            $table->decimal('fuel_used', 12, 2)->nullable()->default(null);
            $table->decimal('fuel_left', 12, 2)->nullable()->default(null);
            $table->timestamps();
        });

        Schema::table('booking_driver_details', function($table) {
           $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_driver_details');
    }
}
