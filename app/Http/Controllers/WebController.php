<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WebController extends Controller
{

    public function categories() {
        $categories = DB::table('categories')
        ->join('hierarchy_category', 'categories.id', '=', 'hierarchy_category.category_id')
        ->orderBy('order_place')
        ->get();

        return '{"server_answer" : "success", "data" : ' . "{$categories}" . ' }';
    }

    public function GetProductsList() {
        $items = DB::table('catalog')
        ->paginate(30);

        return $items;
    }

    public function ProductInfo($id) {
        $product = DB::table('catalog')
        ->where('id', $id)
        ->get();

        return '{"server_answer" : "success", "data" : ' . "{$product}" . ' }';
    }

    public function ProductSave($id, Request $request) {

        $phpData = [];
        foreach($request->savedData as $data){
            $phpData["{$data[0]}"] = $data[1];
        }

        $product = DB::table('catalog')
        ->where('id', $id)
        ->update($phpData);
    
        return '{"server_answer" : "success"}';
    }

    public function categoryParent($id) {
        $category = DB::table('categories')
        ->where('id', $id)
        ->get();

        $categories = DB::table('categories')
        ->join('hierarchy_category', 'categories.id', '=', 'hierarchy_category.category_id')
        ->where('parent_id', $id)
        ->orderBy('order_place')
        ->get();

        return '{"server_answer" : "success", "data" : ' . "{$categories}" . ', "category" : ' . "{$category}" . '}';
    }

    public function categoryInfo($id) {
        $categories = DB::table('categories')
        ->join('hierarchy_category', 'categories.id', '=', 'hierarchy_category.category_id')
        ->where('category_id', $id)
        ->get();

        return '{"server_answer" : "success", "data" : ' . "{$categories}" . ' }';
    }

    public function CreateCategory(Request $request) {
        $id = DB::table('categories')
        ->insertGetId([
            'category_active' => $request->category_active, 
            'category_name'   => $request->category_name,
            'url'             => $request->url,
            'description'     => $request->description,
            //'category_image' => $request->category_image,
        ]);

        DB::table('hierarchy_category')
        ->insert([
            'parent_id' => $request->parent_id, 
            'category_id' => $id,
        ]);

        return '{"server_answer" : "success", "id" : ' . "{$id}" .' }';
    }

    public function SaveCategory($id, Request $request) {
        DB::table('categories')
        ->where('id', $id)
        ->update([
            'category_active' => $request->category_active, 
            'category_name'   => $request->category_name,
            'url'             => $request->url,
            'description'     => $request->description,
            //'category_image' => $request->category_image,
        ]);

        DB::table('hierarchy_category')
        ->updateOrInsert(
            [ 'category_id' => $id, ], //условия поиска
            [ 'parent_id' => $request->parent_id, ] //обновление значений
        );

        return '{"server_answer" : "success" }';
    }

    public function DeleteCategory($id) {
        DB::table('categories')
        ->where('id', $id)
        ->delete();

        DB::table('hierarchy_category')
        ->where('category_id', $id)
        ->delete();

        return '{"server_answer" : "success" }';
    }

    public function ProductsShortList(Request $request) {
        $list = DB::table('catalog')
        ->select(
            'id',
            'Артикул',
            'Фото товара',
            'Наименование',
            'Цена',
            'Включен',
            'URL адрес',
            'Описание'
        )->get();

        return '{"server_answer" : "success", "list" : ' . "{$list}" .' }';
    }

    public function ProductsAddToCategory(Request $request) {
        foreach($request->products as $product){
            $item = DB::table('hierarchy_products')
            ->where('parent_id', $product[0])
            ->where('product_id', $product[1])
            ->get();
            if (count($item) == 0){
                DB::table('hierarchy_products')->insert(['parent_id' => $product[0], 'product_id' => $product[1]]);
            }
        }
        
        return '{"server_answer" : "success" }';
    }

    public function ItemsForParent($id) {
        $items = DB::table('catalog')
        ->join('hierarchy_products', 'catalog.id', '=', 'hierarchy_products.product_id')
        ->where('hierarchy_products.parent_id', $id)
        ->orderBy('order_place')
        ->get();

        return '{"server_answer" : "success", "list" : ' . "{$items}" . ' }';
    }

    public function ProductDeleteFromCategory(Request $request) {
        DB::table('hierarchy_products')
        ->where('parent_id', $request->parent_id)
        ->where('product_id', $request->product_id)
        ->delete();

        return '{"server_answer" : "success"}';
    }

    public function ProductsDeleteFromCategory(Request $request) {
        $checkedArray = $request->checkedArray;
        Log::debug(json_encode($checkedArray));

        foreach($checkedArray as $item){
            DB::table('hierarchy_products')
            ->where('parent_id', $item['parent_id'])
            ->where('product_id', $item['product_id'])
            ->delete();
        }

        return '{"server_answer" : "success"}';
    }    

    #region order functions
    public function SetCategoriesOrder(Request $request) {
        foreach ($request->orders as $order) {
            DB::table('hierarchy_category')
            ->where('category_id', $order['id'])
            ->update([
                'order_place' => $order['index']
            ]);
        }
        return '{"server_answer" : "success"}';
    }

    public function SetProductsOrder(Request $request) {
        foreach ($request->orders as $order) {
            DB::table('hierarchy_products')
            ->where('product_id', $order['id'])
            ->update([
                'order_place' => $order['index']
            ]);
        }
        return '{"server_answer" : "success"}';
    }
    #endregion
    
    //----------------------------------------------------------------------------------
    #region conditions
    public function GetActiveTab(Request $request) {
        $activeTab = DB::table('admin_conditins')
        ->select('active_tab')
        ->get()[0]->active_tab;

        return '{"server_answer" : "success", "activeTab" : "'. $activeTab .'"}';
    }

    public function SetActiveTab(Request $request) {
        DB::table('admin_conditins')
        ->update(['active_tab' => $request->activeTab]);

        return '{"server_answer" : "success"}';
    }
    #endregion
    //----------------------------------------------------------------------------------
    
}
