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
                <link href="/admin/public/css/style.css" rel="stylesheet">
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
                    echo'<li><div class="category-title"><a href="/kategorie/'.$subCategory['link'].'/'.$subCategory['id'].'">'.$subCategory['name'].'</a>';

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

    public static function create()
    {
        echo'<nav class="nav-main">
        <span class="section-name">Zarządzanie</span>
        <ul>';

        echo '<li><div class="category-title"><div class="container-category-icon">'.Svg::create('kolo_kat').'</div><a href="/admin/klienci">Klienci</a>';echo'</li>';
        echo '<li><div class="category-title to-click"><div class="container-category-icon">'.Svg::create('kolo_kat').'</div><a href="/admin/produkty">Produkty</a>';
        echo '<div class="menu-dropdown">'.Svg::create('strzalka').'</div></div>';
            echo'<ol class="submenu">';
                echo'<li><div class="category-title"><a href="/admin/produkty/promocje">promocje</a></div></li>';
                echo'<li><div class="category-title"><a href="/admin/produkty/nowosci">nowości</a></div></li>';
            echo '</ol>';
        echo'</li>';
        echo '<li><div class="category-title"><div class="container-category-icon">'.Svg::create('kolo_kat').'</div><a href="/admin/kategorie">Kategorie</a>';echo'</li>';
        echo '<li><div class="category-title"><div class="container-category-icon">'.Svg::create('kolo_kat').'</div><a href="/admin/konfiguracja">Konfiguracja</a>';echo'</li>';
        echo '<li><div class="category-title"><div class="container-category-icon">'.Svg::create('kolo_kat').'</div><a href="/admin/informacja-o-systemie">Informacja o systemie</a>';echo'</li>';
        echo '<li><div class="category-title"><div class="container-category-icon">'.Svg::create('kolo_kat').'</div><a href="/admin/powiadomienia">Powiadomienia</a>';echo'</li>';
        echo '<li><div class="category-title"><div class="container-category-icon">'.Svg::create('kolo_kat').'</div><a href="/admin/zamowienia">Zamówienia</a>';echo'</li>';








    echo'    </ul>
        <img src="/public/images/icons/logo.png" alt="logo">
    </nav>';

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
    public function create($username, $logo)
    {
        //Search left because it has to take place in flexbox
        $html='
            <header>
        <div class="header-main">
            <button class=" d-md-none show-nav">'.Svg::create('three-bars').'</button>
            <a href="/admin"><img src="'.$logo.'"  alt=""></a>

            <div class="search"></div>
            <div class="user-dropdown">
                <button type="button" class="show-user dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    '.Svg::create('user').'
                    <span class="d-none d-md-inline" >'.$username.'</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="/admin/konto">Ustawienia</a>
                    <a class="dropdown-item" href="/admin/wyloguj">Wyloguj</a>
                  </div>
            </div>
        </div>
    </header>
            ';
        return $html;
    }
}

class ClientForm
{
    public static function create($id,$title,$ajaxUrl)
    {
        echo'
        <div class="modal fade" id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="editUserLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">'.$title.'</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form class="ajax" method="post" action="'.$ajaxUrl.'">
                  <input type="hidden" name="id" class="input-custom" id="'.$id.'-id">
                  <div class="modal-body">
                      <div class="form-group">
                        <label for="'.$id.'-name" class="form-control-label">Nazwa:</label>
                        <input type="text" name="username" class="input-custom" id="'.$id.'-name">
                      </div>
                      <div class="form-group">
                        <label for="'.$id.'-nip" class="form-control-label">NIP:</label>
                        <input type="text" name="nip" class="input-custom" id="'.$id.'-nip">
                      </div>
                        <div class="form-group">
                        <label for="'.$id.'-phone" class="form-control-label ">Telefon:</label>
                        <input type="text" name="phone" class="input-custom" id="'.$id.'-phone">
                      </div>
                       <div class="form-group">
                        <label for="'.$id.'-mail" class="form-control-label">E-mail:</label>
                        <input type="text" name="mail" class="input-custom" id="'.$id.'-mail">
                      </div>
                        <div class="form-group">
                        <label for="'.$id.'-street" class="form-control-label">Ulica:</label>
                        <input type="text" name="address" class="input-custom" id="'.$id.'-street">
                      </div>
                      <div class="form-group">
                        <label for="'.$id.'-place" class="form-control-label">Miejscowość:</label>
                        <input type="text" name="place" class="input-custom" id="'.$id.'-place">
                      </div>
                      <div class="form-group">
                        <label for="'.$id.'-code" class="form-control-label">Kod pocztowy:</label>
                        <input type="text" name="code" class="input-custom" id="'.$id.'-code">
                      </div>
                       <div class="form-group">
                        <label for="'.$id.'-discount" class="form-control-label">Rabat:</label>
                        <input type="number" name="discount" value="0" min="0" max="100" step="1" class="input-custom" id="'.$id.'-discount">
                      </div>
                      <div class="form-group on-off">
                          <label for="'.$id.'-state-on" class="form-control-label">Stan:</label><br>
                        <input type="radio" value="1" name="status" class="form-control" id="'.$id.'-state-on">
                        <input type="radio" value="2" name="status" checked class="form-control" id="'.$id.'-state-off">
                        <div class="switch"></div>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-primary">Zapisz</button>
                  </div>
                 </form>
                </div>
              </div>
            </div>
        ';

    }
}

class CategoryForm
{
    private static function categoriesToSelect($categoriesLevel,$childSymbol='')
    {
        foreach($categoriesLevel as $category)
        {
            echo '<option value="'.$category['id'].'">'.$childSymbol.$category['name'].'</option>';
            
             if(!empty($category['subcategories']))
            {
                self::categoriesToSelect($category['subcategories'],$childSymbol.'--');
            }
        }

    }
    
    public static function create($id,$title,$ajaxUrl,$categories)
    {
        echo'
        <div class="modal fade" id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="editUserLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">'.$title.'</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form class="ajax" method="post" action="'.$ajaxUrl.'">
                  <input type="hidden" name="id" class="input-custom" id="'.$id.'-id">
                  <div class="modal-body">
                      <div class="form-group">
                        <label for="'.$id.'-name" class="form-control-label">Nazwa:</label>
                        <input type="text" name="categoryName" class="input-custom" id="'.$id.'-name">
                      </div>
                      <div class="form-group">
                        <label for="'.$id.'-name" class="form-control-label">Kategoria nadrzędna:</label><br>
                        <select name="idParent" class="select-with-search">
                            <option checked value="0">brak</option>';
                        
                            self::categoriesToSelect($categories);
                
        echo'           </select>
                      </div>

                      <div class="form-group on-off">
                          <label for="'.$id.'-state-on" class="form-control-label">Widoczność:</label><br>
                        <input type="radio" value="1" name="state" class="form-control" id="'.$id.'-state-on">
                        <input type="radio" value="2" name="state" checked class="form-control" id="'.$id.'-state-off">
                        <div class="switch"></div>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-primary">Zapisz</button>
                  </div>
                 </form>
                </div>
              </div>
            </div>
        ';

    }
}

class ProductForm
{
    public static function create($id,$title,$ajaxUrl)
    {
        echo'
        <div class="modal fade" id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="editProductLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">'.$title.'</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form class="ajax" method="post" action="'.$ajaxUrl.'">
                  <input type="hidden" name="id" class="input-custom" id="'.$id.'-id">
                  <div class="modal-body">
                      <div class="form-group">
                        <label for="'.$id.'-name" class="form-control-label">Nazwa:</label>
                        <input type="text" name="name" class="input-custom" id="'.$id.'-name">
                      </div>
                       <div class="form-group">
                        <label for="'.$id.'-product-code" class="form-control-label">Kod produktu:</label>
                        <input type="text" name="product_code" class="input-custom" id="'.$id.'-product_code">
                      </div>
                      <div class="form-group">
                        <label for="'.$id.'-description" class="form-control-label">Opis:</label>
                        <textarea name="description" class="input-custom" id="'.$id.'-description"></textarea>
                      </div>
                        <div class="form-group">
                        <label for="'.$id.'-price" class="form-control-label ">Cena:</label>
                        <input type="text" name="price" class="input-custom" id="'.$id.'-price">
                      </div>
                       <div class="form-group">
                        <label for="'.$id.'-unit" class="form-control-label">Jednostka:</label>
                        <input type="text" name="unit" class="input-custom" id="'.$id.'-unit">
                      </div>

                        <div class="form-group">
                        <label for="'.$id.'-quanity" class="form-control-label">Ilość w magazynie:</label>
                        <input type="number" name="quanityInStock"  class="input-custom" id="'.$id.'-quanity">
                      </div>
                      <div class="form-group">
                        <label for="'.$id.'-reservation" class="form-control-label">Zablokowana ilość:</label>
                        <input type="number" name="reservation"  class="input-custom" id="'.$id.'-reservation">
                      </div>
                      <div class="form-group">
                        <label for="'.$id.'-kategoria" class="form-control-label">Kategoria:</label>
                        <input type="text" name="id_parent" class="input-custom" id="'.$id.'-kategoria">
                      </div>
                      <div class="form-group">
                        <label for="'.$id.'-discount" class="form-control-label">Rabat:</label>
                        <input type="number" value="0" min="0" max="100" step="1" name="discount" class="input-custom" id="'.$id.'-discount">
                      </div>
                      <div class="form-group on-off">
                          <label for="'.$id.'-news-on" class="form-control-label">Nowość:</label><br>
                        <input type="radio" value="1" name="news" class="form-control" id="'.$id.'-news-on">
                        <input type="radio" value="2" checked name="news" class="form-control" id="'.$id.'-news-off">
                        <div class="switch"></div>
                      </div>
                      <div class="form-group on-off">
                          <label for="'.$id.'-state-on" class="form-control-label">Stan:</label><br>
                        <input type="radio" value="1" name="status" class="form-control" id="'.$id.'-state-on">
                        <input type="radio" value="2" checked name="status" class="form-control" id="'.$id.'-state-off">
                        <div class="switch"></div>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-primary">Zapisz</button>
                  </div>
                 </form>
                </div>
              </div>
            </div>
        ';

    }
}

class NewsForm
{
    public static function create($id,$title,$ajaxUrl)
    {
        echo'
        <div class="modal fade" id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="editProductLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">'.$title.'</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form class="ajax" method="post" action="'.$ajaxUrl.'">
                  <input type="hidden" name="id" class="input-custom" id="'.$id.'-id">
                  <div class="modal-body">
                      <div class="form-group">
                        <label for="'.$id.'-title" class="form-control-label">Tytuł:</label>
                        <input type="text" name="title" class="input-custom" id="'.$id.'-title">
                      </div>
                      <div class="form-group">
                        <label for="'.$id.'-content" class="form-control-label">Treść:</label>
                        <textarea name="content" class="input-custom" id="'.$id.'-content"></textarea>
                      </div>

                       <div class="form-group">
                        <label for="'.$id.'-date" class="form-control-label">Data:</label>
                        <input placeholder="dd.mm.rrrr"  type="text" class="input-custom date" name="date" id="'.$id.'-date">
                      </div>

                      <div class="form-group on-off">
                          <label for="'.$id.'-state-on" class="form-control-label">Stan:</label><br>
                        <input type="radio" value="1" name="status" class="form-control" id="'.$id.'-state-on">
                        <input type="radio" value="2" checked name="status" class="form-control" id="'.$id.'-status-off">
                        <div class="switch"></div>
                      </div>
                  </div>



                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-primary">Zapisz</button>
                  </div>
                 </form>
                </div>
              </div>
            </div>
        ';

    }
}

class OrderForm
{
    public static function create($id,$title,$ajaxUrl,$shipmentAndPayment)
    {
        $html='
        <div class="modal fade" id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="editOrderLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">'.$title.'</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form class="ajax" method="post" action="'.$ajaxUrl.'">
                  <input type="hidden" name="id" class="input-custom" id="'.$id.'-id">
                  <div class="modal-body">

                      <div class="form-group">
                          <label for="'.$id.'-shipment" class="form-control-label">Adresy klienta:</label>
                          <select type="text" name="shipment" class="input-custom" id="'.$id.'-shipment"></select>
                     </div>

                    <div class="form-group">
                        <label for="'.$id.'-name" class="form-control-label">Nazwa odbiorcy:</label>
                        <input type="text" name="name" class="input-custom" id="'.$id.'-name">
                      </div>

                      <div class="form-group">
                        <label for="'.$id.'-place" class="form-control-label">Miejscowość:</label>
                        <input type="text" name="place" class="input-custom" id="'.$id.'-place">
                      </div>

                      <div class="form-group">
                        <label for="'.$id.'-code" class="form-control-label">Kod pocztowy:</label>
                        <input type="text" name="code" class="input-custom" id="'.$id.'-code">
                      </div>
                      <div class="form-group">
                        <label for="'.$id.'-address" class="form-control-label">Adres:</label>
                        <input type="text" name="address" class="input-custom" id="'.$id.'-address">
                      </div>

                      <div class="form-group">
                        <label for="'.$id.'-comment" class="form-control-label">Komentarz:</label>
                        <textarea name="comment" class="input-custom" id="'.$id.'-comment"></textarea>
                      </div>

                      <div class="form-group">
                          <label for="'.$id.'-payment" class="form-control-label">Dostawa i sposób płatności:</label>
                          <select type="text" name="payment" class="input-custom" id="'.$id.'-payment">
                          ';

                          foreach($shipmentAndPayment as $shipment)
                          {
                              $html.='<option
                               data-pay-name="'.$shipment['method_payment'].'"
                               data-transport-name="'.$shipment['name'].'"
                               data-free="'. $shipment['free_delivery'].'"
                               data-pay="'.$shipment['delivery_price_1'].'"
                               >

                               </option>';
                          }

                          $html.='</select>
                     </div>

                      <div class="form-group">
                        <label for="'.$id.'-state" class="form-control-label">Status zamówienia:</label>
                        <select name="state" class="input-custom" id="'.$id.'-state">
                            <option value="0">wysłane</option>
                            <option value="1">anulowane</option>
                            <option value="2">niewysłane</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="'.$id.'-paid" class="form-control-label">Status zamówienia:</label>
                        <select name="paid" class="input-custom" id="'.$id.'-paid">
                            <option value="0">zapłacone</option>
                            <option value="1">niezapłacone</option>
                        </select>
                      </div>
                      <div class="form-group on-off">
                          <label for="'.$id.'-send-on" class="form-control-label">Wyślij do klienta:</label><br>
                        <input type="radio" value="1" name="send" class="form-control" id="'.$id.'-send-on">
                        <input type="radio" value="2" checked name="send" class="form-control" id="'.$id.'-send-off">
                        <div class="switch"></div>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-primary">Zapisz</button>
                  </div>
                 </form>
                </div>
              </div>
            </div>
        ';

        return $html;
    }
}

class RemoveForm
{
    public static function create($id,$title,$text,$ajaxUrl)
    {
        $html='
        <div class="modal fade" id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="editOrderLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">'.$title.'</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form class="ajax" method="post" action="'.$ajaxUrl.'">
                  <input type="hidden" name="id" class="input-custom" id="'.$id.'-id">
                  <div class="modal-body">
                  '.$text.' <span class="remove-name"></span>?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-primary">Usuń</button>
                  </div>
                 </form>
                </div>
              </div>
            </div>
        ';

        return $html;
    }
}

class OrderProductForm
{
    public static function create($id,$title,$ajaxUrl,$altAjaxUrl,$shipmentAndPayment)
    {
        $html='
        <div class="modal fade" id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="editOrderLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">'.$title.'</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form class="ajax" method="post" data-alternative-action="'.$altAjaxUrl.'" action="'.$ajaxUrl.'">
                  <input type="hidden" name="id" class="input-custom" id="'.$id.'-id">
                      <input type="hidden" name="id_product" class="input-custom" id="'.$id.'-id-product">
                  <div class="modal-body">

                      <div class="form-group">
                          <label for="'.$id.'-quanity" class="form-control-label">Ilość produktu:</label>
                          <input type="text" name="quanity" class="input-custom number" id="'.$id.'-quanity">
                     </div>

                    
                     <div class="form-group on-off">
                          <label for="'.$id.'-remove-on" class="form-control-label">Usuń:</label><br>
                        <input type="radio" value="1" name="remove" class="form-control" id="'.$id.'-remove-on">
                        <input type="radio" value="2" checked name="remove" class="form-control" id="'.$id.'-remove-off">
                        <div class="switch"></div>
                      </div>

                      <div class="form-group on-off">
                          <label for="'.$id.'-send-on" class="form-control-label">Wyślij do klienta:</label><br>
                        <input type="radio" value="1" name="send" class="form-control" id="'.$id.'-send-on">
                        <input type="radio" value="2" checked name="send" class="form-control" id="'.$id.'-send-off">
                        <div class="switch"></div>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-primary">Zapisz</button>
                  </div>
                 </form>
                </div>
              </div>
            </div>
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
            <script src="/admin/public/js/jquery-3.3.1.min.js"></script>
            <script src="/admin/public/js/bootstrap.bundle.min.js"></script>
            <script src="/admin/public/js/jquery.mCustomScrollbar.js"></script>
            <script src="/admin/public/js/jquery-ui.min.js"></script>
            <script src="/admin/public/js/touchFix.js"></script>
            <script src="/admin/public/js/jquery.sticky-kit.min.js"></script>
            <script src="/admin/public/js/selectize.min.js"></script>
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

          $('a[href=\"/admin/wyloguj\"]').click(function(e)
          {
            e.preventDefault();
            $.get('/admin/public/ajax/wyloguj.php',function()
            {

                window.location.replace('/admin/login');

            });
          });


        $(function()
        {

            $('input.number').keyup(function()
            {
                        if(!$(this).val().isNumeric())
                {
                    e.preventDefault();
                }
            });

        });

        });
        
$(function()
{
            
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
