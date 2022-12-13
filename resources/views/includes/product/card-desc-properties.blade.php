<div class="d-flex flex-row w-100 fs-4 fw-bold mb-3">
    <div>Цена</div>
    <div class="flex-grow-1"></div>
    <div>{{$product['Цена']}}
        <svg style="margin: 0px 0px 6px 0px;" width="28px" height="28px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M8 21h2v-3h6v-2h-6v-2h4.5c2.757 0 5-2.243 5-5s-2.243-5-5-5H9a1 1 0 0 0-1 1v7H5v2h3v2H5v2h3v3zm2-15h4.5c1.654 0 3 1.346 3 3s-1.346 3-3 3H10V6z"/>
        </svg>
    </div>
</div>

<div class="basketButton btn btn-primary w-100 mb-5 fs-4" item_id="{{$product['id']}}">В корзину</div>

<div class="d-flex flex-row w-100 fs-4 mb-3">
    <div class="fw-bold">Артикул</div>
    <div class="flex-grow-1"></div>
    <div>{{$product['Артикул']}}</div>
</div>

<div class="d-flex flex-column align-items-start w-100 fs-4 mb-3 py-2">
    <div class="fw-bold py-1">Характеристики</div>
    @foreach($product as $key=>$value)
        @if ((mb_strpos($key, 'Свойство: ') !== false) && ($value !== ""))
            <div class="d-flex flex-row w-100 fs-6">
                <div>{{str_replace('Свойство: ', '', $key)}}</div>
                <div class="flex-grow-1" style="border-bottom: 2px dotted #000000; margin: 0px 10px 6px 10px;"></div>
                <div>{{str_replace(';', ', ', $value)}}</div>
            </div>
        @endif
    @endforeach
</div>

@if ($product['Описание'] != "")
    <div class="d-flex flex-row w-100 fs-4 m-3">
        <div class="fw-bold">Описание</div>
    </div>

    <div class="product-card-desc d-flex flex-row w-100 fs-6 mb-3">
        {!! $product['Описание'] !!}
    </div>

    <style>
        .product-card-desc,
        .product-card-desc div {
            text-align: justify;
        }
    </style>
@endif