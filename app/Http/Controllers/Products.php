<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class Products extends Controller
{
    public function showAll(){
        $id = 0;
        $items = DB::table('catalog')
        ->join('hierarchy_products', 'catalog.id', '=', 'hierarchy_products.product_id')
        ->where('hierarchy_products.parent_id', $id)
        ->orderBy('order_place')
        ->paginate(32);

        // $table = DB::table('catalog')->paginate(32);
        // $table = DB::table('catalog')->take(20)->get();
        return view('products', ['products' => $items, 'id' => $id]);
    }

    public function show($url){
        $item = DB::table('catalog')->where('URL адрес', $url)->get();
        if (count($item)){
            return view('product', ['product' => (array)$item[0]]);
        }
        else {
            return view('errors.404');
        }
    }

    public function showCategory($url){
        $categories = DB::table('categories')
        ->where('url', $url)
        ->get();

        Log::debug(json_encode($categories));

        if (count($categories) > 0){
            $id = $categories[0]->id;
        }
        else {
            $id = -1;
        }

        $items = DB::table('catalog')
        ->join('hierarchy_products', 'catalog.id', '=', 'hierarchy_products.product_id')
        ->where('hierarchy_products.parent_id', $id)
        ->orderBy('order_place')
        ->paginate(32);

        Log::debug($id);

        // $table = DB::table('catalog')->paginate(32);
        // $table = DB::table('catalog')->take(20)->get();
        return view('products', ['products' => $items, 'id' => $id]);
    }

}
