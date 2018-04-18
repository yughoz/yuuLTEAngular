<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('last_login')->default(time());
            $table->tinyInteger('active')->default(0);
            $table->string('phone',20)->default("");
            $table->string('sex',1)->default("");
            $table->integer('group_id')->default(0);
        });
 

        DB::table('users')->insert(
            [
                'name' => 'administrator',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password'),
                'group_id' => 1,
                'active' => 1,
            ]
        );

        Schema::dropIfExists('users_groups');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
