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

        \App\User::create([
            'name' => "test-user",
            'email' => "test-user@test.test",
            'password' => "test-user@test.test"
        ]);
    }

}