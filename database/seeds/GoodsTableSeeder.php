<?php
/**
 * Created by PhpStorm.
 * User: cemeh666
 * Date: 09.12.17
 * Time: 10:54
 */

use Illuminate\Database\Seeder;

class GoodsTableSeeder extends Seeder
{
    /**
     * Заполнение товаров
     */
    public function run(){

        DB::table('goods')->truncate();
        DB::table('category_goods')->truncate();

        $goods = [
            [
                'goods_title' => 'Газель',
                'goods_description' => 'маневренный автомобиль, предназначенный для грузопассажирских перевозок',
                'categories' => [1, 4]
            ],
            [
                'goods_title' => 'HYUNDAI HD 65',
                'goods_description' => 'Грузовой фургон Hyundai HD 65. Год выпуска 2010',
                'categories' => [1, 4]
            ],
            [
                'goods_title' => 'Lifan Solano',
                'goods_description' => 'Авто в отличном состоянии. Год выпуска 2014. Продажа и начало эксплуатации 2015.',
                'categories' => [1]
            ],
            [
                'goods_title' => 'BMW X5',
                'goods_description' => 'Кроссовер, 2011 г.в., пробег: 162000 км., автомат, 2.98 л',
                'categories' => [1]
            ],
            [
                'goods_title' => 'Лодка надувная из ПВХ СТРЕЛКА',
                'goods_description' => 'Лодка надувная из ПВХ СТРЕЛКА',
                'categories' => [2]
            ],
            [
                'goods_title' => 'Яхта',
                'goods_description' => 'Первоначально лёгкое, быстрое судно для перевозки отдельных персон, оборудованное палубой и каютой (каютами)',
                'categories' => [2]
            ],

            [
                'goods_title' => 'Катер',
                'goods_description' => 'Небольшие суда или небольшие военных кораблей (пассажирские, грузовые, спасательные, туристические, ракетные, сторожевые и др.)',
                'categories' => [2]
            ],

            [
                'goods_title' => 'Airbus A380',
                'goods_description' => 'Широкофюзеляжный двухпалубный четырёхдвигательный реактивный пассажирский самолёт',
                'categories' => [3]
            ],

            [
                'goods_title' => 'Ту-204',
                'goods_description' => 'Самолёт Ту-204 был разработан конструкторским бюро имени Туполева для замены самолётов Ту-154',
                'categories' => [3]
            ],

            [
                'goods_title' => 'МиГ-35',
                'goods_description' => 'МиГ-35 - российский многофункциональный истребитель поколения «4++».',
                'categories' => [3, 5]
            ],

            [
                'goods_title' => 'Ту-160 Белый лебедь',
                'goods_description' => 'Ту-160 — сверхзвуковой стратегический бомбардировщик-ракетоносец с крылом изменяемой стреловидности',
                'categories' => [3, 5]
            ],

        ];

        foreach ($goods as $item){
            $good = \App\Goods::create([
                'goods_title'       => $item['goods_title'],
                'goods_description' => $item['goods_description'],
            ]);
            $good->category()->attach($item['categories']);
        }
    }
}