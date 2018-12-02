<!DOCTYPE html>
<html>
<?=Head::create()?>
<body>
    <?=Header::create($data['user']['mail'], $data['configLogo'][0]['value'])?>
    <?=navMenu::create()?>
 <style>
        h5{
            font-size: 11px;
            color: #8a95a1;
            margin-bottom: 28px;
        }
        p{
            font-size: 13px;
            color: #4c5968;
            margin: 2px;
        }
        .row {
            padding: 0px 50px 0px 50px;
        }
        .space{
            margin-bottom: 40px;
        }
    </style>
    <?=Header::create($data['user']['mail'], $data['configLogo'][0]['value'])?>
    <?=navMenu::create()?>
    <main class="content">
        <div class="main-container">
          <div class="main-content">
              
              <div class="content-title">
                    <?=Svg::create('kontakt5')?>
                    <div class="content-title-text">
                        
                        <h4>Informacje o systemie</h4>
                        
                    </div>
                </div>
              <div class="container-fluid">
                    <div class="row">

                  <div class="col-lg-4 col-sm-4 space">
                      <h5>licencja</h5>
                      <p><b>Numer:</b> <?=$data['licenseInfo']['license']?></p>
                      <p><b>Opłacona do dnia:</b> <?=$data['licenseInfo']['expiration_date']?></p>
                      <p><b>Ilość klientów:</b> <?=$data['clientsQuanity']?></p>               
                  </div>
                    <div class="col-lg-4 col-sm-4">
                        <h5>producent oprogramowania</h5>
                        <p><strong><?=$data['infoDetails'][0]?></strong></p>
                        <p><?=$data['infoDetails'][1]?></p>
                        <p><?=$data['infoDetails'][2]?><?=$data['infoDetails'][3]?></p>
                    </div>
                </div>
              </div>
              
          </div>
        
        </div> 
    </main>

    <?=Scripts::create()?>
</body>
</html>