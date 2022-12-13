@extends('layouts.base')

@section('page.title', 'Каталог товаров')

@section('content')

    <div class="container d-flex justify-content-start flex-wrap" style="max-width: 1200px;">

        @include('includes.products.banner')

        @include('includes.products.hits')

        @include('includes.products.sponsors')

        {{-- @include('includes.products.list', ['products' => $products]) --}}

        @include('includes.products.news')

        @include('includes.products.company')

    </div>

    {{--dd(Route::is('main'))--}}

@endsection

@push('js')
    <script type="text/javascript" src="/js/products.js"></script>
    <style>
        div.card {
            transition: 0.3s;
        }

        div.card:hover {
            cursor: pointer;
            transform: scale(1.05) rotateZ(2deg);
        }
    </style>
@endpush