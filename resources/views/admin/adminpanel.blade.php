<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="/images/tools.ico" type="image/x-icon">

    <title>Панель администратора</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <link rel="stylesheet" href="/css/admin/admin_panel.css" />

    <style>
        .preloader {
            position: fixed;
            top: 0px;
            left: 0px;
            bottom: 0px;
            right: 0px;
            background: #FFFFFFFF;
            opacity: 1.0;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: 1.0s;
            z-index: 100000;
        }

        .preloader.off {
            opacity: 0.0;
        }

        .preloader svg {
            animation-name: rotation;
            animation-duration: 2s;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
        }

        @keyframes rotation {
            0% {
                transform:rotate(0deg);
            }
            100% {
                transform:rotate(360deg);
            }
        }
    </style>

</head>
<body>
    <div class="preloader">
        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-yin-yang" viewBox="0 0 16 16">
            <path d="M9.167 4.5a1.167 1.167 0 1 1-2.334 0 1.167 1.167 0 0 1 2.334 0Z"/>
            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0ZM1 8a7 7 0 0 1 7-7 3.5 3.5 0 1 1 0 7 3.5 3.5 0 1 0 0 7 7 7 0 0 1-7-7Zm7 4.667a1.167 1.167 0 1 1 0-2.334 1.167 1.167 0 0 1 0 2.334Z"/>
        </svg>
    </div>

    @include('admin.includes.modals.catalog_window')
    @include('admin.includes.modals.product_window')
    @include('admin.includes.modals.product_edit_window')
    @include('admin.includes.offcanvas.product_edit')
    @include('includes.messages-panel')

    <main class="min-vh-100 w-100">

        <div class="card text-center vh-100" style="box-shadow: 0px 5px 4px #0000FF7F;">
            <div class="card-header pb-0">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Главная</button>
                    <button class="nav-link" id="nav-services-pages-tab" data-bs-toggle="tab" data-bs-target="#nav-services-pages" type="button" role="tab" aria-controls="nav-services-pages" aria-selected="false">Сервисные страницы</button>
                    <button class="nav-link" id="nav-search-logs-tab" data-bs-toggle="tab" data-bs-target="#nav-search-logs" type="button" role="tab" aria-controls="nav-search-logs" aria-selected="false">Поисковые логи</button>
                    <button class="nav-link" id="nav-orders-logs-tab" data-bs-toggle="tab" data-bs-target="#nav-orders-logs" type="button" role="tab" aria-controls="nav-orders-logs" aria-selected="false">Заказы</button>
                    <button class="nav-link" id="nav-catalog-tab" data-bs-toggle="tab" data-bs-target="#nav-catalog" type="button" role="tab" aria-controls="nav-catalog" aria-selected="false">Каталог</button>
                    <a class="nav-link ms-auto fs-4 mb-1 py-0" href="/" target="_blank">Главная</a>
                </div>
            </div>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                    <input type="date">
                </div>
                
                <!-- Панель сервисных страниц -->
                <div class="tab-pane fade" id="nav-services-pages" role="tabpanel" aria-labelledby="nav-services-pages-tab" tabindex="0">
                    <select id="services-pages-select" class="w-100 p-1">
                        <option value="-1"></option>
                        @php
                            $items = DB::table('services')->get();

                            $html = "";
                            foreach($items as $item){
                                $html .= "
                                    <option value='{$item->url}'>{$item->page_name}</option>
                                ";
                            }

                            echo $html;
                        @endphp
                    </select>
                    <div class="categories pt-3">
                        <div class="textEditor"><textarea id="textEditArea-categories"></textarea></div>
                        <div class="textEditor__buttons-wrapper w-100 d-flex flex-row pt-3">
                            <div class="textEditorImage py-1 px-3 btn btn-primary shadow">Картинка</div>
                            <div class="textEditorShow ms-auto py-1 px-3 btn btn-primary shadow">Перейти</div>
                            <div class="textEditorSave py-1 px-3 btn btn-primary ms-3 shadow">Сохранить</div>
                        </div>
                    </div>

                </div>

                <!-- Панель поисковых логов -->
                <div class="tab-pane fade" id="nav-search-logs" role="tabpanel" aria-labelledby="nav-search-logs-tab" tabindex="0">
                    <table class="table table-striped">
                        <thead class="table-info sticky-top" style="top: -10px;">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Поисковый запрос</th>
                                <th scope="col">Дата и время поиска</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $items = DB::table('searching_logs')->get();
                                
                                $number = 1;
                                $html = "";
                                foreach($items as $item){
                                    $html .= "
                                        <tr>
                                            <th scope='row'>{$number}</th>
                                            <td>{$item->search_text}</td>
                                            <td>{$item->timestamp}</td>
                                        </tr>
                                    ";
                                    $number++;
                                }

                                echo $html;
                            @endphp
                        </tbody>
                    </table>
                </div>

                <!-- Панель заказов -->
                <div class="tab-pane fade" id="nav-orders-logs" role="tabpanel" aria-labelledby="nav-orders-logs-tab" tabindex="0">
                    <div class="sticky-row"> 
                        <div class="header-row">
                            <div>Номер</div>
                            <div>Дата</div>
                            <div>Город</div>
                            <div>Телефон</div>
                            <div>Имя</div>
                            <div>Адрес</div>
                            <div>Сумма</div>
                            <div class="expand-button"></div>
                        </div>
                    </div>
                
                    @php
                        $items = DB::table('orders')->get();
                        
                        $startNumber = 1138;
                        $html = "";
                        foreach($items as $item){
                            $number = $startNumber + $item->id;
                            $html .= "
                                <div class='item-row' id='{$item->id}'>
                                    <div class='item-row__wrapper'>
                                        <div>{$number}</div>
                                        <div>{$item->timestamp}</div>
                                        <div>{$item->city}</div>
                                        <div>{$item->phone_number}</div>
                                        <div>{$item->name}</div>
                                        <div>{$item->adress}</div>
                                        <div>{$item->order_summ}</div>
                                        <div class='expand-button'>
                                            <img src='/images/caret-down.svg'>
                                        </div>
                                    </div>
                                    <div class='item-row-expand item-row-expand-{$item->id}' id='{$item->id}'></div>
                                </div>
                            ";
                        }
                        echo $html;
                    @endphp
                </div>

                <!-- Каталог товаров -->
                <div class="tab-pane fade bg-light" id="nav-catalog" role="tabpanel" aria-labelledby="nav-catalog-tab" tabindex="0">
                    <div class="d-flex flex-row h-100">
                        <!-- Левая панель -->
                        <div id="panel-area"class="d-flex flex-column h-100 p-2 user-select-none" style="min-width: 300px;">
                            <div id="items-info">
                                <div class="fs-6 fw-bold d-flex justify-content-start align-items-center">Товары
                                    <!-- <div title="Добавить товар" class="ms-auto"><img class="add-button add-item" src="/images/round-plus.svg"></div> -->
                                </div>
                                <div class="list ps-2" style="font-size: 12px;">
                                    <div class="item-wrapper-info d-flex justify-content-between"><div class="item-label statistics statistic-1">Все товары</div><div class="item-counter me-4">2387/5668</div></div>
                                    <div class="item-wrapper-info d-flex justify-content-between"><div class="item-label statistics statistic-2">Товары без категории</div><div class="item-counter me-4">10/20</div></div>
                                    <!-- <div class="item-wrapper-info d-flex justify-content-between"><div class="item-label statistic-3">Хиты продаж</div><div class="item-counter me-4">34/67</div></div>
                                    <div class="item-wrapper-info d-flex justify-content-between"><div class="item-label statistic-4">Новинки</div><div class="item-counter me-4">3/7</div></div>
                                    <div class="item-wrapper-info d-flex justify-content-between"><div class="item-label statistic-5">Товары со скидкой</div><div class="item-counter me-4">234/789</div></div>
                                    <div class="item-wrapper-info d-flex justify-content-between"><div class="item-label statistic-6">Лидеры просмотров</div><div class="item-counter me-4">568/878</div></div> -->
                                </div>
                            </div>

                            <div id="items-catalog" class="mt-4">
                                <div class="item-wrapper d-flex justify-content-start align-items-center">
                                    <div category-id="0" id="catalog-label" class="fs-6 fw-bold item-label selected">Каталог</div>
                                    <!-- <div title="Добавить категорию" class="ms-auto"><img class="add-button add-catalog" src="/images/round-plus.svg"></div> -->
                                </div>
                                <div parent-id="0" class="main-childs list ps-2" style="font-size: 12px;">
                                    
                                    <!-- <div class="item-wrapper category-item d-flex">
                                        <div class="item-label">Все товары</div><div class="item-counter ms-auto me-4">2387/5668</div>
                                    </div>
                                    
                                    <div class="item-wrapper category-item d-flex">
                                        <div class="item-label">Товары без категории</div><div class="item-counter ms-auto me-4">23/68</div>
                                    </div>

                                    <div class="item-wrapper category-item d-flex flex-column">
                                        <div class="d-flex flex-row">
                                            <div class="item-label">Хиты продаж</div><div class="item-counter ms-auto me-2">7/8</div>
                                            <div class="item-extender"></div>
                                        </div>
                                        <div parent-id="3" class="item-childs d-flex flex-column justify-content-start ps-4">
                                            <div class="item-wrapper category-item d-flex"><div class="item-label">Квадратные столы</div><div class="item-counter ms-auto me-4">223/628</div></div>
                                            <div class="item-wrapper category-item d-flex"><div class="item-label">Круглые столы</div><div class="item-counter ms-auto me-4">123/164</div></div>
                                            <div class="item-wrapper category-item d-flex"><div class="item-label">Стеклянные столы</div><div class="item-counter ms-auto me-4">63/89</div></div>
                                        </div>
                                    </div>

                                    <div class="item-wrapper category-item d-flex">
                                        <div class="item-label">Новинки</div><div class="item-counter ms-auto me-4">23/58</div>
                                    </div>

                                    <div class="item-wrapper category-item d-flex">
                                        <div class="item-label">Товары со скидкой</div><div class="item-counter ms-auto me-4">237/566</div>
                                    </div>

                                    <div class="item-wrapper category-item d-flex">
                                        <div class="item-label">Лидеры просмотров</div><div class="item-counter ms-auto me-4">387/668</div>
                                    </div> -->
                                </div>
                            </div>

                        </div>

                        <!-- Рабочая область -->
                        <div id="main-area" class="d-flex flex-column flex-grow-1 h-100 p-2">
                            
                            <div id="category-panel" class="d-flex flex-column w-100 p-2 bg-white shadow">
                                <div class="area-title fw-bold ms-2 me-auto py-2 d-flex w-100">
                                    <div id="category-title">Каталог</div>
                                    <div id="category-go-link" link="" class="ms-2" style="" title="Перейти на страницу">
                                        <svg class="link text-primary" width="24" height="24" fill="currentColor" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="ReplyAllTwoToneIcon" tabindex="-1" title="ReplyAllTwoTone">
                                            <path d="M7 8V5l-7 7 7 7v-3l-4-4 4-4zm6 1V5l-7 7 7 7v-4.1c5 0 8.5 1.6 11 5.1-1-5-4-10-11-11z"></path>
                                        </svg>
                                    </div>
                                    <div title="Добавить категорию" class="ms-auto me-3"><img class="add-button add-catalog" src="/images/round-plus.svg"></div>
                                </div>
                                <div class="area-content d-flex flex-row flex-wrap">

                                    <!-- <div class="category-card d-flex flex-column border p-1 m-2" style="width: 200px;" draggable="true">
                                        <div class="category-card-header d-flex flex-row p-1">
                                            <img src="/images/drag-button.svg" class="category-card-drag" draggable="false">
                                            <img src="/images/edit-button.svg" class="category-card-edit ms-auto me-2">
                                            <img src="/images/close-button.svg" class="category-card-close">
                                        </div>
                                        <div class="category-card-image d-flex flex-row p-1 justify-content-center align-items-center" style="height:100px;">
                                            <img src="/images/no-photo.svg" style="width: 32px; height:32px;">
                                        </div>
                                        <div class="category-card-label d-flex flex-row p-1">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                            <label class="form-check-label ms-2" for="flexCheckDefault">Готовка(78)</label>
                                        </div>
                                    </div>

                                    <div class="category-card d-flex flex-column border p-1 m-2" style="width: 200px;" draggable="true">
                                        <div class="category-card-header d-flex flex-row p-1">
                                            <img src="/images/drag-button.svg" class="category-card-drag" draggable="false">
                                            <img src="/images/edit-button.svg" class="category-card-edit ms-auto me-2">
                                            <img src="/images/close-button.svg" class="category-card-close">
                                        </div>
                                        <div class="category-card-image d-flex flex-row p-1 justify-content-center align-items-center" style="height:100px;">
                                            <img src="/images/no-photo.svg" style="width: 32px; height:32px;">
                                        </div>
                                        <div class="category-card-label d-flex flex-row p-1">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                            <label class="form-check-label ms-2" for="flexCheckDefault">Продажа(78)</label>
                                        </div>
                                    </div>

                                    <div class="category-card d-flex flex-column border p-1 m-2" style="width: 200px;" draggable="true">
                                        <div class="category-card-header d-flex flex-row p-1">
                                            <img src="/images/drag-button.svg" class="category-card-drag" draggable="false">
                                            <img src="/images/edit-button.svg" class="category-card-edit ms-auto me-2">
                                            <img src="/images/close-button.svg" class="category-card-close">
                                        </div>
                                        <div class="category-card-image d-flex flex-row p-1 justify-content-center align-items-center" style="height:100px;">
                                            <img src="/images/no-photo.svg" style="width: 32px; height:32px;">
                                        </div>
                                        <div class="category-card-label d-flex flex-row p-1">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                            <label class="form-check-label ms-2" for="flexCheckDefault">Акции(78)</label>
                                        </div>
                                    </div>

                                    <div class="category-card d-flex flex-column border p-1 m-2" style="width: 200px;" draggable="true">
                                        <div class="category-card-header d-flex flex-row p-1">
                                            <img src="/images/drag-button.svg" class="category-card-drag" draggable="false">
                                            <img src="/images/edit-button.svg" class="category-card-edit ms-auto me-2">
                                            <img src="/images/close-button.svg" class="category-card-close">
                                        </div>
                                        <div class="category-card-image d-flex flex-row p-1 justify-content-center align-items-center" style="height:100px;">
                                            <img src="/images/no-photo.svg" style="width: 32px; height:32px;">
                                        </div>
                                        <div class="category-card-label d-flex flex-row p-1">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                            <label class="form-check-label ms-2" for="flexCheckDefault">Скидки(78)</label>
                                        </div>
                                    </div> -->

                                </div>
                            </div>

                            <div id="product-panel" class="d-flex flex-column w-100 p-2 mt-3 bg-white shadow">
                                <div class="area-title fw-bold ms-2 me-auto py-2 d-flex w-100">
                                    <div id="product-title">Товар(ы)</div>
                                    <div title="Добавить товар" class="ms-auto me-3"><img class="add-button add-item" src="/images/round-plus.svg"></div>
                                </div>
                                <div class="area-contnet p-2">
                                    <div class="table-items">
                                        <div class="table-items-header w-100 border sticky-top" style="background: #FFFFFF; top: -10px;">
                                            <div class="header1 w-100 d-flex flex-row align-items-center p-2" style="height: 40px;">
                                                <div class="column-drag"></div>
                                                <div class="column-check"><input class="form-check-input" type="checkbox" value="" id="panel-table-items-header-check"></div>
                                                <div>
                                                    <div id="header-menu-check" class="dropdown" style="display:none;">
                                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0px 5px 3px 10px;">
                                                            Действие
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><button id="del-all-from-catalog" class="dropdown-item" type="button">Удалить все из каталога</button></li>
                                                            <li><button class="dropdown-item" type="button">Действие2</button></li>
                                                            <li><button class="dropdown-item" type="button">Действие3</button></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="header-main-content column-articul">Артикул</div>
                                                <div class="header-main-content column-image">Изобр.</div>
                                                <div class="header-main-content column-name flex-grow-1">Название</div>
                                                <div class="header-main-content column-price">Цена</div>
                                                <div class="header-main-content column-quantity">Кол-во</div>
                                                <div class="header-main-content column-order">Порядок</div>
                                                <div class="header-main-content column-activity">Актив.</div>
                                                <div class="header-main-content column-delete"></div>
                                            </div>
                                        </div>
                                        <div class="table-items-body w-100 border border-top-0">
                                            {{--
                                            <div item-id="1" class="table-item w-100 d-flex flex-row justify-content-between p-2" draggable="true">
                                                <div class="column-drag"><img src="/images/drag-button.svg" class="item-drag" draggable="false"></div>
                                                <div class="column-check"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></div>
                                                <div class="column-articul">465001</div>
                                                <div class="column-image"><img src="/images/no-photo.svg" style="width: 32px; height:32px;"></div>
                                                <div class="column-name">Стул Vivian 1</div>
                                                <div class="column-price">6 990 руб</div>
                                                <div class="column-quantity">0</div>
                                                <div class="column-order">0</div>
                                                <div class="column-activity">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                                                    </div>
                                                </div>
                                                <div class="column-delete"><img src="/images/close-button.svg" class="category-card-close"></div>
                                            </div>

                                            <div item-id="2" class="table-item w-100 d-flex flex-row justify-content-between p-2" draggable="true">
                                                <div class="column-drag"><img src="/images/drag-button.svg" class="item-drag" draggable="false"></div>
                                                <div class="column-check"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></div>
                                                <div class="column-articul">465002</div>
                                                <div class="column-image"><img src="/images/no-photo.svg" style="width: 32px; height:32px;"></div>
                                                <div class="column-name">Стул Vivian 2</div>
                                                <div class="column-price">6 490 руб</div>
                                                <div class="column-quantity">0</div>
                                                <div class="column-order">0</div>
                                                <div class="column-activity">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked">
                                                    </div>
                                                </div>
                                                <div class="column-delete"><img src="/images/close-button.svg" class="category-card-close"></div>
                                            </div>

                                            <div item-id="3" class="table-item w-100 d-flex flex-row justify-content-between p-2" draggable="true">
                                                <div class="column-drag"><img src="/images/drag-button.svg" class="item-drag" draggable="false"></div>
                                                <div class="column-check"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></div>
                                                <div class="column-articul">465003</div>
                                                <div class="column-image"><img src="/images/no-photo.svg" style="width: 32px; height:32px;"></div>
                                                <div class="column-name">Стул Vivian 3</div>
                                                <div class="column-price">6 990 руб</div>
                                                <div class="column-quantity">0</div>
                                                <div class="column-order">0</div>
                                                <div class="column-activity">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked">
                                                    </div>
                                                </div>
                                                <div class="column-delete"><img src="/images/close-button.svg" class="category-card-close"></div>
                                            </div>
                                            --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex w-100" style="min-height: 15px;"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="/js/nic-edit.js" type="text/javascript"></script>
    <script type="module" src="/js/init.js"></script>
    <script type="module" src="/js/admin.js"></script>

    <script>
        $(document).ready(function() { 
            $('.preloader').addClass('off');
            setTimeout(() => {
                $('.preloader').remove();
            }, 1000);
        });
    </script>

</body>
</html>