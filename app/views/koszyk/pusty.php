<!DOCTYPE html>
<html>
<?=Head::create()?>
<body>
    <style>
        h2{
            font-size: 45px;
            color: #4c5968;
        }
        p{
            font-size: 13px;
            color: #4c5968;
        }
        .btnProperty {
            width: 168px;
            height: 32px;
            font-size: 12px;
            text-align: center;
        }
        .empty-cart svg
        {
          max-width:250px;
          height:auto;
          margin-right:20px;
        }
    </style>
    <?=Header::create($data['user']['mail'], $data['configLogo'][0]['value'],$data['user']['cartQuanity'])?>
    <?=navMenu::create($data['menu'])?>

    <main class="content empty-cart">
        <div class="main-container">
            <div class="main-content empty-cart d-flex align-items-center justify-content-around">
                <?=Svg::create('koszyk')?>
                    <div>
                        <h2>Twój koszyk jest pusty</h2>
                        <p>Dodaj produkty do koszyka!</p>
                        <a href="/" style="width:200px;" class="btn d-flex justify-content-center text-center" role="button">strona główna</a>
                    </div>


            </div>
           <?=Content::rightSide($data['user']['discount'] ,$data['configPhone'][0]['value'], $data['configMail'][0]['value'])?>


        </div>
    </main>


    <?=Scripts::create()?>

</body>
</html>
