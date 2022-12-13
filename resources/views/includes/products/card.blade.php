@php
    $item = (array)$value;
    $item_id = $item['id'];
    $photos = explode(';', $item['Фото товара']);
    $image = pathinfo($photos[0])['filename'];
    
    $imageURL = getImageUrl($image); // function from helpers

@endphp

<a class="card" target="_blank" rel="noopener noreferrer" href="/product/{{$item['URL адрес']}}" style="text-decoration: none; color: #000000; border:none; background: none;">
    <div class="card m-2 ms-0 shadow p-1" style="min-width: 17rem; width: 17rem; height: 430px;">
        <div class="card-image d-flex justify-content-center flex-column" style="min-height: 270px; height: 270px;">
            <img src="{{$imageURL}}" class="card-img-top" alt="{{$item['Наименование']}}" loading="lazy" style="height: 100%; width: 100%; object-fit: contain;">
        </div>
        <div class="card-body d-flex flex-column">
            <h5 class="card-title" style="height: 40; line-height: 20px; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; overflow: hidden;">{{$item['Наименование']}}</h5>
            <p class="card-text mt-auto">Цена {{$item['Цена']}}<svg style="margin: 0px 0px 3px 0px;" width="16px" height="16px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 21h2v-3h6v-2h-6v-2h4.5c2.757 0 5-2.243 5-5s-2.243-5-5-5H9a1 1 0 0 0-1 1v7H5v2h3v2H5v2h3v3zm2-15h4.5c1.654 0 3 1.346 3 3s-1.346 3-3 3H10V6z"/>
                </svg>
            </p>
            <!-- <a target="_blank" rel="noopener noreferrer" href="/product/{{$item['URL адрес']}}" class="btn btn-primary mt-auto">В корзину</a> -->
            <div class="basketButton btn btn-primary mt-auto" item_id="{{ $item_id }}">В корзину</div>
        </div>
    </div>
</a>