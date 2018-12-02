<?php

class Zamowienia extends Controller
{
    public function __construct()
    {
        $this->menu =  $this->model('menuTest');
        $this->user = $this->model('user');
        $this->config = $this->model('config');
        $this->configLogo = $this->config->getConfig(1);
        $this->freeDelivery=$this->config->getConfig(10);
        $this->userData=$this->user->userData();
        $this->ordersModel=$this->model('orders');
        $this->orders=$this->ordersModel->listOrder();

        $this->shipmentAndPayment=$this->ordersModel->listShipment();

        $clientsModel=$this->model('clients');

        $this->productsModel=$this->model('products');
        $this->products=$this->productsModel->listProducts();
    }

    public function index()
    {
        $orders= $this->ordersModel->listOrder();
        $this->view('zamowienia/index',['configLogo'=>$this->configLogo,'freeDelivery'=>$this->freeDelivery,
        'shipmentAndPayment'=>$this->shipmentAndPayment,'user'=>$this->userData,'ordersHistory'=>$orders,'products'=>$this->products, 'shipmentAndPayment'=>$this->shipmentAndPayment]);
    }
    public function uzytkownik($id){
        $orders= $this->ordersModel->listOrder($id);
        $this->view('zamowienia/index',['configLogo'=>$this->configLogo,'freeDelivery'=>$this->freeDelivery,
            'shipmentAndPayment'=>$this->shipmentAndPayment,'user'=>$this->userData,'ordersHistory'=>$orders,'products'=>$this->products, 'shipmentAndPayment'=>$this->shipmentAndPayment]);
    }
}
