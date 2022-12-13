@extends('layouts.base')

@section('page.title', $product['Наименование'])

@section('content')
    <div class="container d-flex justify-content-center flex-column align-self-center" style="align-items: center; max-width: 1200px;">
        
        <div class="h1 pb-3">{{$product['Наименование']}}</div>

        @include('includes.product.card-desc-images', ['product' => $product])
        @include('includes.product.card-desc-properties', ['product' => $product])
        @include('includes.product.questions')
        @include('includes.product.reviews')

        @include('includes.product.like')
        @include('includes.product.additions')
        @include('includes.product.see-before')

    </div>

    {{--dd(Route::is('main'))--}}

@endsection

@push('js')
    <script type="text/javascript" src="/js/product.js"></script>
    <style>
        #carouselExampleControls.start {
            transition: 0.0s;
            transform: translateX(-2000px) rotateZ(360deg);
        }

        #carouselExampleControls {
            transition: 1.0s;
            transform: translateX(0px) rotateZ(0deg);
        }

        div.card {
            transition: 0.3s;
        }

        div.card:hover {
            cursor: pointer;
            transform: scale(1.05) rotateZ(2deg);
        }
    </style>
@endpush