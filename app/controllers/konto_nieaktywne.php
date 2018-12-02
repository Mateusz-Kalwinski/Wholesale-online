<?php

class Konto_nieaktywne extends Controller
{
    public function index()
    {
        $menu =  $this->model('menuTest');
        $user = $this->model('user');
        $news = $this->model('news');
        $notifications = $this->model('notifications');
        $ordersHistory = $this->model('ordersHistory');
        $discountNews = $this->model('discountNews');
        $config = $this->model('config');
        
        $res = $menu->getTree();
        $res2 = $user->userData();
        $res4 = $notifications->notifications();
        $configLogo = $config->getConfig(1);
        $configPhone = $config->getConfig(2);
        $configMail = $config->getConfig(3);


        $this->view('konto_nieaktywne/index', ['menu'=>$res, 'user'=>$res2, 'notification'=>$res4[12], 'configPhone'=>$configPhone, 'configMail'=>$configMail, 'configLogo'=>$configLogo]);
    }
}

