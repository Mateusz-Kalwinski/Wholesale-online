<?php

class Zamowienie extends Controller
{
    public function index()
    {
        $menu =  $this->model('menuTest');
        $user = $this->model('user');
        $news = $this->model('news');
        $notifications = $this->model('notifications');
        $cart = $this->model('cart');
        $payment = $this->model('payment');
        $config = $this->model('config');

        $addressModel = $this->model('shipment');

        $res = $menu->getTree();
        $res2 = $user->userData();
        $res3 = $news->getNews();
        $res4 = $notifications->notifications();
        $res5 = $cart->getCart();
        if(empty($res5))
        {
          header('Location: /');
        }
        $configLogo = $config->getConfig(1);
        $configPhone = $config->getConfig(2);
        $configMail = $config->getConfig(3);
        $configMinPrice = $config->getConfig(10);

        $address=$addressModel->address($_SESSION['id']);


        $getPayment = $payment->getPayment();

        $cartQuanity=0;
        $cartValue=0;
        foreach($res5 as $cartData)
        {
            $cartQuanity+=$cartData['ilosc'];
            $cartValue+=$cartData['ilosc']*(ceil($cartData['price']*((100-$res2['discount'])/100)*((100-$cartData['discount'])/100)*100)/100);
        }


//        $this->view('zamowienie/index', ['menu'=>$res, 'user'=>$res2, 'news'=>$res3, 'notifications'=>$res4, 'cartQuanity'=>$cartQuanity,'cartValue'=>$cartValue, 'payment'=>$getPayment]);

        $this->view('zamowienie/index', ['menu'=>$res, 'user'=>$res2, 'news'=>$res3, 'notifications'=>$res4, 'cartQuanity'=>$cartQuanity,'cartValue'=>$cartValue, 'payment'=>$getPayment,'addresses'=>$address,
                    'configPhone'=>$configPhone, 'configMail'=>$configMail, 'configMinPrice'=>$configMinPrice, 'configLogo'=>$configLogo]);

    }
}
