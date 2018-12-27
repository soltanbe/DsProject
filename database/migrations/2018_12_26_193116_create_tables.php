<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('user_log')){
            DB::statement('CREATE TABLE `user_log` (
                 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                 `username` INT(11)  NOT NULL,
                 `status_login` INT(1)  NOT NULL,
                 `ip` varchar(30)  NOT NULL,
                 `last_login` timestamp NULL ,
                
                 PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

        }
        if(!Schema::hasTable('hobbies')){
            DB::statement('CREATE TABLE `hobbies` (
                 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                 `name` varchar(255)  NOT NULL,
                 PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');
            for($i=0;$i<20;$i++){
                DB::table('hobbies')->insert([
                    'name' => 'hobbies'.$i ,
                ]);
            }

        }

        if(!Schema::hasTable('user_hobbies')){
            DB::statement('CREATE TABLE `user_hobbies` (
                 `user_id` int(11) NOT NULL,
                 `hobbies` varchar(255)  NOT NULL,
                 PRIMARY KEY (`user_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');
            $hobbies=DB::select('SELECT id from hobbies');
            $hobbies_arr=array();
            foreach ($hobbies as $h){
                $hobbies_arr[]=$h->id;
            }
            $users=DB::select('SELECT * from users');
            foreach ($users as $u){
                $hobbies_of_user=array(
                    $hobbies_arr[array_rand($hobbies_arr)],
                    $hobbies_arr[array_rand($hobbies_arr)],
                    $hobbies_arr[array_rand($hobbies_arr)],
                    $hobbies_arr[array_rand($hobbies_arr)],
                    $hobbies_arr[array_rand($hobbies_arr)],
                );
                $hobbies_of_user=array_unique($hobbies_of_user);
                DB::table('user_hobbies')->insert(array(
                    'user_id'=>$u->id,
                    'hobbies'=>implode(',',$hobbies_of_user),
                ));
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
        //
    }
}
