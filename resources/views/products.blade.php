@extends('layouts.base')

@section('page.title', 'Каталог товаров')

@section('content')
    <?php
        $cookieUuid = Cookie::get('cookie-uuid');
                
        $list = DB::table('wish_list')
        ->where('cookie_uuid', $cookieUuid)
        ->select('product_id')
        ->get();
        
        $wishList = [];
        foreach ($list as $item) {
            array_push($wishList, $item->product_id);
        }
    ?>

    <div class="container d-flex justify-content-start flex-wrap" style="max-width: 1200px;">

        @include('includes.products.categories')

        @include('includes.products.list', ['products' => $products])

        <div class="py-4">
            {{ $products->appends(['products' => request()->products])->links() }}
        </div>

    </div>

    {{--dd(Route::is('main'))--}}

@endsection

@push('js')
    <script type="text/javascript" src="/js/products.js"></script>
    <style>
        div.card {
            transition: 0.3s;
        }

        div.card img {
            transition: 0.3s;
            filter: grayscale(0.5);
        }

        div.card:hover {
            cursor: pointer;
            /* transform: scale(1.05) rotateZ(2deg); */
        }
        
        div.card:hover img {
            filter: grayscale(0.0);
        }

        div.card:hover .wishButton,
        div.card:hover .basketButton {
            background-color: #0D6EFDAF;
        }

        .wishButton svg {
            transition: 0.3s;
        }

        .wishButton:hover svg {
            color: #FF0000;
        }

        .wishButton svg:first-child {
            display: block;
        }

        .wishButton svg:last-child {
            display: none;
        }

        .wishButton.wishset svg:first-child {
            display: none;
        }

        .wishButton.wishset svg:last-child {
            display: block;
        }        
        
    </style>
@endpush