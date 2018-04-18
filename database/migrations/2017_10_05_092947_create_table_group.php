<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50);
            $table->string('description',100);
            $table->char('bgcolor',20);
            $table->timestamps();
        });

        DB::table('groups')->insert(
            [
                'name' => 'administrator',
                'description' => 'Administrator',
                'bgcolor' => 'blue',
            ]
        );
        DB::table('groups')->insert(
            [
                'name' => 'member',
                'description' => 'Member',
                'bgcolor' => 'red',
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
    }
}
