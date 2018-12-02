<?=Head::create()?>
<body>
    <?=Header::create($data['user']['mail'], $data['configLogo'][0]['value'],$data['user']['cartQuanity'])?>
    <?=navMenu::create($data['menu'])?>
    <main class="content">
        <div class="main-container">
            <div class="main-content product d-flex">
                <div class="product-data">
                    <div class="content-title"><div>
                        <?=Svg::create('kategoria')?></div>
                        <div class="content-title-text">

                            <h4><?=$data['newProduct']['name']?></h4>
                            <?php
                            $path=[];
                            function getPath(&$path,$pathArray)
                            {

                                $pathItem=['name'=>$pathArray['name'],'link'=>$pathArray['link'], 'id'=>$pathArray['id']];
                                $path[]=$pathItem;
                                if(isset($pathArray[0]) && !empty($pathArray[0]))
                                {
                                    $pathTemp=getPath($path,$pathArray[0]);
                                    if(!empty($pathTemp))
                                    {
                                        $path[]=$pathTemp;
                                    }
                                }
                                
                            }
                            getPath($path,$data['newProduct']['path']);
                            $path   = array_reverse($path);
                            echo "<span style='font-size:12px; opacity:.6;'>Kategorie</span>";
                           foreach ($path as $value){
                               $name =  $value['name'];
                               $link = $value['link'];
                               $id = $value['id'];
                               echo " <span style='opacity:.6;'>·</span> <a style='font-size:12px; opacity:.8;' href =' /kategorie/$link/$id'>$name</a>";
                           }
                           if($data['newProduct']['quanity'] == NULL){
                               $data['newProduct']['quanity'] = '0';
                           }
                            $case = $data['newProduct']['quanityInStock'] - $data['newProduct']['reservation'];
                           ?>

                        </div>
                    </div>
                    <article>
                        <h5>Opis produktu</h5>
                        <p><?=$data['newProduct']['description']?>
                        </p>
                        
                        <hr>
                        
                        <div class="product-features">
                            <div class="product-feature">
                                <h5>Cena katalogowa</h5>
                                <p><?=number_format($data['newProduct']['price'],2)?> zł</p>
                            </div>
                            <div class="product-feature ">
                                <h5>Rabat</h5>
                                <p><?=$data['user']['discount']?>%</p>
                            </div>
                            <div class="product-feature promotion">
                                <h5>Promocja</h5>
                                <p><?=$data['newProduct']['discount']?>%</p>
                            </div>
                        </div>
                        
                        <hr>

                        <div class="product-features add-features">
                             <div class="product-feature">
                                <h5>Ilość</h5>

                                <p><input class="number" name="quanity" min="1" max="<?=$case?>" value="<?=$data['newProduct']['quanity']?>"> <?=$data['newProduct']['unit']?></p>
                                <input class='d-none'  class="number"  name="id-product" value="<?=$data['productId']?>">
                            </div>
                            <div class="product-feature product-feature-price">
                                <h5>Cena</h5>
                                <?php $priceForOne=number_format(ceil(100*$data['newProduct']['price']*(100-$data['user']['discount'])/10000*(100-$data['newProduct']['discount']))/100,2)?>
                                <p class="text-large" ><span data-price-one="<?=$priceForOne?>" class="product-price"> <?=$priceForOne?></span> zł</p>
                            </div>
                            
                            <div style="position:relative;" class="add-to-store product-feature">
                                <h5></h5>
                                <p><button class="btn add-to-store-button"><?=Svg::create('koszyk')?>dodaj do koszyka</button></p>
                            </div>

                        </div>
                        
                    </article>
                </div>
                
                    
                    <?php
                      echo'      <div class="product-gallery">
                    <h5>Zdjęcia produktu</h5>';
                    if(!empty($data['newProduct']['photos']))
                    {
                        echo '

                             <div class="main-photo">
                                <a href="/public/images/products/'.$data['newProduct']['photos'][0]['link'].'" data-lightbox="product-gallery" ><img class="img-fluid" src="/public/images/products/'.$data['newProduct']['photos'][0]['link'].'" alt="'.$data['newProduct']['photos'][0]['alt'].'"></a>
                            </div>
                            ';
                        
                        unset($data['newProduct']['photos'][0]);
                        
                        if(!empty($data['newProduct']['photos']))
                        {
                            echo'<div class="secondary-photos">';
                            foreach($data['newProduct']['photos'] as $photo)
                            {
                                 echo"<a href='/public/images/products/".$photo['link']."' data-lightbox='product-gallery' ><img class='img-fluid' src='/public/images/products/".$photo['link']."' alt=".$photo['alt']."></a>";
                            }
                            echo'</div>';
                        }
                        
                        

                           

                        
                    }
                    else
                    {
                        echo'<div class="main-photo">
                                '.Svg::create('photo-01').'
                            </div>';
                    }
                     echo '</div>';
                    ?>

            </div>
           <?=Content::rightSide($data['user']['discount'], $data['configPhone'][0]['value'], $data['configMail'][0]['value'])?>
        </div> 
    </main>
    <?=Notification::create()?>
    <?=Scripts::create(['/public/js/lightbox.js','/public/js/notifications.js'])?>
    <script>
     $('.add-to-store-button').click(function()
          {
          
            var quanity=$('input[name="quanity"]').val();
            var id_product=$('input[name="id-product"]').val();
            var products={};
            var product={};
            product['id']=id_product;
            product['quanity']=quanity;
            products['0']=product;
            
            productsJSON=JSON.stringify(products);
            
            
            $.post('/public/ajax/addProducts.php',{'products':productsJSON}).done(function(data)
            {

                let notificationText;
                if(data==1)
                {
                    
                    notificationText='<?=$data['notifications'][16]['text']?>';
                    notification.notify(notificationText,'error');
                }
                else if(data==0) 
                {
                    notificationText='<?=$data['notifications'][17]['text']?>';
                    notification.notify(notificationText,'success');
                }
                else
                {
                    notificationText=data;
                    notification.notify(notificationText,'error');
                }
                
                
            });

          });
          
    
    $(function()
    {

        $('input[name="quanity"]').on('change',function()
            {
                 var quanity=parseInt($(this).val());
                 var priceForOne=parseFloat($('.product-price').attr('data-price-one'));
                 $('.product-price').text((quanity*priceForOne).toFixed(2));
            });
    });
    </script>      

</body>