<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('users')){
            DB::statement('CREATE TABLE `users` (
                 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                 `name` varchar(30)  NOT NULL,
                 `username` varchar(30)  NOT NULL,
                 brithday date NOT NULL,
                 `email` varchar(30) UNIQUE NOT NULL,
                 `password` varchar(255) NOT NULL,
                 `remember_token` varchar(100) DEFAULT NULL,
                 friends_list varchar(100) DEFAULT NULL,
                 `created_at` timestamp NULL ,
                 `updated_at` timestamp NULL,
                 PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

        }
        DB::table('users')->insert([
            'name' => 'admin admin',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'brithday' => '1985-10-07',
            'created_at'=>date('Y-m-d'),
            'password' => bcrypt('admin'),
        ]);
        for($i=0;$i<100;$i++){
            $start = strtotime("10 September 1970");
            $end = strtotime("22 July 2000");
            $date = date('Y-m-d',mt_rand($start, $end));
            DB::table('users')->insert([
                'name' => 'soltan'.$i.' bebar'.$i ,
                'email' => 'soltan'.$i.'@gmail.com',
                'username' => 'soltan'.$i,
                'brithday' => $date,
                'created_at'=>date('Y-m-d'),
                'password' => bcrypt('soltan'.$i),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
