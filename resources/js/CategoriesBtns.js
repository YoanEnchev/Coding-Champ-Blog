let CategoriesBtns = {
    'init': function() {
        $('.categories-btns button').click(function() {
            $(this).closest('.categories-btns').find('button').removeClass('active');
            $(this).addClass('active');
        });
    
    }
}

export default CategoriesBtns;