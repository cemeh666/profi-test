<?php

namespace Tests\Feature;

use App\Category;
use App\Goods;
use App\User;
use Tests\TestCase;

class GoodsTest extends TestCase
{
    public function testGetGoods(){
        $this->json('GET', "api/goods")
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    '*' => [
                        'id',
                        'goods_title',
                        'goods_description',
                        'created_at',
                        'updated_at',
                        'category'=>[
                            '*' => [
                                'category_name',
                                'id',
                                'created_at',
                                'updated_at'
                            ]
                        ]
                    ],
                ]
            ]);
    }

    public function testGetCategoryGoods()
    {
        $category = Category::create_category(['category_name' => 'New Category']);
        $goods1 = Goods::create_goods(['goods_title' => 'Goods1', 'goods_description' => 'Description goods1', 'categories' => [$category->id]]);
        $goods2 = Goods::create_goods(['goods_title' => 'Goods2', 'goods_description' => 'Description goods2', 'categories' => [$category->id]]);
        $this->json('GET', "api/category/{$category->id}/goods")
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    '*' => ['id', 'goods_title', 'goods_description', 'created_at', 'updated_at'],
                ]
            ])->assertJson([
                'status'  => "Ok",
                'data' => [
                    [
                        'id'                => $goods1->id,
                        'goods_title'       => $goods1->goods_title,
                        'goods_description' => $goods1->goods_description,
                        'created_at'        => $goods1->created_at,
                        'updated_at'        => $goods1->updated_at,
                        'pivot' => [
                            'category_id' => $category->id,
                            'goods_id' => $goods1->id,
                        ]
                    ],
                    [
                        'id'                => $goods2->id,
                        'goods_title'       => $goods2->goods_title,
                        'goods_description' => $goods2->goods_description,
                        'created_at'        => $goods2->created_at,
                        'updated_at'        => $goods2->updated_at,
                        'pivot' => [
                            'category_id' => $category->id,
                            'goods_id'    => $goods2->id,
                        ]
                    ],
                ]
            ]);
    }

    public function testCreateGoodsSuccess()
    {
        $user    = User::first();
        $token   = $user->generateToken();
        $headers = ['Authorization' => "$token"];
        $category1 = Category::create_category(['category_name' => 'New Category1']);
        $category2 = Category::create_category(['category_name' => 'New Category2']);
        $payload = ['goods_title' => 'Goods1', 'goods_description' => 'Description goods1', 'categories' => [$category1->id, $category2->id]];
        //создание товара в двух категориях
        $this->json('POST', 'api/goods', $payload, $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id', 'goods_title', 'goods_description', 'created_at', 'updated_at',
                ]
            ])->assertJson([
                'status'  => "Ok",
                'data' => [
                    'goods_title'       => $payload['goods_title'],
                    'goods_description' => $payload['goods_description'],
                ]
            ]);
        //проверка на наличие товара в первой категории
        $this->json('GET', "api/category/{$category1->id}/goods")
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data'  => [
                    '*' => ['id', 'goods_title', 'goods_description', 'created_at', 'updated_at'],
                ]
            ])->assertJson([
                'status'  => "Ok",
                'data' => [
                    [
                        'goods_title'       => $payload['goods_title'],
                        'goods_description' => $payload['goods_description'],
                    ]
                ]
            ]);
        //проверка на наличие товара во второй категории
        $this->json('GET', "api/category/{$category2->id}/goods")
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data'  => [
                    '*' => ['id', 'goods_title', 'goods_description', 'created_at', 'updated_at'],
                ]
            ])->assertJson([
                'status'  => "Ok",
                'data' => [
                    [
                        'goods_title'       => $payload['goods_title'],
                        'goods_description' => $payload['goods_description'],
                    ]
                ]
            ]);
    }

    public function testCreateGoodsFailedNoToken()
    {
        $category = Category::create_category(['category_name' => 'New Category']);
        $payload = ['goods_title' => 'Goods1', 'goods_description' => 'Description goods1', 'categories' => [$category->id]];

        $this->json('POST', 'api/goods', $payload)
            ->assertStatus(401)
            ->assertJson([
                'status'  => "Error",
                'message' => "Вы не авторизованы"
            ]);
    }

    public function testCreateGoodsFailedNoInputs()
    {
        $user     = User::first();
        $token    = $user->generateToken();
        $headers  = ['Authorization' => "$token"];
        $category = Category::create_category(['category_name' => 'New Category']);
        $payload_no_title       = ['goods_title' => '', 'goods_description' => 'Description goods', 'categories' => [$category->id]];
        $payload_no_description = ['goods_title' => 'Goods', 'goods_description' => '', 'categories' => [$category->id]];
        $payload_no_category    = ['goods_title' => 'Goods', 'goods_description' => 'Description goods'];

        $this->json('POST', 'api/goods', [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message'  => [
                    'goods_title',
                    'goods_description',
                    'categories',
                ]
            ])->assertJson([
                'status'  => "Error",
                'message' => [
                    'goods_title'       => ['Нужно ввести название Товара'],
                    'goods_description' => ['Нужно ввести описание Товара'],
                    'categories'        => ['Выберите одну или несколько категорий'],
                ]
            ]);

        $this->json('POST', 'api/goods', $payload_no_title, $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message'  => [
                    'goods_title',
                ]
            ])->assertJson([
                'status'  => "Error",
                'message' => [
                    'goods_title' => ['Нужно ввести название Товара'],
                ]
            ]);

        $this->json('POST', 'api/goods', $payload_no_description, $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message'  => [
                    'goods_description',
                ]
            ])->assertJson([
                'status'  => "Error",
                'message' => [
                    'goods_description' => ['Нужно ввести описание Товара'],
                ]
            ]);

        $this->json('POST', 'api/goods', $payload_no_category, $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message'  => [
                    'categories',
                ]
            ])->assertJson([
                'status'  => "Error",
                'message' => [
                    'categories' => ['Выберите одну или несколько категорий'],
                ]
            ]);
    }

    public function testEditGoods(){
        $user     = User::first();
        $token    = $user->generateToken();
        $headers  = ['Authorization' => "$token"];
        $category = Category::create_category(['category_name' => 'New Category']);
        $goods    = Goods::create_goods(['goods_title' => 'Goods', 'goods_description' => 'Description goods', 'categories' => [$category->id]]);

        $payload  = ['goods_title' => 'Goods Edit', 'goods_description' => 'Description goods', 'categories' => [$category->id]];
        //Успешное изменение
        $this->json('PUT', 'api/goods/'.$goods->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data'  => [
                    'id', 'goods_title', 'goods_description', 'updated_at', 'created_at',
                ]
            ])->assertJson([
                'status'  => "Ok",
                'data' => [
                    'id'          => $goods->id,
                    'goods_title' => $payload['goods_title'],
                ]
            ]);
        unset($payload['goods_description']);
        //Неудачное изменение
        $this->json('PUT', 'api/goods/'.$goods->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message'
            ])->assertJson([
                'status'  => "Error",
                'message' => [
                    'goods_description' => ["Нужно ввести описание Товара"]
                ]
            ]);
    }

    public function testDeleteGoods(){
        $user     = User::first();
        $token    = $user->generateToken();
        $headers  = ['Authorization' => "$token"];
        $category = Category::create_category(['category_name' => 'New Category']);
        $goods    = Goods::create_goods(['goods_title' => 'Goods', 'goods_description' => 'Description goods', 'categories' => [$category->id]]);

        $this->json('DELETE', 'api/goods/'.$goods->id, [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data'
            ])->assertJson([
                'status'  => "Ok",
                'message' => "Удаление прошло успешно",
                'data'    => []
            ]);

        $this->json('DELETE', 'api/goods/'.$goods->id, [], $headers)
            ->assertStatus(404)
            ->assertJsonStructure([
                'status',
                'message'
            ])->assertJson([
                'status'  => "Error",
                'message' => "Нет результата по запросу к моделе [App\\Goods] {$goods->id}"
            ]);
        //проверка удалился ли товар
        $this->json('GET', "api/category/{$category->id}/goods")
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    '*' => ['id', 'goods_title', 'goods_description', 'created_at', 'updated_at'],
                ]
            ])->assertJson([
                'status'  => "Ok",
                'data' => []
            ]);
    }
}
