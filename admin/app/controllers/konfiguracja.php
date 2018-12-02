<?php

class Konfiguracja extends Controller
{
    public function index()
    {
        $menu =  $this->model('menuTest');
        $user = $this->model('user');
        $config = $this->model('config');
        $clientsModel=$this->model('clients');
        
        $configLogo = $config->getConfig(1);
        $configColor = $config->getConfig(14)[0];
        $configs=$config->getAll();
        
        $userData=$user->userData();
        $clients=$clientsModel->listClients();


        $this->view('konfiguracja/index',['configLogo'=>$configLogo,'user'=>$userData,'clients'=>$clients,'config'=>$configs,'color'=>$configColor]);
    }
}
