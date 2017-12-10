<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testRequiresEmailAndLogin()
    {
        $this->json('POST', 'api/auth')
            ->assertStatus(200)
            ->assertJson([
                'status'  => "Error",
                'message' => [
                    'email'    => ['Обязательное поле для заполнения'],
                    'password' => ['Обязательное поле для заполнения'],
                ]
            ]);
    }

    public function testUserLoginSuccessfully()
    {
        factory(User::class)->create([
            'email'     => 'test-user1@test.test',
            'password'  => 'test-user1@test.test',
        ]);

        $payload = ['email' => 'test-user1@test.test', 'password' => 'test-user1@test.test'];
        $this->json('POST', 'api/auth', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                    'api_token',
                ],
            ]);

    }

    public function testUserLogout(){

        $this->json('POST', 'api/api_logout')
            ->assertStatus(401)
            ->assertJson([
                'status'  => "Error",
                'message' => "Вы не авторизованы"
            ]);

        $user = factory(User::class)->create([
            'email'     => 'test-user1@test.test',
            'password'  => 'test-user1@test.test',
        ]);
        $headers = ['Authorization' => "$user->api_token"];
        $this->json('POST', 'api/api_logout', [], $headers)
            ->assertStatus(200)
            ->assertJson([
                'status' => 'Ok',
                'data' => [
                    'user' => 'Вы успешно вышли'
                ],
            ]);
    }

}
