<!DOCTYPE html>
<html>
<?=Head::create()?>
<body>
    <?=Header::create($data['user']['mail'], $data['configLogo'][0]['value'],$data['user']['cartQuanity'])?>
    <?=navMenu::create($data['menu'])?>
    
    <main class="content">
        <div class="main-container">

            <div class="main-site-table-container">
                <div class="main-content with-table">
                    <div class="content-title"><div>
                        <?=Svg::create('nowosci')?>
                        <div class="content-title-text">

                            <h4>Nowości</h4>

                        </div>
                    </div>

                    <?php


                            if(!empty($data['newsProducts']))
                            {
                                echo '<table class="table table-products ">
                                <tr>
                                    <th>Nazwa produktu</th>
                                    <th>Cena</th>
                                    <th class="quanity-header">Ilość</th>
                                    <th>Do koszyka</th>
                                </tr>';

                                $i=1;
                                foreach($data['discountProducts'] as $product)
                                {
                                    $descriptionLen =  strlen($product['description']);
                                    if($descriptionLen<=255){
                                        $descrition = $product['description'];    
                                    }else{
                                        $descrition = substr($product['description'], 0, 246)."...";
                                    }
                                    $cartQuanity=$product['ilosc']?$product['ilosc']:0;

                                        $case = $product['quanityInStock'] - $product['reservation'];

                                    echo '<tr>
                                            <td class="table-name"><a href="/produkt/'.$product['link'].'/'.$product['id'].'">'.$product['name'].'</a> <span title="'.$descrition.'">'.Svg::create('info').'</span><p class="product-number">'.$product['kod_produktu'].'</p></td>
                                            <td class="table-price-end">'.number_format(ceil($product['price']*(100-$data['user']['discount'])/10000*(100-$product['discount'])*100)/100,2).' zł</td>
                                            <td class="table-quanity"><input class="number" name="quanity" min="0" max="'.$case.'" value="'.$cartQuanity.'"> ' .$product['unit'].'<input class="d-none"  class="number"  name="id-product" value="'.$product['id'].'"></td>
                                            <td><button class="btn block-center add-row-to-cart">'.Svg::create('koszyk').'</button></td>
                                        </tr>';

                                    if($i==5)
                                    {
                                        break;
                                    }

                                    $i++;
                                }

                                echo'</table>';
                            }


                    ?>

                </div>

                <div class="main-content with-table">
                    <div class="content-title"><div>
                        <?=Svg::create('historia')?>
                        <div class="content-title-text">

                            <h4>Historia zamówień</h4>

                        </div>
                    </div>

                    <?php


                            if(!empty($data['ordersHistory']))
                            {
                                echo '<table class="table table-products ">
                                <tr>
                                    <th>Numer zamówienia</th>
                                    <th>Data</th>
                                    <th>Wartość</th>
                                    <th>Status zamówienia</th>
                                </tr>';

                                $i=1;
                                foreach($data['ordersHistory'] as $order)
                                {
                                    $descriptionLen =  strlen($product['description']);
                                    
                                    echo '<tr>
                                            <td>'.$order['order_number'].'</td>
                                            <td class="product-number">'.$order['order_date'].'</td>
                                            <td>'.number_format($order['pay'],2).' zł</td>
                                            <td><span style="padding:5px 10px; color:#fff; background-color:'.$order['color'].'">'.$order['status_name'].'</span></td>
                                        </tr>';

                                    if($i==5)
                                    {
                                        break;
                                    }

                                    $i++;
                                }

                                echo'</table>';
                            }


                    ?>

                </div>

                <div class="main-content with-table">
                    <div class="content-title"><div>
                        <?=Svg::create('promocje')?>
                        <div class="content-title-text">

                            <h4>Promocje</h4>

                        </div>
                    </div>

                    <?php


                            if(!empty($data['discountProducts']))
                            {
                                echo '<table class="table table-products ">
                                <tr>
                                    <th>Fotografia</th>
                                    <th>Nazwa produktu</th>
                                    <th>Cena katalogowa</th>
                                    <th class="table-discount">Rabat</th>
                                    <th>Promocja</th>
                                    <th>Cena</th>
                                    <th class="quanity-header">Ilość</th>
                                    <th></th>
                                </tr>';

                                $i=1;
                                foreach($data['discountProducts'] as $product)
                                {
                                    $descriptionLen =  strlen($product['description']);
                                    if($descriptionLen<=255){
                                        $descrition = $product['description'];    
                                    }else{
                                        $descrition = substr($product['description'], 0, 246)."...";
                                    }
                                    $cartQuanity=$product['ilosc']?$product['ilosc']:0;
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
                                            <td class="table-price-end">'.number_format(ceil($product['price']*(100-$data['user']['discount'])/10000*(100-$product['discount'])*100)/100,2).' zł</td>
                                            <td class="table-quanity"><input class="number" name="quanity" min="0" max="'.$case.'" value="'.$cartQuanity.'"> ' .$product['unit'].'<input class="d-none"  class="number"  name="id-product" value="'.$product['id'].'"></td>
                                            <td><button class="btn add-row-to-cart">'.Svg::create('koszyk').' dodaj do koszyka</button></td>
                                        </tr>';

                                    if($i==5)
                                    { 
                                        break;
                                    }

                                    $i++;
                                }

                                echo'</table>';
                            }


                    ?>

                </div>
            </div>
           <?=Content::rightSide($data['user']['discount'] ,$data['configPhone'][0]['value'], $data['configMail'][0]['value'])?>


        </div> 
    </main>

    <?= Notification::create()?>
    <?=Scripts::create()?>
 <script>
    $('.add-row-to-cart').click(function()
          {
            var products={};
            var productsCounter=0;
            
            let productRow=$(this).parents('tr');
            

                var quanity=parseInt(productRow.find('input[name="quanity"]').val());
                var id_product=productRow.find('input[name="id-product"]').val();
                
                if(quanity>0)
                {
                    var product={};
                    product['id']=id_product;
                    product['quanity']=quanity;
                    products[productsCounter.toString()]=product;
                    productsCounter+=1;
                    console.log(product);
                }
                
          
            productsJSON=JSON.stringify(products);
            console.log(productsJSON);
            $.post('/public/ajax/addProducts.php',{'products':productsJSON}).done(function(data)
            {

                

                if(data==1)
                {
                    
                    $('#notification .modal-body').text('Wprowadzono błędne dane.');
                }
                else if(data==0) 
                {
                    $('#notification .modal-body').text('Dane zostały zmienione.');
                }
                else
                {
                    $('#notification .modal-body').text(data);
                }
                $('#notification').modal('toggle');
                
            });

          });
          
    </script>
</body>
</html>