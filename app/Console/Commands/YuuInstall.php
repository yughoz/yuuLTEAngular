<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class YuuInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'YuuInstall:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'YuuLTE Install';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $this->info('Replace Custom menus');
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
}
