<!DOCTYPE html>
<html>
<?=Head::create()?>
<body>
    <style>
        .content
        {
            font-weight:600;
        }
        h5{
            font-size: 11px;

            margin-bottom: 28px;
        }
        p{
            font-size: 13px;
            color: #4c5968;
            margin: 2px;
        }
        .row {
            padding: 0px 0px 0px 26px;
        }
        .space{
            margin-bottom: 36px;
        }
        
        hr
        {
            margin:0;
            margin-bottom:40px;
        }
    </style>
    <?=Header::create($data['user']['mail'], $data['configLogo'][0]['value'],$data['user']['cartQuanity'])?>
    <?=navMenu::create($data['menu'])?>
    <main class="content">
        <div class="main-container">
          <div class="main-content">
              
              <div class="content-title"><div>
                    <?=Svg::create('kontakt5')?></div>
                    <div class="content-title-text">
                        
                        <h4><?=$data['title']?></h4>
                        
                    </div>
                </div>
              <div class="container-fluid">
                    <div class="row">

                  <div class="col-lg-4 col-sm-4 col-md-4 space">
                      <h5 class="light-heading">Dane firmy</h5>
                      <p><?=$data['configCampanyName'][0]['value']?></></p>
                      <p><?=$data['configAddress'][0]['value']?>
                      <p><?=$data['configCode'][0]['value'],' ', $data['configPlace'][0]['value']?>                  
                  </div>
                  <div class="col-lg-4 col-sm-4 col-md-4 space">
                      <h5 class="light-heading">Dane do przelewu</h5>
                      <p><?=$data['configAcountNumber'][0]['value']?></p>
                      <p><?=$data['configAcountData'][0]['value']?></p>

                  </div>
                  <div class="col-lg-4 col-sm-4 col-md-4 space">
                      <h5 class="light-heading">Dane kontaktowe</h5>
                      <p><?=$data['configMail'][0]['value']?></p>
                      <p><?=$data['configPhone'][0]['value']?></p>
                  </div>
                </div>
                <div  class="row">  
                    <div  class="col-12"><hr></div>
                    <div class="col-lg-4 col-sm-4 col-md-4">
                        <?php
                        $details = json_decode($data['apiDetails'], true);
                        $stringDetails = ($details['information']);
                        $arrayDetails = explode('/', $stringDetails);
                        ?>
                        <h5 class="light-heading">producent oprogramowania</h5>
                        <p><strong><?=$arrayDetails[0]?></strong></p>
                        <p><?=$arrayDetails[1]?></p>
                        <p><?=$arrayDetails[2]?><?=$arrayDetails[3]?></p>
                        <?php
                        if(!empty($details['additional'])) {
                            echo '<p>'.$details['additional'].'</p>';
                        }
                        ?>
                    </div>
                </div>
                  
              </div>
          </div>
        
           <?=Content::rightSide($data['user']['discount'], $data['configPhone'][0]['value'], $data['configMail'][0]['value'])?>
        </div> 
    </main>

    
    <?=Scripts::create()?>

</body>
</html>
