function bindSlideDownEvent()
{
    $('.category-edit__title').on('click',function(event)
    {
        console.log(event.target);
        inEdit=['path','svg','.category-edit__icon_edit']
        if(inEdit.indexOf(event.target.nodeName)<0)
        {
          $(this).parent('.category-edit').toggleClass('category-edit_expanded');  
        }
        
    });
}

function unbindSlideDownEvent()
{
    $('.category-edit__title').off('click');
}

$(function()
{
            $('.switch').click(function()
        {
           $(this).siblings('input:not(:checked)').trigger('click');
        });
    
    
    bindSlideDownEvent();
    $('.categories-sort').sortable({revert: "true",scroll:false,connectWith:'.categories-sort',placeholder: "category-edit__sort-placeholder"});
    $('.categories-sort').disableSelection();
    
    $('.categories-sort').on('sortstart',function(event,ui)
    {
        unbindSlideDownEvent();
    });
    
    $('.categories-sort').on('sortstop',function(event,ui)
    {
        let order={};
        $('.categories-sort').each(function()
        {
            let idParent=$(this).data('id-parent');
            order[idParent]=[];
            console.log(order);
            $(this).children('.category-edit').each(function()
            {
                let idCategory=$(this).data('id');
                order[idParent].push(idCategory);
            });
        });
        let orderForm=$('<form></form>');
        orderForm.addClass('d-none');
        orderForm.addClass('ajax');
        orderForm.attr('method','post');
        orderForm.attr('action','/admin/ajax/reorderCategories');
        
        let orderInput=$('<input name="categoryList" type="text"></input>');
        orderInput.val(JSON.stringify(order));
        
        orderForm.append(orderInput);
        
        $('body').append(orderForm);
        orderForm.submit();
        
        bindSlideDownEvent();
        
    });
    /*$('.category-edit').draggable(
    {
        connectToSortable: ".categories-sort",
        helper:'clone',
        scroll:false,
        revert: "invalid"
    });*/
    
    $('.category-edit__icon_edit').click(function()
    {
       let formModal=$('#editCategory');
       let category=$(this).parents('.category-edit').eq(0);
 
       let state=category.data('state');
            if(state===1)
            {
                $('#editCategory-state-on').trigger('click');
            }
            else
            {
                $('#editCategory-state-off').trigger('click');
            }
       
       let id=category.data('id');
       formModal.find('#editCategory-id').val(id);
       
       let name=category.data('name');
       formModal.find('#editCategory-name').val(name);
       
       formModal.editCategory;
       formModal.modal();  
    });
    
    $('.addCategory').click(function()
    {
        $('#addCategory').modal();
    });
});

$('.select-with-search').selectmenu();

$('.category-edit__icon_remove').click(function()
        {
            let removeForm=$('#remove');
            let row=$(this).parents('.category-edit').eq(0);
            let id=row.data('id');
            
            let name=row.data('name');
            
            removeForm.find('#remove-id').val(id);
            removeForm.find('.remove-name').text(name);
            removeForm.modal();
        });