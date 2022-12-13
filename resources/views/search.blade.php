@extends('layouts.base')

@section('page.title', 'Результат поиска')

@section('content')

    <div class="container d-flex justify-content-start flex-wrap" style="max-width: 1200px;">

        @include('includes.search.list', ['products' => $searchResult])
        
        <div class="py-4">
            {{ $searchResult->appends(['searchProducts' => request()->searchProducts])->links() }}
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

        div.card:hover {
            cursor: pointer;
            transform: scale(1.05) rotateZ(2deg);
        }
    </style>
@endpush