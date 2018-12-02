<?php

class Konto extends Controller
{
    public function index()
    {
        $menu =  $this->model('menuTest');
        $user = $this->model('user');        $adres = $this->model('shipment');
        $notifications = $this->model('notifications');
        $config = $this->model('config');

        $res = $menu->getTree();
        $res2 = $user->userData();
        $res3 = $adres->address($_SESSION['id']);
        $res4 = $notifications->notifications();
        $configLogo = $config->getConfig(1);
        $configPhone = $config->getConfig(2);
        $configMail = $config->getConfig(3);
        
        $this->view('konto/index', ['menu'=>$res, 'user'=>$res2, 'adres'=>$res3,'notifications'=>$res4, 'configLogo'=>$configLogo, 'configPhone'=>$configPhone, 'configMail'=>$configMail] );
    }
}