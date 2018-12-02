<!DOCTYPE html>
<html>
<?=Head::create()?>
<body class="site-login">
    <main>
        <div class="login-panel">
            <form class="showed login-form" action="public/ajax/loginAdmin.php" method="post">
                <img src="/public/images/personal/logo.png" alt="Logo firmy">
                <p class="form-error invisible">Błędny login lub hasło</p>
                <div class="form-group">
                    <label for="mail" class="sr-only">Nazwa użytkownika</label>
                    <span>
                        <?=Svg::create('user')?>
                        <input name="mail" type="text" class="form-control" id="mail" placeholder="adres e-mail">
                    </span>
                    <label for="password" class="sr-only">Hasło</label>
                    <span>
                        <?=Svg::create('klodka')?>
                        <input name="password" type="password" class="form-control" id="password" placeholder="hasło">
                    </span>
                </div>

                <button class="btn" type="submit">zaloguj się</button>

                <p>Nie pamiętasz hasła? <b class="login-recover-password">Przywróć hasło.</b></p>
            </form>
                        <form class="recover-password " action="public/ajax/changePasswordAdmin.php" method="post">
                <img src="/public/images/personal/logo.png" alt="Logo firmy">
                <p class="form-error invisible">Brak użytkownika o tej nazwie</p>
                <div class="form-group">
                    <label for="passwordUser" class="sr-only">Adres e-mail</label>
                    <span>
                        <?=Svg::create('user')?>
                        <input name="mail" type="text" class="form-control" id="passwordMail" placeholder="adres e-mail">
                    </span>
                    <label for="passwordNew" class="sr-only">Nowe hasło</label>
                    <span>
                         <?=Svg::create('klodka')?>
                        <input name="password" type="password" class="form-control" id="passwordNew" placeholder="nowe hasło">
                    </span>
                </div>

                <button class="btn" type="submit">Zmień hasło</button>

                <p>Powrót do <b class="login-recover-password">logowania.</b></p>
            </form>
 
            <?=Svg::create('platforma')?>
        </div>
    </main>

    
    
    <?=Scripts::create()?>
    <script>
        $('.login-panel form.login-form').submit(function(e)
        {
            e.preventDefault();
            $('.form-error').addClass('invisible');
            var username=$(this).find('input[name="mail"]').val();
            var password=$(this).find('input[name="password"]').val();
            $.post('/admin/public/ajax/loginAdmin.php',{'mail':username,'password':password}).done(function(data)
            {
                var response =data.charAt(0);

                if(response==0)
                {
                    $('.form-error').removeClass('invisible');
                    $('.form-error').text('<?=$data['notifications'][0]['text']?>');
                }
                else if(response==1) 
                {
                    window.location.replace("/admin/"+data.substr(1));
                }
                else if(response==2)
                {
                    window.location.replace("/konto-nieaktywne");
                }
                else if (response ==4)
                {
                    $('.form-error').removeClass('invisible');
                    $('.form-error').text('<?=$data['notifications'][9]['text']?>');
                }
                else
                {
                    $('.form-error').removeClass('invisible');
                    $('.form-error').text(data);
                }
                
                console.log(data);
                
            });
            

             
        });
        
        $('.login-panel form.recover-password').submit(function(e)
        {
            e.preventDefault();
            $('.form-error').addClass('invisible');
            var mail=$(this).find('input[name="mail"]').val();
            var password=$(this).find('input[name="password"]').val();
            $.post('/admin/public/ajax/changePasswordAdmin.php',{'mail':mail,'password':password}).done(function(data)
            {


                if(data==1)
                {
                    $('.form-error').removeClass('invisible');
                    $('.form-error').text('<?=$data['notifications'][3]['text']?>');
                }
                else if(data==3) 
                {
                    $('.form-error').removeClass('invisible');
                    $('.form-error').text('<?=$data['notifications'][2]['text']?>');
                }
                else
                {
                    $('.form-error').removeClass('invisible');
                    $('.form-error').text('<?=$data['notifications'][9]['text']?>');
                }
                
                console.log(data);
                
            });
        });
        
        $('.login-recover-password').click(function()
        {
            var toggleForm=$(this);
             toggleForm.parent().hide()
            $('form.showed').fadeOut(400,function()
            {
                $('form').toggleClass('showed');
                $('form.showed').fadeIn();
                toggleForm.parent().show();
            });

        });

    </script>
</body>
</html>