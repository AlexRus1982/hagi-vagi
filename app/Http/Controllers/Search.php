<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Search extends Controller
{
    public function showSearchResult(Request $request){

        $searchProducts = $request->searchProducts;

        // write searching log to base
        $now = new \DateTime();
        DB::table('searching_logs')->insert([
            'search_text' => $searchProducts, 
            'timestamp'   => $now,
        ]);

        // find searching value
        $items = DB::table('catalog')->where('Наименование', 'LIKE', "%{$searchProducts}%")
                                     ->orWhere('Свойство: Материал', 'LIKE', "%{$searchProducts}%")
                                     ->orWhere('Описание', 'LIKE', "%{$searchProducts}%")
                                     ->paginate(8);

        if (count($items)){
            return view('search', ['searchResult' => $items]);
        }
        else {
            return view('errors.404');
        }
    }
}
