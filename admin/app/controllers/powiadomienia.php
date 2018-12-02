<?php

class Powiadomienia extends Controller
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
        
        $newsModel=$this->model('news');
        $news=$newsModel->listNews();
        

        $this->view('powiadomienia/index',['configLogo'=>$configLogo,'user'=>$userData,'news'=>$news]);
    }
}
