<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable()->default(null);
            $table->timestamps();
        });


        $data = array(
            array(
                'name'          => 'Pending', 
                'description'   => 'Pending Booking',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ),
            array(
                'name'          => 'Processing', 
                'description'   => 'Processed by dispatcher/admin',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ),
            array(
                'name'          => 'Approved', 
                'description'   => 'Approved Booking',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ),
            array(
                'name'          => 'Completed', 
                'description'   => 'Completed Booking',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ),
            array(
                'name'          => 'Cancelled', 
                'description'   => 'Cancelled booking',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ),     
        );

        DB::table('booking_statuses')->insert($data);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_statuses');
    }
}
