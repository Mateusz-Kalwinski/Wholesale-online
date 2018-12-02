<?php

class Produkty extends Controller
{
    public function __construct()
   {
        $this->menu =  $this->model('menuTest');
        $this->user = $this->model('user');
        $this->config = $this->model('config');
        $this->configLogo = $this->config->getConfig(1);
        $this->userData=$this->user->userData();
        $this->productsModel=$this->model('products');
        $this->units = $this->model('units');
        $this->unitsData = $this->units->getUnits();
    }
    
    public function index()
    {
        $products=$this->productsModel->listProducts();
        $this->view('produkty/index',['title'=>'Produkty','configLogo'=>$this->configLogo,'user'=>$this->userData,'products'=>$products, 'units'=>$this->unitsData]);
    }
    
    public function promocje()
    {
        $products=$this->productsModel->listProducts('discount');
        $this->view('produkty/index',['title'=>'Promocje','configLogo'=>$this->configLogo,'user'=>$this->userData,'products'=>$products, 'units'=>$this->unitsData]);
    }
    
    public function nowosci()
    {
        $products=$this->productsModel->listProducts('news');
        $this->view('produkty/index',['title'=>'Nowości','configLogo'=>$this->configLogo,'user'=>$this->userData,'products'=>$products, 'units'=>$this->unitsData]);
    }
}
