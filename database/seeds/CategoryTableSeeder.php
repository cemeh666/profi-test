<?php
/**
 * Created by PhpStorm.
 * User: cemeh666
 * Date: 09.12.17
 * Time: 10:54
 */

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Заполнение категорий
     */
    public function run(){

        DB::table('category')->truncate();

        $categories = [
          1 => 'Автомобили',
          2 => 'Лодки',
          3 => 'Самолёты',
          4 => 'Грузовые автомобили',
          5 => 'Военные самолёты',
        ];

        foreach ($categories as $item){
            \App\Category::create([
                'category_name' => $item,
            ]);
        }
    }
}