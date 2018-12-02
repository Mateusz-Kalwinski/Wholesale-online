<!DOCTYPE html>
<html>
<?=Head::create()?>
<body>
    <?=Header::create($data['user']['mail'], $data['configLogo'][0]['value'],$data['user']['cartQuanity'])?>
    <?=navMenu::create($data['menu'])?>
    
    <main class="content main-site">
        <div class="main-container">

            <div class="main-site-table-container">
                <div class="main-content with-table no-scroll-rwd small-content">
                    <div class="content-title d-none d-flex">
                        <?=Svg::create('nowosci')?>
                        <div class="content-title-text">

                            <h4>Nowości</h4>
                            <a class="link-to-main-site " href="/nowosci">przejdź do <b>Nowości</b></a>
                        </div>
                    </div>

                    <div class=" d-block d-md-none rwd-content"><a href="/nowosci"><?=Svg::create('nowosci')?><h4>Nowości</h4></a></div>
                    
                    <?php


                            if(!empty($data['newsProducts']))
                            {
                                echo '<div class="table-container"><table class=" d-none d-md-table table table-products  table-small">
                                <tr>
                                    <th style="padding-left:8px; width:250px;">Nazwa produktu</th>
                                    <th style="width:90px; text-align:center;">Cena</th>
                                    <th style="width:95px;" class="quanity-header">Ilość</th>
                                    <th style="width:90px;     padding-right: 0px;
    padding-left: 15px;">Do koszyka</th>
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
                                            <td style="width:250px; padding-left:8px;" class="table-name"><a href="/produkt/'.$product['link'].'/'.$product['id'].'">'.$product['name'].'</a> <span title="'.$descrition.'">'.Svg::create('info').'</span><p class="product-number">'.$product['kod_produktu'].'</p></td>
                                            <td style="width:90px; text-align:center;" class="table-price-end">'.number_format(ceil($product['price']*(100-$data['user']['discount'])/10000*(100-$product['discount'])*100)/100,2).' zł</td>
                                            <td style="width:95px;" class="table-quanity"><input class="number" name="quanity" min="0" max="'.$case.'" value="'.$cartQuanity.'"> ' .$product['unit'].'<input class="d-none"  class="number"  name="id-product" value="'.$product['id'].'"></td>
                                            <td style="width:90px;     padding-right: 0px;
    padding-left: 15px;"><button class="btn block-center add-row-to-cart">'.Svg::create('koszyk').'</button></td>
                                        </tr>';

                                    if($i==5)
                                    {
                                        break;
                                    }

                                    $i++;
                                }

                                echo'</table></div>';
                            }


                    ?>

                </div>

                <div class="main-content with-table small-content no-scroll-rwd">
                    <div class="content-title d-none d-flex">
                        <?=Svg::create('historia')?>
                        <div class="content-title-text">

                            <h4>Historia zamówień</h4>
                            <a class="link-to-main-site " href="/historia-zamowien">przejdź do <b>Historii zamówień</b></a>
                        </div>
                    </div>

                    <div class=" d-block d-md-none rwd-content"><a href="/historia-zamowien"><?=Svg::create('historia')?><h4>Historia zamówień</h4></a></div>
                    
                    <?php


                            if(!empty($data['ordersHistory']))
                            {
                                echo '<div class="table-container"><table class="table d-none d-md-table table-products table-small">
                                <tr>
                                    <th style="width:120px; padding-left:19px; ">Numer zamówienia</th>
                                    <th style="width:162px; text-align:center">Data</th>
                                    <th style="width:110px;">Wartość</th>
                                    <th style="width:150px; padding-right: 0px;">Status zamówienia</th>
                                    <th style="width:150px; padding-right: 0px; padding-left: 18px;">Płatność zamówienia</th>
                                </tr>';

                                $i=1;
                                foreach($data['ordersHistory'] as $order)
                                {
                                    $descriptionLen =  strlen($product['description']);
                                    
                                    echo '<tr>
                                            <td style="padding-left:19px; width:120px;font-size:11px;">'.$order['order_number'].'</td>
                                            <td style="width:162px; font-size:12px; text-align:center;" class="product-number">'.$order['order_date'].'</td>
                                            <td style="width:96px;">'.number_format($order['pay'],2).' zł</td>
                                            <td style="width:150px; padding-right: 0px;"><span class="label" style="background-color:'.$order['color'].'">'.$order['status_name'].'</span></td>
                                            <td style="width:150px; padding-right: 0px; padding-left: 18px;"><span class="label" style="background-color:'.$order['color_paid'].'">'.$order['order_paid'].'</span></td>
                                        </tr>';

                                    if($i==5)
                                    {
                                        break;
                                    }

                                    $i++;
                                }

                                echo'</table></div>';
                            }


                    ?>

                </div>

                <div class="main-content with-table no-scroll-rwd">
                    <div class="content-title  d-none d-flex">
                        <?=Svg::create('promocje')?>
                        <div class="content-title-text">
<h4>Promocje</h4>
                            
                            <a class="link-to-main-site" href="/promocje">przejdź do <b>Promocji</b></a>
                        </div>
                    </div>
                    
                    <div class=" d-block d-md-none rwd-content"><a href="/promocje"><?=Svg::create('promocje')?><h4>Promocje</h4></a></div>

                    <?php


                            if(!empty($data['discountProducts']))
                            {
                                echo '<div class="table-container"><table class="table d-none d-md-table table-products  ">
                                <tr>
                                    <th>Fotografia</th>
                                    <th>Nazwa produktu</th>
                                    <th>Cena katalogowa</th>
                                    <th>Promocja</th>
                                    <th>Cena</th>
                                    <th class="quanity-header">Ilość</th>
                                    <th style="padding-right: 0px;
    padding-left: 15px;">Do koszyka</th>
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
                                            <td class="table-promotion">'.$product['discount'].'%</td>
                                            <td class="table-price-end">'.number_format(ceil($product['price']*(100-$data['user']['discount'])/10000*(100-$product['discount'])*100)/100,2).' zł</td>
                                            <td class="table-quanity"><input class="number" name="quanity" min="0" max="'.$case.'" value="'.$cartQuanity.'"> ' .$product['unit'].'<input class="d-none"  class="number"  name="id-product" value="'.$product['id'].'"></td>
                                            <td style="width:90px; padding-right: 0px;
    padding-left: 15px;"><button class="btn block-center add-row-to-cart">'.Svg::create('koszyk').'</button></td>
                                        </tr>';

                                    if($i==5)
                                    { 
                                        break;
                                    }

                                    $i++;
                                }

                                echo'</table></div>';
                            }


                    ?>

                </div>
            </div>
           <?=Content::rightSide($data['user']['discount'] ,$data['configPhone'][0]['value'], $data['configMail'][0]['value'],$data['news'])?>


        </div> 
    </main>
    


    <?= Notification::create()?>
    <?=Scripts::create(['/public/js/notifications.js'])?>
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
            $.post('/public/ajax/addProducts.php',{'products':productsJSON}).done(function(data)
            {

                
                let notifyText;
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
</body>
</html>