<?php

class Home extends Controller
{
    public function index()
    {
        $menu =  $this->model('menuTest');
        $user = $this->model('user');
        $config = $this->model('config');
        $configLogo = $config->getConfig(1);
        
        $userData=$user->userData();
        
        
        
        $this->view('home/index',['configLogo'=>$configLogo,'user'=>$userData]);
    }
}
