<div 
    class="modal fade" 
    id="productModal"
    parent_id="" 
    data-bs-keyboard="false" 
    tabindex="-1" 
    aria-labelledby="productModalLabel" 
    aria-hidden="true" 
    style="background: #FFFFFF00; backdrop-filter: blur(8px) grayscale(1.0);">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="min-width: 950px;">
        <div class="modal-content shadow">
            <div class="modal-header bg-primary bg-gradient text-white">
                <h1 class="modal-title fs-5 w-100 d-flex flex-row" id="productModalLabel">Добавить товар в категорию<div class="px-2">-</div><div id="parentCatalog">каталог</div></h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="w-100 py-2 d-flex flex-column">
                    <div class="accordion" id="accountAccordion">
                        <div 
                            id='transport-list' 
                            class='accordion-item'>
                            <h2 
                                class='accordion-header' 
                                id='account-heading-1'>
                                <button
                                    id="product_list_header" 
                                    class='fs-6 accordion-button collapsed p-2' 
                                    type='button' 
                                    data-bs-toggle='collapse' 
                                    data-bs-target='#account-collapse-1' 
                                    aria-expanded='false' 
                                    aria-controls='account-collapse-1'>
                                    Родитель - каталог
                                </button>
                            </h2>
    
                            <div 
                                id='account-collapse-1' 
                                class='accordion-collapse collapse' 
                                aria-labelledby='account-heading-1'
                                data-bs-parent='#accountAccordion'>
                                <div class='accordion-body p-3 d-flex flex-column'>
                                    @include('admin.includes.contents.catalog_modal_form')
                                </div>
                            </div>
    
                        </div>
                    </div>
                </div>

                <div class="table-items">
                    <div class="table-items-header w-100 border sticky-top" style="background: #FFFFFF; top: -16px;">
                        <div class="header1 w-100 d-flex flex-row justify-content-between p-2 ">
                            <!-- <div class="column-drag"></div> -->
                            <div class="column-check"><input class="form-check-input" type="checkbox" value="" id="table-header-check"></div>
                            <div class="column-articul">Арт.</div>
                            <div class="column-image">Изобр.</div>
                            <div class="column-name">Название</div>
                            <div class="column-price">Цена</div>
                            <div class="column-quantity">Кол-во</div>
                            <!-- <div class="column-order">Порядок</div> -->
                            <div class="column-activity">Актив.</div>
                            <!-- <div class="column-delete"></div> -->
                        </div>
                    </div>
                    <div class="table-items-body w-100 border border-top-0">
                        {{--
                        <div item-id="1" class="table-item w-100 d-flex flex-row justify-content-between p-2" draggable="true">
                            <!-- <div class="column-drag"><img src="/images/drag-button.svg" class="item-drag" draggable="false"></div> -->
                            <div class="column-check"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></div>
                            <div class="column-articul">465001</div>
                            <div class="column-image"><img src="/images/no-photo.svg" style="width: 32px; height:32px;"></div>
                            <div class="column-name">Стул Vivian 1</div>
                            <div class="column-price">6 990 руб</div>
                            <div class="column-quantity">0</div>
                            <!-- <div class="column-order">0</div> -->
                            <div class="column-activity">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked disabled>
                                </div>
                            </div>
                            <!-- <div class="column-delete"><img src="/images/close-button.svg" class="category-card-close"></div> -->
                        </div>

                        <div item-id="2" class="table-item w-100 d-flex flex-row justify-content-between p-2" draggable="true">
                            <!-- <div class="column-drag"><img src="/images/drag-button.svg" class="item-drag" draggable="false"></div> -->
                            <div class="column-check"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></div>
                            <div class="column-articul">465002</div>
                            <div class="column-image"><img src="/images/no-photo.svg" style="width: 32px; height:32px;"></div>
                            <div class="column-name">Стул Vivian 2</div>
                            <div class="column-price">6 490 руб</div>
                            <div class="column-quantity">0</div>
                            <!-- <div class="column-order">0</div> -->
                            <div class="column-activity">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" disabled>
                                </div>
                            </div>
                            <!-- <div class="column-delete"><img src="/images/close-button.svg" class="category-card-close"></div> -->
                        </div>

                        <div item-id="3" class="table-item w-100 d-flex flex-row justify-content-between p-2" draggable="true">
                            <!-- <div class="column-drag"><img src="/images/drag-button.svg" class="item-drag" draggable="false"></div> -->
                            <div class="column-check"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></div>
                            <div class="column-articul">465003</div>
                            <div class="column-image"><img src="/images/no-photo.svg" style="width: 32px; height:32px;"></div>
                            <div class="column-name">Стул Vivian 3</div>
                            <div class="column-price">6 990 руб</div>
                            <div class="column-quantity">0</div>
                            <!-- <div class="column-order">0</div> -->
                            <div class="column-activity">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" disabled>
                                </div>
                            </div>
                            <!-- <div class="column-delete"><img src="/images/close-button.svg" class="category-card-close"></div> -->
                        </div>
                        --}}
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button id="accept-button" type="button" class="btn btn-primary">Добавить</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>
<style>
    #productModal.show {
        z-index: 1000000;
    }

    .modal-backdrop {
        background-color: #FFFFFF00;
    }

    .modal-body input[type="date"] {
        width: 75%;
    }

    .modal-body input[type="time"] {
        width: 24%;
    }

    .modal-body .label {
        width: 25px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
    }

    input[type="date"],
    input[type="time"] {
        border-color: #7F7F7F1F;
        border-radius: 10px;
    }

    input[type="date"]:focus,
    input[type="time"]:focus {
        outline: none;
    }

    #new_account {
        transition : 0.3s;
        opacity: 0.0;
        max-height : 0px;
        overflow-y: hidden;
    }

    #new_account.active {
        opacity: 1.0;
        transition : 0.3s;
    }

    #add_account {
        color : rgba(var(--bs-primary-rgb));
        transition : 0.3s;
        margin-left : auto;
    }

    .del_account {
        color : rgba(var(--bs-danger-rgb));
        transition : 0.3s;
        margin-left : auto;
    }

    #add_account:hover {
        cursor : pointer;
        transform : scale(1.2);
        filter : drop-shadow(0px 0px 2px #00FF00)
    }

    .del_account:hover {
        cursor : pointer;
        transform : scale(1.2);
        filter : drop-shadow(0px 0px 2px #FF0000)
    }


</style>