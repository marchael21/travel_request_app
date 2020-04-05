<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number',50);
            $table->text('reference_number')->nullable()->default(null);
            $table->text('destination')->nullable()->default(null);
            $table->text('purpose')->nullable()->default(null);
            $table->text('objectives')->nullable()->default(null);
            $table->string('requestor_name')->nullable()->default(null);
            $table->string('requestor_position')->nullable()->default(null);
            $table->string('requestor_official_station')->nullable()->default(null);
            $table->decimal('requestor_monthly_salary', 12, 4)->nullable()->default(null);
            $table->decimal('daily_expenses_allowed', 12, 4)->nullable()->default(null);
            $table->decimal('assistant_laborers_allowed', 12, 4)->nullable()->default(null);
            $table->decimal('appropriation_travel_charged', 12, 4)->nullable()->default(null);
            $table->text('remarks')->nullable()->default(null);
            $table->bigInteger('employee_id')->nullable()->unsigned()->index()->default(null);
            $table->integer('vehicle_id')->nullable()->unsigned()->index()->default(null);
            $table->bigInteger('driver_id')->nullable()->unsigned()->index()->default(null);
            $table->bigInteger('approved_by')->nullable()->unsigned()->index()->default(null);
            $table->bigInteger('processed_by')->nullable()->unsigned()->index()->default(null);
            $table->integer('status')->unsigned()->index();
            $table->dateTime('status_date')->nullable()->default(null);
            $table->dateTime('departure_date')->nullable()->default(null);
            $table->dateTime('return_date')->nullable()->default(null);
            $table->bigInteger('created_by')->nullable()->unsigned()->index()->default(null);
            $table->bigInteger('updated_by')->nullable()->unsigned()->index()->default(null);
            $table->timestamps();
        });

        Schema::table('bookings', function($table) {
           $table->foreign('employee_id')->references('id')->on('users')->onDelete('restrict');
           $table->foreign('driver_id')->references('id')->on('users')->onDelete('restrict');
           $table->foreign('approved_by')->references('id')->on('users')->onDelete('restrict');
           $table->foreign('processed_by')->references('id')->on('users')->onDelete('restrict');
           $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('restrict');
           $table->foreign('status')->references('id')->on('booking_statuses')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
