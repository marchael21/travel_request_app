<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('name');
            $table->text('description')->nullable()->default(null);
            $table->timestamps();
        });

        $data = array(
            array(
                'code'          => 'ADMIN',
                'name'          => 'Administrator', 
                'description'   => 'Administrator/Dispatcher',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ),
            array(
                'code'          => 'DIR',
                'name'          => 'Director', 
                'description'   => 'Director/Approver',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ),
            array(
                'code'          => 'EMP',
                'name'          => 'Employee', 
                'description'   => 'Employee',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ),
            array(
                'code'          => 'DRV',
                'name'          => 'Driver', 
                'description'   => 'Driver',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ),
            // array(
            //     'code'          => 'U',
            //     'name'          => 'User', 
            //     'description'   => 'User',
            //     'client'        => 1,
            //     'client_parent' => 0,
            //     'created_at'    => date('Y-m-d H:i:s'),
            //     'updated_at'    => date('Y-m-d H:i:s'),
            // ),
        );

        DB::table('roles')->insert($data);    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
