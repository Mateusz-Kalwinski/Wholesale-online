<!DOCTYPE html>
<html>
<?=Head::create()?>
<body data-free-delivery="<?=$data['freeDelivery']?>">
    <?=Header::create($data['user']['mail'], $data['configLogo'][0]['value'])?>
    <?=navMenu::create()?>
    <main class="content">
        <div class="main-container">
            <div class="main-content with-table">
                <div class="content-title">
                    <?=Svg::create('kategoria')?>
                    <div class="content-title-text">
                        <h4>Zamówienia</h4>
                        <p>Lista produktów</p>
                    </div>
                 </div>

                <div class="history-date-form d-flex align-items-center justify-content-center justify-content-md-start flex-wrap">
                    <label  for="#date-start">Od
                    <input placeholder="dd.mm.rrrr"  type="text" class="input-custom date" name="date-start" id="date-start"></label>
                    <label for="#date-stop">do
                    <input placeholder="dd.mm.rrrr"  type="text" class="input-custom date" name="date-stop" id="date-stop"></label>
                    <input class="input-custom search-order" type="text" placeholder="wyszukaj">
                </div>
                <table class="table table-products table-history">
                    <thead>
                        <tr>
                            <th>Edycja</th>
                            <th>Numer zamówienia</th>
                            <th>Zamawiający</th>
                            <th>Data złożenia</th>
                            <th>Do zapłaty</th>
                            <th>Wysyłka</th>
                            <th>Status zamówienia</th>
                            <th>Płatność zamówienia</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                            foreach($data['ordersHistory'] as $order)
                            {
                              echo'<tr
                                    data-name="'.$order['name'].'"
                                    data-order-status="'.$order['order_status'].'"
                                    data-place="'.$order['place'].'"
                                    data-code="'.$order['code'].'"
                                    data-address="'.$order['address'].'"
                                    data-comment="'.$order['comment'].'"
                                    data-shipment="'.$order['shipment'].'"
                                    data-state="'.$order['order_status'].'"
                                    data-pay="'.$order['pay'].'"
                                    data-id="'.$order['id_order'].'"
                                    data-user-id="'.$order['id_user'].'"
                                     class="main-row" id="#'.$order['order_number'].'">
                                    <td class="editOrder">'.Svg::create('edit').'</td>
                                    <td class="order-number">'.$order['order_number'].'</td>
                                    <td class="order-client">'.$order['username'].' / '.$order['nip'].' / '.$order['mail'].' '.$order['phone'].'</td>
                                    <td class="order-date">'.str_replace('-', '.',$order['order_date']).'</td>
                                    <td class="order-payment">'.number_format($order['pay'],2).' zł</td>
                                    <td class="order-shipment">'.$order['shipment'].'</td>
                                    <td class="order-status"><span style="padding:5px 10px; color:#fff; background-color:'.$order['color'].'">'.$order['status_name'].'</span></td>
                                    <td class="order-status"><span style="padding:5px 10px; color:#fff; background-color:'.$order['color_paid'].'">'.$order['order_paid'].'</span></td>
                                    <td ><img class="show-products" src="/public/images/icons/menu-ikony-down.png"></td>
                                   </tr>
                                  ';
                                    echo '<tr class="additional-row" data-parent="#'.$order['order_number'].'">
                                  <td colspan="8">
                                  <table class="table table-products">
                        <tbody>';
                                $products= @unserialize($order['product']);
                                if(!empty($products))
                                {
                                echo '<tr>
                            <th>Edycja</th>
                            <th>Nazwa</th>
                            <th class="text-center">Cena jednostkowa</th>
                            <th>Ilość</th>
                            <th>Cena</th>
                        </tr>';
                              foreach($products as $product)
                              {
                                $fig = (int) str_pad('1',3, '0');
                                $price= (ceil($product['price']*(100-$product['discount'])/100*(100-$order['user_discount'])/100 * $fig) / $fig);
                                 echo '<tr
                                        data-quanity="'.$product['ilosc'].'"
                                        data-id="'.$product['id'].'"
                                     >
                                    <td class="editProduct">'.Svg::create('edit').'</td>
                                    <td class="table-name"><a href="/produkt/'.$product['link'].'/'.$product['id'].'">'.$product['name'].'</a></td>
                                    <td class="table-price text-center">'.number_format($price,2).' zł</td>
                                    <td class="table-quanity">'.$product['ilosc'].' '.$product['unit'].'</td>
                                    <td class="table-price-end">'.number_format($price*$product['ilosc'],2).' zł</td>
                                </tr>';

                              }

                              echo'<tr><td class="addProduct" colspan="4">+</td></tr>';


                              }

                              echo'</tbody></table>
                                  <div class="history-information">
                                  <div class="history-address">
                                    <p>Dane do wysyłki:</p>
                                    <address>
                                        <b>'.$order['name'].'</b><br>
                                      <b></b>
                                      '.$order['address'].'<br>
                                      '.$order['code'].' '.$order['place'].'<br>
                                      tel. '.$order['phone'].'
                                    </address>
                                </div>
                                <a href="/admin/pdf/pobierz/'.$order['id_order'].'" class="btn">Generuj pdf</a>
                                 </div>
                                  </td>
                                  </tr>';

                            }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>
    </main>

    
        <div class="modal fade" id="addProductToOrder" tabindex="-1" role="dialog" aria-labelledby="editUserLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Dodaj produkt do zamówienia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form class="ajax" method="post" action="/admin/ajax/addProductToOrder">
                  <input type="hidden" name="id" class="input-custom" id="addProductToOrder-id">
                  <div class="modal-body">
                        <div class="form-group">
                        <label for="addProductToOrder-product" class="form-control-label">Produkt:</label>
                        <select data-live-search="true" name="id_product" class="input-custom select-with-search" id="addProductToOrder-product">
                            <?php

                            foreach($data['products'] as $product)
                            {
                                echo'<option value="'.$product['id'].'">'.$product['name'].'</option>';
                            }
                            ?>
                        </select>
                        
                      </div>
                      
                      
                      <div class="form-group">
                        <label for="addProductToOrder-quantity" class="form-control-label">Ilość:</label>
                        <input type="number" min="1" value="1" name="quantity" class="input-custom" id="addProductToOrder-quantity">
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-primary">Dodaj</button>
                  </div>
                 </form>
                </div>
              </div>
            </div>
    <?=Notification::create()?>    
    <?=OrderForm::create('editOrder','Edytuj dane zamówienia', '/admin/ajax/editOrder',$data['shipmentAndPayment'])?>
    <?= OrderProductForm::create('editProductOrder', 'Edytuj produkt w zamówieniu', '/admin/ajax/changeQuanity','/admin/ajax/deleteProductFromOrder',$shipmentAndPayment)?>
    <?=Scripts::create(['/admin/public/js/formHandling.js',"/admin/public/js/tinymce/tinymce.min.js"])?>
     <script>
      $( function() {
        $( "input.date" ).datepicker();
      } );

      $('.notification').on('notification-end',function()
      {
          window.location.reload();
      })

      $(function()
      {
          $('.main-row td:not(.editOrder)').click(function()
          {
              if(event.target!=$('.editOrder'))
              {
                             mainRow=$(this).parent();
            additionalRow=mainRow.next('.additional-row');
                            mainRow.toggleClass('extended');
                additionalRow.toggleClass('extended');
            additionalRow.fadeToggle(400,'swing',function()
              {
              });

                mainRow.find('.show-products').toggleClass('rotated'); 
              }


          });

          $('input[name="date-start"]').change(function()
          {
              var date=($(this).val().split('.'));


              $('.main-row').each(function()
              {
                  var orderDate=$(this).find('.order-date').text().split(' ')[0].split('.');

                  console.log(date);
                  for(var i=0; i<3; i++)
                  {

                      if(parseInt(orderDate[i])<parseInt(date[2-i]))
                      {
                          console.log(orderDate[i]);
                          console.log(date[2-i]);
                          $(this).hide().attr('data-hide-reason','start');
                          $(this).next('.additional-row').hide();
                          i=4;
                      }
                      else
                      {
                            if($(this).attr('data-hide-reason')==='start')
                            {
                              $(this).show();
                            }


                      }
                  }
              });

          });

          $('input[name="date-stop"]').change(function()
          {
              var date=($(this).val().split('.'));

              $('.main-row').each(function()
              {
                  var orderDate=$(this).find('.order-date').text().split(' ')[0].split('.');
                  console.log(date);
                  for(var i=0; i<3; i++)
                  {

                      if(parseInt(orderDate[i])>parseInt(date[2-i]))
                      {
                          console.log(orderDate[i]);
                          console.log(date[2-i]);
                          $(this).hide().attr('data-hide-reason','stop');
                          $(this).next('.additional-row').hide();
                          i=4;
                      }
                      else
                      {
                            if($(this).attr('data-hide-reason')==='stop')
                            {
                              $(this).show();
                            }
                      }
                  }
              });

          });

      });

      $('.editOrder').click(function()
        {
            let userRow=$(this).parent('tr');
            let formModal=$('#editOrder');

            let userId=userRow.data('user-id');
            let addresses;
            $('#editOrder-shipment').html('');
            $.post('/admin/ajax/addressesOfClient',{id:userId},
            function(data)
            {
                addresses=JSON.parse(data);

                for (let index=0;index<addresses.length;index++)
                {
                    console.log(address);
                    let option=$('<option></option>');
                    option.attr('data-name',addresses[index].nazwa);
                    option.attr('data-place',addresses[index].miasto);
                    option.attr('data-address',addresses[index].adres);
                    option.attr('data-code',addresses[index].kod);
                    option.val(addresses[index].id);
                    option.text(addresses[index].nazwa);
                    $('#editOrder-shipment').append(option);
                }

            });
        
            $('#editOrder-payment option').each(function()
            {
               let deliveryName=$(this).data('pay-name');
               let deliveryMethod=$(this).data('transport-name');
               let freeDeliveryValue=parseFloat($('body').data('free-delivery'));
               let freeDeliveryStatus=$(this).data('free');
               let deliveryNormalPrice=$(this).data('pay');
               
               let deliveryFinalPrice=(deliveryNormalPrice<freeDeliveryValue)||freeDeliveryStatus==0?deliveryNormalPrice:0;
               
               let optionContent=deliveryMethod+' - '+deliveryName+' + '
                                + deliveryFinalPrice+ ' zł';
               
               $(this).text(optionContent);
               $(this).val(optionContent);
               
               let currentShipment=userRow.data('shipment');

               if(currentShipment===optionContent)
               {
                   $(this).parent().val(optionContent);
               }
            });

            let id=userRow.data('id');
            formModal.find('#editOrder-id').val(id);

            let name=userRow.data('name');
            formModal.find('#editOrder-name').val(name);


            let place=userRow.data('place');
            formModal.find('#editOrder-place').val(place);

            let code=userRow.data('code');
            formModal.find('#editOrder-code').val(code);

            let address=userRow.data('address');
            formModal.find('#editOrder-address').val(address);

            let comment=userRow.data('comment');
            tinymce.get('editOrder-comment').setContent(comment);
            tinymce.get('editOrder-comment').save();

            let status=userRow.data('state');

            $('#editOrder-state option').each(function()
            {
                let optionValue=$(this).val();
               if($(this).val()==status)
               {
                   
                   $(this).parent().val(status);
               }
            });


            formModal.modal();

        });

            $('#editProductOrder input[name="remove"]').click(function()
            {
                

                    let form=$('#editProductOrder form');
                    
                    let formActionTemp=form.attr('action');
                    let formActionNew=form.data('alternative-action');
                    form.attr('action',formActionNew);
                    form.data('alternative-action',formActionTemp);
                    
                    $('#editProductOrder-quanity').val(0);
                
            });

$('.editProduct').click(function()
        {
            let userRow=$(this).parent('tr');
            let formModal=$('#editProductOrder');
            
            let quanity=userRow.data('quanity');
            formModal.find('#editProductOrder-quanity').val(quanity);

            let idProduct=userRow.data('id');
            formModal.find('#editProductOrder-id-product').val(idProduct);
            
           let id=userRow.parents().prev('tr').data('id');
            formModal.find('#editProductOrder-id').val(id);

            formModal.modal();

        });

        $('.addresses').change(function()
        {
                let option=$(this).find('option:checked');

                let name=option.data('name');
                let code=option.data('code');
                let address=option.data('address');
                let place=option.data('place');

                $('#editOrder-name').val(name);
                $('#editOrder-code').val(code);
                $('#editOrder-address').val(address);
                $('#editOrder-place').val(place);
        });

        $('.switch').click(function()
        {
           $(this).siblings('input:not(:checked)').trigger('click');
        });


        $('.addProduct').click(function()
        {
            let id=$(this).parents('.table-history').find('.main-row').data('id');
            $('#addProductToOrder').find('#addProductToOrder-id').val(id);
            $('#addProductToOrder').modal();
        });

$('.search-order').keyup(function()
        {
            let keyword=$(this).val();
            
            if(keyword.length<3)
            {
                $('.table-history tr').fadeIn();
            }
            else
            {
                $('.table-history tr').fadeOut(function()
                {
                    $('.table-history tr').each(function()
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
