<?php
/**
 * Created by PhpStorm.
 * User: cemeh666
 * Date: 09.12.17
 * Time: 10:17
 */

namespace App;


class Category extends \Eloquent
{
    protected $table      = 'category';
    protected $guarded    = ['id'];
    protected $primaryKey = 'id';


    /**
     * Связь моногие ко многим с таблицеей Goods
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function goods(){
        return $this->belongsToMany(Goods::class);
    }

    /**
     * Валидация модели
     * @return bool|\Illuminate\Validation\Validator
     */
    public function Validate()
    {
        $rules = [
            'category_name' => ['required', 'max:191'],
        ];

        $model = self::getAttributes();

        $validator = \Validator::make($model, $rules);
        if ($validator->fails()) {
            return $validator;
        }
        return true;
    }

    /**
     * Создание новой категории
     * @param $inputs
     * @return Category|\Illuminate\Support\MessageBag
     */
    public static function create_category(Array $inputs){

        $category = new Category([
            "category_name" => isset($inputs['category_name']) ? $inputs['category_name'] : '',
        ]);

        if($category->Validate() === true){
            $category->save();
            return $category;
        }

        return $category->Validate()->getMessageBag();
    }

    /**
     * Изменение категории
     * @param Category $category
     * @param $inputs
     * @return Category|\Illuminate\Support\MessageBag
     */
    public static function edit_category(Category $category, Array $inputs){

        $category->setAttribute('category_name', isset($inputs['category_name']) ? $inputs['category_name'] : '');

        if($category->Validate() === true){
            $category->save();
            return $category;
        }

        return $category->Validate()->getMessageBag();
    }


    public static function delete_category(Category $category){
        //удаление связанных товаров
        if(count($category->goods))
            $category->goods()->delete();

        //Удаление связей товар-категория
        CategoryGoods::deleteCategoryAttach($category);
        return $category->delete();
    }

}