<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('brand');
            $table->string('model');
            $table->string('year');
            $table->string('plate_number')->unique();
            $table->string('cor_number')->unique();
            $table->string('gps_sim_number')->nullable()->default(null);
            $table->string('current_location')->nullable()->default(null);
            $table->integer('status')->unsigned()->index();
            $table->bigInteger('created_by')->nullable()->unsigned()->index()->default(null);
            $table->bigInteger('updated_by')->nullable()->unsigned()->index()->default(null);
            $table->timestamps();
        });

        Schema::table('vehicles', function($table) {
           $table->foreign('status')->references('id')->on('vehicle_statuses')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
