<?php
/**
 * Created by PhpStorm.
 * User: cemeh666
 * Date: 10.12.17
 * Time: 10:01
 */

namespace App\Http\Controllers\API;


use App\Goods;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiGoodsController extends Controller
{

    public function get(){
        $result = Goods::with('category')->get();
        return $this->sendSuccessResponse($result);
    }

    /**
     * Создание товара
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request){
        $result = Goods::create_goods($request->all());
        if($result instanceof Goods){
            return $this->sendSuccessResponse($result);
        }
        return $this->sendErrorResponse($result);
    }

    /**
     * Редактирование товара
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request, $id){
        $goods  = Goods::findOrFail($id);
        $result = Goods::edit_goods($goods, $request->all());
        if($result instanceof Goods){
            return $this->sendSuccessResponse($result);
        }
        return $this->sendErrorResponse($result);
    }

    /**
     * Удаление товара
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id){
        $goods  = Goods::findOrFail($id);
        $result = Goods::delete_goods($goods);
        if($result){
            return $this->sendSuccessResponse(['delete' => 'Удаление прошло успешно']);
        }
        return $this->sendErrorResponse(['delete' => 'Ошибка удаления']);
    }
}