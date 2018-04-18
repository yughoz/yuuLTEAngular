<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGroupAccess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_access', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id');
            $table->string('module_code',25);
            $table->tinyInteger('createAcc');
            $table->tinyInteger('readAcc');
            $table->tinyInteger('updateAcc');
            $table->tinyInteger('deleteAcc');
            $table->timestamps();
        });

        $path = base_path()."/vendor/jeroennoten/laravel-adminlte/src/Menu/Filters/GateFilter.php";
        $pathReplace = base_path()."/packages/yuu/cutom-menus/src/GateFilter.php";
        if (is_file($path)) {
            if (is_file($pathReplace)) {
                copy($pathReplace, $path);
            }
        }

        $path = base_path()."/vendor/laravel/framework/src/Illuminate/Foundation/Auth/AuthenticatesUsers.php";
        $pathReplace = base_path()."/packages/yuu/cutom-menus/src/AuthenticatesUsers.php";
        if (is_file($path)) {
            if (is_file($pathReplace)) {
                copy($pathReplace, $path);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_access');
    }
}
