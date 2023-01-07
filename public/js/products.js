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
    }

}

new ProductsScript();