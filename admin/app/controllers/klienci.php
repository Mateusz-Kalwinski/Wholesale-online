<?php

class Klienci extends Controller
{
    public function index()
    {
        $menu =  $this->model('menuTest');
        $user = $this->model('user');
        $config = $this->model('config');
        $clientsModel=$this->model('clients');
        
        $configLogo = $config->getConfig(1);
        $userData=$user->userData();
        $clients=$clientsModel->listClients();
        

        $this->view('klienci/index',['configLogo'=>$configLogo,'user'=>$userData,'clients'=>$clients]);
    }
}
