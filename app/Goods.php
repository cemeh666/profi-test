<?php
/**
 * Created by PhpStorm.
 * User: cemeh666
 * Date: 09.12.17
 * Time: 10:21
 */

namespace App;


class Goods extends \Eloquent
{
    protected $table      = 'goods';
    protected $guarded    = ['id'];
    protected $primaryKey = 'id';

    /**
     * Связь моногие ко многим с таблицеей Category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function category(){
        return $this->belongsToMany(Category::class);
    }


    /**
     * Валидация модели
     * @return bool|\Illuminate\Validation\Validator
     */
    public function Validate()
    {
        $rules = [
            'goods_title'       => ['required', 'max:191'],
            'goods_description' => ['required', 'max:191'],
            'categories'        => ['required', 'array'],
        ];

        $model = self::getAttributes();

        $validator = \Validator::make($model, $rules);
        if ($validator->fails()) {
            return $validator;
        }
        return true;
    }


    /**
     * Создание товара
     * @param array $inputs
     * @return Goods|array|\Illuminate\Support\MessageBag
     */
    public static function create_goods(Array $inputs){

        $goods = new Goods([
            "goods_title"       => isset($inputs['goods_title'])        ? $inputs['goods_title'] : '',
            "goods_description" => isset($inputs['goods_description'])  ? $inputs['goods_description'] : '',
            "categories"        => isset($inputs['categories'])         ? $inputs['categories'] : '',
        ]);

        if($goods->Validate() === true){
            //проверка на существование и правильный формат категорий
            $check_validation_category = CategoryGoods::checkValidCategoryIds($goods['categories']);
            if($check_validation_category !== true)
                return ['categories' => $check_validation_category];

            unset($goods['categories']);
            $goods->save();

            //создание связей товар-категория
            CategoryGoods::createGoodsAttach($goods, $inputs['categories']);
            return $goods;
        }

        return $goods->Validate()->getMessageBag();
    }

    /**
     * Изменение товара
     * @param Goods $goods
     * @param $inputs
     * @return Goods|array|\Illuminate\Support\MessageBag
     */
    public static function edit_goods(Goods $goods, Array $inputs){

        $goods->setAttribute('goods_title',         isset($inputs['goods_title'])       ? $inputs['goods_title'] : '');
        $goods->setAttribute('goods_description',   isset($inputs['goods_description']) ? $inputs['goods_description'] : '');
        $goods->setAttribute('categories',          isset($inputs['categories'])        ? $inputs['categories'] : '');

        if($goods->Validate() === true){
            //проверка на существование и правильный формат категорий
            $check_validation_category = CategoryGoods::checkValidCategoryIds($goods['categories']);
            if($check_validation_category !== true)
                return ['categories' => $check_validation_category];

            unset($goods['categories']);
            $goods->save();
            //удаление и создание новых связей товар-категория
            CategoryGoods::editGoodsAttach($goods, $inputs['categories']);
            return $goods;
        }

        return $goods->Validate()->getMessageBag();
    }

    /**
     * Удаление товара
     * @param Goods $goods
     * @return bool|null
     */
    public static function delete_goods(Goods $goods){
        //Удаление связей товар-категория
        CategoryGoods::deleteGoodsAttach($goods);
        return $goods->delete();
    }
}