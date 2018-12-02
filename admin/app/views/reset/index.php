<?=Head::create()?>
<body class="site-login">
    <main>
        <div class="login-panel">
            <form class="showed login-form" action="public/ajax/loginAdmin.php" method="post">
                <img src="/public/images/personal/logo.png" alt="Logo firmy">
                <br><br>
                <p>
                    <?=$data['notification']['text']?>
                </p>

                <p>Przejdź do <a class="link" href="/admin/"><b class="login-recover-password">systemu.</b></a></p>
            </form>


            <img class="logo" src="/public/images/icons/logo.png" alt="logo">
        </div>
    </main>
</body>