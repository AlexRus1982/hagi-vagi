@if (count($products) > 0)
    <div class="d-flex flex-row w-100 fs-4 mt-0 mb-1 fw-bold">Каталог</div>

    <div class="d-flex flex-row w-100 justify-content-between flex-wrap pb-3">
        @foreach($products as $key=>$value)
            @include('includes.products.card', ['value' => $value])
        @endforeach
    </div>
@endif