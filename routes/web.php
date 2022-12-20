<?php

Route::view('/adminpanel', 'admin.adminpanel');

Route::view('/', 'main')->name('main');
Route::get('/products', 'Products@showAll')->name('products');
Route::get('/products/{url}', 'Products@showCategory')->name('category');
Route::get('/product/{url}', 'Products@show')->name('product');
Route::get('/service/{url}', 'Services@show')->name('service');
Route::get('/search', 'Search@showSearchResult')->name('search');

Route::get('/basket/index', 'BasketController@index')->name('basket.index');
Route::get('/basket/checkout', 'BasketController@checkout')->name('basket.checkout');

Route::post('/test/get', function(){
    return '{"server_answer" : "success"}';
});

Route::view('/test', 'test')->name('test');


// Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');

#region admin requests
Route::prefix('admin')->group(function(){

    //--------------------------------------------------------------------------------------------------------
    // перед всеми командами должно стоять /admin
    // во всех командах должно присутствовать поле 'token' со значением токена

    Route::get ('/products/list', 'WebController@GetProductsList')->name('products.list');

    Route::prefix('condition')->group(function(){
        Route::get ('/activetab', 'WebController@GetActiveTab')->name('condition.getActiveTab');
        Route::put ('/activetab', 'WebController@SetActiveTab')->name('condition.setActiveTab');
    });

    Route::prefix('categories')->group(function(){
        Route::post  ('/', 'WebController@categories')->name('categories.list');
        Route::post  ('/new', 'WebController@CreateCategory')->name('category.create');
        Route::put   ('/orders', 'WebController@SetCategoriesOrder')->name('categories.orders');
    });

    Route::put ('/products/orders', 'WebController@SetProductsOrder')->name('products.orders');

    Route::prefix('category')->group(function(){
        Route::post  ('/parent/{id}', 'WebController@categoryParent')->name('category.parent');
        Route::post  ('/info/{id}', 'WebController@categoryInfo')->name('category.info');
        Route::put   ('/save/{id}', 'WebController@SaveCategory')->name('category.save');
        Route::delete('/delete/{id}', 'WebController@DeleteCategory')->name('category.delete');
    });
    
    Route::prefix('products')->group(function(){
        Route::get   ('/short', 'WebController@ProductsShortList')->name('products.shortlist');
        Route::get   ('/info/{id}', 'WebController@ProductInfo')->name('products.productInfo');
        Route::put   ('/save/{id}', 'WebController@ProductSave')->name('products.productSave');
        Route::get   ('/parent/{id}', 'WebController@ItemsForParent')->name('products.forparent');
        Route::put   ('/add', 'WebController@ProductsAddToCategory')->name('products.add_to_category');
        Route::delete('/category/delete', 'WebController@ProductsDeleteFromCategory')->name('products.delete_from_category');
    });
    

    Route::prefix('properties')->group(function(){
        // Route::get   ('/check', 'WebController@PropertiesCheck')->name('properties.check');
        // Route::get   ('/info/{id}', 'WebController@ProductInfo')->name('products.productInfo');
        Route::put   ('/orders', 'WebController@SetPropertiesOrder')->name('properties.order');
        // Route::get   ('/parent/{id}', 'WebController@ItemsForParent')->name('products.forparent');
        // Route::put   ('/add', 'WebController@ProductsAddToCategory')->name('products.add_to_category');
        // Route::delete('/category/delete', 'WebController@ProductsDeleteFromCategory')->name('products.delete_from_category');
    });

    Route::delete('/product/category/delete', 'WebController@ProductDeleteFromCategory')->name('product.delete_from_category');
    Route::post('/product/edit/form', function (Request $request) {
        return view('admin.includes.offcanvas.product_edit');
    });
    //--------------------------------------------------------------------------------------------------------
});
#endregion

?>