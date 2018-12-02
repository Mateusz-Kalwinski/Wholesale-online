<!DOCTYPE html>
<html>
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
                        
                        <h4>Potwierdzenie złożenia zamówienia</h4>
                        
                    </div>
                </div>
              
              <div style="height:100%;" class="d-flex align-items-center justify-content-center text-center">
                  <p  class="text-center"><?=$data['orderNumber']?></p>
              </div>
              
          </div>
        
           <?=Content::rightSide($data['user']['discount'], $data['configPhone'][0]['value'], $data['configMail'][0]['value'])?>
        </div> 
    </main>

    
    <?=Scripts::create()?>

</body>
</html>
