<?php

class Nowosci extends Controller
{
    public function index()
    {
        $menu = $this->model('menuTest');
        $user = $this->model('user');
        $newsProducts = $this->model('Products');
        $config = $this->model('config');
        
        $notificationsModel = $this->model('notifications');
        $notifications=$notificationsModel->notifications();
                

        $res1 = $menu->getTree();
        $res2 = $user->userData();
        $res3 = $newsProducts->newsProducts();
        $configLogo = $config->getConfig(1);
        $configPhone = $config->getConfig(2);
        $configMail = $config->getConfig(3);


        $title = "Nowości";
        $this->view('produkty/index', ['menu' => $res1, 'user' => $res2, 'products' => $res3, 'title' => $title,
            'configPhone' => $configPhone, 'configMail' => $configMail, 'configLogo' => $configLogo,'notifications'=>$notifications]);
    }
}
