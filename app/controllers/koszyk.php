<?php

class Koszyk extends Controller
{
    public function index()
    {
        $menu =  $this->model('menuTest');
        $user = $this->model('user');
        $news = $this->model('news');
        $notifications = $this->model('notifications');
        $cart = $this->model('cart');
        $config = $this->model('config');
        
        $res = $menu->getTree();
        $res2 = $user->userData();
        $res3 = $news->getNews();
        $res4 = $notifications->notifications();
        $res5 = $cart->getCart();
        $configLogo = $config->getConfig(1);
        $configPhone = $config->getConfig(2);
        $configMail = $config->getConfig(3);
        if(!empty($res5)){
            $this->view('koszyk/index', ['menu'=>$res, 'user'=>$res2, 'news'=>$res3, 'notifications'=>$res4, 'products'=>$res5, 'configPhone'=>$configPhone, 'configMail'=>$configMail, 'configLogo'=>$configLogo]);
        }else{
            $this->view('koszyk/pusty',['menu'=>$res, 'user'=>$res2, 'news'=>$res3, 'configPhone'=>$configPhone, 'configMail'=>$configMail, 'configLogo'=>$configLogo]);
    }
}
}

