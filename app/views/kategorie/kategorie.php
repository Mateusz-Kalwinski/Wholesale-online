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
                    <?=Svg::create('kategoria')?></div>
                    <div class="content-title-text">

                        <h4><?=$data['products']['name']?></h4>
                        <p>Kategorie produktów</p>

                    </div>
                </div>

                <?php


                if(!isset($data['products']['products']))
                {
                    foreach($data['products']['subcategories'] as $subcategory)
                    {

                        if(!empty($subcategory['products']))
                        {
                            echo '<div class="table-title"><h4>'.$subcategory['name'].'</h4></div>';
                            echo '<div class="table-container"><table class="table table-products table-one-of-many ">
                            <tr>
                                <th>Fotografia</th>
                                <th>Nazwa produktu</th>
                                <th>Cena katalogowa</th>
                                <th class="table-discount">Rabat</th>
                                <th>Promocja</th>
                                <th>Cena</th>
                                <th class="quanity-header">Ilość</th>
                            </tr>';

                            foreach($subcategory['products'] as $product)
                            {
                                $descriptionLen =  strlen($product['description']);
                                if($descriptionLen<=255){
                                    $descrition = $product['description'];
                                }else{
                                    $descrition = substr($product['description'], 0, 246)."...";
                                }
                                $cartQuanity=$product['quanity']?$product['quanity']:0;
                                    if(isset($product['photos'][0]['link']) and isset($product['photos'][0]['alt'])){
                                        $link = ($product['photos'][0]['link']);
                                        $alt = $product['photos'][0]['alt'];
                                        $mainPhoto = '<td class="table-photo"><img src="/public/images/products/'.$link.'" alt="'.$alt.'"></td>';
                                    }else{
                                        $mainPhoto ='<td class="table-photo">'.Svg::create('photo-01').'</td>';
                                    }
                                    $case = $product['quanityInStock'] - $product['reservation'];

                                echo '<tr>
                                        '.$mainPhoto.'
                                        <td class="table-name"><a href="/produkt/'.$product['link'].'/'.$product['id'].'">'.$product['name'].'</a> <span title="'.$descrition.'">'.Svg::create('info').'</span><p class="product-number">'.$product['kod_produktu'].'</p></td>
                                        <td class="table-price">'.number_format($product['price'],2).' zł</td>
                                        <td class="table-discount">'.$data['user']['discount'].'%</td>
                                        <td class="table-promotion">'.$product['discount'].'%</td>
                                        <td class="table-price-end">'.number_format(ceil($product['price']*(100-$data['user']['discount'])/10000*(100-$product['discount'])*100)/100,2).'zł</td>
                                        <td class="table-quanity"><input class="number" name="quanity" min="0" max="'.$case.'" value="'.$cartQuanity.'"> ' .$product['unit'].'<input class="d-none"  class="number"  name="id-product" value="'.$product['id'].'"></td>

                                    </tr>';
                            }

                            echo'</table></div>';
                        }
                    }
                }
                else
                {
                     if(!empty($data['products']['products']))
                        {
                            echo '<div class="table-container"><table class="table table-products ">
                            <tr>
                                <th>Fotografia</th>
                                <th>Nazwa produktu</th>
                                <th>Cena katalogowa</th>
                                <th class="table-discount">Rabat</th>
                                <th>Promocja</th>
                                <th>Cena</th>
                                <th class="quanity-header">Ilość</th>
                            </tr>';

                            foreach($data['products']['products'] as $product)
                            {
                                $descriptionLen =  strlen($product['description']);
                                if($descriptionLen<=255){
                                    $descrition = $product['description'];
                                }else{
                                    $descrition = substr($product['description'], 0, 246)."...";
                                }

                                $productQuanity=$product['quanity']!=NULL?$product['quanity']:'0';

                                if(isset($product['photos'][0]['link']) and isset($product['photos'][0]['alt'])){
                                    $link = ($product['photos'][0]['link']);
                                    $alt = $product['photos'][0]['alt'];
                                    $mainPhoto = '<td class="table-photo"><img src="/public/images/products/'.$link.'" alt="'.$alt.'"></td>';
                                }else{
                                    $mainPhoto ='<td class="table-photo">'.Svg::create('photo-01').'</td>';
                                }

                                echo '<tr>
                                        '.$mainPhoto.'
<td class="table-name"><a href="/produkt/'.$product['link'].'/'.$product['id'].'">'.$product['name'].'</a> <span title="'.$descrition.'">'.Svg::create('info').'</span><p class="product-number">'.$product['kod_produktu'].'</p></td>                                        <td class="table-price">'.number_format($product['price'],2).' zł</td>
                                        <td class="table-discount">'.$data['user']['discount'].'%</td>
                                        <td class="table-promotion">'.$product['discount'].'%</td>
                                        <td class="table-price-end">'.number_format(ceil($product['price']*(100-$data['user']['discount'])/10000*(100-$product['discount'])*100)/100,2).'zł</td>
                                        <td class="table-quanity"><input class="number" name="quanity" min="0" value="'.$productQuanity.'"> ' .$product['unit'].'<input class="d-none"  class="number"  name="id-product" value="'.$product['id'].'"></td>

                                    </tr>';
                            }

                            echo'</table></div>';
                        }
                }
                ?>

                <div  class="add-to-store"><button class="btn add-to-store-button"><?=Svg::create('koszyk')?>dodaj do koszyka</button></div>
            </div>
        <?=Content::rightSide($data['user']['discount'], $data['configPhone'][0]['value'] ,$data['configMail'][0]['value'])?>
        </div>
    </main>

    <?=Notification::create()?>
    <?=Scripts::create(['/public/js/notifications.js'])?>
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
    $('input[name="quanity"]').change(function()
    {
           let maxQuanity=parseInt($(this).attr('max'));
           let notificationText='';

           if (maxQuanity<$(this).val())
           {
              notificationText+=' Przekroczono dostępną wartość dla tego produktu. Ilość została zmieniona na '+maxQuanity+'. ';
              $(this).val(maxQuanity);
                notification.notify(notificationText,'error');
           }
    });

    $('.add-to-store-button').click(function()
          {
            var products={};
            var productsCounter=0;
            $('.table-products tr').each(function()
            {
                var productRow=$(this);
                var quanity=parseInt(productRow.find('input[name="quanity"]').val());
                var id_product=productRow.find('input[name="id-product"]').val();
                ;



                if(quanity>0)
                {
                    var product={};
                    product['id']=id_product;
                    product['quanity']=quanity;
                    products[productsCounter.toString()]=product;
                    productsCounter+=1;


                }

            });

            productsJSON=JSON.stringify(products);
            $.post('/public/ajax/addProducts.php',{'products':productsJSON}).done(function(data)
            {


                let notificationText;
                if(data==1)
                {
                    
                    notifyText='<?=$data['notifications'][16]['text']?>';
                    notification.notify(notifyText,'error');   
                }
                else if(data==0) 
                {
                    notifyText='<?=$data['notifications'][17]['text']?>';

                    notification.notify(notifyText,'success');
                }
                else
                {
                    notifyText=data;
                    notification.notify(notifyText,'error');
                }
            });

          });

    </script>
    <script src="/public/js/fixedButton.js"></script>

</body>
</html>
