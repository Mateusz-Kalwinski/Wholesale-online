<!DOCTYPE html>
<html>
<?=Head::create()?>
<body>
    <?=Header::create($data['user']['mail'], $data['configLogo'][0]['value'],$data['user']['cartQuanity'])?>
    <?=navMenu::create($data['menu'])?>
    
    <main class="content">
        <div class="main-container">
            <div class="main-content with-table">
                <div class="content-title"><div>
                    <?=Svg::create('historia')?></div>
                    <div class="content-title-text">
                        <h4>Historia zamówień</h4>
                    </div>
                </div>
                <div class="history-date-form d-flex align-items-center justify-content-center justify-content-md-start flex-wrap">
                    <label  for="#date-start">Od
                    <input placeholder="dd.mm.rrrr"  type="text" class="input-custom date" name="date-start" id="date-start"></label>
                    <label for="#date-stop">do
                    <input placeholder="dd.mm.rrrr"  type="text" class="input-custom date" name="date-stop" id="date-stop"></label>
                    <!--<button class="btn">pokaż zamówienia</button>-->
                </div>
                <div class="table-container">
                <table class="table table-products table-history">
                    <thead>
                        <tr>
                            <th>Numer zamówienia</th>
                            <th class="text-center">Data złożenia</th>
                            <th>Do zapłaty</th>
                            <th>Wysyłka</th>
                            <th>Status zamówienia</th>
                            <th>Płatność zamówienia</th>
                            <th style="width:20px;min-width:auto;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($data['ordersHistory'] as $order)
                            {
                              echo'<tr class="main-row" id="#'.$order['order_number'].'">
                                    <td class="order-number">'.$order['order_number'].'</td>
                                    <td class="order-date">'.str_replace('-', '.',$order['order_date']).'</td>
                                    <td class="order-payment">'.number_format($order['pay'],2).' zł</td>
                                    <td class="order-shipment">'.$order['shipment'].'</td>
                                    <td class="order-status"><span class="label" style=" background-color:'.$order['color'].'">'.$order['status_name'].'</span></td>
                                    <td class="order-status"><span class="label" style=" background-color:'.$order['color_paid'].'">'.$order['order_paid'].'</span></td>
                                    <td style="width:20px; min-width:auto" ><img class="show-products" src="/public/images/icons/menu-ikony-down.png"></td>
                                   </tr>
                                  ';
                                    echo '<tr class="additional-row" data-parent="#'.$order['order_number'].'">
                                  <td colspan="6">
                                  <table class="table table-products">
                        <tbody>';
                                $products= @unserialize($order['product']);
                                if(!empty($products))
                                {
                                echo '<tr>
                            <th>Nazwa produktu</th>
                            <th class="text-center">Cena</th>
                            <th>Ilość</th>
                            <th class="text-right">Wartość</th>
                        </tr>';
                                    
                                    
                                
                              foreach($products as $product)
                              {
                                $fig = (int) str_pad('1',3, '0');
                                $price= (ceil($product['price']*(100-$product['discount'])/100*(100-$data['user']['discount'])/100 * $fig) / $fig);
                                 echo '<tr class="history-products-row">
                                    <td ><a class="link" href="/produkt/'.$product['link'].'/'.$product['id'].'">'.$product['name'].'</a></td>
                                    <td class="table-price text-center">'.number_format($price,2).' zł</td>
                                    <td class="table-quanity">'.$product['ilosc'].' '.$product['unit'].'</td>
                                    <td class="table-price-end text-right">'.number_format($price*$product['ilosc'],2).' zł</td>
             
                                    
                                </tr>';  
                                  
                              }
                              

                                
                              } 

                              echo'</tbody></table>
                                  <div class="history-information">
                                  <div class="history-address">
                                    <p class="light-heading">Dane do wysyłki:</p>
                                    <address>
                                        <b>'.$order['name'].'</b><br>
                                      <b></b>
                                      '.$order['address'].'<br>
                                      '.$order['code'].' '.$order['place'].'<br><br>
                                      tel. '.$order['phone'].'
                                    </address>
                                </div>
                                <a href="/pdf/pobierz/'.explode('/',$order['order_number'])[1].'" class="btn">'.Svg::create('pdf').'podsumowanie PDF</a>
                                 </div>
                                  </td>
                                  </tr>';
                              
                            }
                        ?>
                    </tbody>
                </table></div>
            </div>
           <?=Content::rightSide($data['user']['discount'], $data['configPhone'][0]['value'], $data['configMail'][0]['value'])?>
        </div> 
    </main>

    
    <?=Scripts::create()?>
    <script>
      $( function() {
        $( "input.date" ).datepicker();
      } );
      
      $(function()
      {
          $('.main-row').click(function()
          {
            mainRow=$(this);
            additionalRow=mainRow.next('.additional-row');
                            mainRow.toggleClass('extended');
                additionalRow.toggleClass('extended');
            additionalRow.fadeToggle(400,'swing',function()
              {
              });

                mainRow.find('.show-products').toggleClass('rotated');
              
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
      </script>
</body>
</html>