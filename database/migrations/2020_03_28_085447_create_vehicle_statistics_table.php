<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_statistics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vehicle_id')->unsigned()->index();
            $table->boolean('battery')->nullable()->default(0);
            $table->boolean('lights')->nullable()->default(0);
            $table->boolean('oil')->nullable()->default(0);
            $table->boolean('water')->nullable()->default(0);
            $table->boolean('brake')->nullable()->default(0);
            $table->boolean('tire')->nullable()->default(0);
            $table->boolean('gas')->nullable()->default(0);
            $table->boolean('spare_tire')->nullable()->default(0);
            $table->boolean('tool_set')->nullable()->default(0);
            $table->boolean('ewd')->nullable()->default(0);
            $table->boolean('easytrip')->nullable()->default(0);
            $table->boolean('fleet_card')->nullable()->default(0);
            $table->text('remarks')->nullable()->default(null);
            $table->bigInteger('created_by')->nullable()->unsigned()->index()->default(null);
            $table->bigInteger('updated_by')->nullable()->unsigned()->index()->default(null);
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
        Schema::dropIfExists('vehicle_statistics');
    }
}
