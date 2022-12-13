<div 
    class="modal fade" 
    id="catalogModal"
    parent_id="" 
    data-bs-keyboard="false" 
    tabindex="-1" 
    aria-labelledby="catalogModalLabel" 
    aria-hidden="true" 
    style="background: #FFFFFF00; backdrop-filter: blur(8px) grayscale(1.0);">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow">
            <div class="modal-header bg-primary bg-gradient text-white">
                <h1 class="modal-title fs-5" id="catalogModalLabel">Категория</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="w-100 p-2 d-flex flex-column">
                    <div class="mb-3">
                        <!-- <label class="form-label ps-1">Название</label> -->
                        <input type="text" class="form-control" id="category_name" placeholder="Название категории">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            <svg class="translate" width="24" height="24" fill="currentColor" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="TranslateTwoToneIcon" tabindex="-1" title="TranslateTwoTone">
                                <path d="m12.87 15.07-2.54-2.51.03-.03c1.74-1.94 2.98-4.17 3.71-6.53H17V4h-7V2H8v2H1v1.99h11.17C11.5 7.92 10.44 9.75 9 11.35 8.07 10.32 7.3 9.19 6.69 8h-2c.73 1.63 1.73 3.17 2.98 4.56l-5.09 5.02L4 19l5-5 3.11 3.11.76-2.04zM18.5 10h-2L12 22h2l1.12-3h4.75L21 22h2l-4.5-12zm-2.62 7 1.62-4.33L19.12 17h-3.24z"></path>
                            </svg>
                        </span>
                        <input type="text" class="form-control" id="category_url" placeholder="Чпу" aria-label="Amount (to the nearest dollar)">
                        <span class="input-group-text">
                            <svg class="link" width="24" height="24" fill="currentColor" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="ReplyAllTwoToneIcon" tabindex="-1" title="ReplyAllTwoTone">
                                <path d="M7 8V5l-7 7 7 7v-3l-4-4 4-4zm6 1V5l-7 7 7 7v-4.1c5 0 8.5 1.6 11 5.1-1-5-4-10-11-11z"></path>
                            </svg>
                        </span>
                    </div>
                    <style>
                        .input-group-text .translate,
                        .input-group-text .link {
                            transition: 0.3s;
                            color: var(--bs-primary);
                        }

                        .input-group-text:hover {
                            cursor: pointer;
                        }

                        .input-group-text:hover .translate {
                            transform: scale(1.3);
                            filter: drop-shadow(0px 0px 2px #0000007F);
                        }

                        .input-group-text .link {
                            transform: scale(1.0) scaleX(-1.0);
                        }

                        .input-group-text:hover .link {
                            transform: scale(1.3) scaleX(-1.0);
                            filter: drop-shadow(0px 0px 2px #0000007F);
                        }
                    </style>

                    <div class='form-check form-switch form-check-reverse ms-auto mb-3'>
                        <label class='form-check-label' for='activityChecked'>Активность</label>
                        <input category_id='' class='form-check-input' type='checkbox' role='switch' id='activityChecked' checked>
                    </div>
                    <div class="accordion" id="accountAccordion">
                        <div 
                            id='transport-list' 
                            class='accordion-item'>
                            <h2 
                                class='accordion-header' 
                                id='account-heading-1'>
                                <button
                                    id="catalog_list_header" 
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

                    <div class="form-floating my-3">
                        <textarea class="form-control" placeholder="Leave a comment here" id="categoryDescription" style="height: 100px; min-height:100px;"></textarea>
                        <label for="categoryDescription">Описание</label>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button id="accept-button" type="button" class="btn btn-primary">Сохранить</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>
<style>
    #catalogModal.show {
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