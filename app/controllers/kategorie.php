<?php
class Kategorie extends Controller
{
    public function index($link = false, $id = false,$subLink = false, $subID= false)
    {
        
        $link=str_replace('_','-',$link);
        $subLink=str_replace('_','-',$subLink);
        $menu =  $this->model('menuTest');
        $user = $this->model('user');
        $notifications = $this->model('notifications');
        $config = $this->model('config');
        
        $res = $menu->getTree();
        $res2 = $user->userData();
        $res4 = $notifications->notifications();
        $configLogo = $config->getConfig(1);
        $configPhone = $config->getConfig(2);
        $configMail = $config->getConfig(3);
        
        $productsModel=$this->model('Products');
        $products=$productsModel->getProductsByCategory($id);
        if(!empty($products['name'])){
            $this->view('kategorie/kategorie', ['menu' => $res, 'user' => $res2, 'products' => $products, 'notifications' => $res4, 'configPhone' => $configPhone, 'configMail' => $configMail, 'configLogo' => $configLogo]);
        }else{
            $this->view('brak_strony/index');
        }
        

    }
    }
