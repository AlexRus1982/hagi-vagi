class ProductsScript {

    constructor(){
        console.log(this.constructor.name);
        this.MakeKeys();
    }

    MakeKeys(){
        $('tbody').off('click');
        $('tbody').click(event => {
            const tableLine = $(event.target).parent();
            const url = tableLine.attr('link');
            window.open(url, '_blank').focus();
        });

        $('.basketButton').off('click');
        $('.basketButton').on('click', function(event){
            const item_id = $(this).attr('item_id');
            basket.AddItem(item_id);

            event.stopPropagation();
            event.preventDefault();
        });

        $('.wishButton').off('click');
        $('.wishButton').on('click', function(event){
            const item_id = $(this).attr('item_id');
            // basket.AddItem(item_id);
            // alert(`${item_id} - wish`);

            $(this).toggleClass('wishset');

            event.stopPropagation();
            event.preventDefault();
        });
    }

}

new ProductsScript();