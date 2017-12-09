<?php

/**
 * Created by PhpStorm.
 * User: cemeh666
 * Date: 09.12.17
 * Time: 10:26
 */
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Создание тестовых пользователей
     */
    public function run(){

        DB::table('users')->truncate();

        foreach (range(1, 3) as $item){
            \App\User::create([
                'name' => "test-user$item",
                'email' => "test-user$item@test.test",
                'password' => bcrypt("test-user$item@test.test"),
            ]);
        }
    }

}