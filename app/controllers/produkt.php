<?php

class Produkt extends Controller
{
    public function index($productName=False,$productId=False)
    {
        $productName=str_replace('_','-',$productName);

        $menu =  $this->model('menuTest');
        $user = $this->model('user');
        $notifications = $this->model('notifications');
        $config = $this->model('config');
        
        $res = $menu->getTree();
        $res2 = $user->userData();
        $res5 = $notifications->notifications();
        $configLogo = $config->getConfig(1);
        $configPhone = $config->getConfig(2);
        $configMail = $config->getConfig(3);
 
        
        $productsModel=$this->model('Products');
        $product=$productsModel->getProduct($productId);

        if(!$product['path']==NULL){
            $this->view('produkt/index', ['menu'=>$res,'newProduct'=>$product, 'user'=>$res2, 'product'=>$product, 'path'=>'test','productId'=>$productId, 'notifications'=>$res5, 'configLogo'=>$configLogo, 'configPhone'=>$configPhone, 'configMail'=>$configMail]);
        }else{
            $this->view('brak_strony/index');
        }

        
    }
}

