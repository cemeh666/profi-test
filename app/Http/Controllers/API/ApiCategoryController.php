<?php
/**
 * Created by PhpStorm.
 * User: cemeh666
 * Date: 09.12.17
 * Time: 11:46
 */

namespace App\Http\Controllers\API;


use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiCategoryController extends Controller
{
    /**
     * Вывод списка всех категорий
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(){

        $categories = Category::select(['id', 'category_name'])->get();

        return $this->sendSuccessResponse($categories);
    }

    /**
     * Вывод товаров из конкретной категории
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_goods($id){

        $category = Category::with('goods')->findOrFail($id);

        return $this->sendSuccessResponse($category->goods);
    }

    /**
     * Создание категории
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request){
        $result = Category::create_category($request->all());
        if($result instanceof Category){
            return $this->sendSuccessResponse($result);
        }
        return $this->sendErrorResponse($result);
    }

    /**
     * Изменение категории
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request, $id){
        $category  = Category::findOrFail($id);

        $result = Category::edit_category($category, $request->all());
        if($result instanceof Category){
            return $this->sendSuccessResponse($result);
        }
        return $this->sendErrorResponse($result);
    }

    /**
     * Удаление категории
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id){
        $category  = Category::findOrFail($id);
        $result    = Category::delete_category($category);
        if($result){
            return $this->sendSuccessResponse(['delete' => 'Удаление прошло успешно']);
        }
        return $this->sendErrorResponse(['delete' => 'Ошибка удаления']);
    }

}