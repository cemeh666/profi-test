<?php
/**
 * Created by PhpStorm.
 * User: cemeh666
 * Date: 10.12.17
 * Time: 10:20
 */

namespace App;



class CategoryGoods extends \Eloquent
{
    protected $table      = 'category_goods';
    protected $guarded    = ['id'];
    protected $primaryKey = 'id';

    public function Validate()
    {
        $rules = [
            'category_id' => ['required', 'exists:category,id'],
            'goods_id'    => ['required', 'exists:goods,id'],
        ];

        $model = self::getAttributes();

        $validator = \Validator::make($model, $rules);
        if ($validator->fails()) {
            return $validator;
        }
        return true;
    }

    /**
     * Проверка и сохранение валидных связей между категориями и товарами
     * @param Goods $goods
     * @param array $attach
     */
    public static function createGoodsAttach(Goods $goods, Array $attach){

        $attach = array_unique($attach);
        foreach ($attach as $item){

            $category_goods = new CategoryGoods([
                "category_id" => $item,
                "goods_id"    => $goods->id,
            ]);

            if($category_goods->Validate() === true)
                $category_goods->save();
        }
    }

    /**
     * Удаление и создание новых связей между категориями и товарами
     * @param Goods $goods
     * @param array $attach
     */
    public static function editGoodsAttach(Goods $goods, Array $attach){

        $attach = array_unique($attach);
        $goods->category()->detach();

        foreach ($attach as $item){

            $category_goods = new CategoryGoods([
                "category_id" => $item,
                "goods_id"    => $goods->id,
            ]);

            if($category_goods->Validate() === true)
                $category_goods->save();
        }
    }

    /**
     * Удаление связей между товаром и категориями
     * @param Goods $goods
     */
    public static function deleteGoodsAttach(Goods $goods){

        $goods->category()->detach();

    }

    /**
     * Удаление связей между категорией и товарами
     * @param Category $category
     */
    public static function deleteCategoryAttach(Category $category){

        $category->goods()->detach();

    }
}