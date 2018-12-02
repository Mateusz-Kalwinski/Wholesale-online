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
                    <?=Svg::create('koszyk')?>
                    <div class="content-title-text">

                        <h4>Twój koszyk</h4>
                    </div>
                </div>

                <?php
                     echo '<table class="table table-products table-cart">
                        <tr>
                            <th>Fotografia</th>
                            <th>Nazwa produktu</th>
                            <th>Cena katalogowa</th>
                            <th>Promocja</th>
                            <th>Cena</th>
                            <th class="quanity-header">Ilość</th>
                            <th>Usuń</th>
                        </tr>';
                $priceAll = 0;
                foreach($data['products'] as $product) {
                    $descriptionLen = strlen($product['description']);
                    if ($descriptionLen <= 255) {
                        $descrition = $product['description'];
                    } else {
                        $descrition = substr($product['description'], 0, 246) . "...";
                    }
                    if ($product['status'] == 0) {
                        echo '<tr data-product-id="' . $product['id_produkt'] . '" class="product-row cart-removed"><td col="6 text-danger">' . str_replace('%value%', $product['name'], $data['notifications'][15]['text']) . '</td></tr>';
                    } else {
                        $price = number_format($product['price'] * (100 - $data['user']['discount']) / 10000 * (100 - $product['discount']), 2);

                        if ($product['ilosc'] == NULL) {
                            $product['ilosc'] = '0';
                        }
                        if (isset($product['photos'][0]['link']) and isset($product['photos'][0]['alt'])) {
                            $link = $product['photos'][0]['link'];
                            $alt = $product['photos'][0]['alt'];
                            $mainPhoto = '<td class="table-photo"><img src="/public/images/products/' . $link . '" alt="' . $alt . '"></td>';
                        } else {
                            $mainPhoto ='<td class="table-photo">'.Svg::create('photo-01').'</td>';
                        }
                        if($product['discount'] != '0'){
                            $discount = $product['discount']. ' %';
                        }else{
                            $discount = ' - ';
                        }
                        $case = $product['quanityInStock'] - $product['reservation'];
                        echo '<tr class="product-row">
                                    ' . $mainPhoto . '
                                    <td class="table-name"><a href="/produkt/' . $product['link'] . '/' . $product['id'] . '">' . $product['name'] . ' ' . '</a><span title="' . $descrition . '">' . Svg::create('info') . '</span></td>
                                    <td class="table-price">' . number_format($product['price'], 2) . ' zł</td>
                                    <td class="table-promotion">'. $discount .'</td>
                                    <td class="table-price-end">' . number_format($product['price'] * (100 - $data['user']['discount']) / 10000 * (100 - $product['discount']), 2) . 'zł</td>
                                    <td class="table-quanity"><input class="number" name="quanity" min="0" max="'.$case.'" value="' . $product['ilosc'] . '"> ' . $product['unit'] . '<input class="d-none"  class="number"  name="id-product" value="' . $product['id'] . '"></td>
                                    <td class="table-delete-row">'.Svg::create('x').'</td>
                                </tr>';
                        $priceAll += $price* $product['ilosc'];
                    }
                }
                 echo'</table>';


                        echo'
                            <div class="d-flex w-100 justify-content-center justify-content-sm-end">
                                <div class="order-price-end justify-content-sm-start" style="padding-left:11px;">
                                    <span>RAZEM:</span> <b><span class="ending-price">'.number_format($priceAll,2).'</span> zł</b>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end w-100 align-items-center flex-column-reverse flex-sm-row">
                                <a class="btn" href="/zamowienie" >'.Svg::create('koszyk').' złóż zamówienie</a>
                            </div>
                            ';

                ?>

            </div>
        <?=Content::rightSide($data['user']['discount'], $data['configPhone'][0]['value'],$data['configMail'][0]['value'])?>
        </div>
    </main>

    <?=Notification::create()?>
    <?=Scripts::create()?>
    <script>
    $( function() {
      $( document ).tooltip({
        position: {
          my: "center bottom-20",
          at: "center top",
          using: function( position, feedback ) {
            $( this ).css( position );
            $( "<div>" )
              .addClass( "arrow" )
              .addClass( feedback.vertical )
              .addClass( feedback.horizontal )
              .appendTo( this );
          }
        }
      });
    } );
    </script>
    <script>
    function cartRecount()
    {
        var priceAll=0;
        $('.table-cart tr.product-row').each(function()
        {

            var price=parseFloat($(this).find('.table-price-end').text());
            console.log(price);
            var quanity=parseInt($(this).find('.table-quanity input[name="quanity"]').val());
            var newPrice=price*quanity;
            console.log(quanity);
            //$(this).find('.table-price-end').text((Math.ceil(newPrice*100)/100).toFixed(2)+ 'zł');
            priceAll+=newPrice;
        });

        $('.ending-price').text((Math.ceil(priceAll*100)/100).toFixed(2));
    }

    function deleteProduct(id_product)
    {
        $.post('/public/ajax/deleteProducts.php',{'id':id_product}).done(function(){});
    }

    $('.table-delete-row svg').click(function()
        {
           var productRow=$(this).parents('tr');
               console.log(productRow);
            var id_product=productRow.find('input[name="id-product"]').val();

            $.post('/public/ajax/deleteProducts.php',{'id':id_product}).done(function(data)
            {

                if(data==='1')
                {

                    $('#notification .modal-body').text('<?=$data['notifications'][18]['text']?>');
                }
                else if(data==='0')
                {
                    $('#notification .modal-body').text('<?=$data['notifications'][19]['text']?>');

                    productRow.remove();
                    cartRecount();
                }
                else
                {
                    $('#notification .modal-body').text(data);
                }
                $('#notification').modal('show');

                if(!$('.product-row').lenght)
                {
                  $('body').click(function()
                  {
                    window.location.reload();
                  })

                }

            });
        });

        $('.table-quanity input[name="quanity"]').on('change',function()
        {
            var quanity=$(this).val();
            if(quanity==='0')
            {
                $(this).parents('tr').find('.table-delete-row svg').trigger('click');
            }
            else
            {
              var id_product=$(this).parent().find('input[name="id-product"]').val();
            var products={};
            var product={};
            product['id']=id_product;
            product['quanity']=quanity;
            products['0']=product;

           let maxQuanity=parseInt($(this).attr('max'));
           let notification='';

           if (maxQuanity<quanity)
           {
              notification+=' Przekroczono dostępną wartość dla tego produktu. Ilość została zmieniona na '+maxQuanity+' ';
              product['quanity']=maxQuanity;
              //$(this).val(maxQuanity);
           }

            productsJSON=JSON.stringify(products);


            $.post('/public/ajax/addProducts.php',{'products':productsJSON,'update':1}).done(function(data)
            {
                if(data==1)
                {
                    notification+='<?=$data['notifications'][20]['text']?>'+' ';
                }
                else if(data==0)
                {
                    notification='<?=$data['notifications'][21]['text']?>'+' ';;
                }
                else
                {
                    notification+=data+' ';;
                }
                $('#notification .modal-body').text(notification);
                $('#notification').modal('toggle');


            });

            }
            cartRecount();
        });
        $(function()
        {
            $('.cart-removed').each(function()
            {
                var id=$(this).attr('data-product-id');
                deleteProduct(id);
            });
        })




    </script>

</body>
</html>
