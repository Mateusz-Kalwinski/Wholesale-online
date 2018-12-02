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
                    <h4>Powiadomienia</h4>
                    <p>Lista powiadomień</p>
                </div>
             </div>
                 <div class="table-panel">
                     <input class="input-custom search-product" type="text" placeholder="wyszukaj">
                                         <button class="btn addNews">dodaj produkt</button>
                 </div>
                 <table class="table table-clients">
                    <tr>
                        <th>Edycja</th>
                        <th>Tytuł</th>
                        <th>Treść</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th>Usuń</th>
                    </tr>
                    
                    <?php
                    
                        foreach($data['news'] as $news)
                        {
                            $news['news_date']=implode('.',array_reverse(explode('-',$news['news_date'])));
                          echo'<tr
                              data-id="'.$news['id'].'"
                              data-title="'.$news['title'].'"
                              data-content="'.$news['content'].'"
                              data-date="'.$news['news_date'].'"
                              data-status="'.$news['status'].'"
                              >
                              <td class="editNews">'.Svg::create('edit').'</td>
                                  <td>'.$news['title'].'</td>
                                  <td>'.(strlen($news['content'])>200?substr($news['content'],0,197).'...':$news['content']).'</td>
                                  <td>'.$news['news_date'].'</td>
                                  <td class="changeState">
                                    <div class="on-off">
                                    <form class="form-change-status ajax" method="post"
                                    action="/admin/ajax/changeNewsStatus">
                                          <input type="hidden" value="'.$news['id'].'" name="id">
                                          <input type="radio" value="1" '.($news['status']==='1'?'checked':'').'
                                              name="status" class="form-control" >
                                          <input type="radio" value="2" '.($news['status']==='2'?'checked':'').'
                                              name="status" class="form-control">
                                          <div class="switch"></div>
                                    </form>
                                    </div>
                                  </td>
                                  <td class="remove">
                                        <button class="no-style" type="submit">'.Svg::create('x').'</button>
                                    </form>
                                    </td>
                              </tr>';

                        }

                    
                    ?>
                   
                 </table>
               
               
                 
            </div>
        </div>


    </main>
    <?=Notification::create()?>
    <?=RemoveForm::create('remove','Potwierdzenie usunięcia','Czy na pewno chcesz usunąć powiadomienie:', '/admin/ajax/deleteNews')?>
    <?=newsForm::create('editNews','Edytuj powiadomienie', '/admin/ajax/editNews')?>
    <?=newsForm::create('addNews','Dodaj powiadomienie', '/admin/ajax/addNews')?>
    
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
                        <input type="number" name="discount" class="input-custom" id="add-discount-discount">
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
    
    
      $( function() {
        $( "input.date" ).datepicker();
      } );
        
        function updateClientList()
        {   
            window.location.reload();
        }
        
        
        $('.editNews').click(function()
        {
                        console.log('test');
            let userRow=$(this).parent('tr');
            let formModal=$('#editNews');
            
            let id=userRow.data('id');
            formModal.find('#editNews-id').val(id);
            
            let name=userRow.data('title');
            formModal.find('#editNews-title').val(name);
            
            let date=userRow.data('date');
            formModal.find('#editNews-date').val(date);
            
            let description=userRow.data('content');
            tinymce.get('editNews-content').setContent(description);
            tinymce.get('editNews-content').save();
            
            let state=userRow.data('status');
            
            if(state===1)
            {
                $('#editNews-state-on').trigger('click');
            }
            else
            {
                $('#editNews-state-off').trigger('click');
            }
            
            

            formModal.modal();  
            
        });
        
        $('.addNews').click(function()
        {
            let formModal=$('#addNews');
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
        
        $('.search-order').keyup(function()
        {
            let keyword=$(this).val().toLowerCase();
            
            if(keyword.length<3)
            {
                $('.table-clients tr').fadeIn();
            }
            else
            {
                $('.table-history tr:not(:first-of-type)').fadeOut(function()
                {
                    $('.table-history *:not(table-products) tr').each(function()
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
        
               $('.remove').click(function()
        {
            let removeForm=$('#remove');
            let row=$(this).parents('tr');
            let id=row.data('id');
            
            let name=row.data('title');
            
            removeForm.find('#remove-id').val(id);
            removeForm.find('.remove-name').text(name);
            removeForm.modal();
        });
        
    </script>
    <script>tinyMCE.init({
                    selector:'textarea',
                    plugins:'code,preview',
                    setup: function (editor)
                    {
                        editor.on('load change', function ()
                        {
                            editor.save();
                        });
                    }
                });</script>
</body>
</html>