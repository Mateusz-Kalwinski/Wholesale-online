<?php
class Head
{
    public static function create($title='system zamówień', $description='')
    {
       $html='
            <head lang="pl">
                <meta charset="utf-8">
                <meta http-equiv="x-ua-compatible" content="ie=edge">
                <title>'.$title.'</title>
                <meta name="description" content="'.$description.'">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <link href="/public/css/style.css" rel="stylesheet">
            </head>';

        return $html;
    }
}

class navMenu
{
    public static function subCategories($fork)
    {
        echo'<ol class="submenu">';

                foreach($fork as $subCategory)
                {
                    echo'<li><div class="'.(!empty($subCategory['subcategories'])?' to-click ':'').' category-title"><a href="/kategorie/'.$subCategory['link'].'/'.$subCategory['id'].'">'.$subCategory['name'].'</a>';

                    if(!empty($subCategory['subcategories']))
                    {
                        echo '<div class="menu-dropdown">'.Svg::create('strzalka').'</div></div>';
                        self::subCategories($subCategory['subcategories']);
                    }
                    else
                    {
                        echo '</div>';
                    }


                    echo'</li>';
                }
        echo '</ol>';
    }

    public static function create($menuContent)
    {
        echo'<nav class="nav-main">

        <ul>
            <li><div class="category-title"><div class="container-category-icon">'.Svg::create('glowna').'</div><a href="/">Strona główna</a></li>
            <li><div class="category-title"><div class="container-category-icon">'.Svg::create('historia').'</div><a href="/historia-zamowien">Historia zamówień</a></li>
            <li><div class="category-title"><div class="container-category-icon">'.Svg::create('kontakt1').'</div><a href="/kontakt">Kontakt</a></li>
        </ul>

        <span style="font-weight:600" class="section-name">PRODUKTY</span>

        <ul>';
        echo'<li><div class="category-title"><div class="container-category-icon">'.Svg::create('promocje').'</div><a href="/promocje">Promocje</a></li>
            <li><div class="category-title"><div class="container-category-icon">'.Svg::create('nowosci').'</div><a href="/nowosci">Nowości</a></li>';
        foreach($menuContent as $menuItem)
        {
            echo '<li ><div class="category-title '.(!empty($menuItem['subcategories'])?'to-click':'').'"><div class="container-category-icon">'.Svg::create('kolo_kat').'</div><a href="/kategorie/'.$menuItem['link'].'/'.$menuItem['id'].'">'.$menuItem['name'].'</a>';

            if(!empty($menuItem['subcategories']))
            {
                echo '<div class="menu-dropdown">'.Svg::create('strzalka').'</div></div>';
                self::subCategories($menuItem['subcategories']);
            }
            else
            {
                echo '</div>';
            }

            echo'</li>';


        }



    echo'    </ul>
        <img src="/public/images/icons/logo.png" alt="logo">
    </nav>';

    }
}

class Content
{
    public static function rightSide($discount, $phone, $mail, $data=false)
    {
        $html='
                        <div class="right-side">
                <div class="right-side-contact">
                    <div class="right-side-element-top">
                        <h5>'.Svg::create('kontakt5').'Kontakt</h5>
                        <a href="/kontakt">przejdź do <b>Kontaktu</b></a>
                    </div>
                    <div class="right-side-contact-content">
                        <address class="phone"><a href="tel:'.$phone.'">'.$phone.'</a></address>
                        <address class="mail"><a href="mailto:'.$mail.'">'.$mail.'</a></address>
                    </div>
                </div>
                <div class="right-side-discount">
                    <div class="right-side-element-top">
                        <h5>'.Svg::create('promocje').'Przyznany rabat</h5>
                    </div>

                    ';
        if($discount!==0)
        {
            $html.='                    <div class="right-side-discunt-content">
                        '.$discount.'%
                    </div>
                    </div>';
        }
        if(!empty($data)){
            $html .='<div class="right-side-contact right-side-news" style="background-color: #ffffff; height:250px; overflow-y: hidden;">
                    <div style="margin-bottom: 5px" class="right-side-element-top">
                        <h5>'.Svg::create('user').'<b>Aktualności</b></h5>
                    </div>
                    <div  style=" padding: 20px; background-color: #ffffff;">';
            foreach ($data as $news){

                $arrayData = explode('-', $news['news_date']);
                $newsData = implode('.', array_reverse($arrayData));

                $html .='<div style="line-height: 8px; border-left: 3px solid #ff3d2e; padding: 7px 15px 0px 15px;">
                            <p><b>'.$news['title'].'</b></p>
                            <p style="color: #a6adb3">'.$newsData.'</p>
                         </div>
                         <hr>
                     <div class="right-side-news-content">'.$news['content'].'</div>';
            }
            $html .='</div></div>';
        }


           $html.='</div>';

           return $html;
    }

}

class Svg
{
    public static function create($name)
    {
        return file_get_contents(dirname(dirname(dirname(dirname(__FILE__))))."/public/images/icons/{$name}.svg");
    }
}

class Header
{
    public function create($username, $logo,$cartQuanity)
    {
        $html='
            <header>
        <div class="header-main">
            <button class=" d-md-none show-nav"><div class="menu-bars"></div></button>
            <a href="/"><img src="'.$logo.'"  alt=""></a>

            <div class="search">
                <form action="" method="post">
                    <button type="submit"><img src="/public/images/icons/wyszukaj.png" alt=""></button>
                    <input autocomplete="off"  class="d-none d-sm-inline" type="text" name="keywords" placeholder="Wyszukaj">
                </form>
                <div class="search-close">'.Svg::create('x').'</div>
                <ol class=search-results>
                </ol>
            </div>
            <a href="/koszyk">
                
                '.Svg::create('koszyk').'
                <span class="d-none d-md-inline" >Twój koszyk</span>
                '.(!empty($cartQuanity)?('<span style="font-size:10px;">&nbsp;('.$cartQuanity.')</span>'):'').'
            </a>
            <a class="news-bell" href="/aktualnosci">'.Svg::create('dzwonek').'</a>
            <div class="user-dropdown">
                <button type="button" class="show-user dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    '.Svg::create('user').'
                    <span class="d-none d-xl-inline" >'.$username.'</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="/konto">Ustawienia</a>
                    <a class="dropdown-item" href="/wyloguj">Wyloguj</a>
                  </div>
            </div>
        </div>
    </header>
            ';
        return $html;
    }
}

class Notification
{
    public static function create()
    {
        return '
                <div class="notification">
        <aside>
            <p class="notification-text">
                
            </p>
        </aside>
    </div>
            ';
    }
}

class Scripts
{
    public static function create($uniqueScripts=[],$inlineScripts=[])
    {
        $html='
            <script src="/public/js/jquery-3.3.1.min.js"></script>
            <script src="/public/js/bootstrap.bundle.min.js"></script>
            <script src="/public/js/jquery.mCustomScrollbar.js"></script>
            <script src="/public/js/jquery-ui.min.js"></script>
            <script src="/public/js/jquery.sticky-kit.min.js"></script>
            ';

        $html.="<script>
            $('.to-click').click(function()
            {
                if(!$(event.target).is('a'))
                {
                
                selectedListItem=$(this).parent('li');
                selectedListItem.toggleClass('showed');
                selectedListItem.children('ol').slideToggle();
                }
            });


            (function($){
                $(window).on(\"load\",function(){
                    $(\".nav-main\").mCustomScrollbar();
                    $(\".search-results\").mCustomScrollbar();
                    $(\".main-content.with-table\").mCustomScrollbar({axis:'x'});
                    $(\".right-side-news\").mCustomScrollbar();
                });
            })(jQuery);

            $('.show-nav').click(function()
            {
                $('.nav-main').toggleClass('nav-showed');
            });

         $('.search input').keyup(function()
        {
            var keywords=$(this).val();

            var form=$(this).parents('form');
            if(keywords.length>0)
            {
                form.attr('action','/wyszukaj/'+keywords);
            }
            else
            {
                form.attr('action','#');
            }

            if(keywords.length>2)
            {
                $.ajax({
                dataType: 'json',
                type: 'POST',
                url: '/public/ajax/navBar.php',
                data: {'keywords':keywords}
                })
                  .done(function( msg ) {
                  console.log(msg);
                    var results='';
                    $.each(msg,function(key,val)
                    {

                        results+='<a href=\"/produkt/'+val['link']+'/'+val['id']+'\"><li>'+val['name']+'</li></a>';
                    });
                      $('.search-results .mCSB_container').html(results);
                      $('.search-results').fadeIn();
                  });
            }
            else
            {
                $('.search-results').fadeOut();
            }


        });

            </script>
        <script>
        $(function()
        {
           $('.nav-main a').each(function()
           {
               var link=$(this).attr('href');
               console.log(link);
               var url=window.location.pathname;

               if(url===link)
               {
                   $(this).parents('li').addClass('active');
                   $('.nav-main li.active').children('.submenu').slideDown();
                    $('.nav-main li.active').addClass('showed');
                   $('.nav-main li.active').eq(-1).addClass('active-last');
               }

           });

          $('a[href=\"/wyloguj\"]').click(function(e)
          {
            e.preventDefault();
            $.get('/public/ajax/wyloguj.php',function()
            {

                window.location.replace('/login');

            });
          });




        });
        
        
        $(function()
        {
            
        $('input.number').keydown(function (e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                     // Allow: Ctrl+A, Command+A
                    (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
                     // Allow: home, end, left, right, down, up
                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                         // let it happen, don't do anything
                         return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });

        });

    </script>
            ";

        foreach($uniqueScripts as $script)
        {
            $html.='<script src="'.$script.'"></script>';

        }

        foreach($inlineScripts as $script)
        {
            $html.='<script>'.$script.'</script>';
        }


        return $html;
    }
}
