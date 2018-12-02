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
                    <h4>Klienci</h4>
                    <p>Lista klientów</p>
                </div>
             </div>
                 <div class="table-panel">
                     <input class="input-custom search-client" type="text" placeholder="wyszukaj">
                    <button class="btn addClient">dodaj klienta</button>
                 </div>
                 <table class="table table-clients">
                    <tr>
                        <th>Edycja</th>
                        <th>Generuj hasło</th>
                        <th>Klient</th>
                        <th>Zamówienia</th>
                        <th>Stan</th>
                        <th>Usuń</th>
                    </tr>
                    <?php
                    foreach($data['clients'] as $client)
                    {
                        $orderSum=!empty($client['orders']['price'])?$client['orders']['price']:'0';
                        $onChecked=$client['status']==='1'?' checked ':'';
                        $offChecked=$client['status']==='2'?' checked ':'';
                        echo'
                        <tr data-client-address="'.$client['dane_adres'].'"
                                 data-client-place="'.$client['dane_miejscowosc'].'"
                                 data-client-code="'.$client['dane_kod'].'"
                                 data-client-discount="'.$client['discount'].'"
                                 data-client-state="'.$client['status'].'"
                                 data-client-nip="'.$client['nip'].'"
                                 data-client-name="'.$client['username'].'"
                                 data-client-id="'.$client['id'].'">
                                     
                        <td class="editClient">'.Svg::create('edit').'</td>
                        <td class="generate-password">'.Svg::create('key').'</td>
                        <td class="name">'.$client['username'].'<br>'.$client['nip'].'</td>

                        <td>
                            <a href="/admin/zamowienia/uzytkownik/'.$client['id'].'">'.$client['orders']['countOrders'].' ('.$orderSum.' zł)</a>
                        </td>
                        <td class="changeState">
                              <div class="on-off">
                              <form class="form-change-status ajax" method="post" action="/admin/ajax/banClient">
                                <input type="hidden" value="'.$client['id'].'" name="id">
                                <input type="radio" value="1" '.$onChecked.' name="status" class="form-control" >
                                <input type="radio" value="2" '.$offChecked.' name="status" class="form-control">
                                <div class="switch"></div>
                              </form>
                              </div>
                        </td>
                        <td class="remove">
                            <button class="no-style" type="submit">'.Svg::create('x').'</button>
                        </td>
                    </tr>';
                    }
                    ?>
                    
                    
                 </table>
                 
            </div>
        </div>


    </main>
    <?=Notification::create()?>
    <?=RemoveForm::create('remove','Potwierdzenie usunięcia','Czy na pewno chcesz usunąć klienta:', '/admin/ajax/deleteClient')?>
    <?=ClientForm::create('editUser','Edytuj dane klienta', '/admin/ajax/editClient')?>
    <?=ClientForm::create('addUser','Dodaj klienta', '/admin/ajax/addClient')?>
    <?=Scripts::create(['/admin/public/js/notifications.js','/admin/public/js/formHandling.js'])?>
    <script>
        /*$(function()
        {
           $('#editUser').modal();
        });*/
        
        function updateClientList()
        {
            /*
                TO DO:
                Asynchronus update of table contents
             */
            
            window.location.reload();
        }
        
        
        $('.editClient').click(function()
        {
            let userRow=$(this).parent('tr');
            let formModal=$('#editUser');
            
            let id=userRow.data('client-id');
            formModal.find('#editUser-id').val(id);
            
            let name=userRow.find('.name').text();
            formModal.find('#editUser-name').val(name);
            
            let nip=userRow.find('.nip').text();
            formModal.find('#editUser-nip').val(nip);
            
            let phone=userRow.find('.phone').text();
            formModal.find('#editUser-phone').val(phone);
            
            let mail=userRow.find('.mail').text();
            formModal.find('#editUser-mail').val(mail);
            
            let address=userRow.data('client-address');
            formModal.find('#editUser-street').val(address);

            let place=userRow.data('client-place');
            formModal.find('#editUser-place').val(place);

            let code=userRow.data('client-code');
            formModal.find('#editUser-code').val(code);
            
            let discount=userRow.data('client-discount');
            formModal.find('#editUser-discount').val(discount);            
            
            let state=userRow.data('client-state');
            if(state===1)
            {
                $('#editUser-state-on').trigger('click');
            }
            else
            {
                $('#editUser-state-off').trigger('click');
            }
            
            formModal.modal();  
            
        });
        
        $('.addClient').click(function()
        {
            let formModal=$('#addUser');
            
            formModal.modal();  
            
        });
        
        $('.notification').on('notification-end',function()
        {
           updateClientList();
        });
        
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
        
        $('.search-client').keyup(function()
        {
            let keyword=$(this).val();
            
            if(keyword.length<3)
            {
                $('.table-clients tr').fadeIn();
            }
            else
            {
                $('.table-clients tr').fadeOut(function()
                {
                    $('.table-clients tr').each(function()
                    {
                        let content='';
                        
                        $(this).find('td').each(function()
                        {
                           content+=$(this).text(); 
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
        
        $('.remove').click(function()
        {
            let removeForm=$('#remove');
            let row=$(this).parents('tr');
            let id=row.data('client-id');
            
            let name=row.data('client-name')+' ('+row.data('client-nip')+')';
            
            removeForm.find('#remove-id').val(id);
            removeForm.find('.remove-name').text(name);
            removeForm.modal();
        });
        
    </script>
</body>
</html>
