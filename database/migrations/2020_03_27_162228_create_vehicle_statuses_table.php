<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable()->default(null);
            $table->timestamps();
        });

        $data = array(
            array(
                'name'          => 'Available', 
                'description'   => '',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ),
            array(
                'name'          => 'Not Available', 
                'description'   => '',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ),
            array(
                'name'          => 'On Trip', 
                'description'   => '',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ),     
            array(
                'name'          => 'On Maintenance', 
                'description'   => '',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ),   
        );

        DB::table('vehicle_statuses')->insert($data);
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_statuses');
    }
}
