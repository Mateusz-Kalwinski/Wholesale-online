<?php

class Wyszukaj extends Controller
{
    public function index()
    {
        $menu =  $this->model('menuTest');
        $user = $this->model('user');
        $notifications = $this->model('notifications');
        $search = $this->model('Products');
        $config = $this->model('config');

        $res = $menu->getTree();
        $res2 = $user->userData();
        $res3 = $notifications->notifications();
        $res4 = $search->getSearch();
        $configLogo = $config->getConfig(1);
        $configPhone = $config->getConfig(2);
        $configMail = $config->getConfig(3);
        $title = 'Wyniki wyszukiwania';
        if(empty($res4)){
            $this->view('wyszukaj/brak', ['menu'=>$res, 'user'=>$res2, 'notifications'=>$res3]);
        }
        else{
            $this->view('produkty/index', ['menu'=>$res, 'user'=>$res2, 'notifications'=>$res3, 'products'=>$res4, 'title'=>$title,
                        'configLogo'=>$configLogo, 'configMail'=>$configMail, 'configPhone'=>$configPhone]);
        }
    }
}

