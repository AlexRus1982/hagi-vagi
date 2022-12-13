function translit(word) {
    var converter = {
        'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd',
        'е': 'e', 'ё': 'e', 'ж': 'zh', 'з': 'z', 'и': 'i',
        'й': 'y', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n',
        'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't',
        'у': 'u', 'ф': 'f', 'х': 'h', 'ц': 'c', 'ч': 'ch',
        'ш': 'sh', 'щ': 'sch', 'ь': '', 'ы': 'y', 'ъ': '',
        'э': 'e', 'ю': 'yu', 'я': 'ya'
    };

    word = word.toLowerCase();

    var answer = '';
    for (var i = 0; i < word.length; ++i) {
        if (converter[word[i]] == undefined) {
            answer += word[i];
        } else {
            answer += converter[word[i]];
        }
    }

    answer = answer.replace(/[^-0-9a-z]/g, '-');
    answer = answer.replace(/[-]+/g, '-');
    answer = answer.replace(/^\-|-$/g, '');
    return answer;
}

class AdminCatalog {

    constructor() {
        console.log(this.constructor.name);
        this.token = $('meta[name="csrf-token"]').attr('content');
        this.MakeCatalog();
        this.MakeKeys();
        messages.Success('Добро пожаловать.');
    }


    MakeCatalogKeys() {

        $('.add-button.add-catalog').off('click');
        $('.add-button.add-catalog').on('click', ()=>{
            $('#catalogModal #category_name').val('');
            
            $('#catalogModal').modal('show');
            
            $('#catalogModal .accordion-body').collapse('hide');

            if (!$('button#catalog_list_header').hasClass('collapsed')){
                $('button#catalog_list_header').trigger('click');
            }

            $('#catalogModal').attr('parent_id', $(`#items-catalog .item-label.selected`).attr('category-id'));
            $('#catalogModal').attr('item_id', $(`#items-catalog .item-label.selected`).attr('item-id'));
            $('#catalogModal').attr('category_id', $(`#category-title`).attr('category-id'));
            $('#catalogModal .list-group .list-group-item').removeClass('active');

            const id = $('#catalogModal').attr('category_id');
            $(`#catalogModal .list-group .list-group-item[category_id="${id}"]`).addClass('active');

            const categoryName = $(`#items-catalog .item-label.selected`).prop('innerHTML');
            const newName = $('#catalog_list_header').prop('innerHTML').split('-')[0] + ' - ' + categoryName.toLowerCase();
            $('#catalog_list_header').prop('innerHTML', newName);

            this.MakeCatalogModalKeys();
        });

        $('.add-button.add-item').off('click');
        $('.add-button.add-item').on('click', ()=>{
            const listItem = $('.item-label.selected');
            console.debug(listItem);
            if (listItem.hasClass('statistics')){
                console.debug('statistics');
            }
            else {
                $('#productModal').modal('toggle');
            
                $('#productModal .accordion-body').collapse('hide');
    
                if (!$('button#catalog_list_header').hasClass('collapsed')){
                    $('button#catalog_list_header').trigger('click');
                }
    
                //*
                $.ajax({
                    url: "/admin/products/short",
                    type : "GET",
                    data: {
                        _token : $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: response => {
                        const list = JSON.parse(response).list;
                        let listHTML = ``;
    
                        for(const item of list){
                            const photos = item['Фото товара'].split(';');
                            let photo = '/images/no-photo.svg';
                            let photoBorder = '';
                            if (photos[0] != ''){
                                let name = photos[0].split('.')[0];
                                let ext = photos[0].split('.')[1];
                                photo = `https://leger.market/pictures/product/small/${name}_small.${ext}`;
                                photoBorder = 'border: 1px solid #0000001F; object-fit: cover;';
                            }
    
                            const active = (item['Включен'] == '+') ? 'checked' : '';
                            listHTML += `
                                <div item-id="${item.id}" class="table-item w-100 d-flex flex-row justify-content-between align-items-center p-2" draggable="false">
                                    <div class="column-check"><input class="form-check-input" type="checkbox" value="" item-id="${item.id}"></div>
                                    <div class="column-articul">${item['Артикул']}</div>
                                    <div class="column-image"><img src="${photo}" style="width: 50px; height:50px; ${photoBorder}"></div>
                                    <div class="column-name flex-grow-1">${item['Наименование']}</div>
                                    <div class="column-price">${item['Цена']} руб</div>
                                    <div class="column-quantity">0</div>
                                    <div class="column-activity">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" ${active} disabled>
                                        </div>
                                    </div>
                                </div>
                            `;
                        }
                        $('#productModal .table-items .table-items-body').empty().append(listHTML);
    
                    },
                    error: (e)=>console.warn('error', e),
                });
                //*/
    
                $('#productModal').attr('parent_id', $('.item-wrapper .item-label.selected').attr('category-id'));
                $('#productModal').attr('category_id', $(`#category-title`).attr('category-id'));
                $('#productModal .list-group .list-group-item').removeClass('active');
    
                const id = $('#productModal').attr('category_id');
                $(`#productModal .list-group .list-group-item[category_id="${id}"]`).addClass('active');
    
                const categoryName = $(`#productModal .list-group .list-group-item[category_id="${id}"]`).prop('innerHTML');
                const newName = $('#product_list_header').prop('innerHTML').split('-')[0] + ' - ' + categoryName.toLowerCase();
                $('#parentCatalog').prop('innerHTML', categoryName.toLowerCase());
                $('#product_list_header').prop('innerHTML', newName);
    
                this.MakeProductModalKeys();
            }
        });

    }

    MakeTableDragKeys() {

        // #region item dragging functions
        $('.table-item').attr('draggable', 'true');

        $('.table-item').off('mousedown');
        $('.table-item').on('mousedown', (event)=>{
            if ($(event.target).hasClass('item-drag')){
                this._itemStartDragg = true;
            }
        });

        $('.table-item').off('dragstart');
        $('.table-item').on('dragstart', (event)=>{
            if (!this._itemStartDragg){
                event.preventDefault();
                return;
            }

            $(event.target).addClass(`dragging`);
        });

        $('.table-item').off('dragend');
        $('.table-item').on('dragend', (event)=>{
            $(event.target).removeClass(`dragging`);
            this._itemStartDragg = false;
            this.UpdateProductsOrders();
        });

        const getItemNextElement = (cursorPosition, currentElement) => {
            const currentElementCoord = currentElement.getBoundingClientRect();
            const currentElementCenter = currentElementCoord.y + currentElementCoord.height / 2;

            const nextElement   = (cursorPosition < currentElementCenter)
                                ? currentElement
                                : currentElement.nextElementSibling;

            return nextElement;
        };

        $('.table-item').off('dragover');
        $('.table-item').on('dragover', (event)=>{
            event.preventDefault();

            const activeElement = $(`.dragging`)[0];
            const currentElement = $(event.target);
            const isMoveable = activeElement !== currentElement && currentElement.hasClass('table-item');
              
            if (!isMoveable) {
              return;
            }

            const nextElement = getItemNextElement(event.clientY, event.target);

            if ((nextElement && activeElement === nextElement.previousElementSibling) || (activeElement === nextElement)) {
                return;
            }
            
            nextElement.before(activeElement);
        });
        // #endregion

    }

    MakeListKeys() {

        const that = this;

        $('.item-wrapper .item-label').off('click');
        $('.item-wrapper .item-label').on('click', function(){
            if ($(`#category-panel`).attr('style') != undefined){
                $(`#category-panel`).attr('style', $(`#category-panel`).attr('style').replace('; display: none!important',''));
            }

            $('.item-label.selected').removeClass('selected');
            $(this).addClass('selected');
            const categeoryId = $(this).attr('category-id');
            that.UpdateWorkPanel(categeoryId);
        });

        $('.item-extender').off('click');
        $('.item-extender').on('click', (event)=>{
            const element = $(event.target);
            if (element.parent().hasClass('item-extender')){
                element.parent().toggleClass('extended');
                const childs = element.parent().parent().next();
                if (childs.hasClass('item-childs')){
                    childs.toggleClass('extended');

                    const exHeight = childs.hasClass('extended') ? `${childs.prop('scrollHeight')}px` : '0px';
                    childs.css('height', exHeight);
                }

                parent = element.parent().parent().parent().parent();
                if (parent.hasClass('item-childs')) {
                    setTimeout(()=>{
                        let summHeight = 0;
                        parent.children().each((index, element)=>{
                            summHeight += $(element).prop('scrollHeight');
                        });

                        const exHeight = parent.hasClass('extended') ? `${summHeight}px` : '0px';
                        parent.css('height', exHeight);
                    }, 500);
                }
            }
        });

    }

    MakePanelKeys() {
        const that = this;

        // #region card dragging functions
        $('.category-card').attr('draggable', 'true');

        $('.category-card').off('mousedown');
        $('.category-card').on('mousedown', (event)=>{
            if ($(event.target).hasClass('category-card-drag')){
                this._cardStartDragg = true;
            }
        });

        $('.category-card').off('dragstart');
        $('.category-card').on('dragstart', (event)=>{
            if (!this._cardStartDragg){
                event.preventDefault();
                return;
            }

            $(event.target).addClass(`dragging`);
        });

        $('.category-card').off('dragend');
        $('.category-card').on('dragend', (event)=>{
            $(event.target).removeClass(`dragging`);
            this._cardStartDragg = false;
            this.UpdateCategoryOrders();
        });

        const getCardNextElement = (cursorPosition, currentElement) => {
            const currentElementCoord = currentElement.getBoundingClientRect();
            const currentElementCenter = currentElementCoord.x + currentElementCoord.width / 2;

            const nextElement   = (cursorPosition < currentElementCenter)
                                ? currentElement
                                : currentElement.nextElementSibling;

            return nextElement;
        };

        $('.category-card').off('dragover');
        $('.category-card').on('dragover', (event)=>{
            event.preventDefault();

            const activeElement = $(`.dragging`)[0];
            const currentElement = $(event.target);
            const isMoveable = activeElement !== currentElement && currentElement.hasClass('category-card');
            
            if (!isMoveable) return;

            // const nextElement = (currentElement === activeElement.nextElementSibling) ?
            // currentElement.nextElementSibling :
            // currentElement;

            const nextElement = getCardNextElement(event.clientY, event.target);

            if ((nextElement && activeElement === nextElement.previousElementSibling) || (activeElement === nextElement)) {
                return;
            }
            
            nextElement.before(activeElement);
        });
        // #endregion

        // #region card keys functions
        $('.category-card-edit').off('click');
        $('.category-card-edit').on('click', (event)=>{
            const categeoryId = $(event.target).attr('category_id');

            $.ajax({
                url: `/admin/category/info/${categeoryId}`,
                type : "POST",
                data: {
                    _token : $('meta[name="csrf-token"]').attr('content'),
                },
                success: response => {
                    const categoryInfo = JSON.parse(response).data[0];

                    $('#catalogModal #category_name').val(categoryInfo.category_name);
        
                    $('#catalogModal').modal('toggle');
                    
                    $('#catalogModal .accordion-body').collapse('hide');
        
                    if (!$('button#catalog_list_header').hasClass('collapsed')){
                        $('button#catalog_list_header').trigger('click');
                    }
        
                    $('#catalogModal').attr('parent_id', categoryInfo.parent_id);
                    $('#catalogModal').attr('category_id', categoryInfo.category_id);
                    $('#catalogModal .list-group .list-group-item').removeClass('active');

                    $('#catalogModal #category_url').val(categoryInfo.url);
                    $('#catalogModal #categoryDescription').val(categoryInfo.description);
        
                    $(`#catalogModal .list-group .list-group-item[category_id="${categoryInfo.parent_id}"]`).addClass('active');
                    $(`#catalogModal .list-group .list-group-item[category_id="${categoryInfo.category_id}"]`).remove();
        
                    $('#catalogModal #activityChecked').prop('checked', categoryInfo.category_active == '1' ? true : false);

                    const categoryName = $(`#catalogModal .list-group .list-group-item.active`).prop('innerHTML');
                    const newName = $('#catalog_list_header').prop('innerHTML').split('-')[0] + ' - ' + categoryName.toLowerCase();
                    $('#catalog_list_header').prop('innerHTML', newName);
        
                    $('#catalogModal .list-group .list-group-item').off('click');
                    $('#catalogModal .list-group .list-group-item').on('click', (event)=>{
                        $('#catalogModal .list-group .list-group-item').removeClass('active');
                        $(event.target).addClass('active');
        
                        const categoryName = $(`#catalogModal .list-group .list-group-item.active`).prop('innerHTML');
                        const newName = $('#catalog_list_header').prop('innerHTML').split('-')[0] + ' - ' + categoryName.toLowerCase();
                        $('#catalog_list_header').prop('innerHTML', newName);
                    });

                    $('#catalogModal #accept-button').off('click');
                    $('#catalogModal #accept-button').on('click', ()=>{
                        $.ajax({
                            url: `/admin/category/save/${categoryInfo.category_id}`,
                            type : "PUT",
                            data: {
                                _token          : $('meta[name="csrf-token"]').attr('content'),
                                parent_id       : $(`#catalogModal .list-group .list-group-item.active`).attr('category_id'), 
                                category_active : $('#catalogModal #activityChecked').prop('checked') ? '1' : '0', 
                                category_name   : $('#catalogModal #category_name').val(),
                                url             : $('#catalogModal #category_url').val(),
                                description     : $('#catalogModal #categoryDescription').val(),
                            },
                            success: response => {
                                $('#catalogModal').modal('toggle');
                                console.debug('Saved', response);
                                this.UpdateList();
                            },
                            error: (e)=>console.warn('error', e),
                        });
            
                    });

                },
                error: (e)=>console.warn('error', e),
            });
            
        });

        $('.category-card-close').off('click');
        $('.category-card-close').on('click', (event)=>{
            const categeoryId = $(event.target).attr('category_id');
            
            if (!confirm('Удалить категорию')) return;


            console.debug('delete - ', categeoryId);

            $.ajax({
                url: `/admin/category/delete/${categeoryId}`,
                type : "DELETE",
                data: {
                    _token : $('meta[name="csrf-token"]').attr('content'),
                },
                success: response => {
                    this.UpdateList();
                },
                error: (e)=>console.warn('error', e),
            });
            
        });

        $('.category-card-image').off('click');
        $('.category-card-image').on('click', function() {

            const currentCategory = $(`.item-wrapper .item-label.selected`);
            const extender = currentCategory.parent().find('.item-extender');
            const childs = currentCategory.parent().next();

            if (!extender.hasClass('extended')){
                extender.addClass('extended');
                childs.addClass('extended');
                const exHeight = `${childs.prop('scrollHeight')}px`;
                childs.css('height', exHeight);
            }

            const categoryId = $(this).parent().attr('category_id');
            console.debug(childs, categoryId);
            
            $('.item-wrapper .item-label').removeClass('selected');
            $(`.item-wrapper .item-label[category-id="${categoryId}"`).addClass('selected');

            that.UpdateWorkPanel(categoryId);
        });
        // #endregion

        // #region products keys functions
        $('.item-card-close').off('click');
        $('.item-card-close').on('click', (event)=>{
            if (confirm('Удалить товар из категории ?')){
                const itemId = $(event.target).attr('item-id');
                const categoryId = $(event.target).attr('category-id');
                $.ajax({
                    url: `/admin/product/category/delete`,
                    type : "DELETE",
                    data: {
                        _token : $('meta[name="csrf-token"]').attr('content'),
                        parent_id : categoryId,
                        product_id : itemId,
                    },
                    success: response => {
                        this.UpdateList(false);
                        $(event.target).parent().parent().remove();
                        console.debug(`Товар с id - ${itemId} удален из категории с id - ${categoryId}`);
                    },
                    error: (e)=>console.warn('error', e),
                });
            }
        });

        $('.table-item .column-name').off('click');
        $('.table-item .column-name').on('click', (event)=>{
            const itemId = $(event.target).parent().attr('item-id');
            $('.base-data').val('');
            $('#productEdit').offcanvas('show');
            $('#productEdit').attr('item-id', itemId);

            $.ajax({
                url: `/admin/products/info/${itemId}`,
                type : "GET",
                data: { _token : $('meta[name="csrf-token"]').attr('content'), },
                success: response => {
                    const item = JSON.parse(response).data[0];
                    $('#productEdit #productName').prop('innerHTML', item['Наименование']);

                    console.debug(`Товар с id - ${itemId}`, item);
                    $('#productEdit .base-data').each((index, element) => {
                        const nodeName = $(element).prop('nodeName');
                        const bdColumn = $(element).attr('bd-column');
                        const elementType = $(element).attr('type');
                        if (elementType == "text"){
                            $(element).val(item[`${bdColumn}`]);
                        }
                        if (elementType == "checkbox"){
                            $(element).prop('checked', (item[`${bdColumn}`] == "+") ? true : false);
                        }
                        if (nodeName == "TEXTAREA") {
                            if ($(element).val() != ""){
                                $(element).css('height', $(element).prop('scrollHeight') + 5);
                            }
                            else {
                                $(element).css('height', '38');
                            }
                        }
                    });

                    $('#accordionImages .gallery').empty();
                    const photos = item['Фото товара'].split(';');
                    for(const photo of photos){
                        const photoName = photo.split('.')[0];
                        const photoExt = photo.split('.')[1];
                        const photoURL = `https://leger.market/pictures/product/small/${photoName}_small.${photoExt}`;
                        $('#accordionImages .gallery').append(`
                            <img src="${photoURL}" class="img-thumbnail shadow m-2" draggable="true" style="width: 150px; height: 150px;"/>
                        `);
                    }
                },
                error: (e)=>console.warn('error', e),
            });
        });

        $('#panel-table-items-header-check').off('input');
        $('#panel-table-items-header-check').on('input', function(){
            const headerCheck = $('#panel-table-items-header-check').prop('checked');

            $('#header-menu-check').css('display', headerCheck ? 'block' : 'none');
            $('.header-main-content').css('display', headerCheck ? 'none' : 'block');

            const checkedList = $('#product-panel .table-items-body .column-check input');
            checkedList.each((index, element)=>{
                const productId = $(element).parent().parent().attr('item-id');
                if (productId != undefined){
                    $(element).prop('checked', headerCheck);
                }
            });
        });

        $('#product-panel .table-items-body input').off('input');
        $('#product-panel .table-items-body input').on('input', function(){
            const check = ($(`#product-panel .column-check input:checked`).length > 0);

            $('#header-menu-check').css('display', check ? 'block' : 'none');
            $('.header-main-content').css('display', check ? 'none' : 'block');
        });

        $('#del-all-from-catalog').off('click');
        $('#del-all-from-catalog').on('click', ()=>{
            const parentId = $('#items-catalog .item-label.selected').attr('category-id');
            const checkedList = $('#product-panel .table-items-body .column-check input:checked');

            const checkedArray = [];
            checkedList.each((index, element)=>{
                const productId = $(element).parent().parent().attr('item-id');
                if (productId != undefined){
                    checkedArray.push({ parent_id : parentId, product_id : productId });
                }
            });

            console.debug(`Delete from ${parentId}`, checkedArray);
            $.ajax({
                url: `/admin/products/category/delete`,
                type : "DELETE",
                data: {
                    _token : $('meta[name="csrf-token"]').attr('content'),
                    checkedArray : checkedArray,
                },
                success: response => {
                    this.UpdateList();
                },
                error: (e)=>console.warn('error', e),
            });
        });

        // #endregion

        $('#category-go-link').off('click');
        $('#category-go-link').on('click', function() {
            const link = $(this).attr('link');
            window.open(link);
        });


        $('#catalogModal .link').off('click');
        $('#catalogModal .link').on('click', function() {
            const link = $(this).parent().parent().find('input').val();
            window.open(`/products/${link}`);
        });

    }

    MakeCatalogModalKeys() {
        //#region catalogModal functions
        $('#catalogModal .translate').off('click');
        $('#catalogModal .translate').on('click', () => {
            const categoryName = $('#category_name').val();
            if (categoryName != ''){
                const url = translit(categoryName);
                $('#category_url').val(url);
            }
        });

        $('#catalogModal .list-group .list-group-item').off('click');
        $('#catalogModal .list-group .list-group-item').on('click', (event)=>{
            $('#catalogModal .list-group .list-group-item').removeClass('active');
            $(event.target).addClass('active');

            const categoryName = $(`#catalogModal .list-group .list-group-item.active`).prop('innerHTML');
            const newName = $('#catalog_list_header').prop('innerHTML').split('-')[0] + ' - ' + categoryName.toLowerCase();
            $('#catalog_list_header').prop('innerHTML', newName);
        });

        $('#catalogModal #accept-button').off('click');
        $('#catalogModal #accept-button').on('click', ()=>{
            const categoryName = $('#catalogModal #category_name').val();
            const categoryParent = $(`#catalogModal .list-group .list-group-item.active`).attr('category_id');

            $.ajax({
                url: "/admin/categories/new",
                type : "POST",
                data: {
                    _token          : $('meta[name="csrf-token"]').attr('content'),
                    parent_id       : categoryParent, 
                    category_active : $('#catalogModal #activityChecked').prop('checked') ? '1' : '0', 
                    category_name   : categoryName,
                    url             : $('#catalogModal #category_url').val(),
                    description     : $('#catalogModal #categoryDescription').val(),
                },
                success: response => {
                    const id = JSON.parse(response).id;
                    $('#catalogModal').modal('toggle');
                    
                    const itemHTML = `
                        <div class="item-wrapper category-item d-flex flex-column">
                            <div class="item-name-wrapper d-flex flex-row">
                                <div category-id="${id}" class="item-label">${categoryName}</div><div class="item-counter ms-auto me-2">7/8</div>
                                <div class="item-extender"><img src="/images/caret-down.svg"></div>
                            </div>
                            <div parent-id="${id}" class="item-childs d-flex flex-column justify-content-start ps-3"></div>
                        </div>
                    `;

                    $(`div[parent-id="${categoryParent}"]`).append(itemHTML);
                    $('.item-childs:empty').parent().find('.item-counter').removeClass('me-2').addClass('me-4');
                    $('.item-childs:empty').parent().find('.item-extender').css('display', 'none');
        
                    this.UpdateList();
                    console.debug('Created', response);
                },
                error: (e)=>console.warn('error', e),
            });

        });
        //#endregion
    }

    MakeProductModalKeys() {
        //#region productModal functions
        $('#productModal .list-group .list-group-item').off('click');
        $('#productModal .list-group .list-group-item').on('click', (event)=>{
            $('#productModal .list-group .list-group-item').removeClass('active');
            $(event.target).addClass('active');

            const categoryName = $(`#items-catalog .item-label.selected`).prop('innerHTML');
            const newName = $('#product_list_header').prop('innerHTML').split('-')[0] + ' - ' + categoryName.toLowerCase();
            $('#product_list_header').prop('innerHTML', newName);
            $('#parentCatalog').prop('innerHTML', categoryName.toLowerCase());
        });

        $('#productModal #accept-button').off('click');
        $('#productModal #accept-button').on('click', ()=>{
            const categoryParent = $(`#productModal .list-group .list-group-item.active`).attr('category_id');
            console.debug('accept', categoryParent);

            const checkedList = $('.column-check input[item-id]:checked');

            let list = [];
            checkedList.each((index, element)=>{
                const productId = $(element).attr('item-id');
                if (productId != undefined){
                    list.push([categoryParent, productId]);
                }
            });

            console.debug(list);

            $.ajax({
                url: "/admin/products/add",
                type : "PUT",
                data: {
                    _token : $('meta[name="csrf-token"]').attr('content'),
                    products : list, 
                },
                success: response => {
                    // console.debug(response);
                    this.UpdateList();
                    $('#productModal').modal('toggle');
                },
                error: (e)=>console.warn('error', e),
            });
        });

        $('#productModal #table-header-check').off('input');
        $('#productModal #table-header-check').on('input', ()=>{
            const headerCheck = $(`#productModal #table-header-check`).prop('checked');
            console.debug(headerCheck);
            const checkedList = $('#productModal .column-check input[item-id]');
            checkedList.each((index, element)=>{
                const productId = $(element).attr('item-id');
                if (productId != undefined){
                    $(element).prop('checked', headerCheck);
                }
            });
        });

        $('#productEdit .link').off('click');
        $('#productEdit .link').on('click', function() {
            const link = $(this).parent().parent().find('input').val();
            window.open(`/product/${link}`);
        });

        $('#productEdit .translate').off('click');
        $('#productEdit .translate').on('click', () => {
            const categoryName = $('#product_name').val();
            if (categoryName != ''){
                const url = translit(categoryName);
                $('#product_url').val(url);
            }
        });

        $('#productEdit #product-save-button').off('click');
        $('#productEdit #product-save-button').on('click', () => {
            const itemId = $('#productEdit').attr('item-id');
            console.debug(itemId);
            
            const savedData = new Map();
            $('#productEdit .base-data').each((index, element) => {
                const nodeName = $(element).prop('nodeName');
                const bdColumn = $(element).attr('bd-column');
                const elementType = $(element).attr('type');

                if (elementType == "text"){
                    savedData.set(`${bdColumn}`, $(element).val());
                }
                if (elementType == "checkbox"){
                    savedData.set(`${bdColumn}`, $(element).prop('checked') ? '+' : '-');
                }
            });

            $.ajax({
                url: `/admin/products/save/${itemId}`,
                type : "PUT",
                data: { 
                    _token : $('meta[name="csrf-token"]').attr('content'), 
                    savedData : Array.from(savedData),
                },
                success: response => {
                    console.debug(JSON.parse(response));
                    messages.Success('Данные сохранены успешно.');
                    $('#productEdit').offcanvas('hide');
                    this.UpdateWorkPanel();
                },
                error: (e)=>{ 
                    console.warn('error', e)
                    messages.Danger('Ошибка сохранения данных.');
                },
            });
        });

        //#endregion
    }

    MakeModalKeys() {
        this.MakeCatalogModalKeys();
        this.MakeProductModalKeys();
    }

    MakeStatisticKeys() {
        $('.item-label.statistic-1').on('click', () => {
            $('.item-label.selected').removeClass('selected');
            $('.item-label.statistic-1').addClass('selected');
            console.debug('Все товары');
            $.ajax({
                url: "/admin/products/list?page=1",
                type : "GET",
                data: {},
                success: response => {
                    console.debug(response);
                    const items = response.data;
                    $(`#category-panel`).attr('style', $(`#category-panel`).attr('style') + '; ' + 'display: none!important');

                    let itemsHTML = ``;
                    if (items.length > 0){
                        for(const item of items){
                            const photos = item['Фото товара'].split(';');
                            let photo = '/images/no-photo.svg';
                            let photoBorder = '';
                            if (photos[0] != ''){
                                let name = photos[0].split('.')[0];
                                let ext = photos[0].split('.')[1];
                                photo = `https://leger.market/pictures/product/small/${name}_small.${ext}`;
                                photoBorder = 'border: 1px solid #0000001F; object-fit: cover;';
                            }
        
                            const active = (item['Включен'] == '+') ? 'checked' : '';
        
                            itemsHTML += `
                                <div item-id="${item.id}" class="table-item w-100 d-flex flex-row align-items-center p-2" draggable="true">
                                    <div class="column-drag"><img src="/images/drag-button.svg" class="item-drag" draggable="false"></div>
                                    <div class="column-check"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></div>
                                    <div class="column-articul" title="${item['Артикул']}">${item['Артикул']}</div>
                                    <div class="column-image"><img src="${photo}" style="width: 50px; height:50px; ${photoBorder}"></div>
                                    <div class="column-name flex-grow-1" title="${item['Наименование']}">${item['Наименование']}1</div>
                                    <div class="column-price">${item['Цена']} руб</div>
                                    <div class="column-quantity">0</div>
                                    <div class="column-order">0</div>
                                    <div class="column-activity">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" ${active}>
                                        </div>
                                    </div>
                                    <div class="column-delete"><img item-id="${item.id}" src="/images/close-button.svg" class="item-card-close"></div>
                                </div>
                            `;
                        }
                        $(`#product-panel .table-items-body`).empty().append(itemsHTML);
                        $(`#product-panel .area-contnet`).show();
                        $('.column-drag').hide();
                        $('.column-check').hide();
                        $('.column-order').hide();
                        this.MakePanelKeys();
                    }
                    else {
                        $(`#product-panel .area-contnet`).hide();
                    }
                },
                error: (e)=>console.warn('error', e),
            });

        });

        $('.item-label.statistic-2').on('click', () => {
            console.debug('Товары без категории');
        });
    }

    MakeKeys() {
        this.MakeCatalogKeys();
        this.MakeTableDragKeys();
        this.MakeModalKeys();
        this.MakeStatisticKeys();
    }

    UpdateList(updateWorkPanel = true) {
        const extendedItems = $('.item-extender.extended');

        let currentCategory = 0;
        const selectedItem = $('#items-catalog .item-label.selected');
        if (selectedItem.length > 0) {
            currentCategory = selectedItem.attr('category-id');
        }

        const categoriesList = ()=>$.post({
            url: "../admin/categories",
            data: { '_token' : this.token, },
            success: (response)=>{
                try { 
                    makeList(JSON.parse(response).data); 
                }
                catch(e) {
                    console.warn('Пришел не JSON', e, response);
                }
            },
            error: (e)=>console.warn('error', e),
        });
        categoriesList();

        const makeList = list => {
            const that = this;

            let itemsHTML = ``;
            for(const category of list){
                itemsHTML += `
                    <div parent-id="${category.parent_id}" class="item-wrapper category-item d-flex flex-column">
                        <div class="item-name-wrapper d-flex flex-row">
                            <div category-id="${category.category_id}" class="item-label">${category.category_name}</div><div class="item-counter ms-auto me-2">7/8</div>
                            <div category-id="${category.category_id}" class="item-extender"><img src="/images/caret-down.svg"></div>
                        </div>
                        <div parent-id="${category.category_id}" class="item-childs d-flex flex-column justify-content-start ps-3"></div>
                    </div>
                `;
            }
            $('.main-childs').empty().append(itemsHTML);

            $('.item-wrapper').each((index, element) => {
                const parentId = $(element).attr('parent-id');
                $(`.item-childs[parent-id="${parentId}"]`).append($(element));
            });

            this.MakeListKeys();
            $(`#items-catalog .item-label[category-id="${currentCategory}"]`).addClass('selected');
            $('.item-childs:empty').parent().find('.item-counter').removeClass('me-2').addClass('me-4');
            $('.item-childs:empty').parent().find('.item-extender').css('display', 'none');

            if (updateWorkPanel){
                this.UpdateWorkPanel(currentCategory);
            }
        
            extendedItems.each((index, element)=>{
                const categeoryId = $(element).attr('category-id');
                $(`.item-extender[category-id="${categeoryId}"]`).addClass('extended');
                const childs = $(`.item-childs[parent-id="${categeoryId}"]`).addClass('extended');                
                const exHeight = childs.hasClass('extended') ? `${childs.prop('scrollHeight')}px` : '0px';
                childs.css('height', exHeight);
            });
        }
    }

    UpdateWorkPanel(categoryId = 0) {
        const selectedItem = $('.item-wrapper .item-label.selected');

        const subCategoriesList = ()=>$.ajax({
            url: `../admin/category/parent/${selectedItem.attr('category-id')}`,
            type : "POST",
            data: { '_token' : this.token, },
            success: (response)=>{
                try {
                    const subList = JSON.parse(response).data;
                    const mainCategory = JSON.parse(response).category;
                    let itemsHTML = ``;
                    for(const subCategory of subList){
                        const activity = (subCategory.category_active == '0') ? ' filter:grayscale(1);' : '';
                        itemsHTML += `
                            <div category_id="${subCategory.category_id}" class="category-card d-flex flex-column align-items-center border p-1 m-2" style="width: 200px;${activity}" draggable="true">
                                <div class="category-card-header d-flex flex-row p-1 w-100">
                                    <img category_id="${subCategory.category_id}" src="/images/drag-button.svg" class="category-card-drag" draggable="false">
                                    <img category_id="${subCategory.category_id}" src="/images/edit-button.svg" class="category-card-edit ms-auto me-2">
                                    <img category_id="${subCategory.category_id}" src="/images/close-button.svg" class="category-card-close">
                                </div>
                                <div class="category-card-image d-flex flex-row p-1 justify-content-center align-items-center" style="height:150px; width:150px;">
                                    <img src="/images/no-photo.svg" style="width: 50px; height:50px;">
                                </div>
                                <div class="category-card-label d-flex flex-row w-100 p-1">
                                    <input category_id="${subCategory.category_id}" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label ms-2" for="flexCheckDefault">${subCategory.category_name}</label>
                                </div>
                            </div>
                        `;
                    }
                    $(`.area-content`).empty().append(itemsHTML);
                    $(`#category-title`).empty().append($('.item-wrapper .item-label.selected')[0].innerHTML);
                    $(`#category-title`).attr('category-id', categoryId);

                    let categoryURL = "/products";
                    if (mainCategory.length > 0){
                        categoryURL = `/products/${mainCategory[0].url}`;
                    }

                    $('#category-go-link').attr('link', categoryURL);

                    itemsList();
                }
                catch(e) {
                    console.warn('Пришел не JSON', e, response);
                }
            },
            error: (e)=>console.warn('error', e),
        });

        const itemsList = ()=>$.ajax({
            url: `/admin/products/parent/${selectedItem.attr('category-id')}`,
            type : "GET",
            data: { '_token' : this.token, },
            success: (response)=>{
                const items = JSON.parse(response).list;
                // console.debug(items);
                //*
                let itemsHTML = ``;
                const categoryId = selectedItem.attr('category-id');
                if (items.length > 0){
                    for(const item of items){
                        const photos = item['Фото товара'].split(';');
                        let photo = '/images/no-photo.svg';
                        let photoBorder = '';
                        if (photos[0] != ''){
                            let name = photos[0].split('.')[0];
                            let ext = photos[0].split('.')[1];
                            photo = `https://leger.market/pictures/product/small/${name}_small.${ext}`;
                            photoBorder = 'border: 1px solid #0000001F; object-fit: cover;';
                        }
    
                        const active = (item['Включен'] == '+') ? 'checked' : '';
    
                        itemsHTML += `
                            <div item-id="${item.product_id}" class="table-item w-100 d-flex flex-row align-items-center p-2" draggable="true">
                                <div class="column-drag"><img src="/images/drag-button.svg" class="item-drag" draggable="false"></div>
                                <div class="column-check"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></div>
                                <div class="column-articul" title="${item['Артикул']}">${item['Артикул']}</div>
                                <div class="column-image"><img src="${photo}" style="width: 50px; height:50px; ${photoBorder}"></div>
                                <div class="column-name flex-grow-1" title="${item['Наименование']}">${item['Наименование']}1</div>
                                <div class="column-price">${item['Цена']} руб</div>
                                <div class="column-quantity">0</div>
                                <div class="column-order">0</div>
                                <div class="column-activity">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" ${active}>
                                    </div>
                                </div>
                                <div class="column-delete"><img item-id="${item.product_id}" category-id=${categoryId} src="/images/close-button.svg" class="item-card-close"></div>
                            </div>
                        `;
                    }
                    $(`#product-panel .table-items-body`).empty().append(itemsHTML);
                    $(`#product-panel .area-contnet`).show();
                }
                else {
                    $(`#product-panel .area-contnet`).hide();
                }
                //*/
                this.MakePanelKeys();
                this.MakeTableDragKeys();
            },
            error: (e)=>console.warn('error', e),
        });

        subCategoriesList();
        $(`#panel-table-items-header-check`).prop('checked', false);
        $('#header-menu-check').css('display', 'none');
        $('.header-main-content').css('display', 'block');

    }

    MakeCatalog() {
        this.UpdateList();
    }

    UpdateCategoryOrders() {
        const orders = [];
        $('.category-card').each((index, element) => {
            const id = $(element).attr('category_id');
            orders.push({id : id, index : index});
        });

        $.ajax({
            url: "/admin/categories/orders",
            type : "PUT",
            data: { orders : orders, },
            success: response => {
                this.UpdateList(false);
            },
            error: (e)=>console.warn('error', e),
        });
    }

    UpdateProductsOrders() {
        const orders = [];
        $('.table-item').each((index, element) => {
            const id = $(element).attr('item-id');
            orders.push({id : id, index : index});
        });

        $.ajax({
            url: "/admin/products/orders",
            type : "PUT",
            data: { orders : orders, },
            success: response => {
                // this.UpdateList(false);
            },
            error: (e)=>console.warn('error', e),
        });
    }

}

class AdminPanel {

    _cardStartDragg = false;
    _itemStartDragg = false;

    constructor() {
        console.log(this.constructor.name);
        this.token = $('meta[name="csrf-token"]').attr('content');

        this.CheckVisible();
        this.MakeTextEditor();

        this.LoadOrders();
        this.MakeKeys();
        
        new AdminCatalog();

        // #region test

        // const categoriesList = ()=>$.post({
        //     url: "../admin/category/parent/0",
        //     data: { '_token' : this.token, },
        //     success: (response)=>{
        //         try { 
        //             console.info(JSON.parse(response).data); 
        //         }
        //         catch(e) {
        //             console.warn('Пришел не JSON', e, response);
        //         }
        //     },
        //     error: (e)=>console.warn('error', e),
        // });
        // categoriesList();

        // console.debug($.fn.jquery);
        // const token = $('meta[name="csrf-token"]').attr('content');
        // const listener = ()=>$.post({
        //     url: "../test/get",
        //     data: {
        //         '_token'   : token,
        //         'email'    : '123',
        //         'password' : '123',
        //     },
        //     success: (response)=>{
        //         try {
        //             const json = JSON.parse(response);
        //             console.debug(json['server_answer']);
        //         }
        //         catch(e) {console.warn('Пришел не JSON', e, response);}
        //     },
        //     error: (e)=>console.warn('error', e),
        //     complete: ()=>{
        //         // setTimeout(()=>{
        //         //     listener();
        //         // }, 1000);
        //     },
        // });
        // listener();
        // #endregion

        $('button[role="tab"]').each((index, triggerEl) => {
            const tabTrigger = new bootstrap.Tab(triggerEl);
            // console.debug(triggerEl);
        });

        $.ajax({
            url     : "/admin/condition/activetab",
            type    : "GET",
            data    : {},
            success : response => {
                const activeTab = JSON.parse(response).activeTab;
                if (activeTab != '') {
                    const triggerTab = $(`#${activeTab}`);
                    bootstrap.Tab.getInstance(triggerTab).show()
                }
            },
            error   : e => console.debug("Ошибка", e)
        });

    }

    CheckVisible() {
        const page = $("#services-pages-select").val();
        if (page == "-1") {
            $(".categories").css("display", "none");
        } else {
            $(".categories").css("display", "block");
        }
    }

    MakeKeys() {

        $("#services-pages-select").on("change", () => {
            console.log(
                "selection changed !!!",
                $("#services-pages-select").val()
            );

            const page = $("#services-pages-select").val();
            const editor = $(`.categories .nicEdit-main`);
            editor[0].innerHTML = "";

            this.CheckVisible();

            if (page == "-1") return;

            try {
                window.query.Post(
                    `api/services/pagecontent/${page}`,
                    { token: window.api_token /* "zone_id" : "63465",*/ },
                    (data) => {
                        // console.info(data);
                        editor[0].innerHTML = data;
                    },
                    false
                );
            } catch (e) {
                console.warn(e);
            }
        });

        $(".textEditorShow").on("click", () => {
            const page = $("#services-pages-select").val();
            if (page != "-1") {
                window.open(`service/${page}`, "_blank");
            }
        });

        $(".textEditorSave").on("click", () => {
            const page = $("#services-pages-select").val();
            const editor = $(`.categories .nicEdit-main`);
            if (page != "-1") {
                try {
                    window.query.Post(
                        `api/services/pagecontent/${page}/save`,
                        {
                            token: window.api_token,
                            content: editor[0].innerHTML,
                        },
                        (data) => {
                            console.info(data);
                        },
                        false
                    );
                } catch (e) {
                    console.warn(e);
                }
            }
        });

        $("#nav-orders-logs").on("click", (event) => {
            // alert('Pressed', event.target);
            const nodeName = $(event.target)[0].nodeName;

            let expandElement = null;
            let arrowElement = null;
            switch (nodeName) {
                case "IMG":
                    if ($(event.target).parent().hasClass('expand-button')){
                        expandElement = $(event.target).parent().parent().parent().find('.item-row-expand');
                        arrowElement = $(event.target).parent();
                    }
                    break;
                case "DIV":
                    if ($(event.target).hasClass('expand-button')){
                        expandElement = $(event.target).parent().parent().find('.item-row-expand');
                        arrowElement = $(event.target);
                    }
                    break;
                default:
                    break;
            }
            if (expandElement == null) return;

            arrowElement.toggleClass('active');
            if (arrowElement.hasClass('active')){
              const expandHeight = expandElement.prop("scrollHeight");
              expandElement.css('height', `${expandHeight}px`);
              expandElement.css('opacity', '1');
            }
            else {
              expandElement.css('height', '0');
              expandElement.css('opacity', '0');
            }
      
        });

        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', event => {
            // event.target; // newly activated tab
            // event.relatedTarget; // previous active tab
            // console.debug('changed', $(event.target).attr('id'), $(event.relatedTarget).attr('id'));
            $.ajax({
                url     : "/admin/condition/activetab",
                type    : "PUT",
                data    : { activeTab :  $(event.target).attr('id') },
                success : response => {},
                error   : e => console.debug("Ошибка", e)
            });
        });

    }

    MakeTextEditor() {
        bkLib.onDomLoaded(function () {
            new nicEditor({ fullPanel: true }).panelInstance(
                "textEditArea-categories"
            );
            $(".nicEdit-panelContain").parent().width("auto");
            $(".nicEdit-panelContain").parent().next().width("auto");
            $(".nicEdit-main").width("auto");
            $(".nicEdit-main").height("auto");
            $(".nicEdit-main").css("min-height", "600px");
            $(".nicEdit-main").css("padding", "10px");
        });
    }

    LoadOrders() {
        try {
            window.query.Post(
                "/api/orders",
                {
                    token: window.api_token,
                },
                (data) => {
                    const orders = JSON.parse(data);
                    // console.table(orders);

                    const maxOrders = orders.length;
                    let expandCounter = 0;

                    const loadExpand = () => {
                        if (expandCounter >= maxOrders) return;
                        const order = orders[expandCounter++];
                    
                        const itemElement = $(
                            `.item-row-expand-${order.id}`
                        );

                        // console.info(order);

                        try {
                            window.query.Post(
                                `api/order/products`,
                                { token: window.api_token, order_hash : order.order_hash, },
                                (data) => {

                                    let productsList = JSON.parse(data);
                                    
                                    if (productsList.length > 0) {
                                        let content = `<table class="orders-table" cellspacing="0">`;

                                        let fullSumm = 0;

                                        content += `<tr><th>Наименование</th><th>Количество</th><th>Общая стоимость</th><tr>`;

                                        for(const product of productsList){
                                            content += `<tr>`;
                                            const summ = parseInt(product['quantity']) * parseInt(product['Цена']);
                                            fullSumm += summ;
                                            content += `<td>${product['Наименование']}</td><td>${product['quantity']} шт.</td><td>${summ} руб</td>`;
                                            content += `</tr>`;
                                        }

                                        content += `</table>`;
                                        content += `<div class="summery">Всего на сумму: ${fullSumm} руб</div>`;

                                        itemElement.append(content);
                                    }
                                },
                                false
                            );
                        } catch (e) {
                            console.warn(e);
                        }
                        setTimeout(()=>{loadExpand()}, 100);
                    };
                    loadExpand();
                },
                false
            );
        } catch (e) {
            console.warn(e);
        }
    }

}

new AdminPanel();
