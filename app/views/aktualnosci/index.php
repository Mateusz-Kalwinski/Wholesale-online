<!DOCTYPE html>
<html>
<?=Head::create()?>
<body>
<?=Header::create($data['user']['mail'], $data['configLogo'][0]['value'],$data['user']['cartQuanity'])?>
<?=navMenu::create($data['menu'])?>

<main class="content">
    <div class="main-container">
        <div class="main-content news">

            <div class="content-title"><div>
                <?=Svg::create('user')?></div>
                <div class="content-title-text">
                    <h4>Aktualnosci</h4>
                </div>
            </div>
            <?php

            $html = '';
            foreach ($data['news'] as $news){
                $arrayData = explode('-', $news['news_date']);
                $newsData = implode('.', $arrayData);

                $html .='<div style="line-height: 8px; border-left: 3px solid #ff3d2e; padding: 7px 15px 0px 15px;">
                            <p style="font-size: 16px;"><b>'.$news['title'].'</b></p>
                            <p style="color: #a6adb3">'.$newsData.'</p>
                         </div>
                         <hr>
                     <div class="news-text">'.$news['content'].'</div>';
            }
            echo $html;
            ?>
        </div>
        <?=Content::rightSide($data['user']['discount'], $data['configPhone'][0]['value'] ,$data['configMail'][0]['value'])?>
    </div>
</main>
<?=Notification::create()?>
<?=Scripts::create()?>
</body>
</html>