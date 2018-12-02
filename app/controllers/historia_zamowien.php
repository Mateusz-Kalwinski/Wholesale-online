<?php

class historia_zamowien extends Controller
{
    public function index()
    {
        $menu =  $this->model('menuTest');
        $user = $this->model('user');
        $news = $this->model('news');
        $notifications = $this->model('notifications');
        $ordersHistory = $this->model('ordersHistory');
        $config = $this->model('config');
        
        $res = $menu->getTree();
        $res2 = $user->userData();
        $res3 = $news->getNews(); 
        $res4 = $notifications->notifications();
        $res5 = $ordersHistory->getOrder();
        $configLogo = $config->getConfig(1);
        $configPhone = $config->getConfig(2);
        $configMail = $config->getConfig(3);

        $this->view('historia_zamowien/index', ['menu'=>$res, 'user'=>$res2, 'news'=>$res3, 'notifications'=>$res4, 'ordersHistory'=>$res5, 'configPhone'=>$configPhone, 'configMail'=>$configMail, 'configLogo'=>$configLogo]);
    }
} 