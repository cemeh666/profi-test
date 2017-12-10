<?php

namespace Tests\Feature;

use App\Category;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryTest extends TestCase
{
    public function testGetCategory()
    {
        $this->json('GET', 'api/categories')
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    '*' => ['id', 'category_name'],
                ]
            ]);
    }

    public function testCreateCategorySuccess()
    {
        $payload = ['category_name' => 'New Category'];
        $user    = User::first();
        $token   = $user->generateToken();
        $headers = ['Authorization' => "$token"];

        $this->json('POST', 'api/category', $payload, $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data'  => [
                    'id', 'category_name', 'updated_at', 'created_at', 'id',
                ]
            ])->assertJson([
                'status'  => "Ok",
                'data' => [
                    'category_name' => 'New Category',
                ]
            ]);
    }

    public function testCreateCategoryFailedNoToken()
    {
        $payload = ['category_name' => 'New Category'];

        $this->json('POST', 'api/category', $payload)
            ->assertStatus(401)
            ->assertJson([
                'status'  => "Error",
                'message' => "Вы не авторизованы"
            ]);
    }

    public function testCreateCategoryFailedNoInputs()
    {
        $user    = User::first();
        $token   = $user->generateToken();
        $headers = ['Authorization' => "$token"];

        $this->json('POST', 'api/category', [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message'  => [
                    'category_name',
                ]
            ])->assertJson([
                'status'  => "Error",
                'message' => [
                    'category_name' => ['Нужно ввести название категории'],
                ]
            ]);
    }

    public function testEditCategory(){
        $user     = User::first();
        $token    = $user->generateToken();
        $headers  = ['Authorization' => "$token"];
        $category = Category::create_category(['category_name' => 'New Category']);

        $payload  = [ 'category_name' => 'Edit Category'];
        //Успешное изменение
        $this->json('PUT', 'api/category/'.$category->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data'  => [
                    'id', 'category_name', 'updated_at', 'created_at', 'id',
                ]
            ])->assertJson([
                'status'  => "Ok",
                'data' => [
                    'id'            => $category->id,
                    'category_name' => 'Edit Category',
                ]
            ]);
        //Неудачное изменение
        $this->json('PUT', 'api/category/123', $payload, $headers)
            ->assertStatus(404)
            ->assertJsonStructure([
                'status',
                'message'
            ])->assertJson([
                'status'  => "Error",
                'message' => "Нет результата по запросу к моделе [App\\Category] 123"
            ]);
    }

    public function testDeleteCategory(){
        $user     = User::first();
        $token    = $user->generateToken();
        $headers  = ['Authorization' => "$token"];
        $category = Category::create_category(['category_name' => 'New Category']);

        $this->json('DELETE', 'api/category/'.$category->id, [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data'
            ])->assertJson([
                'status'  => "Ok",
                'data' => [
                    'delete' => 'Удаление прошло успешно',
                ]
            ]);
        $this->json('DELETE', 'api/category/'.$category->id, [], $headers)
            ->assertStatus(404)
            ->assertJsonStructure([
                'status',
                'message'
            ])->assertJson([
                'status'  => "Error",
                'message' => "Нет результата по запросу к моделе [App\\Category] {$category->id}"
            ]);
    }
}

