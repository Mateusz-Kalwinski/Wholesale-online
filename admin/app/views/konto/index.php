<?=Head::create()?>

<body>
    <style>
        .inputProperty{
            margin-bottom: 12px !important;
            padding: 0px 20px 0px 20px;
            color: #8a95a1 !important;
            width: 250px;
            text-align: left !important;
        }
    </style>
    <?=Header::create($data['user']['mail'], $data['configLogo'][0]['value'])?>
    <?=navMenu::create($data['menu'])?>

    <main class="content account">
        <div class="main-container">
            <div class="main-content">

                <div class="content-title">
                    <?=Svg::create('ustawienia')?>
                    <div class="content-title-text">
                        <h4 style="margin-top:5px; white-space: nowrap; margin-bottom:5px;">Ustawienia konta</h4>
<!--                    <p><span data-option="dane-konta" class="active">dane konta</span> | <span data-option="zmien-haslo">zmień hasło</span></p>-->
                        <button data-option="zmien-haslo" class="btn change-option"><?=Svg::create('ustawienia')?><span class="active">zmień hasło</span></button>
                        <button style="display:none;" data-option="dane-konta" class="btn change-option"><?=Svg::create('ustawienia')?><span class="active">dane konta</span></button>
                    </div>

                </div>
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-lg-4 col-sm-4 space">
                            <h5 style="color: #8a95a1; font-size: 11px;">Dane firmy:</h5>
                            <address style="font-size: 13px; color: #4c5968;">
                                <b>Nazwa:</b> <?=$data['user']['username']?><br>
                                <b>Adres:</b> <?=$data['user']['dane_adres']?><br>
                                <b>Kod pocztowy:</b> <?=$data['user']['dane_kod']?><br>
                                <b>Miejscowość:</b> <?=$data['user']['dane_miejscowosc']?><br>
                                <b>NIP:</b> <?=$data['user']['nip']?><br>
                            </address>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <h5 style="color: #8a95a1; font-size: 11px; text-align: left;">Dane kontaktowe:</h5>
                            <div style="font-size: 13px; color: #4c5968;">
                            <b>E-mail: </b><?=$data['user']['mail']?><br>
                            <b>Telefon: </b></label><?=$data['user']['telefon']?>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-option="dane-konta"  id="zmien-haslo" class="user-data">
                    <div class="d-flex justify-content-center align-items-center text-right">
                        <form class="change-password" action="/amdin/public/ajax/changePasswordAdmin" method="post">
                            <h5 class="text-center">Zmień hasło:</h5>
                            <label for="#currentPassword"><b>Obecne hasło:</b>
                            <input id="currentPassword" value="" type="password" name="currentPassword"></label><br>
                            <label for="#newPassword"><b>Nowe hasło:</b>
                            <input value="" id="newPassword" type="password" name="password">
                            <input value="<?=$data['user']['mail']?>" type="hidden" class="d-none" name="mail"></label><br>
                            <button type="submit" class="btn">Zmień</button>
                        </form>
                    </div>
                    <div class="password-key-info text-center">
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?=Notification::create()?>
    <?=Scripts::create(['/admin/public/js/notifications.js'])?>

    <script>
        $('.add-shipment').click(function()
        {
            var newShipment=$('.new-shipment-form.d-none').clone();
            $('.add-shipment').before(newShipment);
            $('.new-shipment-form').eq(-2).removeClass('d-none');
            $('.new-shipment-form').eq(-2).find('form').addClass('add');
        });


        $('.shipment-data').on('submit','.shipments form.add',function(e)
        {
            e.preventDefault();
                var name=$(this).find('input[name="name"]').val();
                var address=$(this).find('input[name="address"]').val();
                var postal=$(this).find('input[name="postal"]').val();
                var place=$(this).find('input[name="place"]').val();
                var phone=$(this).find('input[name="phone"]').val();
                var form=$(this);
                $.post('/public/ajax/updateAddress.php',{'nazwa':name,'adres':address,'kod':postal,'miasto':place,'telefon':phone,'option':0}).done(function(data)
                {


                    if(data==1)
                    {

                        $('.modal-body').text('<?=$data['notifications'][4]['text']?>');
                        $('.change-data-info').fadeIn();

                    }
                    else if(data==0)
                    {
                        $('.modal-body').text('<?=$data['notifications'][5]['text']?>');
                        $('.change-data-info').fadeIn();

                        form.find('button.save-button').text('Zmień').removeClass('save-button');
                        form.find('button.cancel-button').text('Usuń').removeClass('cancel-button').addClass('delete-button');
                        form.removeClass('add');
                        form.addClass('change');
                        form.find('input[name="name"]').attr('readonly',true);
                    }
                    else if(data==2)
                    {
                        $('.modal-body').text('<?=$data['notifications'][6]['text']?>');
                        $('.change-data-info').fadeIn();


                    }
                    else
                    {
                        $('.modal-body').text('Wystąpił błąd: '+data);
                        $('.change-data-info').fadeIn();
                    }
                    $('#notification').modal('toggle');


                });



        });
        $('.shipments').on('click','.cancel-button',function()
        {
           $(this).parents('.new-shipment-form').remove();
        });

        $('.shipments').on('click','.delete-button',function()
        {
             var form = $(this).parents('.shipments').find('form');
             var name=form.find('input[name="name"]').val();
             var address=form.find('input[name="address"]').val();
             var postal=form.find('input[name="postal"]').val();
             var place=form.find('input[name="place"]').val();
             var phone=form.find('input[name="phone"]').val();
             var button=$(this);
             console.log(form);
                $.post('/public/ajax/updateAddress.php',{'nazwa':name,'adres':address,'kod':postal,'miasto':place,'telefon':phone,'option':2}).done(function(data)
                {
                button.parents('.new-shipment-form').remove();
                });


        });

        $('.change').click(function()
        {
            $(this).next('form').trigger('submit');
        })

        $('.shipment-data').on('submit','.shipments form.change',function(e)
        {
            e.preventDefault();
                var name=$(this).find('input[name="name"]').val();
                var address=$(this).find('input[name="address"]').val();
                var postal=$(this).find('input[name="postal"]').val();
                var place=$(this).find('input[name="place"]').val();
                var phone=$(this).find('input[name="phone"]').val();
                $.post('/public/ajax/updateAddress.php',{'nazwa':name,'adres':address,'kod':postal,'miasto':place,'telefon':phone,'option':1}).done(function(data)
                {


                    if(data==1 || data==2)
                    {
                        $('.modal-body').text('<?=$data['notifications'][8]['text']?>');
                    }
                    else if(data==0)
                    {
                        $('.modal-body').text('<?=$data['notifications'][7]['text']?>');
                    }
                    else
                    {
                        $('.modal-body').text('Wystąpił błąd: '+data);
                    }

                $('#notification').modal('toggle');
                });


        });

        $('.change-option').click(function()
        {
            let button=$(this);
            $('.change-option').fadeIn(function()
            {
              button.hide();
            });



            var optionId='#'+$(this).attr('data-option');

            $('.user-data:visible').fadeOut(400,function()
            {
                 $(optionId).fadeIn();
            });

        });

        $('form.change-password').submit(function(e)
        {
            e.preventDefault();
        });
        /*$('form.change-mail').submit(function(e)
        {
            e.preventDefault();
            $('.password-key-info').fadeOut();
            var mail=$(this).find('input[name="mail"]').val();
            var phone=$(this).find('input[name="phone"]').val();

            $.post('/public/ajax/changeMail.php',{'mail':mail,'phone':phone}).done(function(data)
            {


                if(data==1)
                {

                    $('.change-data-info').text('Wprowadzono błędne dane.');
                    $('.change-data-info').fadeIn();
                }
                else if(data==0)
                {
                    $('.change-data-info').text('Dane zostały zmienione.');
                    $('.change-data-info').fadeIn();
                }
                else
                {
                    $('.change-data-info').text(data);
                    $('.change-data-info').fadeIn();
                }
                $('#notification').modal('toggle');

            });
                    });*/

            $('form.change-password').submit(function(e)
        {
            e.preventDefault();
            $('.password-key-info').fadeOut();
            var mail=$(this).find('input[name="mail"]').val();
            var password=$(this).find('input[name="password"]').val();
            var currentPassword=$(this).find('input[name="currentPassword"]').val();
            $.post('/admin/public/ajax/changePasswordAdmin.php',{'mail':mail,'password':password,'currentPassword':currentPassword}).done(function(data)
            {
                if(data==1)
                {

                    let notificationText='<?=$data['notifications'][4]['text']?>';
                    notification.notify(notificationText,'error');
                }
                else if(data==3)
                {
                    let notificationText='<?=$data['notifications'][2]['text']?>';
                    notification.notify(notificationText,'success');
                }
                else if (data==4)
                {
                     let notificationText='<?=$data['notifications'][9]['text']?>';
                    notification.notify(notificationText,'error');
                }
                else
                {
                    let notificationText='Wystąpił błąd: '+data;
                    notification.notify(notificationText,'error');
                }

            });
        });






    </script>

</body>