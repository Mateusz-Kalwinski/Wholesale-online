<!DOCTYPE html>
<html>
<?=Head::create()?>
<body>
    <?=Header::create($data['user']['mail'], $data['configLogo'][0]['value'],$data['user']['cartQuanity'])?>
    <?=navMenu::create($data['menu'])?>
    
    <main class="content">
        <div class="main-container">
            <div class="main-content d-flex align-items-center justify-content-center">
                    <h2>Nie ma takiej strony</h2>
            </div>
           <?=Content::rightSide($data['user']['discount'], $data['configPhone'][0]['value'], $data['configMail'][0]['value'])?>
        </div> 
    </main>

    
    <?=Scripts::create()?>

</body>
</html>