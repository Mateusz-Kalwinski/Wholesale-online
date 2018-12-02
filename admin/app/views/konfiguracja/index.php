<!DOCTYPE html>
<html>
<?=Head::create()?>
<body>
    <?=Header::create($data['user']['mail'], $data['configLogo'][0]['value'])?>
    <?=navMenu::create()?>
    
    <main class="content">
        <div class="main-container">
           <div class="main-content with-table">
             <div class="content-title">
                <?=Svg::create('kategoria')?>
                <div class="content-title-text">
                    <h4>Konfiguracja</h4>
                    <p>Panel konfiguracyjny</p>
                </div>
             </div>
                 <div class="table-panel">
                     <input class="input-custom search-product" type="text" placeholder="wyszukaj">
                 </div>
                 <table class="table table-clients">
                    <tr>
                        <th>Nazwa</th>
                        <th>Wartość</th>
                        <th class="d-none">Edycja</th>
                    </tr>
                    
                    <?php
                    
                        foreach($data['config'] as $config)
                        {
                            if(!empty($config['nazwa']))
                            {
                                echo'
                                <tr>
                                <form enctype="multipart/form-data"  method="post" '.($config['id']==1?'target="upload_target" class="ajax-file"':' class="ajax"').' action="/admin/ajax/editConfig">
                                    <td>'.$config['nazwa'].'</td>
                                    <td><input type="hidden" class="input-custom" name="id" value="'.$config['id'].'">
                                        <input name="val" type="'.($config['id']==1?'hidden':'text').'" class="input-custom" value="'.$config['value'].'">';
                                
                                if($config['id']==1)
                                {   
                                    echo'<iframe class="d-none" name="upload_target" src="/admin/ajax/editConfig"></iframe>';
                                    echo '<div class="edit-image">';
                                        echo '<input type="file" name="image" id="image">';
                                        echo '<img style="background-color:'.$data['color']['value'].'" class="table-form-img" src="'.$config['value'].'" alt="">';
                                    echo '</div>';
                                }
                                
                                echo'  </td>  <td class="d-none"><button class="btn save">Zmień</button></td>
                                    </form>
                                </tr>
                                ';
                            }

                        }

                    
                    ?>
                   
                 </table>
               
               
                 
            </div>
        </div>


    </main>
    <?=Notification::create()?>
    <?=productForm::create('editProduct','Edytuj dane produktu', '/admin/ajax/editProduct')?>
    <?=productForm::create('addProduct','Dodaj produkt', '/admin/ajax/addProduct')?>
    
    <div class="modal fade" id="addDiscount" tabindex="-1" role="dialog" aria-labelledby="editUserLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Ustaw rabat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form class="ajax" method="post" action="/admin/ajax/addDiscountProduct">
                  <input type="hidden" name="id" class="input-custom" id="add-discount-id">
                  <div class="modal-body">
                      <div class="form-group">
                        <label for="add-discount-discount" class="form-control-label">Dodaj do promocji:</label>
                        <input type="number"  name="discount" class="input-custom" id="add-discount-discount">
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-primary">Zapisz</button>
                  </div>
                 </form>
                </div>
              </div>
            </div>
    
    <?=Scripts::create(['/admin/public/js/notifications.js','/admin/public/js/formHandling.js',"/admin/public/js/tinymce/tinymce.min.js"])?>
    <script>
        /*$(function()
        {
           $('#editUser').modal();
        });*/
        
        function updateConfigList()
        {
            /*
                TO DO:
                Asynchronus update of table contents
             */
            
            window.location.reload();
        }
        
        
        $('.editProduct').click(function()
        {
            let userRow=$(this).parent('tr');
            let formModal=$('#editProduct');
            
            let id=userRow.data('id');
            formModal.find('#editProduct-id').val(id);
            
            let name=userRow.data('name');
            formModal.find('#editProduct-name').val(name);
            
            let productCode=userRow.data('product_code');
            formModal.find('#editProduct-product_code').val(productCode);
            
            let description=userRow.data('description');
            tinymce.get('editProduct-description').setContent(description);
            
            let price=userRow.data('price');
            formModal.find('#editProduct-price').val(price);
            
            let unit=userRow.data('unit');
            formModal.find('#editProduct-unit').val(unit);
            
            let quanity=userRow.data('quanity');
            formModal.find('#editProduct-quanity').val(quanity);
            
            let reservation=userRow.data('reservation');
            formModal.find('#editProduct-reservation').val(reservation);
            
            let category=userRow.data('category');
            formModal.find('#editProduct-kategoria').val(category);
            
            let discount=userRow.data('discount');
            formModal.find('#editProduct-discount').val(discount);
            
            let state=userRow.data('state');
            if(state===1)
            {
                $('#editProduct-state-on').trigger('click');
            }
            else
            {
                $('#editProduct-state-off').trigger('click');
            }
            
            let news=userRow.data('news');
            console.log(news);
            if(news===1)
            {
                $('#editProduct-news-on').trigger('click');
            }
            else
            {
                $('#editProduct-news-off').trigger('click');
            }
            
            
            formModal.modal();  
            
        });
        
        $('.addProduct').click(function()
        {
            let formModal=$('#addProduct');
            formModal.modal();  
            
        });
        
        $('.notification').on('notification-end',function()
        {
            updateClientList();
        })
        
        $('.remove').click(function()
        {
            
        });
        
        $('.switch').click(function()
        {
           $(this).siblings('input:not(:checked)').trigger('click');
        });
        
        $('.form-change-status').change(function()
        {
            $(this).submit();
        });
        
        $('.search-product').keyup(function()
        {
            let keyword=$(this).val().toLowerCase();
            
            if(keyword.length<3)
            {
                $('.table-clients tr').fadeIn();
            }
            else
            {
                $('.table-clients tr:not(:first-of-type)').fadeOut(function()
                {
                    $('.table-clients tr').each(function()
                    {
                        let content='';
                        
                        $(this).find('td').each(function()
                        {
                           content+=$(this).text().toLowerCase(); 
                        });
                        
                        
                        console.log(content);
                        if (content.match(keyword))
                        {
                            $(this).fadeIn();
                        }
                    });
                    
                });
            }
        });
        
        $('.addDiscount').click(function()
        {
            let id=$(this).data('id-product');
            $('#add-discount-id').val(id);
            $('#addDiscount').modal('toggle');
        });
        
        $(function()
        {
            $('form input').keyup(function()
            {
                console.log('test');
               $(this).parents('form').submit();
            });
        });
        

        
    </script>
    <script>tinyMCE.init({
                    selector:'textarea',
                    plugins:'code,preview',
                    setup: function (editor)
                    {
                        editor.on('change', function ()
                        {
                            editor.save();
                        });
                    }
                });</script>
</body>
</html>