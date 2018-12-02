<?php

class Home extends Controller
{
    public function index()
    {
        $menu =  $this->model('menuTest');
        $user = $this->model('user');
        $news = $this->model('news');
        $productsModel=$this->model('Products');
        $notifications = $this->model('notifications');
        $ordersHistory = $this->model('ordersHistory');
        $discountNews = $this->model('discountNews');
        $config = $this->model('config');
        
        $res = $menu->getTree();
        $res2 = $user->userData();
        $res3 = $news->getNews();
        $res4 = $notifications->notifications();
        $res5 = $ordersHistory->getOrder();
        $res6 = $productsModel->newsProducts();
        $res7 = $productsModel->discountProducts();
        $configLogo = $config->getConfig(1);
        $configPhone = $config->getConfig(2);
        $configMail = $config->getConfig(3);
        $this->view('home/index', ['menu'=>$res, 'user'=>$res2, 'news'=>$res3, 'notifications'=>$res4, 'ordersHistory'=>$res5, 'newsProducts'=>$res6, 'discountProducts'=>$res7,
            'configPhone'=>$configPhone, 'configMail'=>$configMail, 'configLogo'=>$configLogo]);
    }
}
