<?=Head::create()?>
<body>
    <?=Header::create($data['user']['mail'], $data['configLogo'][0]['value'],$data['user']['cartQuanity'])?>
    <?=navMenu::create($data['menu'])?>

    <main class="content">
        <div class="main-container">
            <div class="main-content">

                <div class="content-title"><div>
                    <?=Svg::create('koszyk')?></div>
                    <div class="content-title-text">
                        <h4>Twoje zamówienie</h4>
                    </div>
                </div>
                <div class="order-header">
                     <?=Svg::create('koszyk')?>
                    <div class="title">
                        <h2>Twój koszyk</h2>
                        <p><span class="opacity">Ilość produktów: </span><b><span class="quanity"><?=$data['cartQuanity']?></span> szt.</b></p>
                    </div>
                    <div class="value">
                        <p><span class="opacity">wartość:</span> <b><span class="amount"><?= number_format(ceil(100*$data['cartValue'])/100,2)?></span> zł</b></p>
                    </div>
                </div>

                <form class="order-form" action="/public/ajax/addArchives.php" method="post">
                    <label for="#comment">Uwagi do zamówienia</label>
                    <textarea id="comment" name="comment" placeholder="Twoje informacje dla nas" class="input-custom"></textarea>

                    <label for="#delivery">Forma dostawy i płatności:</label>
                    <select id="delivery" name="delivery" class="input-custom">
                        <?php
                        $cartPrice =  number_format(ceil(100*$data['cartValue'])/100,2);
                        $minPrice = $data['configMinPrice'][0]['value'];
                        $defaultDeliveryPrice=($cartPrice>$minPrice )&& $data['payment'][0]['free_delivery']==1?0:$data['payment'][0]['delivery_price_1'];
                        foreach($data['payment'] as $payment)
                        {
                            if($cartPrice>$minPrice and $payment['free_delivery'] ==1){
                                $price = 0;
                            }else{
                                $price = $payment['delivery_price_1'];
                            }
                                echo'<option data-payment="'.$price.'" value="'.$payment['paymentId'].'">'.$payment['name'].' - '.$payment['method_payment'].' + '.$price.' zł</option>';

                        }

                        ?>
                    </select>
                    <label for="#address">Adres dostawy:</label>
                    <select id="address" name="address" class="input-custom">
                        <option selected>Wybierz adres dostawy</option>
                        <?php
                        foreach($data['addresses'] as $address)
                        {
                            echo'<option data-address="'.$address['adres'].'" data-postal="'.$address['kod'].'" data-place="'.$address['miasto'].'" data-phone="'.$address['telefon'].'" >'.$address['nazwa'].'</option>';
                        }
                        
                        ?>
                    </select>
                   
                    <div class="delivery-address">
                        <input class="input-custom" value="<?=$data['user']['username']?>" name="name" placeholder="Imię i nazwisko"><br>
                        <input class="input-custom" name="address" placeholder="Adres"><br>
                        <input class="input-custom" name="postal" placeholder="Kod pocztowy"><br>
                        <input class="input-custom" name="place" placeholder="Miejscowość"><br>
                        <input class="input-custom" name="phone" placeholder="Telefon"><br>
                    </div>
                    <div class="order-summary d-flex w-100 justify-content-center justify-content-sm-end">
                        <div class="order-price-end">
                            <span>RAZEM:</span> <b><span data-additional-price="<?=$defaultDeliveryPrice?>" class="price-end"><?= number_format($data['cartValue']+$defaultDeliveryPrice,2)?></span> zł</b>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between w-100 align-items-center flex-column-reverse flex-sm-row">
                        <a href="/koszyk" class="button-secondary">wstecz</a>
                        <button class="btn" type="submit"><?=Svg::create('koszyk')?> złóż zamówienie</button>
                    </div>

                </form>
                
            </div>
        <?=Content::rightSide($data['user']['discount'], $data['configPhone'][0]['value'],$data['configMail'][0]['value'])?>
        </div>
    </main>
    <form method="post" class='d-none order-message-form' action="/potwierdzenie"><textarea name="orderMessage"></textarea></form>
    <?=Notification::create()?>
    <?=Scripts::create(['/public/js/notifications.js'])?>
    <script>
        $('select').selectmenu();

        $(document).on('click','#address-menu li',function()
        {
            var deliverySelect=$('#address option:selected');
           $('.delivery-address input').each(function()
           {
             if($(this).attr('name')!='name')
             {
                var dataSelector='data-'+$(this).attr('name');
                var value=deliverySelect.attr(dataSelector);
                console.log(value);
                $(this).val(value);
             }

           });
        });

        $(document).on('click','#delivery-menu li',function()
        {
            var deliverySelect=$('#delivery option:selected');
            var additionalPrice=parseFloat(deliverySelect.attr('data-payment'));

            var currentPriceSelector=$('.order-price-end .price-end');

            var currentPrice=parseFloat(currentPriceSelector.text());
            var currentAdditionalPrice=parseFloat(currentPriceSelector.attr('data-additional-price'));

            var newPrice=currentPrice-currentAdditionalPrice+additionalPrice;

            newPrice=newPrice.toFixed(2);

            currentPriceSelector.text(newPrice);
            currentPriceSelector.attr('data-additional-price',additionalPrice);
        });

        $('.order-form').submit(function(e)
        {
            e.preventDefault();
            var comment=$('#comment').val();
            var delivery=$('#delivery').val();
            var name=$('.delivery-address input[name="name"]').val();
            var address=$('.delivery-address input[name="address"]').val();
            var postal=$('.delivery-address input[name="postal"]').val();
            var place=$('.delivery-address input[name="place"]').val();
            var phone=$('.delivery-address input[name="phone"]').val();
            console.log('test');
            $.post('/public/ajax/addArchives.php',{'name':name,'address':address,'postal':postal,'place':place,'phone':phone,'delivery':delivery,'comment':comment}).done(function(data)
            {
                let notificationText;
                console.log(data.charAt(0));
                console.log(data);
                if(data.indexOf('[SUKCES]')>=0)
                {
                  data=data.replace('[SUKCES]','');
                  
                  let form=$('.order-message-form');
                  form.find('textarea').html(data);
                  form.submit();
                  
                }
                else
                {
                    notificationText=data;
                    notification.notify(notificationText,'error');
                }
            });
        });

    </script>
</body>
